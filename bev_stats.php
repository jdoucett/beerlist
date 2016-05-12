<!DOCTYPE html>
<html lang="en">
<head>
<title>THC Meeting Bev Stats</title>
<?php include 'head.php';?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="http://code.highcharts.com/highcharts.js"></script>
</head>
<body>
<div class="container">
	<div class="row text-center">
		<h1>Meeting Beverage Summary Charts</h1>
	</div>
<?php
date_default_timezone_set('America/New_York');
$timezone = date_default_timezone_get();
$date = date('Y-m-d');//date('m/d/Y');

//Create variable to store values for start and end time of records to display
$datecheckstart =date('Y-m-d', strtotime('-1 day', strtotime($date))) . ' 00:00:00';
$datecheckend = date('Y-m-d', strtotime('+1 day', strtotime($date))) . ' 00:00:00';

include 'dbconnect.php';
$stat_con =  mysqli_connect($db_host,$db_username,$db_pwd,$db_name);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();

}
?>
<div id="type_container" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
<div id="beer_container" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
<div id="mead_container" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
<div id="cider_container" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
<div id="wine_container" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>

<?php
//Display Beverage Type Statistics
$count_type = "SELECT Beverage_Type, count(Beverage_Type), Date_Entered FROM Brew_Info WHERE Beverage_Type <> '' AND Date_Entered >= '{$datecheckstart}' AND Date_Entered <= '{$datecheckend}' GROUP BY Beverage_Type;";
if ($result = $stat_con->query($count_type)) {
    // printf("Select returned %d rows.\n <br>", $result->num_rows);
    $Style_count = 0;
    while($row = $result->fetch_assoc()){
	    $Type_stats = $Type_stats . "['" . $row['Beverage_Type'] . "', " . $row['count(Beverage_Type)'] ."],";
        $Style_count++;
    }
    $Type_stats = rtrim($Type_stats, ','); 
    if ($Style_count > 0){
        ?>
        <script>
        $(function () {
            $('#type_container').highcharts({
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false
                },
                title: {
                    text: 'Beverage Types '
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                            style: {
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            }
                        }
                    }
                },
                series: [{
                    type: 'pie',
                    name: 'Percent people who brought: ',
                    data: [
                        <?php echo $Type_stats; ?>
                    ]
                }]
            });
        });
        </script>    
        <?php        
    }
    else {
        //no results, blank all
        ?>
        <script>
        document.getElementById('type_container').innerHTML = "<h4 style='text-align:center;'>No beverage entries</h4>"; 
        document.getElementById('type_container').style.height = "100px";
        document.getElementById('beer_container').innerHTML = "<h4 style='text-align:center;'>No beer entries</h4>"; 
        document.getElementById('beer_container').style.height = "100px";
        document.getElementById('mead_container').innerHTML = "<h4 style='text-align:center;'>No mead entries</h4>"; 
        document.getElementById('mead_container').style.height = "100px";
        document.getElementById('cider_container').innerHTML = "<h4 style='text-align:center;'>No cider entries</h4>"; 
        document.getElementById('cider_container').style.height = "100px";
        document.getElementById('wine_container').innerHTML = "<h4 style='text-align:center;'>No wine entries</h4>"; 
        document.getElementById('wine_container').style.height = "100px";
        </script>
        <?php
    }
}
/* free result set */
$result->close();

//Display Beer Style Statistics
$count_style_beer = "SELECT Style, count(Style), Date_Entered FROM  Brew_Info WHERE Beverage_Type = 'Beer' and Style <> '' AND Date_Entered >= '{$datecheckstart}' AND Date_Entered <= '{$datecheckend}' GROUP BY Style;";
if ($result = $stat_con->query($count_style_beer)) {
    //printf("Select returned %d rows.\n <br>", $result->num_rows);
    $Beer_count = 0;
    while($row = $result->fetch_assoc()){
       $Beer_stats = $Beer_stats . "['" . $row['Style'] . "', " . $row['count(Style)'] ."],";
       $Beer_count++;
    }
    $Beer_stats = rtrim($Beer_stats, ',');
    if ($Beer_count > 0){       
        ?>
        <script>
        $(function () {
            $('#beer_container').highcharts({
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false
                },
                title: {
                    text: 'Beer Styles'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                            style: {
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            }
                        }
                    }
                },
                series: [{
                    type: 'pie',
                    name: 'Percent people who brought: ',
                    data: [
                        <?php echo $Beer_stats; ?>
                    ]
                }]
            });
        });
        </script>
        <?php    
    }
    else {
        //no results, blank all
        ?>
        <script>
        document.getElementById('beer_container').innerHTML = "<h4 style='text-align:center;'>No beer Entries</h4>"; 
        document.getElementById('beer_container').style.height = "100px";        
        </script>
        <?php
    }    
}
/* free result set */
$result->close();

