<?php

require_once './DatabaseController.php';
require_once '../Model/User.php';

class UserController extends EDatabaseController {

    function __construct() {
        $this->tableName = "user";
        $this->fieldId= "user_id";
        $this->fieldEmail = "user_email";
        $this->fieldNickname = "user_nickname";
        $this->fieldProfilPicture = "user_profil_picture";
    }

    public function getUserById($userId) {
        $query = <<<EX
            SELECT `{$this->fieldEmail}`, `{$this->fieldNickname}`, `{$this->fieldProfilPicture}`
            FROM {$this->tableName}
            WHERE {$this->fieldId} = :userId
        EX;
        
        $requestUser = $this::getInstance()->prepare($query);
        $requestUser->bindparam(':userId', $userId, PDO::PARAM_INT);
        $requestUser->execute();

        $result = $requestUser->fetchAll(PDO::FETCH_ASSOC);

        return new User($result[$this->fieldEmail], $result[$this->fieldNickname], $result[$this->fieldProfilPicture]);
    }

}