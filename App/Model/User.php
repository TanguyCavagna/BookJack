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
    public $email;
    public $nickname;
    public $profilPicture;

    function __construct($email, $nickname, $profilPicture) {
        $this->email = $email;
        $this->nickname = $nickname;
        $this->profilPicture = $profilPicture;
    }
}