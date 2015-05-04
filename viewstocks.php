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
        <title>TradeNet | View Stocks</title>
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
            <li><a href="viewstocks.php" class="first">View Stocks</a></li>
            <li><a href="buy.php">Buy</a></li>
            <li><a href="sell.php">Sell</a></li>
            <li><a href="transfer.php">Transfer</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <div id="content">
        <div id="page">
            <div id="column1">
                <?php
                if(isset($error)){
                    echo '<h2 style="color: red">' . $error . '</h2><br/>';
                }
                ?>

                <?php

                if (isset($_POST['stock'])) {
                    $url = 'http://finance.yahoo.com/d/quotes.csv?s=' . $_POST['stock'] . '&f=' . 'snl1c1p2d1t1v';
                    $handle = fopen($url, 'r');
                    while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                        ?>
                        <a href='http://finance.yahoo.com/q?s=<?php echo $data[0] ?>' target='_blank'>
                            <div class="span2 row-margin-small" style="margin-left: 200px">
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

                                            <div
                                                id="stock-delta-<?php echo $data[0] ?>"><?php echo $data[3] ?></div>
                                            <div
                                                id="stock-perc-<?php echo $data[0] ?>"><?php echo '(' . $data[4] . ')' ?></div>

                                            <div>&nbsp;</div>

                                            <div id="stock-price-lt"><strong>Last Trade</strong></div>
                                            <div
                                                id="stock-time-<?php echo $data[0] ?>"><?php echo $data[6] . ' EST' ?></div>
                                        </div>
                                    </div>
                                </div>
                        </a>
                    <?php
                    }
                    fclose($handle);
                }
                ?>

                <form method="post" name="sell" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                      accept-charset="utf-8">
                    <table border="0" style="border-collapse: collapse; padding: 0; left:10%; width:550px;">
                        <tbody>
                        <tr>
                            <td style="text-align:center;">
                                <label for="stock" style="float:left;width:170px;">Stock Symbol:</label>
                                <input type="text" name="stock" id="stock" value="" maxlength="5"
                                       placeholder="Stock"
                                       onkeydown="if (event.keyCode == 13) document.getElementById('Submit').click()"/>

                                <div style="clear:left;height:10px;">&nbsp;</div>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;">
                                <button id="submit" type="submit" value="Submit">Submit</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </form>
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