<?php
$link = mysql_connect("localhost","SecureTrader","G1vemEMonie$",false,MYSQL_CLIENT_SSL) 
        or die(mysql_error());

echo "Hello World!";
?>