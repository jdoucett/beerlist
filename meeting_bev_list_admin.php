<!DOCTYPE html>
<html lang="en"><html> 
<head>
<title>THC Meeting Beverage List</title>
<?php 
include 'dbconnect.php';
$change_direction = '+';
$mysqli = mysqli_connect($db_host,$db_username,$db_pwd,$db_name);
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();

}
if ($_SERVER["REQUEST_METHOD"] == "POST"){

}
include 'head.php';
?>
<br>
</head>
<body onload="curRow()">
<div class="container">
    <div class="row">
        <form method="POST" action="meeting_bev_list_admin.php">
        <div class="col-md-6">
                <input type="submit" name="row_change" value="-" class="btn btn-danger btn-lg btn-block"/>
        </div>
        <div class="col-md-6">    
                <input type="submit" name="row_change" value="+" class="btn btn-success btn-lg btn-block"/>
        </div>
        <form method="POST" action="meeting_bev_list_admin.php">
    </div>
<?php include 'meeting_bev_body.php';?>
</div>
<?php
$change_direction = $_POST['row_change'];
$update_stmt = " UPDATE `Cur_Row` SET `Current_Row`=Current_Row" . $change_direction ."1 WHERE `id`=0";
if (!empty($change_direction)){
    $stmt = $mysqli->query($update_stmt);
}
?>
<body>