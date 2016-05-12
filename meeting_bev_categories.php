<?php
$style_in = strval($_GET['style_input']);
$type_in = strval($_GET['type_input']);

//Set table name based on style
$cat_table_name = $type_in . "_Categories";

include 'dbconnect.php';
$style_con =  mysqli_connect($db_host,$db_username,$db_pwd,$db_name);
//check connection 
if (!$style_con) {
	echo "Could not connect";
  die('Could not connect: ' . mysqli_error($style_con));
}

//if get beer styles
$sql_cat ="SELECT * FROM " . $cat_table_name . " WHERE Style = '" . $style_in ."'  ORDER BY " . $cat_table_name . ".Rank";
if ($result = $style_con->query($sql_cat)) {
    printf("Select returned %d rows.\n <br>", $result->num_rows);
    while($row = $result->fetch_assoc()){
        echo "<option value='". $row['Category']."'>".$row['Rank']. " ". $row['Category']
        .'</option>';
    }
    /* free result set */
    $result->close();
}

else {
	echo "<option value='Error'>No Categories Found</option>";
}


//close connection
mysqli_close($style_con);
?>