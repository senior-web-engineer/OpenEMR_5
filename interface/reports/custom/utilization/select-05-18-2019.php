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

<FORM ACTION="fiscal_units_utilization.php" METHOD=POST id="ProviderSelect" name="ProviderSelect">
<?php



// Write out our query.
$con = new mysqli($host, $login, $pass, $dbase); 
//mysql_select_db($dbase, $con);

$query = "SELECT id, fname, lname, calendar FROM users WHERE active = '1' AND calendar = '1' ORDER BY lname ASC";
// Execute it, or return the error message if there's a problem.
$result = $con -> query ($query) or die(mysqli_error());

$dropdown1 .= "<select name='providerid'><option selected=''></option>";

	
while($row = mysqli_fetch_assoc($result)) {
  //$dropdown1 .= "\r\n<option value='{$row['lname']}". ",  "."{$row['fname']}'>{$row['lname']}". ",  "."{$row['fname']}</option>";
  $dropdown1 .= "\r\n<option value='{$row['id']}'>{$row['lname']}". ",  "."{$row['fname']}</option>";
}
//$dropdown1 .= "\r\n<option selected="selected">yes</option>";
$dropdown1 .= "\r\n</select>";
echo  "Select a provider ",$dropdown1, "" ;

?>
<br>
Select a fiscal year
<select name="fiscal_year">
		<option selected=""></option>
		<option value="2017">2017</option>
		<option value="2018">2018</option>
		<option value="2019">2019</option>
</select>
<br>
<input id="SignBtn" name="SignBtn" type="submit" value="Submit"  ><br><br>



  
 
</FORM>

