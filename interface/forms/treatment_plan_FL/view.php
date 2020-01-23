<?php
/**
 *
 * Copyright (C) 2012-2013 Naina Mohamed <naina@capminds.com> CapMinds Technologies
 *
 * LICENSE: This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 3
 * of the License, or (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://opensource.org/licenses/gpl-license.php>;.
 *
 * @package OpenEMR
 * @author  Naina Mohamed <naina@capminds.com>
 * @link    http://www.open-emr.org
 */
 
//SANITIZE ALL ESCAPES
 $sanitize_all_escapes=true;

 //STOP FAKE REGISTER GLOBALS
 $fake_register_globals=false;
 
include_once("../../globals.php");
include_once("$srcdir/api.inc");
require_once("$srcdir/patient.inc");
require_once("$srcdir/options.inc.php");
formHeader("Form:Treatment Planning");
$returnurl = $GLOBALS['concurrent_layout'] ? 'encounter_top.php' : 'patient_encounter.php';
$formid = 0 + (isset($_GET['id']) ? $_GET['id'] : '');
$obj = $formid ? formFetch("form_treatment_plan", $formid) : array();

// $query = "SELECT description FROM form_treatment_plan_sub_behavioral_definition WHERE form_id='$id' and pid = '{$GLOBALS['pid']}' " ;
// $result = mysql_query($query) or die(mysql_error());
// $row = mysql_fetch_array($result);
// //while($row = mysql_fetch_assoc($result)) {
//  $description = $row['description'];
//  
//}

//echo $description;
//echo ($obj{"description"});

// Get the providers list.
//$con = mysql_connect($host, $login, $pass); 
//mysql_select_db($dbase, $con);


$provider_results = sqlQuery("select fname, mname, lname, supervisor from users where username='" . $_SESSION{"authUser"} . "'");

// $ures = sqlStatement("SELECT id, username, fname, lname FROM users WHERE " . "authorized != 0 AND active = 1 ORDER BY lname, fname");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
<!--<?php html_header_show();?>-->
		<!-- pop up calendar -->
	    <!--<style type="text/css">@import url(<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.css);</style>
	    <script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.js"></script>
	    <?php include_once("{$GLOBALS['srcdir']}/dynarch_calendar_en.inc.php"); ?>
	    <script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar_setup.js"></script>
	    <script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/textformat.js"></script>
	    <script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dialog.js"></script>-->

		<!-- stylesheets -->
		<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-3.3.7/css/bootstrap.min.css" type="text/css">
		<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-datepicker/bootstrap-datepicker.min.css" type="text/css">
		<!--<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/library/css/bootstrap-sidebar.css" type="text/css">-->
		<!--[if lt IE 9]>
			<script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<!-- supporting javascript code -->
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-2.0.2.min.js"></script>
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-3.3.7/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-datepicker.min.js"></script>


<!-- Changed FancyBox to 2.1.5 dnunez 6/29/16-->
<!-- <link rel="stylesheet" type="text/css" href="/openemr/interface/themes/style_oemr3.css" media="screen" />-->
<link rel="stylesheet" type="text/css" href="/openemr/library/js/fancybox-2.1.5/jquery.fancybox.css" media="screen" />
<!--<link rel="stylesheet" href="<?php echo $css_header;?>" type="text/css">-->

<!--<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dialog.js"></script>-->
<!--<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-1.10.1.min.js"></script>-->
<!--<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/common.js"></script>-->
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/fancybox-2.1.5/jquery.fancybox.pack.js"></script>
<!-- <script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-ui.js"></script> -->
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/signaturepad/SigWebTablet.js"></script>

<!-- Updated by dnunez 6/29/16-->
<style type="text/css">
.fancybox-skin {
 background-color: #FFF !important;
}
</style>
<script type="text/javascript">
$(document).ready(function() {
	
	$(".various").fancybox({
		maxWidth	: 1400,
		maxHeight	: 1000,
		fitToView	: false,
		width		: '100%',
		height		: '100%',
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none',
		type: 'iframe'
	});
	
	$(".medium_modal").fancybox( {
		openEffect: 'elastic',
	    closeEffect: 'elastic',
	    fitToView: false,
	    width: "100%",
	    height: "100%",
	    type: 'iframe',
	    autoSize: false
	});

	$(".small_modal").fancybox( {
		openEffect: 'elastic',
	    closeEffect: 'elastic',
	    fitToView: false,
	    width: "40%",
	    maxWidth: 1080,
	    height: "70%",
	    type: 'iframe'
	});

});
</script>

</head>

