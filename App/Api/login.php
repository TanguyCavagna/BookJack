<?php
require_once '../Controller/UserController.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Initialisation
$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
$userController = new UserController();

if (strlen($username) > 0 && strlen($password) > 0) {

    if (strpos($username, '@')) {
        $loggedUser = $userController->loginWithMail($username, $password);
    } else {
        $loggedUser = $userController->loginWithNickname($username, $password);
    }

    if ($loggedUser !== null) {
        $_SESSION["loggedUser"] = $loggedUser;
        $_SESSION['loggedIn'] = true;

        echo json_encode([
            'ReturnCode' => 0,
            'Success' => "Login is correct"
        ]);
        exit();
    }

    echo json_encode([
        'ReturnCode' => 2,
        'Error' => "Username/Password invalid"
    ]);
}
