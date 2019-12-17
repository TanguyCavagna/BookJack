<?php
/**
 * @author tanguy.cvgn@gmail.com
 * @date 15.12.2019
 * @brief User model
 */

/**
 * Model of the user
 */
class User {
    public $id;
    public $email;
    public $nickname;
    public $profilPicture;

    function __construct($id, $email, $nickname, $profilPicture) {
        $this->id = $id;
        $this->email = $email;
        $this->nickname = $nickname;
        $this->profilPicture = $profilPicture;
    }
}