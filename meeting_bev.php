<!DOCTYPE html>
<html lang="en">
<head>
<title>THC Meeting Beverage Entries</title>
<?php include 'head.php';
// define variables and set to empty values
$brwr_first_name_Error = $brwr_last_name_Error = $asst_brwr_first_name_Error = $asst_brwr_last_name_Error = $email_Error = $bev_type_Error = $bev_style_Error = $bev_category_Error = $bev_fshvkw_Error = "";
$brwr_first_name = $brwr_last_name = $asst_brwr_first_name = $asst_brwr_last_name = $email = $bev_type = $bev_style = $bev_category = $bev_fshvkw = "";
   

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	// Validate values entered before posting
  	$brwr_first_name = test_input($_POST["brwr_first_name"]);
 		$brwr_last_name = test_input($_POST["brwr_last_name"]);
 		$asst_brwr_first_name = test_input($_POST["asst_brwr_first_name"]);
 		$asst_brwr_last_name = test_input($_POST["asst_brwr_last_name"]);
    $abv = test_input($_POST["abv"]);
    $ibu = test_input($_POST["ibu"]);
  	$bev_type = test_input($_POST["bev_type"]);
    $bev_style = test_input($_POST["bev_style"]);
  	$bev_category = test_input($_POST["bev_category"]);
    $bev_fshvkw = test_input($_POST['bev_fshvkw']);
    $des = test_input($_POST['description']);
    $email = test_input($_POST['email']);     


  //If any errors generate error message 
  if (empty($brwr_first_name) || empty($brwr_last_name) || empty ($abv) || empty($bev_type) || empty($bev_style) || empty($bev_category))
  	{$field_missing_Error = "Please complete all required fields.";}
  else {
  	$field_missing_Error = '';
  }

}

//function to clean inputs before submitting
function test_input($data)
	{
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
          $data = str_replace("'", "", $data);
	  return $data;
	}

?>
<script>
// Set type to beer to start so that style and category functions can populate drow down lists
var global_type = "Beer";
//function to show beverage style based on beverage type. Also launches show categories so they are updated with style. Runs on field in meeting_bev_options.php
function showStyles(type_str) {
  global_type = type_str;
  if (type_str=="") {
    document.getElementById("bev_style_div").innerHTML="";
    return;
  } 
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("bev_style_div").innerHTML=xmlhttp.responseText;
        //Populate category drop down with first category for style
		  if (type_str == "Beer") {
		  	showCategories("Standard American Beer")
		  }
		  else if (type_str == "Cider") {
		  	showCategories("Standard")
		  }
		  else if (type_str == "Mead") {
		  	showCategories("Traditional")
		  }
		  else if (type_str == "Wine") {
		  	showCategories("Sparkling")
		  }
		  //Should cause categories  not to be found.
		  else {
		  	showCategories("Flavored")
		  }		  
	}
  }
  xmlhttp.open("GET","meeting_bev_styles.php?type_input="+type_str,true);
  xmlhttp.send();

}

//Set categories based on style
function showCategories(style_str) {
  if (style_str=="") {
    document.getElementById("bev_cat_div").innerHTML="";
    return;
  } 
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("bev_cat_div").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","meeting_bev_categories.php?style_input="+style_str+"&type_input="+global_type,true);
  xmlhttp.send();
}

