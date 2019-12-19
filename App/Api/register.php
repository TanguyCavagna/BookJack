<?php
require_once '../Controller/UserController.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Initialisation
$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
$mail = filter_input(INPUT_POST, "mail", FILTER_SANITIZE_EMAIL);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
$verifyPassword = filter_input(INPUT_POST, "verifyPassword", FILTER_SANITIZE_STRING);

// Traitement
if (strlen($username) > 0 && strlen($mail) > 0 && strlen($password) > 0 && strlen($verifyPassword) > 0) {
    
}