<body>
	<div class="container">
		<h1 class="forms-title text-center"><?php echo xlt('Treatment Planning'); ?></h1>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h2 class="panel-title">Problems:</h2>
			</div>
			<div class="panel-body">
				<ul>
					<?php 
					   // Get Problems
					 $mysqli = new mysqli($host,$login,$pass,$dbase);  
					 $query = "SELECT id, IsPrimary, description FROM form_treatment_plan_problems WHERE (form_id='$formid' and pid = '{$GLOBALS['pid']}') AND IsDeleted = 0 ORDER BY IsPrimary " ;
					 $result = $mysqli -> query ($query);
					 while ($row = mysqli_fetch_array($result)) {
					 	 $rows[] = $row;
					 }				 
					 foreach ($rows as $row) {
					  echo "<li>".$row['description']."</li>";
					}
					?>
				</ul>
			</div>
		</div>
	    <div class="list-group">
			<a href="<?php echo "$web_root";?>/interface/forms/treatment_plan/tabs3.php?dev=1&formid=<?php echo "$formid";?>" class="iframe medium_modal list-group-item"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Click here to use Treatment Plan builder</a>
			<a href="<?php echo "$web_root";?>/interface/forms/treatment_plan/edit.php?dev=1&formid=<?php echo "$formid";?>" class="iframe medium_modal list-group-item"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Click Here to edit Treatment Plan</a>
	        <a href="<?php echo "$web_root";?>/interface/forms/treatment_plan/patient_signature.php?dev=1&formid=<?php echo "$formid";?>" class="various list-group-item" data-fancybox-type="iframe"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Click Here for Patient Signature Page</a>
	       	<a href="<?php echo "$web_root";?>/interface/forms/treatment_plan/guardian_signature.php?dev=1&formid=<?php echo "$formid";?>" class="various list-group-item" data-fancybox-type="iframe"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Click Here for Guardian Signature Page</a>
	       	<a href="<?php echo "$web_root";?>/interface/forms/treatment_plan/provider_signature.php?dev=1&formid=<?php echo "$formid";?>" class="various list-group-item" data-fancybox-type="iframe"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Click Here for Provider Signature Page</a>
	       	<a href="<?php echo "$web_root";?>/interface/forms/treatment_plan/supervisor_signature.php?dev=1&formid=<?php echo "$formid";?>" class="various list-group-item" data-fancybox-type="iframe"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Click Here for Supervisor Signature Page</a>
	       	<a href="<?php echo "$web_root";?>/interface/forms/treatment_plan/physician_signature.php?dev=1&formid=<?php echo "$formid";?>" class="various list-group-item" data-fancybox-type="iframe"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Click Here for Physician Signature Page</a>
	       	<a href="<?php echo "$web_root";?>/interface/forms/treatment_plan/treatment_plan.php?dev=1&formid=<?php echo "$formid";?>" target="_blank" class="various list-group-item"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> Click Here to Preview the entire Treatment Plan</a>
	    </div>

		<?php echo "<form class='form-inline' method='post' name='my_form' " .  "action='$rootdir/forms/treatment_plan/savetp.php?mode=update&id=" . attr($formid) ."'>\n";?>
			<div>
				
				<span><input id="signatures_on_file"  name="signatures_on_file" class="element checkbox" type="checkbox" <?php if ($obj{"signatures_on_file"} == "on") {echo "checked";};?>  /><label class="choice" for="signatures_on_file"> Scanned signatures, on File.</label></span>
				
				<p>Select the status of this document. It will not be billed until signed and the status is 'Ready for Billing':</p>
				<select class="form-control" name="status" id="status" >
					<option selected=""><?php echo stripslashes($obj{"status"});?></option>
					<option value="In Progress">In Progress</option>
					<option value="Ready for Billing/Supervisor">Ready for Billing/Supervisor</option>
					<option value="Void/Delete Request">Void/Delete Request</option>
				</select>
			</div>
			<div class="well">
				<dl class="dl-horizontal">
					<dt>Service Code:</dt>
					<dd><?php echo stripslashes($obj{"service_code"});?></dd>
					<dt><?php echo xlt('Client Name' ); ?>:</dt>
					<dd>
						<?php if (is_numeric($pid)) {
					    $result = getPatientData($pid, "fname,lname,squad");
					   	echo text($result['fname'])." ".text($result['lname']);}
					   	$patient_name=($result['fname'])." ".($result['lname']);
					   	?>
					</dd>
				    <!--<input type="hidden" name="client_name" value="<?php echo attr($patient_name);?>">-->
					<dt><?php echo xlt('DOB' ); ?>:</dt>
					<dd>
						<?php if (is_numeric($pid)) {
			        	$result = getPatientData($pid, "*");
			   			echo text($result['DOB']);}
			  			$dob=($result['DOB']);
			   			?>
					</dd>
				    <!--<input type="hidden" name="DOB" value="<?php echo attr($dob);?>">-->
					<dt><?php echo xlt('Client Number'); ?>:</dt>
					<dd>
						<?php if (is_numeric($pid)) {
				        $result = getPatientData($pid, "*");
				   		echo text($result['pid']);}
				        $patient_id=$result['pid'];
				        ?>
					</dd>
				</dl>
			</div>
			<div class="text-center">		   
		    <!--<input type="hidden" name="client_number" value="<?php echo attr($patient_id);?>">-->
			    <button class="btn btn-success" type='submit'><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Save</button>
				<a class="btn btn-primary" role='button' href="<?php echo "$web_root";?>/interface/forms/treatment_plan/treatment_plan.php?dev=1&formid=<?php echo "$formid";?>" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</a>
				<button class="btn btn-danger" type='button' onclick="top.restoreSession();location='<?php echo "$rootdir/patient_file/encounter/$returnurl" ?>'">Cancel</button>
			</div>
	</div>
<div id="errors" class="errors" ></div>

<?php
formFooter();
?>





