<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', '1');
error_reporting(E_ALL | E_STRICT);

include_once 'classes/tools.php';

sec_session_start();

if (login_check($db) === true) {

    ?>

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>TradeNet | Transactions</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
        <link href="css/layout.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/flat-ui.css" rel="stylesheet">
        <link href="css/app.css" rel="stylesheet">
    </head>
    <body>
    <div id="header">
        <div id="logo">
            <h1>TradeNet</h1>
        </div>
    </div>
    <div id="navigation">
        <ul>
            <li><a href="customerhome.php">Home</a></li>
            <li><a href="viewstocks.php">View Stocks</a></li>
            <li><a href="buy.php">Buy</a></li>
            <li><a href="sell.php">Sell</a></li>
            <li><a href="transactions.php" class="first">Transactions</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <div id="content">
        <div id="page">
            <div id="column1">
                <div class="box1">
                    <h2 style="text-align: center;">Transactions</h2>

                    <?php
                    $Customer_Balance = $db->prepare('SELECT Stock, Number, Time FROM Transactions WHERE Customer = ?');
                    $Customer_Balance->bind_param('s', $_SESSION['user_id']);
                    $Customer_Balance->execute();
                    $Customer_Balance->store_result();
                    $Customer_Balance->bind_result($Stock, $Number, $Time);
                    while($Customer_Balance->fetch()){
                        if($Number[0] === '-'){
                            $Number = ltrim ($Number, '-');
                            echo '<h4>' . date('m/d/Y H:i:s', $Time) . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . ' Sold ' . $Number . ' Shares of ' . $Stock . '</h4>';
                        }
                        else{
                            echo '<h4>' . date('m/d/Y H:i:s', $Time) . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . ' Bought ' . $Number . ' Shares of ' . $Stock . '</h4>';
                        }
                    }
                    $Customer_Balance->close();
                    ?>
                </div>
            </div>
            <div id="column2">
                <h2>World Markets</h2>
                <ul>
                    <?php

                    $world = array('^IXIC', '^GSPC', 'EURUSD=X', 'GCM15.CMX', 'CLM15.NYM');
                    $url = 'http://finance.yahoo.com/d/quotes.csv?s=' . implode('+', $world) . '&f=' . 'snl1c1jkd1t1';
                    $handle = fopen($url, 'r');
                    while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                        echo "<li><a href='http://finance.yahoo.com/q?s=$data[0]' target='_blank'>$data[1]  -  $$data[2]</a></li>";
                    }
                    fclose($handle);

                    ?>
                </ul>
            </div>
        </div>
        <div style="clear: both;">&nbsp;</div>
    </div>
    <div id="footer">
        <p>&copy;&nbsp;Copyright 2015. All Rights Reserved | Downs, Jones, Jozefiak, Richards, Turnipseed</p>
    </div>
    </body>
    </html>

<?php
} else {
    header('Location: /index.php');
}

?>