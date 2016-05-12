<?php
include 'dbconnect.php';
$rowcon = mysqli_connect($db_host,$db_username,$db_pwd,$db_name);
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
$Cur_Row_query = "SELECT Current_Row FROM Cur_Row WHERE id=0";
if ($rowResult = $rowcon->query($Cur_Row_query)) {
    $curRowResult = $rowResult->fetch_assoc();
    $curRow = $curRowResult['Current_Row'];
    echo $curRow;
}
else {
	echo "no result returned";
}
// close connection
mysqli_close($rowcon);
?>