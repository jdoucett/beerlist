<!DOCTYPE html>
<html lang="en">
<head>
<title>THC Meeting Beer Entries</title>
<?php include 'head.php';?><br>
</head>
<body>
<div class="container">
<script src="http://code.jquery.com/jquery.js"></script>
<script src="bootstrap-3.1.1-dist/js/bootstrap.min.js"></script>

<?php 
//set date
date_default_timezone_set('America/New_York');
$timezone = date_default_timezone_get();
$date = date('Y/m/d H:i:s');
?>
<div class="row text-center">
	<div >
		<h2>
		<?php 
			echo $date . "<br>";  
		?>
	 	</h2>
	</div>
</div>


<?php
//set variables
$brwr_first_name = $_POST['brwr_first_name'];
$brwr_last_name = $_POST['brwr_last_name'];
$asst_brwr_first_name = $_POST['asst_brwr_first_name'];
$asst_brwr_last_name = $_POST['asst_brwr_last_name'];
$email = $_POST['email'];
$bev_type = $_POST['bev_type'];
$bev_style = $_POST['bev_style'];
$bev_cat = $_POST['bev_category'];
$abv = $_POST['abv'];
$ibu = $_POST['ibu'];
$des = $_POST['description'];
$email = $_POST['email'];
include 'dbconnect.php';
$mysqli =  mysqli_connect($db_host,$db_username,$db_pwd,$db_name);

//Make sure abv and ibu are numbers
if ($abv == false){
	$abv = 0;
}
if ($ibu == false){
	$ibu = 0;
}
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
$insert_stmt = "INSERT INTO `Brew_Info` (`Date_Entered`, 
`Brewer_First_Name`,`Brewer_Last_Name`,`Asst_Brewer_First`,`Asst_Brewer_Last`,`Beverage_Type`,`Style`,`Category`,`ABV`,`IBU`,`Description`,`Email`) VALUES ('{$date}', '{$brwr_first_name}', '{$brwr_last_name}','{$asst_brwr_first_name}','{$asst_brwr_last_name}','{$bev_type}','{$bev_style}','{$bev_cat}',$abv,$ibu,'{$des}','{$email}')";
$stmt = $mysqli->query($insert_stmt);
?>
<br>
<div class="row text-center">
	<div>
		<h2> Thank you for submitting a 
		<br />
<?php
 echo $bev_style . " style " . $bev_type . " " . $brwr_first_name . " " . $brwr_last_name; 
?>
		</h2>
	</div>
</div>
<br>


<div class="row">
	<div style="padding:30px">
		<a href="meeting_beer.php" type="button" class="btn btn-primary btn-lg btn-block">Enter Another Beverage</a>
	</div>
</div>
<div class="row">	
	<div style="padding:30px">
		<a href="meeting_bev_list.php" type="button" class="btn btn-info btn-lg btn-block">View List</a>
	</div>
</div>

</div>
</body>
</html>