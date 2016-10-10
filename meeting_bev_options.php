<?php
include 'dbconnect.php';
$mysqli = mysqli_connect($db_host,$db_username,$db_pwd,$db_name);
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
?>

<!--This creates the beverage type drop down box-->
<div class="form-group <?php echo $brwr_first_name_Error; ?>">
    <label for="bev_type" class="col-sm-2 control-label">* Beverage Type:  </label>
    <div class="col-sm-10">
        <select name= 'bev_type' class="form-control" onchange="showStyles(this.value)">
<?php
// Execute the query (the recordset $rs contains the result)
/* Select queries return a resultset */
if ($result = $mysqli->query("SELECT * FROM Bev_Type ORDER BY Rank ")) {
    printf("Select returned %d rows.\n <br>", $result->num_rows);
	while($row = $result->fetch_assoc()){
	    echo "<option value='". $row['Beverage_Type']."'>".$row['Rank']. " ". $row['Beverage_Type']
 		.'</option>';
	}
    /* free result set */
    $result->close();
}
?>
    </select>
    </div>
</div>
<!--This creates the beverage style drop down box-->

<div class="form-group <?php echo $brwr_first_name_Error; ?>">
    <label for="bev_style" class="col-sm-2 control-label <?php echo $brwr_first_name_Error; ?>">* Beverage Style: </label>
    <div class="col-sm-10">
        <select name= 'bev_style' class="form-control" id="bev_style_div" onchange="showCategories(this.value)">
<?php
// Execute the query (the recordset $rs contains the result)
/* Select queries return a resultset */
if ($result = $mysqli->query("SELECT * FROM Beer_Styles  ORDER BY Beer_Styles.Rank")) {
    printf("Select returned %d rows.\n <br>", $result->num_rows);
    while($row = $result->fetch_assoc()){
        echo "<option value='". $row['Style']."'>".$row['Rank']. " ". $row['Style']
        .'</option>';
    }
    /* free result set */
    $result->close();
}
?>
    </select>
    </div>
</div>
<!--This creates the beer category drop down box-->

<div class="form-group <?php echo $brwr_first_name_Error; ?>">
    <label for="bev_category" class="col-sm-2 control-label">* Beverage Category: </label>
    <div class="col-sm-10">
        <select name= 'bev_category' class="form-control" id="bev_cat_div">

<?php
// Execute the query (the recordset $rs contains the result)
/* Select queries return a resultset */
if ($result = $mysqli->query("SELECT * FROM Beer_Categories INNER JOIN Beer_Styles ON Beer_Categories.Style = Beer_Styles.Style WHERE Beer_Categories.Style = 'Standard American Beer' ORDER BY Beer_Styles.Rank, Beer_Categories.Rank ")) {
    printf("Select returned %d rows.\n <br>", $result->num_rows);
	while($row = $result->fetch_assoc()){
	    echo "<option value='". $row['Category']."'>".$row['Rank']. " ". $row['Category']
 		.'</option>';
	}
    /* free result set */
    $result->close();
}
?>
    </select>
    </div>
</div>
<!--This creates the additional characteristics drop down box-->

<div class="form-group">
    <label for="bev_fshvkw" class="col-sm-2 control-label">Additions:  </label>
    <div class="col-sm-10">
        <select name= "bev_fshvkw" class="form-control" id="bev_fshvkw">
        <option value="">None</option>
<?php
// Execute the query (the recordset $rs contains the result)
/* Select queries return a resultset */
if ($result = $mysqli->query("SELECT * FROM FSHVKW ORDER BY Rank ")) {
    printf("Select returned %d rows.\n <br>", $result->num_rows);
    while($row = $result->fetch_assoc()){
        echo "<option value='". $row['Addition']."'>".$row['Rank']. " ". $row['Addition']
        .'</option>';
    }
    /* free result set */
    $result->close();
}
?>
    </select>
    </div>

</div>
