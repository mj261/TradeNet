<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', '1');
error_reporting(E_ALL | E_STRICT);

include_once 'classes/tools.php';

sec_session_start();

if (login_check($db) === true) {

    if (isset($_POST['stock'], $_POST['amount'])) {
        if($_POST['stock'] === ''){
            $error = 'Please enter a valid stock symbol!';
        }
        elseif($_POST['amount'] === '' or (int)$_POST['amount'] === 0){
            $error = 'Please enter a valid number of stocks!';
        }
        else{
            $price = 0;
            $Stock_to_Buy = $_POST['stock'];
            $Amount_of_Stocks = $_POST['amount'];
            $url = 'http://finance.yahoo.com/d/quotes.csv?s=' . $Stock_to_Buy . '&f=' . 'l1';
            $handle = fopen($url, 'r');
            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                $price = $data[0];
            }
            fclose($handle);

            if($price >= 0 and $price !== 'N/A'){
                $stocks = $db->prepare('SELECT Balance FROM Customers WHERE ID = ?');
                $stocks->bind_param('s', $_SESSION['user_id']);
                $stocks->execute();
                $stocks->store_result();
                $stocks->bind_result($Balance);
                $stocks->fetch();
                $stocks->close();
                if(($Amount_of_Stocks*$price)>$Balance){
                    $error = 'You do not have enough money in your account!';
                }
                else{
                    $time = time();
                    $newBalance = $Balance - ($Amount_of_Stocks*$price);
                    $update = $db->prepare('UPDATE Customers SET Balance = ? WHERE ID = ?');
                    $update->bind_param('ss', $newBalance, $_SESSION['user_id']);
                    $update->execute();
                    $update->close();
                    $update2 = $db->prepare('INSERT INTO `Transactions`(`Customer`, `Stock`, `Number`, `Time`) VALUES (?,?,?,?)');
                    $update2->bind_param('ssss', $_SESSION['user_id'], $Stock_to_Buy, $Amount_of_Stocks, $time);
                    $update2->execute();
                    $update2->close();
                    $update3 = $db->prepare('INSERT INTO `Portfolio`(`Customer`, `Stock`, `Shares`, `Price`) VALUES (?,?,?,?)');
                    $update3->bind_param('ssss', $_SESSION['user_id'], $Stock_to_Buy, $Amount_of_Stocks, $price);
                    $update3->execute();
                    $update3->close();
                    header('Location: /customerhome.php');
                }
            }
            else{
                $error = 'Please enter a valid stock symbol!';
            }
        }
    }
    ?>

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>TradeNet | Buy</title>
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
            <li><a href="buy.php" class="first">Buy</a></li>
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

                <form method="post" name="buy" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
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

                                <label for="amount" style="float:left;width:170px;">Number of Stocks:</label>
                                <input type="text" name="amount" id="amount" value="" maxlength="5"
                                       placeholder="Amount"
                                       onkeydown="if (event.keyCode == 13) document.getElementById('Submit').click()"/>

                                <div style="clear:left;height:20px;">&nbsp;</div>
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