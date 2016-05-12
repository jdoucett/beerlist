<?php
$type_in = strval($_GET['type_input']);
$style_table_name = $type_in . "_Styles";

include 'dbconnect.php';
$style_con =  mysqli_connect($db_host,$db_username,$db_pwd,$db_name);
//check connection 
if (!$style_con) {
	echo "Could not connect";
  die('Could not connect: ' . mysqli_error($style_con));
}

$sql_style ="SELECT * FROM " . $style_table_name . " ORDER BY " . $style_table_name .".Rank";
if ($result = $style_con->query($sql_style)) {
    printf("Select returned %d rows.\n <br>", $result->num_rows);
    while($row = $result->fetch_assoc()){
        echo "<option value='". $row['Style']."'>".$row['Rank']. " ". $row['Style']
        .'</option>';
    }
    /* free result set */
    $result->close();
}

else {
	echo "<option value='Error'>".$sql_style."</option>";
}


//close connection
mysqli_close($style_con);
?>