//Functions to validate inputs
function validateName(x){
      console.log ("validation test");
      console.log ("x = " + x);
      // Validation rule
      var re = /[A-Za-z -']$/;
      // Check input
      if(document.getElementById(x).value == "") {
        //do nothing
        return true
      }
      else if (re.test(document.getElementById(x).value)){
        // Style green
        document.getElementById(x).style.background ='#ccffcc';
        // Hide error prompt
        document.getElementById(x + '_Error').style.display = "none";
        console.log ("element id = " + x + "_Error");
        console.log("validation passed");
        return true;
      }else{
        // Style red
        document.getElementById(x).style.background ='#e35152';
        // Show error prompt
        console.log ("element id = " + x + "_Error");
        document.getElementById(x + '_Error').style.display = "block";
        document.getElementById(x + '_Error').innerHTML = "Field may only contain text";
        console.log("validation failed");
        return false; 
      }
    }
    //validate numbers
function validateNumber(x){
      // Validation rule
      var re = /[0-9]+(\.[0-9][0-9]?)?/;
      // Check input
      if(document.getElementById(x).value == "") {
        //do nothing
        return true
      }
      else if(re.test(document.getElementById(x).value)){
        // Style green
        document.getElementById(x).style.background ='#ccffcc';
        // Hide error prompt
        document.getElementById(x + '_Error').style.display = "none";
        return true;
      }else{
        // Style red
        document.getElementById(x).style.background ='#e35152';
        // Show error prompt
        document.getElementById(x + '_Error').style.display = "block";
        document.getElementById(x + '_Error').innerHTML = "Invalid number";
        return false; 
      }
    }  
    // Validate email
    function validateEmail(email){ 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      if(document.getElementById(email).value == "") {
        //do nothing
        return true
      }
      else if(re.test(document.getElementById(email).value)){
        document.getElementById(email).style.background ='#ccffcc';
        document.getElementById(email + '_Error').style.display = "none";
        return true;
      }else{
        //Style red
        document.getElementById(email).style.background ='#e35152';
        // Show error prompt
        document.getElementById(email + '_Error').style.display = "block";
        document.getElementById(email + '_Error').innerHTML = "Invalid email address format";
        return false;
      }
    }
    // Validate Select boxes
    function validateSelect(x){
      if(document.getElementById(x).selectedIndex !== 0){
        document.getElementById(x).style.background ='#ccffcc';
        document.getElementById(x + '_Error').style.display = "none";
        return true;
        }else{
        //Style red
        document.getElementById(x).style.background ='#e35152';
        // Show error prompt
        document.getElementById(x + '_Error').style.display = "block";
        document.getElementById(x + '_Error').innerHTML = "Please make a selection";
        return false; 
      }
    }
    function validateRadio(x){
      if(document.getElementById(x).checked){
        return true;
      }else{
        // Show error prompt
        document.getElementById(x + '_Error').style.display = "block";
        document.getElementById(x + '_Error').innerHTML = "Please make a selection";        
        return false;
      }
    }
    function validateCheckbox(x){
      if(document.getElementById(x).checked){
        return true;
      }else{
      // Show error prompt
      document.getElementById(x + '_Error').style.display = "block";
      document.getElementById(x + '_Error').innerHTML = "Please make a selection";        
      return false;
      }
    }   
    // Validate function from http://culttt.com/2012/08/08/really-simple-inline-javascript-validation/
    // function validateForm(){
    //   // Set error catcher
    //   var error = 0;
    //   // Check brewer name
    //   if(!validateName('brwr_first_name')){
    //     document.getElementById('brwr_first_nameError').style.display = "block";
    //     error++;
    //   }
    //   if(!validateName('brwr_last_name')){
    //     document.getElementById('brwr_last_nameError').style.display = "block";
    //     error++;
    //   }
    //   // Validate email
    //   if(!validateEmail(document.getElementById('email').value)){
    //     document.getElementById('emailError').style.display = "block";
    //     error++;
    //   }      
    //   // Check assistant brewer name      
    //   if(!validateName('asst_brwr_first_name')){
    //     document.getElementById('asst_brwr_first_nameError').style.display = "block";
    //     error++;
    //   }
    //   if(!validateName('asst_brwr_last_name')){
    //     document.getElementById('asst_brwr_last_nameError').style.display = "block";
    //     error++;
    //   }      

    //   // // Validate Radio
    //   // if(validateRadio('left')){
 
    //   // }else if(validateRadio('right')){
         
    //   // }else{
    //   //   document.getElementById('handError').style.display = "block";
    //   //   error++;
    //   // }
    //   if(!validateCheckbox('accept')){
    //     document.getElementById('termsError').style.display = "block";
    //     error++;
    //   }
    //   // Don't submit form if there are errors
    //   if(error > 0){
    //     return false;
    //   }
    // }     
</script>
</head>
<body onload="showConfirmation()">
<div class="container">
<script type="text/javascript" src="http://code.jquery.com/jquery.js"></script>
<script type="text/javascript" src="bootstrap-3.1.1-dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="lib/validate.min.js"></script>
<div class="row text-center">
	<div style="padding:15px">
		<h1>New Meeting Beverage Entry Form</h1>
	</div>
  <div class="row text-center">
  <h3 id="conf_h3" style="margin-top:0px"></h3> <!--Submission confirmation added here -->
  </div>  
</div>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="form-horizontal" role="form" name="bev_form" id="">
	<div class="form-group <?php echo $brwr_first_name_Error; ?> ">
		<label for="brwr_first_name" class="col-sm-2 control-label">* Brewer First Name: </label>
		<div class="col-sm-10">
			<!-- php if isset saves name of entered value in case validation fails -->
			<input type="text" name="brwr_first_name" class="form-control" id="brwr_first_name" placeholder="Joseph" onblur="checkRequired(id); validateName(name)">
		</div>
    <div id="brwr_first_name_Error" style="display:none">
    </div>
	</div>
  <script>
  </script>
	<div class="form-group">
		<label for="brwr_last_name" class="col-sm-2 control-label">* Brewer Last Name: </label>
		<div class="col-sm-10">
			<input type="text" name="brwr_last_name" class="form-control" id="brwr_last_name" placeholder="Hopfen" onblur="checkRequired(id); validateName(name)">
		</div>
    <div id="brwr_last_name_Error" style="display:none">
    </div>    
	</div>
	<div class="form-group">
		<label for="email" class="col-sm-2 control-label">Email Address: </label>
		<div class="col-sm-10">
			<input type="email" name="email" class="form-control" id="email" placeholder="jhopfen@gmail.com" onblur="validateEmail(name)">
		</div>
    <div id="email_Error" style="display:none">
    </div>       
	</div>
	<div class="form-group">
		<label for="asst_brwr_first_name" class="col-sm-2 control-label">Asst Brewer First Name: </label>
		<div class="col-sm-10">
			<input type="text" name="asst_brwr_first_name" class="form-control" id="asst_brwr_first_name" placeholder="Otto" onblur="validateName(name)">
		</div>
    <div id="asst_brwr_first_Error" style="display:none">
    </div>       
	</div>
	<div class="form-group">
		<label for="asst_brwr_last_name" class="col-sm-2 control-label">Asst Brewer Last Name: </label>
		<div class="col-sm-10">
			<input type="text" name="asst_brwr_last_name" class="form-control" id="asst_brwr_last_name" placeholder="Malz"  onblur="validateName(name)">
		</div>
    <div id="asst_brwr_last_Error" style="display:none">
    </div>     
	</div>
	<?php require 'meeting_bev_options.php';?><br>
	<div class="form-group <?php echo $abv_Error; ?>">
		<label for="abv" class="col-sm-2 control-label">* Alcohol Content (ABV): </label>
		<div class="col-sm-10">
			<input type="text" name="abv" class="form-control" id="abv" placeholder="6.5" onblur="checkRequired(id); validateNumber(name)">
		</div>
    <div id="abv_Error" style="display:none">
    </div>     
	</div>
	<div class="form-group">
		<label for="ibu" class="col-sm-2 control-label">Bitterness (IBU): </label>
		<div class="col-sm-10">
			<input type="text" name="ibu" class="form-control" id="ibu" placeholder="25"  onblur="validateNumber(name)">
		</div>
    <div id="ibu_Error" style="display:none">   
      <label for="ERROR" class="col-sm-2 control-label">ERROR </label>
    </div> 
	</div>
	<div class="form-group">
		<label for="description" class="col-sm-2 control-label">Description: </label>
		<div class="col-sm-10">
		<input type="text" name="description" class="form-control" id="description" placeholder="Double dry hopped.">
		</div>
	</div>
	<?php echo $field_missing_Error; ?>
	<div style="padding:20px 10px">
		<input type="submit" class="btn btn-primary btn-lg btn-block">
	</div>
</form>
<div class="row">
	<div style="padding:20px">
		<a href="meeting_bev_list.php" type="button" class="btn btn-info btn-lg btn-block">View List</a>
	</div>
</div>
<div class="row">	
	<div style="padding:20px">
		<a href="bev_stats.php" type="button" class="btn btn-warning btn-lg btn-block">View Charts</a>
	</div>
</div>

</div>
<!-- End page content -->
<?php 
//set date
date_default_timezone_set('America/New_York');
$timezone = date_default_timezone_get();
$date = date('Y/m/d H:i:s');
?>

<?php
include 'dbconnect.php';
$mysqli = mysqli_connect($db_host,$db_username,$db_pwd,$db_name);

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
// used to put any style of beer that is smoked at the end of all beers, just after Rauchbier
if ($bev_fshvkw == 'Smoke'){
  $smoked = '1';
}
else {
  $smoked = '0';
}
$insert_stmt = "INSERT INTO `Brew_Info` (`Date_Entered`, 
`Brewer_First_Name`,`Brewer_Last_Name`,`Asst_Brewer_First`,`Asst_Brewer_Last`,`Beverage_Type`,`Style`,`Category`,`FSHVKW`,`ABV`,`IBU`,`Description`,`Email`,`Smoked`) VALUES ('{$date}', '{$brwr_first_name}', '{$brwr_last_name}','{$asst_brwr_first_name}','{$asst_brwr_last_name}','{$bev_type}','{$bev_style}','{$bev_category}','{$bev_fshvkw}',$abv,$ibu,'{$des}','{$email}','{$smoked}')";
if (!empty($brwr_first_name) && !empty($brwr_last_name) && !empty ($abv) && !empty($bev_type) && !empty($bev_style) && !empty($bev_category)){
$stmt = $mysqli->query($insert_stmt);
}
//In case empty check is broken
// else {
//   $stmt = $mysqli->query($insert_stmt);

