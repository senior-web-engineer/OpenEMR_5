<?php
include_once("../../../globals.php");
//include_once ("$srcdir/sql.inc");
//require_once ("{$GLOBALS['srcdir']}/sql.inc");
include_once("$srcdir/api.inc");
require_once("$srcdir/patient.inc");
require_once("$srcdir/options.inc.php");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta charset="utf-8">
		<title>Kraken 1.2</title>
		<meta name="generator" content="OpenEMR" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link rel=stylesheet href="<?php echo $css_header;?>" type="text/css">
		<!-- stylesheets -->
		<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-3.3.7/css/bootstrap.min.css" type="text/css">
		<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-datepicker/bootstrap-datepicker.min.css" type="text/css">
		<!-- <link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/library/css/bootstrap-sidebar.css" type="text/css"> -->
		<!--[if lt IE 9]>
			<script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<!-- supporting javascript code -->
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-2.0.2.min.js"></script>
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-3.3.7/js/bootstrap.min.js"></script>
		<!-- <script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-sidebar.js"></script> -->
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-datepicker.min.js"></script>

<!-- supporting javascript code -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js " type="text/javascript"></script>
<!--<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery.js"></script>-->
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/textformat.js"></script>
<!-- pop up calendar -->
<style type="text/css">@import url(<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.css);
input:invalid { background: red; }
.input-sm {
	padding: 2px;
}
.table td {
	padding: 2px !important;
}
.auto-style1 {
	color: #00FF00;
}
</style>
<!-- <link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/interface/themes/style-form-print.css" type="text/css"> -->

<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.js"></script>
<?php include_once("{$GLOBALS['srcdir']}/dynarch_calendar_en.inc.php"); ?>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar_setup.js"></script>

</head>
<div class="container-fluid">
<input type="checkbox" id="checkAll"> <label for="checkAll"><strong>Ch</strong>eck 
	<span class="auto-style1">All</span></label>

<?php
				$mysqli = new mysqli($host, $login, $pass, $dbase);
				//echo "test";
				//echo $mysqli;
				//$connection = mysql_connect($host, $login, $pass); 
				//$db = @mysql_select_db($dbase, $connection);

$sql = "SELECT pid, fname, lname, mname, DOB, street, city, state, postal_code from patient_data WHERE patient_active = 'YES'";
	
	
	
//echo "<br>Connection:". $connection;
//echo $sql;	
//$result = @mysql_query($sql,$connection) or die(mysql_error());
$result = $mysqli -> query ($sql);
while ($row = mysqli_fetch_array($result)) 
{
//$insurance = getInsuranceDataByDate(pid, '2017/04/29');
//$billed = isEncounterBilled('pid', 'encounter');

//$insurance_test2 = getInsuranceDataByDate($pid, (substr($row["date"], 0, 10)), "primary", "provider");
//$insurance_test2 = getInsuranceDataByDate($row['pid'], '2017/04/29');
$pid = $row['pid'];
$fname = $row['fname'];
$lname = $row['lname'];
$DOB = $row['DOB'];
$street = $row['street'];
$city = $row['city'];
$state = $row['state'];
$postal_code = $row['postal_code'];

echo "<div class='well well-sm'>";
echo "<span><b>&nbsp;". $pid. "</b><br> ";
echo "<span><b>&nbsp;". $lname. ", ";
echo "<b>&nbsp;". $fname. "</b>&nbsp;&nbsp;&nbsp;DOB:";
echo "<b>&nbsp;".$DOB."</span><br>";
echo "<b>&nbsp;".$street. "</span><br>";
echo "<b>&nbsp;".$city. ", ". $state." ". $postal_code. "</span><br>";
//echo "</div>";


$sql2 = sqlQuery("SELECT pid, id, type, provider, policy_number, subscriber_street, subscriber_postal_code, ".
				 "subscriber_city, subscriber_state, date FROM insurance_data WHERE type = 'primary' AND pid = '$pid' GROUP BY id ORDER BY id DESC");
		
		echo "<br> <stong> Primary Insurance Info:</strong><br>";	
		$insid = $sql2['provider'];
		$InsuranceName = getInsuranceProvider($insid);
		echo $InsuranceName;
		echo "<br>Policy Start Date: ". $sql2['date']. "<br>";
		echo "&nbsp;Policy#:</b><span class='auto-style1'>". $sql2['policy_number']. "</span>";
		echo "<br>". $sql2['subscriber_street'];
		echo "<br>". $sql2['subscriber_city']. ", ". $sql2['subscriber_state']. "&nbsp; ". $sql2['subscriber_postal_code']. "<br>";
	
echo "</div>";
		
		
//$pid = null;
//$fname = null;
//$lname = null;
//$DOB = null;
//$street = null;
//$city = null;
//$state = null;
//$postal_code = null;

												 
		



//$insurance_test2 = getInsuranceDataByDate($row['pid'], (substr($dos, 0, 10)), "primary", "provider", "policy_number");
//echo $insurance_test2;
//foreach($insurance_test2 as $key => $value) {
//	$company = getInsuranceProvider($insurance_test2[$key]);
//	echo $company; 
//											}

}
?>


