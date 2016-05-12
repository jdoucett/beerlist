<!DOCTYPE html>
<html lang="en"><html> 
<head>
<title>THC Meeting Beverage List</title>
<?php include 'head.php';?><br>
</head>
<body onload="curRow()">
<div class="container">
<?php 
include 'dbconnect.php';
$mysqli = mysqli_connect($db_host,$db_username,$db_pwd,$db_name);
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();

}
include 'meeting_bev_body.php';
?>
</div>
<body>