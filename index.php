<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', '1');
error_reporting(E_ALL | E_STRICT);

include_once 'inc/validate.inc.php';

$problem = isset($_GET['prob']) ? $_GET['prob'] : NULL;
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
    <form method="post" name="login_form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
          accept-charset="utf-8" style="display: inline-block;">

        <input type="text" name="username" id="username" value="" maxlength="50" placeholder="username"
               onkeydown="if (event.keyCode == 13) document.getElementById('Submit').click()"/>
        <input type="password" name="password" id="password" value="" maxlength="" placeholder="password"
               onkeydown="if (event.keyCode == 13) document.getElementById('Submit').click()"/>
        <input type="button" id="Submit" value="Login"
               onClick="form_hash(this.form, this.form.username, this.form.password);">
    </form>
    <?php
    if ($problem === 'Brute') {
        echo '<h3>Your account has been locked for <br>too many login attempts!</h3>';
    } elseif ($problem === 'Combo') {
        echo '<h3>You entered an invalid username <br>and/or password!</h3>';
    }
    ?>

</div>

<script src='js/jquery.js'></script>

</body>

</html>