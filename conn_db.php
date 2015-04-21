<?php

define('HOST', '52.4.116.111'); // The host you want to connect to.
define('USER', 'SecureTrader'); // The database username.
define('PASSWORD', 'G1vemEMonie$'); // The database password.
define('DATABASE', 'TradeNet'); // The database name.

$db = mysqli_init();
mysqli_options ($db, MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, true);

### Local Testing ###
$db->ssl_set('classes/client-key.pem', 'classes/client-cert.pem', 'classes/ca.pem', NULL, NULL);

### Deployment ###
//$db->ssl_set('/etc/mysql-certs/client-key.pem', '/etc/mysql-certs/client-cert.pem', '/etc/mysql-certs/ca.pem', NULL, NULL);

$mysqli = mysqli_real_connect ($db, HOST, USER, PASSWORD, DATABASE,
    3306, NULL, MYSQLI_CLIENT_SSL);

?>