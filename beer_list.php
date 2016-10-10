<?php
$url = "https://docs.google.com/spreadsheet/pub?key=0Av4Q9Zv953ATdDRLUFdrazAxWmRUWUE1NW5lMG1zVEE&single=true&gid=0&output=csv";
$row=0;
date_default_timezone_set('America/New_York');
$timezone = date_default_timezone_get();
$date = date('m/d/Y');

$beer_array = array();
//echo $date . "\n";
if (($handle = fopen($url, "r")) !== FALSE) {
	    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        	for ($c=0; $c < $num; $c++) {
            	$beer_array[$row][$c] = $data[$c];   
            }
        $row++;
    }
    fclose($handle);
}


echo ("<br />");
if (empty($beer_array)) {
//console.log("Data array is empty");\
echo("Array Empty");
}
else {
	//echo("Brew Array <br >");
	$rows = count($beer_array); // This will get you the number of rows
	echo("Number of entries   " . ($rows - 1) . "<br />");
	foreach ($beer_array as $row => $column);
	{
    	$cols = count($row);
    	echo("number of columns " . $cols . "<br />");
	}	
	echo ("Showing beers for " . $date . " <br />");
	echo ("<br />");
	    echo("<table style=\"width:100%;border: 1px solid black\"
>");
	  	foreach ($beer_array as $i => $row) {		
		$match_date = date('m/d/Y',strtotime($beer_array[$i][0]));
		//echo("Match date " . $match_date . " <br />");

	   		if ($match_date == $date){
			//echo("Date for row " . $i . " matches <br />");
			echo("<tr>");		
			for ($c=0; $c < $num; $c++) {
				if(empty($beer_array[$i][$c])){
					//Do nothing
				}
				else {
            	echo("<td style=\"border: 1px solid black\">");
            	echo($beer_array[$i][$c]);   
            	echo("</td>");
            	}
            }
       		echo("</tr>");
			echo("<br />");
			}
		else {
			//echo("Date for row " . $i . " doesn't match <br />");
			//echo("Match date is  " . $match_date . " and date is " . $date . "<br />");
		}		
	}
			echo("</table>");
}
