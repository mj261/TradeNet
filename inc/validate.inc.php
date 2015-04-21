<?php
//Database
include_once 'classes/tools.php';
sec_session_start();

if (isset($_POST['username'], $_POST['p'])) {
    $username = $_POST['username'];
    $password = $_POST['p']; // The hashed password.

    if (!isset($_SESSION['user_id'])) {
        $_SESSION['user_id'] = NULL;
    }

    if (login($username, $password, $db) === true) {
        // Login success
        header('Location: /customerhome.php');
    } elseif (check_brute($_SESSION['bruteid'], $db) === true) {
        header('Location: /index.php?prob=Brute');
    } else {
        // Login failed
        header('Location: /index.php?prob=Combo');
    }
}

?>