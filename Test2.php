<?php
$arr = array('AAPL');
$url = 'http://finance.yahoo.com/d/quotes.csv?s=' . implode('+', $arr) . '&f=' . 'snl1c1p2d1t1v';
echo '<table>';
$handle = fopen($url, 'r');
while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
    echo '<tr>';
    foreach ($data as $d)
        echo "<td>$d</td>";
    echo '</tr>';
}
fclose($handle);
echo '</table>';

