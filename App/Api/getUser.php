<?php
// requirements
require_once '../Controller/UserController.php';

// filter var
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);

// setup controller
$userController = new UserController();

// validate all filter
if ($id !== false and $id !== null) {
    $user = $userController->getUserById($id);

    echo json_encode([
        'ReturnCode' => 0,
        'Data' => $user
    ]);
    exit();
}

// nothing has gone right
echo json_encode([
    'ReturnCode' => 1,
    'Error' => 'The id is not integer'
]);
exit();