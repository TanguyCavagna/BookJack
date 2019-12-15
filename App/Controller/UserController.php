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
    }

    /**
     * Get the user by the id
     * @param {int} $userId Id of the user
     * @return {User} User found
     */
    public function getUserById($userId) {
        $query = <<<EX
            SELECT `{$this->fieldEmail}`, `{$this->fieldNickname}`, `{$this->fieldProfilPicture}`
            FROM {$this->tableName}
            WHERE {$this->fieldId} = :userId
        EX;
        
        $requestUser = $this::getInstance()->prepare($query);
        $requestUser->bindparam(':userId', $userId, PDO::PARAM_INT);
        $requestUser->execute();

        $result = $requestUser->fetch(PDO::FETCH_ASSOC);

        return new User($result[$this->fieldEmail], $result[$this->fieldNickname], $result[$this->fieldProfilPicture]);
    }

}