//Display Mead Style Statistics
$count_style_mead = "SELECT Style, count(Style), Date_Entered FROM  Brew_Info WHERE Beverage_Type = 'Mead' and Style <> '' AND Date_Entered >= '{$datecheckstart}' AND Date_Entered <= '{$datecheckend}' GROUP BY Style;";
if ($result = $stat_con->query($count_style_mead)) {
    // printf("Select returned %d rows.\n <br>", $result->num_rows);
    $Mead_count = 0;
    while($row = $result->fetch_assoc()){
	    $Mead_stats = $Mead_stats . "['" . $row['Style'] . "', " . $row['count(Style)'] ."],";
        $Mead_count++;
    }
    $Mead_stats = rtrim($Mead_stats, ',');  
    if ($Mead_count > 0) {
        ?>
        <script>
        $(function () {
            $('#mead_container').highcharts({
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false
                },
                title: {
                    text: 'Mead Styles'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                            style: {
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            }
                        }
                    }
                },
                series: [{
                    type: 'pie',
                    name: 'Percent people who brought: ',
                    data: [
                        <?php echo $Mead_stats; ?>
                    ]
                }]
            });
        });  
        </script>
        <?php
    }
    else {
        //no results, blank all
        ?>
        <script>
        document.getElementById('mead_container').innerHTML = "<h4 style='text-align:center;'>No mead entries</h4>"; 
        document.getElementById('mead_container').style.height = "100px";        
        </script>
        <?php
    }      
}
/* free result set */
$result->close();

//Display Cider Style Statistics
$count_style_cider = "SELECT Style, count(Style), Date_Entered FROM  Brew_Info WHERE Beverage_Type = 'Cider' and Style <> '' AND Date_Entered >= '{$datecheckstart}' AND Date_Entered <= '{$datecheckend}' GROUP BY Style;";
if ($result = $stat_con->query($count_style_cider)) {
// printf("Select returned %d rows.\n <br>", $result->num_rows);
    $Cider_count = 0;
    while($row = $result->fetch_assoc()){
       $Cider_stats = $Cider_stats . "['" . $row['Style'] . "', " . $row['count(Style)'] ."],";
       $Cider_count++;
    }
    $Cider_stats = rtrim($Cider_stats, ',');    
    if ($Cider_count > 0) {
        ?>
        <script>
        $(function () {
            $('#cider_container').highcharts({
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false
                },
                title: {
                    text: 'Cider Styles'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                            style: {
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            }
                        }
                    }
                },
                series: [{
                    type: 'pie',
                    name: 'Percent people who brought: ',
                    data: [
                        <?php echo $Cider_stats; ?>
                    ]
                }]
            });
        });  
        </script>
        <?php
    }
    else {
        //no results, blank all
        ?>
        <script>
        document.getElementById('cider_container').innerHTML = "<h4 style='text-align:center;'>No cider entries</h4>"; 
        document.getElementById('cider_container').style.height = "100px";
        </script>
        <?php
    }  
}
/* free result set */
$result->close();

//Display Wine Style Statistics
$count_style_wine = "SELECT Style, count(Style), Date_Entered FROM  Brew_Info WHERE Beverage_Type = 'Wine' and Style <> '' AND Date_Entered >= '{$datecheckstart}' AND Date_Entered <= '{$datecheckend}' GROUP BY Style;";
if ($result = $stat_con->query($count_style_wine)) {
    // printf("Select returned %d rows.\n <br>", $result->num_rows);
    $Wine_count = 0;
    while($row = $result->fetch_assoc()){
	    $Wine_stats = $Wine_stats . "['" . $row['Style'] . "', " . $row['count(Style)'] ."],";
        $Wine_count++; 
    }
    $Wine_stats = rtrim($Wine_stats, ',');
    $Count_wine_stats = count($Wine_stats, COUNT_RECURSIVE);
    if ($Wine_count > 0) {      
        ?>
        <script>
        $(function () {
            $('#wine_container').highcharts({
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false
                },
                title: {
                    text: 'Wine Styles'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                            style: {
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            }
                        }
                    }
                },
                series: [{
                    type: 'pie',
                    name: 'Percent people who brought: ',
                    data: [
                        <?php echo $Wine_stats; ?>
                    ]
                }]
            });
        });
        </script>
        <?php    
    }
    else {
        //no results, blank all
        ?>
        <script>
        document.getElementById('wine_container').innerHTML = "<h4 style='text-align:center;'>No wine entries</h4>"; 
        document.getElementById('wine_container').style.height = "100px";        
        </script>
        <?php
    }      
}
/* free result set */
$result->close();


//close connection
mysqli_close($stat_con);
?>
<div class="row">
    <div style="padding:20px">
        <a href="meeting_bev.php" type="button" class="btn btn-primary btn-lg btn-block">Add Beverage To List</a>
    </div>
</div>
<div class="row">   
    <div style="padding:20px">
        <a href="meeting_bev_list.php" type="button" class="btn btn-info btn-lg btn-block">View List</a>
    </div>
</div>
</div>
</body>
<script>
</script>    
</html>