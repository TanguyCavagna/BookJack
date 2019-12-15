<?php

// Initialisation
$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);

if (strlen($username) > 0 && strlen($password) > 0) {
    if (Login($username, $password)) {
        $_SESSION["logged"] = true;

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