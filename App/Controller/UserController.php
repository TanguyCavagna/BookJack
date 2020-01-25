<?php
/**
 * @author tanguy.cvgn@gmail.com
 * @date 15.12.2019
 * @brief Controlleur de l'utilisateur
 */

// Requirements
require_once __DIR__ . '/DatabaseController.php';
require_once __DIR__ . '/LogController.php';
require_once __DIR__ . '/../Model/User.php';

/**
 * Controlleur de l'utilisateur
 */
class UserController extends EDatabaseController {

    /**
     * Initialise tous les champs de la table `user`
     */
    function __construct() {
        $this->tableName = "user";
        $this->fieldId= "user_id";
        $this->fieldEmail = "user_email";
        $this->fieldNickname = "user_nickname";
        $this->fieldProfilPicture = "user_profil_picture";
        $this->fieldPassword = "user_password";
        $this->fieldSalt = "user_salt";
    }

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ PRIVATE FUNCTIONS ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    /**
     * Récupère le sel avec le champ de son choix
     * Pour utiliser cette fontion, appelez la avec un tableau associatif comme suit:
     *      "$this->GetSalt(['userId' => 1])" => Pour récupéré le sel avec l'id
     *      "$this->GetSalt(['userEmail' => "john.doe@gmail.com"])" => Pour récupéré le sel avec l'email
     *      "$this->GetSalt(['userNickname' => "JohnDoe"])" => Pour récupéré le sel avec le pseudo
     *
     * @param array $args Tableau associtatif pour les différentes options de récupération de sel
     *
     * @return string||null
     */
    private function GetSalt(array $args): ?string {
        $args += [
            'userId' => null,
            'userEmail' => null,
            'userNickname' => null
        ];

        extract($args); // Extract the keys of the associative array has variables

        $clauseField = "";
        $clauseValue = "";
        if ($userId !== null) {
            $clauseField = $this->fieldId;
            $clauseValue = $userId;
        } else if ($userEmail !== null) {
            $clauseField = $this->fieldEmail;
            $clauseValue = $userEmail;
        } else if ($userNickname !== null) {
            $clauseField = $this->fieldNickname;
            $clauseValue = $userNickname;
        }

        $query = <<<EX
            SELECT `{$this->fieldSalt}`
            FROM {$this->tableName}
            WHERE {$clauseField} = :clauseValue
        EX;
        
        $requestUser = $this::getInstance()->prepare($query);
        $requestUser->bindParam(':clauseValue', $clauseValue);
        $requestUser->execute();

        $result = $requestUser->fetch(PDO::FETCH_ASSOC);

        return $result !== false ? $result[$this->fieldSalt] : null;
    }

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ PUBLIC FUNCTIONS ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    /**
     * Retourne l'utilisateur si les informations de connection sont correct. Sinon null
     *
     * @param array $args Tableau associtatif pour les différentes options de login. ATTENTION: LE MOT DE PASSE EST OBLIGATOIRE
     *
     * @return User||null
     */
    public function Login(array $args): ?User {
        $args += [
            'userEmail' => null,
            'userNickname' => null,
            'userPwd' => null
        ];

        extract($args);

        $wayToLoginField = "";
        $wayToLoginValue = "";
        $salt = "";
        if ($userEmail !== null) {
            $salt = $this->GetSalt(['userEmail' => $userEmail]);
            $wayToLoginValue = $userEmail;
            $wayToLoginField = $this->fieldEmail;
        } else if ($userNickname !== null) {
            $salt = $this->GetSalt(['userNickname' => $userNickname]);
            $wayToLoginValue = $userNickname;
            $wayToLoginField = $this->fieldNickname;
        } else {
            return false;
        }

        if ($userPwd === null) {
            return false;
        }

        $pwd = hash("sha256", $userPwd . $salt);
        
        $query = <<<EX
            SELECT `{$this->fieldId}`, `{$this->fieldEmail}`, `{$this->fieldNickname}`, `{$this->fieldProfilPicture}`
            FROM `{$this->tableName}`
            WHERE `{$wayToLoginField}` = :wayToConnectValue 
            AND `{$this->fieldPassword}` = :userPwd
        EX;

        try {
            $requestLogin = $this::getInstance()->prepare($query);
            $requestLogin->bindParam(':wayToConnectValue', $wayToLoginValue, PDO::PARAM_STR);
            $requestLogin->bindParam(':userPwd', $pwd, PDO::PARAM_STR);
            $requestLogin->execute();

            $result = $requestLogin->fetch(PDO::FETCH_ASSOC);
            
            return $result !== false > 0 ? new User($result[$this->fieldId], $result[$this->fieldEmail], $result[$this->fieldNickname], $result[$this->fieldProfilPicture]) : null;
        } catch (PDOException $e) {
            LogController::Error('Error while login', $e->getMessage());

            return null;
        }

    }

