<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', '1');
error_reporting(E_ALL | E_STRICT);

include_once 'classes/tools.php';

sec_session_start();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>TradeNet | Customer Home</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <link href="css/layout.css" rel="stylesheet" type="text/css" media="screen"/>
    <meta name="viewport" content="width=960">
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
        <li><a href="customerhome.php" class="first">Home</a></li>
        <li><a href="viewstocks.php">View Stocks</a></li>
        <li><a href="buy.php">Trade</a></li>
        <li><a href="transactions.php">Transfer</a></li>
        <!--                    <li><a href="#">Training</a></li>-->
        <!--                    <li><a href="#">Support</a></li>-->
        <li><a href="logout.php">Logout</a></li>
    </ul>
</div>
<div id="content">
    <div id="page">
        <div id="column1">
            <div class="container section-margins">
                <div id=stock-tickers class="row" style="width: 90%; margin: 0 auto;">
                    <?php

                    $world = array('AAPL', 'GOOGL', 'T', 'FB', 'TWTR', 'RNST', 'BXS', 'COKE');
                    $url = 'http://finance.yahoo.com/d/quotes.csv?s=' . implode('+', $world) . '&f=' . 'snl1c1p2d1t1v';
                    $handle = fopen($url, 'r');
                    while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                    ?>
                    <div class="span2 row-margin-small">
                        <?php
                        if (substr($data[4], 0, 1) === '-'){
                        ?>
                        <div id="stock-id-{<?php echo $data[0] ?>}" class="tile animate"
                             style="background-color: #E74C3C;">
                            <?php
                            } else {
                            ?>
                            <div id="stock-id-{<?php echo $data[0] ?>}" class="tile animate"
                                 style="background-color: #2ECC71;">
                                <?php
                                }
                                ?>
                                <div id="stock-values-<?php echo $data[0] ?>">
                                    <h2 id="stock-name-<?php echo $data[0] ?>"><?php echo $data[0] ?></h2>
                                    <h4 id="stock-price-<?php echo $data[0] ?>"><?php echo '$' . $data[2] ?></h4>

                                    <div id="stock-delta-<?php echo $data[0] ?>"><?php echo $data[3] ?></div>
                                    <div
                                        id="stock-perc-<?php echo $data[0] ?>"><?php echo '(' . $data[4] . ')' ?></div>

                                    <div>&nbsp;</div>

                                    <div id="stock-price-lt"><strong>Last Trade</strong></div>
                                    <div id="stock-time-<?php echo $data[0] ?>"><?php echo $data[6] ?></div>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        fclose($handle);

                        ?>

                    </div>
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