<?php

include_once 'conn_db.php';
$error_msg = '';

if (isset($_POST['customer_number'], $_POST['username'], $_POST['email'], $_POST['p'])) {
    // Sanitize and validate the data passed in
    $customer = filter_input(INPUT_POST, 'customer_number', FILTER_SANITIZE_STRING);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
    if (strlen($password) !== 128) {
        // The hashed pwd should be 128 characters long.
        // If it's not, something really odd has happened
        $error_msg .= '<p class="error">Invalid password configuration.</p>';
    }

    // Username validity and password validity have been checked client side.
    // This should should be adequate as nobody gains any advantage from
    // breaking these rules.
    //

    $prep_stmt = 'SELECT `CustomerID` FROM `Users` WHERE `Username` = ? OR `Email` = ? LIMIT 1';
    $stmt = $db->prepare($prep_stmt);

    if ($stmt) {
        $stmt->bind_param('ss', $username, $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            // A user with this email address already exists
            $error_msg .= '<p class="error">A user with this username or email already exists.</p>';
        }
    } else {
        $error_msg .= '<p class="error">Database error</p>';
    }

    if (empty($error_msg)) {
        // Create a random salt
        $random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));

        // Create salted password
        $password = hash('sha512', $password . $random_salt);

        // Insert the new user into the database
        if ($insert_stmt = $db->prepare('INSERT INTO `Users` (CustomerID, Username, Email, Password, Salt) VALUES (?, ?, ?, ?, ?)')) {
            $insert_stmt->bind_param('sssss', $customer, $username, $email, $password, $random_salt);
            // Execute the prepared query.
            if (!$insert_stmt->execute()) {
                header('Location: ../adduser.php?prob=Name');
            }
        }
        header('Location: ../index.php');
    }
    header('Location: ../index.php');
}