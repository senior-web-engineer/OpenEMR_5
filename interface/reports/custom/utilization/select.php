<?php
 
 // Copyright (C) 2006-2012 Rod Roark <rod@sunsetsystems.com>
 //
 // This program is free software; you can redistribute it and/or
 // modify it under the terms of the GNU General Public License
 // as published by the Free Software Foundation; either version 2
 // of the License, or (at your option) any later version.

 // This report lists patients that were seen within a given date
 // range, or all patients if no date range is entered.

 require_once("../../../globals.php");
 require_once("$srcdir/patient.inc");
 require_once("$srcdir/formatting.inc.php");
 require_once("$srcdir/options.inc.php");
 // ADDED BY DNUNEZ 8-5-15 TO ALLOW LONGER PHP PROCESSING TIME BEFORE TIMEOUT
 set_time_limit(600);
?>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta charset="utf-8">
		<title>Utilization Report</title>
		<meta name="generator" content="OpenEMR" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link rel=stylesheet href="<?php echo $css_header;?>" type="text/css">
		<!-- stylesheets -->
		<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-3.3.7/css/bootstrap.min.css" type="text/css">
		<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-datepicker/bootstrap-datepicker.min.css" type="text/css">
		<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/library/css/bootstrap-sidebar.css" type="text/css">
		<!--[if lt IE 9]>
			<script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<!-- supporting javascript code -->
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-2.0.2.min.js"></script>
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-3.3.7/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-sidebar.js"></script>
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-datepicker.min.js"></script>


<!-- supporting javascript code 
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/textformat.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery.timeentry.package-1.4.9/jquery.timeentry.js"></script>-->

<FORM ACTION="fiscal_units_utilization.php" METHOD=POST id="ProviderSelect" TARGET="_blank" name="ProviderSelect">
<?php



// Write out our query.
$con = new mysqli($host, $login, $pass, $dbase); 
//mysql_select_db($dbase, $con);

$query = "SELECT id, fname, lname, calendar FROM users WHERE active = '1' AND calendar = '1' ORDER BY lname ASC";
// Execute it, or return the error message if there's a problem.
$result = $con -> query ($query) or die(mysqli_error());

$dropdown1 .= "<div class='form-group col-sm-6'><label for='providerid' class='col-sm control-label'>Select Provider:</label><select name='providerid'><option selected=''></option>";

	
while($row = mysqli_fetch_assoc($result)) {
  //$dropdown1 .= "\r\n<option value='{$row['lname']}". ",  "."{$row['fname']}'>{$row['lname']}". ",  "."{$row['fname']}</option>";
  $dropdown1 .= "\r\n<option value='{$row['id']}'>{$row['lname']}". ",  "."{$row['fname']}</option>";
}
//$dropdown1 .= "\r\n<option selected="selected">yes</option>";
$dropdown1 .= "\r\n</select></div>";
echo  "",$dropdown1, "" ;

?>
<br>
<div class="form-group col-sm-12">
		
		<label for="fiscal_year" class="col-sm control-label">Select Fiscal Year:</label>
		<select name="fiscal_year">
				<option selected=""></option>
				<option value="2017">2017</option>
				<option value="2018">2018</option>
				<option value="2019">2019</option>
		</select>
</div>
<br>
<div class="form-group col-sm-12">
		
		<label for="service_code" class="col-sm control-label">Select Service:</label>
		<select name="service_code">
				<option selected=""></option>
				<option value="H2019HR">H2019HR Individual Therapy</option>
				<option value="H2019HO">H2019HO TBOSS</option>
				<option value="H2017">H2017 PSR</option>
		</select>
</div>
<input id="SignBtn" name="SignBtn" type="submit" value="Submit"  ><br><br>



  
 
</FORM>

