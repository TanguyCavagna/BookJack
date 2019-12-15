<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Initialisation
$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
$userController = new UserController();

if (strlen($username) > 0 && strlen($password) > 0) {
    
    $loggedUser = $userController->loginWithMail($username);
    
    if ($loggedUser !== null) {
        $_SESSION["loggedUser"] = $loggedUser;

        echo json_encode([
            'ReturnCode' => 0,
            'Success' => "Login is correct"
        ]);
        exit();
    }

    echo json_encode([
        'ReturnCode' => 1,
        'Error' => "Username/Password invalid"
    ]);
}