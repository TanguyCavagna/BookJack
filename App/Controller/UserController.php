<?php
/**
 * @author tanguy.cvgn@gmail.com
 * @date 15.12.2019
 * @brief User controller
 */

// Requirements
require_once __DIR__ . '/DatabaseController.php';
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

    /**
     * Get the user by the id
     * @param userId {string} Id of the user
     * @return User
     */
    public function getUserById($userId) {
        $query = <<<EX
            SELECT `{$this->fieldEmail}`, `{$this->fieldNickname}`, `{$this->fieldProfilPicture}`
            FROM {$this->tableName}
            WHERE {$this->fieldId} = :userId
        EX;
        
        $requestUser = $this::getInstance()->prepare($query);
        $requestUser->bindParam(':userId', $userId, PDO::PARAM_INT);
        $requestUser->execute();

        $result = $requestUser->fetch(PDO::FETCH_ASSOC);

        return new User($result[$this->fieldEmail], $result[$this->fieldNickname], $result[$this->fieldProfilPicture]);
    }

    /**
     * Log the user with his mail
     *
     * @param userMail {string}
     * @param userPwd {string}
     *
     * @return User || null
     */
    public function LoginWithMail($userMail, $userPwd) {
        $salt = $this->GetSaltByMail($userMail);

        $pwd = hash("sha256", $userPwd. $salt);
        
        $query = <<<EX
            SELECT `{$this->fieldEmail}`, `{$this->fieldNickname}`, `{$this->fieldProfilPicture}`
            FROM `{$this->tableName}`
            WHERE `{$this->fieldEmail}` = :userMail 
            AND `{$this->fieldPassword}` = :userPwd
        EX;

        $requestLogin = $this::getInstance()->prepare($query);
        $requestLogin->bindParam(':userMail', $userMail, PDO::PARAM_STR);
        $requestLogin->bindParam(':userPwd', $pwd, PDO::PARAM_STR);
        $requestLogin->execute();

        $result = $requestLogin->fetch(PDO::FETCH_ASSOC);

        return count($result) > 0 ? new User($result[$this->fieldEmail], $result[$this->fieldNickname], $result[$this->fieldProfilPicture]) : null;
    }

    /**
     * Log the user with his nickname
     *
     * @param userNickname {string}
     * @param userPwd {string}
     *
     * @return User || null
     */
    public function LoginWithNickname($userNickname, $userPwd) {
        $salt = $this->GetSaltByNickname($userNickname);

        $pwd = hash("sha256", $userPwd. $salt);
        
        $query = <<<EX
            SELECT `{$this->fieldEmail}`, `{$this->fieldNickname}`, `{$this->fieldProfilPicture}`
            FROM `{$this->tableName}`
            WHERE `{$this->fieldNickname}` = :userNickname 
            AND `{$this->fieldPassword}` = :userPwd
        EX;

        $requestLogin = $this::getInstance()->prepare($query);
        $requestLogin->bindParam(':userNickname', $userNickname, PDO::PARAM_STR);
        $requestLogin->bindParam(':userPwd', $pwd, PDO::PARAM_STR);
        $requestLogin->execute();

        $result = $requestLogin->fetch(PDO::FETCH_ASSOC);

        return count($result) > 0 ? new User($result[$this->fieldEmail], $result[$this->fieldNickname], $result[$this->fieldProfilPicture]) : null;
    }

    /**
     * Get the salt with the user mail
     *
     * @param userMail {string}
     *
     * @return salt
     */
    private function GetSaltByMail($userMail)
    {
        $query = <<<EX
            SELECT `{$this->fieldSalt}`
            FROM {$this->tableName}
            WHERE {$this->fieldEmail} = :userMail
        EX;
        
        $requestUser = $this::getInstance()->prepare($query);
        $requestUser->bindParam(':userMail', $userMail, PDO::PARAM_STR);
        $requestUser->execute();

        $result = $requestUser->fetch(PDO::FETCH_ASSOC);

        return $result[$this->fieldSalt];
    }

    /**
     * Get the salt with the user nickname
     *
     * @param userNickname {string}
     *
     * @return salt
     */
    private function GetSaltByNickname($userNickname)
    {
        $query = <<<EX
            SELECT `{$this->fieldSalt}`
            FROM {$this->tableName}
            WHERE {$this->fieldNickname} = :userNickname
        EX;
        
        $requestUser = $this::getInstance()->prepare($query);
        $requestUser->bindParam(':userNickname', $userNickname, PDO::PARAM_STR);
        $requestUser->execute();

        $result = $requestUser->fetch(PDO::FETCH_ASSOC);

        return $result[$this->fieldSalt];
    }
}