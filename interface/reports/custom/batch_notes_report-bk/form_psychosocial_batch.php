<?php
include_once("../../globals.php");
?>



<html><head>
<link rel=stylesheet href="<?echo $css_header;?>" type="text/css">
<link rel=stylesheet href="../themes/style-form-print.css" type="text/css">

<!-- supporting javascript code -->
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/textformat.js"></script>

<!-- pop up calendar -->
<style type="text/css">@import url(<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.css);
</style>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.js"></script>
<?php include_once("{$GLOBALS['srcdir']}/dynarch_calendar_en.inc.php"); ?>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar_setup.js"></script>

<script language="JavaScript">


</script>
</head>

<div class="container">
<?php

$start_date = "$_REQUEST[start_date]";
$end_date = "$_REQUEST[end_date]";
$patientid = "$_REQUEST[patientid]";





$db_name = "openemr";


$connection = @mysql_connect("localhost", "openemruser", "4050!abc123") or die(mysql_error());
$db = @mysql_select_db($db_name, $connection) or die(mysql_error());

$sql = "SELECT ". 
	"fr.id, fr.pid, fr.problems, fr.clinical_intervention, fr.response_to_intervention".
	", fr.provider_print_name, fr.credentials, fr.sig_date, fr.provider, fr.timestart, fr.timeend".
	", fm.form_id, fm.form_name, fm.encounter".
	", en.date, en.encounter, en.facility".
	", pd.fname, pd.lname, pd.mname, pd.dob, pd.ss ".
	
	"FROM form_psychosocial AS fr ".
	"JOIN forms AS fm ON fm.form_id = fr.id ".
	"AND form_name = 'Psychosocial Rehabilitation'  ".
	"JOIN form_encounter AS en ON en.encounter = fm.encounter ". 
	"JOIN patient_data AS pd ON pd.pid = fr.pid ".
	//"JOIN forms AS fm ON fm.form_id = fr.id ". 
	"WHERE fr.pid = '$patientid'".
	" AND en.date between '$start_date' AND '$end_date' "
	;


$result = @mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) 
{


?>

<!-- Info Header -->
<div class="header3">
	<h1><?php echo $row['form_name'];?></h1>
	<div class="info">
<!-- PIRC Info -->
		<div class="pirc-info">
		PIRC Clinic<br>
		817 North Dixie Highway<br>
		Pompano Beach, Florida 33060<br>
		Tel: 954.785.8285 | Fax: 954.928.0040
		</div>

<!-- Form Info -->
		<div class="form-info">
			<span>Client Name:</span><?php echo $row['fname'] . '&nbsp' . $row['mname'] . '&nbsp;' . $row['lname'];?>
			<span>DOB:</span><?php echo $row['dob'];?><br>
			<span>SS#:</span><?php echo $row['ss'];?>
			<span>Treatment Date:</span><?php echo substr($row["date"], 0, 10); ?><br>
			<span>Therapist:</span><?php echo stripslashes($row{"provider"});?>
			<span>POS:</span><?php echo $row['facility'];?><br>
			<span>Time Started:</span><?echo stripslashes($row{"timestart"});?>
			<span>End Time:</span><?echo stripslashes($row{"timeend"});?><br>
		</div>
		<br class="clr">
	</div>
	<br class="clr">
</div>




<!-- Notes -->
	<div class="notes">
<h2>List Specific Treatment Plan Deficit/Problems/Behavior Addressed</h2>
		<p><?php echo stripslashes($row{"problems"});?></p>
		<h2>Clinical Intervention</h2>
		<p><?php echo stripslashes($row{"clinical_intervention"});?></p>
		<h2>Response to Intervention</h2>
		<p><?php echo stripslashes($row{"response_to_intervention"});?></p>
</div>
<br class="clr">

	<!-- Signature -->
	<div class="sig">
		<div class="col1">
			Electronically Signed By:<br>
			<span class="u"><?echo $row['provider_print_name'];?>, <?echo $row['credentials'];?></span>
			
			</div>
		
		<div class="col3">
			Date:<br>
			<span class="u"><?echo $row['sig_date'];?></span>
			
		</div>
	</div>
	<br class="clr">


<?php

}

?>
