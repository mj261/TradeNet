<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', '1');
error_reporting(E_ALL | E_STRICT);

include_once 'classes/tools.php';

sec_session_start();

if (login_check($db) === true) {

    echo 'Home';

    ?>

        <button type="button" onClick="parent.location='logout.php'" class="alumniButton"> Log Out </button>

<?php
}
else{
    header('Location: /index.php');
}

?>