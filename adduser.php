<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', '1');
error_reporting(E_ALL | E_STRICT);

include_once 'conn_db.php';
include_once 'inc/adduser.inc.php';

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

        <input type="text" name="customer_number" id="customer_number" value="" maxlength="5" placeholder="Customer Number">
        <input type="text" name="email" id="email" value="" maxlength="50" placeholder="Email">
        <input type="text" name="username" id="username" value="" maxlength="50" placeholder="Username">
        <input type="password" name="password" id="password" value="" maxlength="" placeholder="Password">
        <input type="password" name="confirm_password" id="confirm_password" value="" maxlength="" placeholder="Confirm Password">
        <input type="button" value="Add User" onclick="return reg_form_hash(this.form,
                                       this.form.customer_number,
                                       this.form.username,
                                       this.form.email,
                                       this.form.password,
                                       this.form.confirm_password);">
    </form>
</div>

<script src='js/jquery.js'></script>

</body>

</html>