    /**
     * Enregistre un nouvel utilisateur
     * 
     * @param string $userEmail Email
     * @param string $userNickname Pseudo
     * @param string $userPassword Mot de passe
     * 
     * @return bool État de l'enregistrement
     */
    public function RegisterNewUser(string $userEmail, string $userNickname, string $userPassword): bool {
        $registerQuery = <<<EX
            INSERT INTO `{$this->tableName}`({$this->fieldEmail}, {$this->fieldNickname}, {$this->fieldPassword}, {$this->fieldSalt}, {$this->fieldProfilPicture})
            VALUES(:userEmail, :userNickname, :userPassword, :userSalt, :userProfilPicture)
        EX;

        $salt = hash('sha256', microtime());
        $userPassword = hash('sha256', $userPassword . $salt);
        $profilPicture = null;

        try {
            $this::beginTransaction();

            $requestRegister = $this::getInstance()->prepare($registerQuery);
            $requestRegister->bindParam(':userEmail', $userEmail);
            $requestRegister->bindParam(':userNickname', $userNickname);
            $requestRegister->bindParam(':userPassword', $userPassword);
            $requestRegister->bindParam(':userSalt', $salt);
            $requestRegister->bindParam(':userProfilPicture', $profilPicture);
            $requestRegister->execute();
            
            $this::commit();
            return true;
        } catch (PDOException $e) {
            $this::rollBack();
            LogController::Error('Error while register a new user', $e->getMessage());

            return false;
        }
    }

    /**
     * Met à jour le pseudo avec l'id de l'utilisateur
     *
     * @param int $userId Id de l'utilisateur
     * @param string $userNickname Nouveau pseudo de l'utilisateur
     *
     * @return bool
     */
    public function UpdateNicknameById(int $userId, string $userNickname): bool {
        $updateQuery = <<<EX
            UPDATE `{$this->tableName}` 
            SET `{$this->fieldNickname}` = :userNickname 
            WHERE `{$this->fieldId}` = :userId
        EX;

        try {
            $this::beginTransaction();

            $requestUpdate = $this::getInstance()->prepare($updateQuery);
            $requestUpdate->bindParam(':userNickname', $userNickname);
            $requestUpdate->bindParam(':userId', $userId);
            $requestUpdate->execute();

            $this::commit();

            return true;
        } catch (PDOException $e) {
            $this::rollBack();
            LogController::Error('Error while updating nickname', $e->getMessage());

            return false;
        }
    }

    /**
     * Met à jour l'email de l'utilisateur
     *
     * @param int $userId Id de l'utilisateur
     * @param string $userEmail Nouvel email de l'utilisateur
     *
     * @return bool
     */
    public function UpdateEmailById(int $userId, string $userEmail): bool {
        $updateQuery = <<<EX
            UPDATE `{$this->tableName}` 
            SET `{$this->fieldEmail}` = :userEmail 
            WHERE `{$this->fieldId}` = :userId
        EX;

        try {
            $this::beginTransaction();

            $requestUpdate = $this::getInstance()->prepare($updateQuery);
            $requestUpdate->bindParam(':userEmail', $userEmail);
            $requestUpdate->bindParam(':userId', $userId);
            $requestUpdate->execute();

            $this::commit();
            return true;
        } catch (PDOException $e) {
            $this::rollBack();
            LogController::Error('Error while updating email', $e->getMessage());

            return false;
        }
    }

    /**
     * Met à jour le mot de passe de l'utilisateur
     *
     * @param int $userId Id de l'utilisateur
     * @param string $userPassword Nouveau mot de passe
     *
     * @return bool
     */
    public function UpdatePasswordById(int $userId, string $userPassword): bool {
        $updateQuery = <<<EX
            UPDATE `{$this->tableName}` 
            SET `{$this->fieldPassword}` = :userPassword
            WHERE `{$this->fieldId}` = :userId
        EX;

        $salt = $this->GetSalt(['userId' => $userId]);
        $userPassword = hash('sha256', $userPassword . $salt);
        
        try {
            $this::beginTransaction();
            $requestUpdate = $this::getInstance()->prepare($updateQuery);
            $requestUpdate->bindParam(':userPassword', $userPassword);
            $requestUpdate->bindParam(':userId', $userId);
            $requestUpdate->execute();

            $this::commit();
            return true;
        } catch (PDOException $e) {
            $this::rollBack();
            LogController::Error('Error while updating password', $e->getMessage());

            return false;
        }
    }

    /**
     * Met à jour le chemin de la photo de profil de l'utilisateur
     *
     * @param int $userId Id de l'utilisateur
     * @param string $filePath Nouveau chemin de l'image de profil
     *
     * @return bool
     */
    public function UpdateProfilPictureById(int $userId, string $filePath): bool {
        $updateQuery = <<<EX
            UPDATE `{$this->tableName}`
            SET `{$this->fieldProfilPicture}` = :picturePath
            WHERE `{$this->fieldId}` = :userId
        EX;

        try {
            $this::beginTransaction();
            $requestUpdate = $this::getInstance()->prepare($updateQuery);
            $requestUpdate->bindParam(':picturePath', $filePath);
            $requestUpdate->bindParam(':userId', $userId);
            $requestUpdate->execute();

            $this::commit();

            return true;
        } catch (PDOException $e) {
            $this::rollBack();
            LogController::Error('Error while updating profile picture', $e->getMessage());

            return false;
        }
    }

    /**
     * Spprime un utilisateur
     *
     * @param int $userId Id de l'utilisateur
     *
     * @return bool
     */
    public function DeleteById(int $userId): bool {
        $updateQuery = <<<EX
            DELETE FROM `{$this->tableName}`
            WHERE `{$this->fieldId}` = :userId
        EX;

        try {
            $this::beginTransaction();
            $requestUpdate = $this::getInstance()->prepare($updateQuery);
            $requestUpdate->bindParam(':userId', $userId);
            $requestUpdate->execute();

            $this::commit();
            
            return true;
        } catch (PDOException $e) {
            $requestUpdate->rollBack();
            LogController::Error('Error while deleting user', $e->getMessage());

            return false;
        }
    }
}