//       echo  "first: " . $brwr_first_name. " last: ". $brwr_last_name . " abv: " . $abv . " type: " . $bev_type . " style: " . $bev_style . " cat: " . $bev_category . " smoke: " .$smoked . " date: " . $date . " description " . $des ;

// }
?>
</body>
<script>
//function to show confirmation of beverage submission.  At bottom so that php variables are available.
// Extended disable function
jQuery.fn.extend({
    disable: function(state) {
        return this.each(function() {
            var $this = $(this);
            if($this.is('input[type="submit"]'))
              this.disabled = state;
            else
              $this.toggleClass('disabled', state);
        });
    }
});
//disable submit button by default
$('input[type="submit"]').disable(true);  
window.setInterval(function(){
  checkRequired();
}, 500);

var Brewer_First_Name_Check = "";
var Brewer_Last_Name_Check = "";
var Abv_Check = 0;
function checkRequired() {
  Brewer_First_Name_Check = document.getElementById("brwr_first_name").value;    
  Brewer_Last_Name_Check = document.getElementById("brwr_last_name").value;
  Abv_Check = document.getElementById("abv").value;
  console.log ("first " + Brewer_First_Name_Check + " Last " + Brewer_Last_Name_Check + " ABV " + Abv_Check);
  if (Brewer_Last_Name_Check != "" && Brewer_First_Name_Check != "" && Abv_Check > 0) {
    // Enabled:
    $('input[type="submit"]').disable(false);
  }
  else {
    // Disabled 
    $('input[type="submit"]').disable(true);  
  }
}


