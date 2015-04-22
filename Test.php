<?php

//function stock_ticker ($symbols, $background_color, $stock_color, $price_color, $up_color, $down_color, $speed)
//{
//    sort($symbols);
//
//    if ($background_color==$stock_color) {
//        // something's wrong, colors weren't specified
//        $background_color = invert_color($background_color);
//    }
//
//    $return = '<div align="center">
//  <marquee bgcolor="#'.$background_color.'" loop="20" scrollamount="'.$speed.'">';
//
//    foreach ($symbols as $symbol) {
//        $data = file_get_contents("http://quote.yahoo.com/d/quotes.csv?s=$symbol&f=sl1d1t1c1ohgv&e=.csv");
//
//        $values = explode(",", $data);
//        $lasttrade = $values[1];
//        $change = $values[4];
//
//        $return .= "<span style=\"color:#$stock_color\">$symbol</span> &nbsp;";
//        $return .= "<span style=\"color:#$price_color\">$lasttrade</span> &nbsp;";
//        if ($change<0)
//            $return .= "<span style=\"color:#$down_color\">$change</span> &nbsp;";
//        else
//            $return .= "<span style=\"color:#$up_color\">$change</span> &nbsp;";
//        $return .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
//    }
//
//    $return .= '</marque>
//  </div>';
//
//    return $return;
//}
//
//$stocks = array("AAPL", "T");
//
//$ticker = stock_ticker($stocks, 'dddddd', 'black', '0000bb', 'green', 'red', 6);
//echo $ticker;


$arr = array('AAPL','YHOO');
$url= 'http://finance.yahoo.com/d/quotes.csv?s='.implode('+', $arr).'&f='.'snl1c1jkd1t1';
echo '<table>';
$handle = fopen($url, 'r');
while (($data = fgetcsv($handle, 1000, ',')) !== FALSE)
{
    echo '<tr>';
    foreach($data as $d)
        echo "<td>$d</td>";
    echo '</tr>';
}
fclose($handle);
echo '</table>';
?>
