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
        <title>TradeNet | Trade</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
        <link href="css/layout.css" rel="stylesheet" type="text/css" media="screen"/>
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
            <li><a href="trade.php" class="first">Trade</a></li>
            <li><a href="transfer.php">Transfer</a></li>
            <!--                    <li><a href="#">Training</a></li>-->
            <!--                    <li><a href="#">Support</a></li>-->
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <div id="content">
        <div id="page">
            <div id="column1">
                <div class="box1">
                    <h2>Welcome to TradeNet </h2>

                    <p><strong><img src="css/images/image06.jpg" alt="" width="120" height="120" class="image-left"/>This
                            template </strong> is a free CSS web template. Thanks goes to <a href="#">Stock Exchange</a>
                        for the free photo I used in this template. This design uses pure CSS and no tables for layout
                        and is released under the <a href="http://creativecommons.org/licenses/by-sa/3.0/ph/">Creative
                            Commons Attribution-Share Alike 3.0 Philippines License</a>, which basically says that:</p>
                    <ul>
                        <li>You <strong>CAN</strong> use this design for both personal or commercial purposes free of
                            charge.
                        </li>
                        <li>You <strong>CAN</strong> copy, distribute and transmit this template.</li>
                        <li>You <strong>CAN</strong> modify this template however you want.</li>
                    </ul>
                    <p>Quisque semper augue mattis wisi. Maecenas ligula. Pellentesque viverra vulputate enim. Aliquam
                        erat volutpat. Pellentesque tristique ante ut risus. Quisque dictum. Integer nisl risus,
                        sagittis convallis, rutrum id, elementum congue, nibh. Suspendisse dictum porta lectus. Donec
                        placerat odio vel elit. Nullam ante orci, pellentesque eget, tempus quis, ultrices in, est.
                        Curabitur sit amet nulla. Nam in massa. </p>
                </div>
            </div>
            <div id="column2">
                <h2>World Markets</h2>
                <ul>
                    <?php

                    $world = array('^IXIC', '^GSPC', 'EURUSD=X', 'GCM15.CMX', 'CLM15.NYM');
                    $url= 'http://finance.yahoo.com/d/quotes.csv?s='.implode('+', $world).'&f='.'snl1c1jkd1t1';
                    $handle = fopen($url, 'r');
                    while (($data = fgetcsv($handle, 1000, ',')) !== FALSE)
                    {
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