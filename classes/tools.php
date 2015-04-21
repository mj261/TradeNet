<?php

header('Content-type: text/html; charset=utf-8');
date_default_timezone_set('America/Chicago');
$usersTimezone = new DateTimeZone('America/Chicago');

include_once 'conn_db.php';

define('L_LANG', 'en_US');

function sec_session_start()
{
    $session_name = 'TradeNet';   // Set a custom session name
    $secure = false;
    // This stops JavaScript being able to access the session id.
    $httponly = true;
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header('Location: ../index.php');
        exit();
    }
    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams['lifetime'],
        $cookieParams['path'],
        $cookieParams['domain'],
        $secure,
        $httponly);
    // Sets the session name to the one set above.
    session_name($session_name);
    if (!isset($_SESSION)) {
        session_start(); // Start the PHP session
        session_regenerate_id(); // regenerated the session, delete the old one.
    }
}

function login($user, $password, $db)
{
    $Customer_ID = '';
    $username = '';
    $db_password = '';
    $salt = '';
    // Using prepared statements means that SQL injection is not possible.
    $stmt = $db->prepare('SELECT CustomerID, Username, Password, Salt FROM Users WHERE Username = ? LIMIT 1');
    $stmt->bind_param('s', $user);
    $stmt->execute(); // Execute the prepared query.
    $stmt->store_result();
    if ($stmt) {
        // get variables from result.
        $stmt->bind_result($Customer_ID, $username, $db_password, $salt);
        $stmt->fetch();
        // hash the password with the unique salt.
        $password = hash('sha512', $password . $salt);
        $now = time();
        $ip = $_SERVER['REMOTE_ADDR'];
        $_SESSION['bruteid'] = $Customer_ID;
        if ($stmt->num_rows === 1) {
            // If the user exists we check if the account is locked
            // from too many login attempts

            if (check_brute($Customer_ID, $db) === true) {
                // Account is locked
                // Send an email to user saying their account is locked

                $db->query("INSERT INTO LoginAttempts(id, time, Success, IP) VALUES ('$Customer_ID', '$now', 0, '$ip')");
                return false;
            } else {
                // Check if the password in the database matches
                // the password the user submitted.
                if ($db_password === $password) {
                    // Password is correct!
                    // Get the user-agent string of the user.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    // XSS protection as we might print this value
                    $user_id = preg_replace('/[^0-9]+/', '', $Customer_ID);
                    $_SESSION['user_id'] = $user_id;
                    // XSS protection as we might print this value
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", '', $username);
                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = hash('sha512',
                        $password . $user_browser);
                    $db->query("INSERT INTO LoginAttempts(id, time, Success, IP) VALUES ('$Customer_ID', '$now', 1, '$ip')");
                    // Login successful.
                    return true;
                } else {
                    // Password is not correct
                    // We record this attempt in the database
                    $db->query("INSERT INTO LoginAttempts(id, time, Success, IP) VALUES ('$Customer_ID', '$now', 0, '$ip')");
                    return false;
                }
            }
        } else {
            // No user exists.
            return false;
        }
    } else {
        return false;
    }
}

function check_brute($user_id, $mysqli)
{
    // Get timestamp of current time
    $now = time();

    // All login attempts are counted from the past 2 hours.
    $valid_attempts = $now - (2 * 60 * 60);

    if ($stmt = $mysqli->prepare("SELECT time FROM LoginAttempts WHERE id = ? AND Success = '0' AND time > '$valid_attempts'")
    ) {
        $stmt->bind_param('i', $user_id);

        // Execute the prepared query.
        $stmt->execute();
        $stmt->store_result();

        // If there have been more than 5 failed logins
        if ($stmt->num_rows > 5) {
            return true;
        } else {
            return false;
        }
    }
    else {
        return false;
    }
}

?>
