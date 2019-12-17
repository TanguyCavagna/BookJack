<?php
/**
 * @author tanguy.cvgn@gmail.com
 * @date 15.12.2019
 * @brief User controller
 */

// Requirements
require_once __DIR__ . '/DatabaseController.php';
require_once __DIR__ . '/LogController.php';
require_once '../Model/User.php';

/**
 * Controll of the user
 */
class UserController extends EDatabaseController {

    /**
     * Initialize all database field name and table name
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
     * Get the salt with the choosen field
     * To use it, call this function with an associative array as argument like so:
     *      "$this->GetSalt(['userId' => 2])" => to get salt with user id
     *      "$this->GetSalt(['userEmail' => "awdwa@awd.com"])" => to get salt with user email
     *      "$this->GetSalt(['userNickname' => "awddw"])" => to get salt with user nickname
     *
     * @param args {array} Associative array for the clause
     *
     * @return salt
     */
    private function GetSalt($args) {
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
     * Log the user with his nickname
     *
     * @param userNickname {string}
     * @param userPwd {string}
     *
     * @return User || null
     */
    public function Login($args) {
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
            LogController::Error('Error while login', $e::getMessage());

            return null;
        }

    }

    /**
     * Register a new user
     * 
     * @param userEmail {string} New email
     * @param userNickname {string} New nickname
     * @param userPassword {string} New password
     * 
     * @return registerState {bool}
     */
    public function RegisterNewUser($userEmail, $userNickname, $userPassword) {
        $registerQuery = <<<EX
            INSERT INTO `{$this->tableName}`({$this->fieldEmail}, {$this->fieldNickname}, {$this->fieldPassword}, {$this->fieldSalt}, {$this->fieldProfilPicture})
            VALUES(:userEmail, :userNickname, :userPassword, :userSalt, :userProfilPicture)
        EX;

        $salt = hash('sha256', microtime());
        $userPassword = hash('sha256', $userPassword . $salt);
        $profilPicture = null;

        try {
            $requestRegister = $this::getInstance()->prepare($registerQuery);
            $requestRegister->bindParam(':userEmail', $userEmail);
            $requestRegister->bindParam(':userNickname', $userNickname);
            $requestRegister->bindParam(':userPassword', $userPassword);
            $requestRegister->bindParam(':userSalt', $salt);
            $requestRegister->bindParam(':userProfilPicture', $profilPicture);
            $requestRegister->execute();

            return true;
        } catch (PDOException $e) {
            LogController::Error('Error while register a new user', $e::getMessage());

            return false;
        }
    }

    /**
     * Update the nickname by the user id
     * 
     * @param userId {int} Id of the user
     * @param userNickname {string} New user nickname
     * 
     * @return updateState {bool}
     */
    public function UpdateNicknameById($userId, $userNickname) {
        $updateQuery = <<<EX
            UPDATE FROM `{$this->tableName}` 
            SET `{$this->fieldNickname}` = :userNickname 
            WHERE `{$this->fieldId}` = :userId
        EX;

        try {
            $requestUpdate = $this::getInstance()->prepare($updateQuery);
            $requestUpdate->bindParam(':userNickname', $userNickname);
            $requestUpdate->bindParam(':userId', $userId);
            $requestUpdate->execute();

            return true;
        } catch (PDOException $e) {
            LogController::Error('Error while updating nickname', $e::getMessage());

            return false;
        }
    }

    /**
     * Update the email by the user id
     * 
     * @param userId {int} Id of the user
     * @param userEmail {string} New user email
     * 
     * @return updateState {bool}
     */
    public function UpdateEmailById($userId, $userEmail) {
        $updateQuery = <<<EX
            UPDATE FROM `{$this->tableName}` 
            SET `{$this->fieldEmail}` = :userEmail 
            WHERE `{$this->fieldId}` = :userId
        EX;

        try {
            $requestUpdate = $this::getInstance()->prepare($updateQuery);
            $requestUpdate->bindParam(':userEmail', $userEmail);
            $requestUpdate->bindParam(':userId', $userId);
            $requestUpdate->execute();

            return true;
        } catch (PDOException $e) {
            LogController::Error('Error while updating email', $e::getMessage());

            return false;
        }
    }

    /**
     * Update the password by the user id
     * 
     * @param userId {int} Id of the user
     * @param userPassword {string} New user password
     * 
     * @return updateState {bool}
     */
    public function UpdatePasswordById($userId, $userPassword) {
        $updateQuery = <<<EX
            UPDATE FROM `{$this->tableName}` 
            SET `{$this->fieldPassword}` = :userPassword
            WHERE `{$this->fieldId}` = :userId
        EX;
        
        try {
            $requestUpdate = $this::getInstance()->prepare($updateQuery);
            $requestUpdate->bindParam(':userPassword', $userPassword);
            $requestUpdate->bindParam(':userId', $userId);
            $requestUpdate->execute();

            return true;
        } catch (PDOException $e) {
            LogController::Error('Error while updating password', $e::getMessage());

            return false;
        }
    }
}