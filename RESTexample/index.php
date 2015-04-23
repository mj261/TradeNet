<?php

include 'request.php';

$domain = "http://dbserver-fedexserver.rhcloud.com/";

define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
define('DB_PORT', getenv('OPENSHIFT_MYSQL_DB_PORT'));
define('DB_USER', getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
define('DB_PASS', getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
define('DB_NAME', getenv('OPENSHIFT_GEAR_NAME'));

//CORS
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers:{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}
//end CORS


//get url
$protocol = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
$location = $_SERVER['REQUEST_URI'];
if ($_SERVER['QUERY_STRING']) {
    $location = substr($location, 0, strrpos($location, $_SERVER['QUERY_STRING']) - 1);
}
$url = $protocol . '://' . $_SERVER['HTTP_HOST'] . $location;
if (substr($url, -1) != '/') { //ensure consistency in trailing /
    $url = $url . '/';
}

//get parameters
$length = strlen($domain);
$parameters = substr($url, $length);

$parameterArray = explode('/', $parameters); //to account for null para due to trailing /
$parameterCount = count($parameterArray) - 1;

$type = $_SERVER['REQUEST_METHOD'];

switch ($type) {
    case 'GET':
        processGET($parameterCount, $parameterArray);
        break;
    case 'POST':
        processPOST($parameterCount, $parameterArray);
        break;
    case 'DELETE':
        processDELETE($parameterCount, $parameterArray);
        break;
    default:
        invalidRequest();
        break;
}

?>
