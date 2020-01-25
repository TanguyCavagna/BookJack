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

$regex = "/^(?=\w{8,})(?=[^a-z]*[a-z])(?=[^A-Z]*[A-Z])(\w*\d)\w*/"; // Faut que le mdp contienne au minimun 8char, une majuscule et 1chiffre

// Traitement

// si tous les champs obligatoire sont remplis
if (strlen($username) > 2 && strlen($mail) > 0 && strlen($password) > 0 && strlen($verifyPassword) > 0) { 
    // si le mdp contient toutes les conditions du regex
    if ((preg_match($regex, $password))) {
        // Si les 2 mdp sont les mêmes
        if ($password == $verifyPassword) { 
            // si le compte s'est bien crée
            if($userController->RegisterNewUser($mail, $username, $password)) { 
                echo json_encode([
                    'ReturnCode' => 0,
                    'Success' => "Register is correct"
                ]);
                exit();
            }
            echo json_encode([
                'ReturnCode' => 3,
                'Error' => "Didn't register"
            ]);
        }
        echo json_encode([
            'ReturnCode' => 4,
            'Error' => "Different passwords"
        ]);
    }
    echo json_encode([
        'ReturnCode' => 5,
        'Error' => "Doesn't fit tp the regex"
    ]);
}
