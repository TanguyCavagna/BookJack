<?php

require_once '../Controller/UserController.php';

$userController = new UserController();

echo json_encode([
    'user' => $userController->getUserById(1)
]);