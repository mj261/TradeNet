<?php
//Database
include_once 'classes/tools.php';
sec_session_start();

// Unset all session values 
$_SESSION = array();

// get session parameters 
$params = session_get_cookie_params();

// Delete the actual cookie. 
setcookie(session_name(),
    '', 86400,
    $params['path'],
    $params['domain'],
    $params['secure'],
    $params['httponly']);

// Destroy session 
session_destroy();
header('Location: ../index.php');

?>