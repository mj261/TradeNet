<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', '1');
error_reporting(E_ALL | E_STRICT);

include_once 'conn_db.php';
include_once 'inc/validate.inc.php';

if (!$mysqli) {
    die ('Connect error (' . mysqli_connect_errno() . '): ' . mysqli_connect_error() . "\n");
} else {
    $query = $db->prepare('SHOW TABLES;');
    $query->execute();
    $query->store_result();
    $query->bind_result($Tables);
    while ($query->fetch()) {
        print $Tables . '<br>';
    }
    $db->close();
}
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>TradeNet Login</title>

    <link rel="stylesheet" href="css/style.css" type="text/css"/>

    <script type="text/JavaScript" src="/js/sha512.js"></script>
    <script type="text/JavaScript" src="/js/forms.js"></script>
    <script src="js/prefixfree.min.js"></script>

</head>

<body>

<div class="body"></div>
<div class="grad"></div>
<div class="header">
    <div>Trade<span>Net</span></div>
</div>
<br>

<div class="login">
    <form method="post" name="login_form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" accept-charset="utf-8" style="display: inline-block;">

        <input type="text" name="username" id="username" value="" maxlength="50" placeholder="username">
        <input type="password" name="password" id="password" value="" maxlength="" placeholder="password">
        <input type="button" value="Login" onclick="form_hash(this.form, this.form.username, this.form.password);">
    </form>
</div>

<script src='js/jquery.js'></script>

</body>

</html>