<?php
$url = "https://spreadsheets.google.com/pub?hl=en&hl=en&key=0AupgXsRU8E9UdC1DY0toUUJLV0M0THM4cGJTSkNSUnc&output=csv";
$row=0;

if (($handle = fopen($url, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        echo "<p> $num fields in line $row: <br /></p>\n";
        $row++;
        for ($c=0; $c < $num; $c++) {
            echo $data[$c] . "<br />\n";
        }
    }
    fclose($handle);
}
