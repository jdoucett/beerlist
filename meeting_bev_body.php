<script src="http://code.jquery.com/jquery.js"></script>
<script src="bootstrap-3.1.1-dist/js/bootstrap.min.js"></script>
<script>
var curRowValue = "0";
</script>
<?php
date_default_timezone_set('America/New_York');
$timezone = date_default_timezone_get();
$date = date('Y-m-d');//date('m/d/Y');
$refreshtime = 5000;

?>
<script>

window.setInterval(curRow, <?php echo $refreshtime; ?>);

//Set categories based on style
function curRow() {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      dbRowValue = xmlhttp.responseText;
      console.log ("value of current row " + dbRowValue);
      if (dbRowValue != curRowValue) {
        console.log ("curRowValue " + curRowValue);
        console.log ("dbRowValue " + dbRowValue);
        oldRow = curRowValue;
        window.curRowValue = dbRowValue;
        updatecurRowValue = "bevtablerownum_" + curRowValue;
        updateOldRow = "bevtablerownum_" + oldRow;
        console.log (updatecurRowValue);
        console.log (updateOldRow);
        if (oldRow > 0){    
            document.getElementById(updateOldRow).style.backgroundColor="white";
            document.getElementById(updateOldRow).style.color="black";
        }
        document.getElementById(updatecurRowValue).style.backgroundColor="green";
        document.getElementById(updatecurRowValue).style.color="white";        
        console.log ("curRowValue " + curRowValue);
        console.log ("oldRow " + oldRow);      }
    }
  }
  xmlhttp.open("GET","meeting_bev_list_row_number.php",true);
  xmlhttp.send();
}
// function curRowValue(currentRowJS,oldRowJS) {
//     console.log (currentRowJS);
//     updatecurRowValue = "bevtablerownum_" + currentRowJS;
//     updateOldRow = "bevtablerownum_" + oldRowJS;
//     console.log (updatecurRowValue);
//     console.log (updateOldRow);    
//     document.getElementById(updateOldRow).style.backgroundColor="white";
//     document.getElementById(updateOldRow).style.color="black";
//     document.getElementById(updatecurRowValue).style.backgroundColor="green";
//     document.getElementById(updatecurRowValue).style.color="white";
// }
</script>
<?php
//Create variable to store values for start and end time of records to display
$datecheckstart =date('Y-m-d', strtotime('-1 day', strtotime($date))) . ' 00:00:00';
$datecheckend = date('Y-m-d', strtotime('+1 day', strtotime($date))) . ' 00:00:00';

//Header text
echo "<h1>THC Meeting Beverage List for ";
echo $date;
echo "</h1>";
?>
<!--Table Showing Results -->
<table class="table">
<tr><th>Order</th><th>First</th><th>Last</th><th>Style</th><th>Category</th><th>ABV</th><th>IBU</th><th>Notes</th></td></tr>
<?php
//Echo date range to screen
// echo "Date range " . $datecheckstart . " to " . $datecheckend." <br>";
//Sorting order is type, non-smoked beer then smoked beer, beer by style and category, Mead by style and category, Cider by style and category, and Wine by style and category
$Set_big_querry = "SET OPTION SQL_BIG_SELECTS = 1";
$mysqli->query($Set_big_querry);
$Big_query = "SELECT DISTINCT Brew_Info.UID, Brew_Info.Date_Entered, Brew_Info.Brewer_First_Name, Brew_Info.Brewer_Last_Name, Brew_Info.Asst_Brewer_First, Brew_Info.Asst_Brewer_Last, Brew_Info.Beverage_Type, Brew_Info.Style, Brew_Info.Category, Brew_Info.FSHVKW, Brew_Info.ABV, Brew_Info.IBU, Brew_Info.Description, Brew_Info.Email, Brew_Info.Tasted, Brew_Info.Smoked FROM Brew_Info INNER JOIN Bev_Type ON Brew_Info.Beverage_Type = Bev_Type.Beverage_Type LEFT JOIN Beer_Styles ON Brew_Info.Style = Beer_Styles.Style LEFT JOIN Beer_Categories ON Brew_Info.Category = Beer_Categories.Category LEFT JOIN Mead_Styles ON Brew_Info.Style = Mead_Styles.Style LEFT JOIN Mead_Categories ON Brew_Info.Category = Mead_Categories.Category LEFT JOIN Cider_Styles ON Brew_Info.Style = Cider_Styles.Style LEFT JOIN Cider_Categories ON Brew_Info.Category = Cider_Categories.Category LEFT JOIN Wine_Styles ON Brew_Info.Style = Wine_Styles.Style LEFT JOIN Wine_Categories ON Brew_Info.Category = Wine_Categories.Category LEFT JOIN FSHVKW ON Brew_Info.FSHVKW = FSHVKW.Addition WHERE Brew_Info.Date_Entered >= '{$datecheckstart}' AND Brew_Info.Date_Entered <= '{$datecheckend}'  ORDER BY Bev_Type.Rank, Brew_Info.Smoked, Beer_Styles.Rank,Beer_Categories.Rank, Mead_Styles.Rank,Mead_Categories.Rank, Cider_Styles.Rank,Cider_Categories.Rank, Wine_Styles.Rank,Wine_Categories.Rank,FSHVKW.Rank";
if ($result = $mysqli->query($Big_query)) {
    //printf("Select returned %d rows.\n <br>", $result->num_rows);
    $i = 1;
    while($row = $result->fetch_assoc()){
        echo $row[0];
    	echo "<tr id=\"bevtablerownum_" . $i . "\">";
	    echo "<td>" .$i . "</td> <td> " . $row['Brewer_First_Name'] . "</td> <td> " . $row['Brewer_Last_Name'] . "</td>  <td> " . $row['Style'] . "</td> <td> " . $row['Category'] . "</td> <td> " . $row['ABV'] . "</td> <td> " . $row['IBU'] . "</td> <td> " . $row['FSHVKW'] . " " .$row['Description'] . "</td>";
	    echo "</tr>";
	    $i += 1;
	}
    /* free result set */

    $result->close();
}
else {
    printf ("query = %s ",$Big_query);
}
?>
<script>
curRow();
</script>
</table>
<div class="row">   
    <div style="padding:20px">
        <a href="meeting_bev.php" type="button" class="btn btn-primary btn-lg btn-block">Enter New Beverage</a>
    </div>
</div>
<div class="row">   
    <div style="padding:20px">
        <a href="bev_stats.php" type="button" class="btn btn-warning btn-lg btn-block">View Charts</a>
    </div>
</div>