function showConfirmation() {
  var subCheck = "<?php echo $brwr_first_name ?>"; //Used to hide text first time page is loaded... before a submission.
  var conf = "<?php echo $brwr_first_name ?> your <?php echo $bev_style ?> has been submitted" ; //confirmation text
  if (subCheck == "") {
    //document.getElementById("conf_h3").innerHTML=subCheck; //sets it to empty
  }
  else {
    document.getElementById("conf_h3").innerHTML=conf;  //sets h2 to full phrase
  }
  console.log (conf);
  document.getElementById('brwr_first_name').value = "<?php echo $brwr_first_name; ?>";
  document.getElementById('brwr_last_name').value = "<?php echo $brwr_last_name; ?>";   
  var emailCheck = "<?php echo $email; ?>";
  if (typeof emailCheck !== "undefined") {
    document.getElementById('email').value = "<?php echo $email ?>";
  }
  var asst_brwr_first_name_check = "<?php echo $asst_brwr_first_name; ?>";
  if (typeof asst_brwr_first_name_check !== "undefined") {
    document.getElementById('asst_brwr_first_name').value = "<?php echo $asst_brwr_first_name ?>";
  }
  var asst_brwr_last_name_check = "<?php echo $asst_brwr_last_name; ?>";
  if (typeof asst_brwr_last_name_check !== "undefined") {
    document.getElementById('asst_brwr_last_name').value = "<?php echo $asst_brwr_last_name ?>";
  } 
  } 
</script>
</html>