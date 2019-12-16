<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['loggedUser']) && !empty($_SESSION['loggedUser'])) {
    unset($_SESSION['loggedUser']);

    $_SESSION['loggedOut'] = true;
    header('Location: ./index.php');
    exit();
}

// Redirect back
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();
