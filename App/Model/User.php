<?php

class User {
    public $nickname = "";
    public $email = "";
    public $profilPicture = "";

    function __consctruct($email, $nickname, $profilPicture) {
        $this->email = $email;
        $this->nickname = $nickname;
        $this->profilPicture = $profilPicture;
    }
}