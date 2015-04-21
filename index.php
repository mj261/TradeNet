<?php

ini_set ('error_reporting', E_ALL);
ini_set ('display_errors', '1');
error_reporting (E_ALL|E_STRICT);

include_once 'conn_db.php';


if (!$link)
{
    die ('Connect error (' . mysqli_connect_errno() . '): ' . mysqli_connect_error() . "\n");
} else {
    $query = $db->prepare('SHOW TABLES;');
    $query->execute();
    $query->store_result();
    $query->bind_result($Tables);
    while($query->fetch()){
        print $Tables . '<br>';
    }
    $db->close();
}
echo 'Hello World!';
?>