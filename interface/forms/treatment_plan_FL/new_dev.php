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
//}

//echo $description;
//echo ($obj{"description"});

// Get the providers list.
 $ures = sqlStatement("SELECT id, username, fname, lname FROM users WHERE " .
  "authorized != 0 AND active = 1 ORDER BY lname, fname");
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
		
		<!--<script src="<?php echo "$web_root";?>/library/textimporter/jquery-1.11.3.min.js"></script>-->
		<script src="<?php echo "$web_root";?>/library/textimporter/underscore.js"></script>
		<script src="<?php echo "$web_root";?>/library/textimporter/jquery-tmpl.js"></script>
		<script src="<?php echo "$web_root";?>/library/textimporter/knockout-3.3.0.debug.js"></script>
		<script src="<?php echo "$web_root";?>/library/textimporter/koExternalTemplateEngine_all.js"></script>
		<script src="<?php echo "$web_root";?>/library/textimporter/textimporter.js"></script>
		<link href="<?php echo "$web_root";?>/library/textimporter/textimporter.css" rel="stylesheet">
		<!--<link rel="stylesheet" href="<?php echo $css_header;?>" type="text/css">-->
	</head>
<!--	<body class="body_top">-->
	<body>
		<div class="container">
			<h1 class="text-center"><?php echo xlt('Treatment Planning'); ?></h1>
			<?php echo "<form method='post' name='my_form' id='sendServiceForm' " .	"action='$rootdir/forms/treatment_plan/savetp.php?id=" . attr($formid) ."'>\n";?>
			<div class="well">
				<dl class="dl-horizontal">
					<dt><?php echo xlt('Client Name' ); ?>:</dt>
					<dd>
						<?php if (is_numeric($pid)) {
			    		$result = getPatientData($pid, "fname,lname,squad");
			 			echo text($result['fname'])." ".text($result['lname']);}
			   			$patient_name=($result['fname'])." ".($result['lname']);
			   			?>
			   		</dd>
	   		<!--<input type="hidden" name="client_name" value="<?php echo attr($patient_name);?>">-->
					<dt><?php echo xlt('DOB'); ?>:</dt>
					<dd>
						<?php if (is_numeric($pid)) {
			   			$result = getPatientData($pid, "*");
			   			echo text($result['DOB']);}
			   			$dob=($result['DOB']);
			   			?>
					</dd>
		    <!--<input type="hidden" name="DOB" value="<?php echo attr($dob);?>">-->
		 	<input class="form-control" type="hidden" name="service_code" id="service_code" value="H0032">
			<input class="form-control" type="hidden" name="service_name" id="service_name" value="Treatment Plan">
			<input class="form-control" type="hidden" name="status" value="In Progress">
					<dt><?php echo xlt('Client Number'); ?>:</dt>
					<dd>
						<?php if (is_numeric($pid)) {
			   			$result = getPatientData($pid, "*");
			   			echo text($result['pid']);}
			   			$patient_id=$result['pid'];
			   			?>
			   		</dd>
	    	<!--<input type="hidden" name="client_number" value="<?php echo attr($patient_id);?>">-->
					<dt><?php echo xlt('Admit Date'); ?>:</dt>
					<dd></dd>
			<!--   <input type='text' size='10' name='admit_date' id='admission_date' <?php echo attr($disabled) ?>;
				   value='<?php echo attr($obj{"admit_date"}); ?>'   
				   title='<?php echo xla('yyyy-mm-dd Date of service'); ?>'
			       onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc)' />-->
				</dl>
			</div>       
			<h2><?php echo xlt('Provider'); ?>:</h2>
<!-- -->		
		<script language="JavaScript">
		// required for textbox date verification
		var mypcc = '<?php echo $GLOBALS['phone_country_code'] ?>';
		function EditTP() {
		  newwin = window.open("<?php echo $rootdir."/forms/treatment_plan/tabs3.php?id=".$_GET["id"]; ?>","mywin");
		}
		</script>
			<!--<input type="button" class="edittp" value="<?php xl('Edit TP','e'); ?>"> 
			<a href="<?php echo "$web_root";?>/interface/forms/treatment_plan/tabs3.php">tabs3.php</a>
			-->
		<div class="text-center">
			<input class="btn btn-primary" type='button' onclick="sendService('H0032','Treatment Plan','new');" value='<?php echo xlt('Start a New Treatment Plan');?>'>
			<input class="btn btn-primary" type='button' onclick="sendService('H0032TS','Treatment Plan Review','new');" value='<?php echo xlt('Start a New Treatment Plan Review');?>'>
			<input class="btn btn-primary" type='button' onclick="sendService('H0032','Treatment Plan','intake');" value='<?php echo xlt('Initial Treatment Plan/Template');?>'>
			<!--<?php echo "encounter $encounter" ?>-->
		</div>
				
		<div class="form-inline">
<?php
// Write out our query.
$query = "select fe.date, fe.encounter, tp.id  as form_id
	from form_encounter as fe inner join forms as f 
			on fe.encounter = f.encounter
		inner join form_treatment_plan as tp 
			on f.form_id = tp.id
	where fe.pid = $pid
		and f.form_name = 'treatment plan'
		and f.pid = $pid
	    and f.deleted = 0
	    and tp.status = 'Ready for Billing/Supervisor'
	    and fe.encounter <> $encounter 
	Order by fe.date desc, tp.id desc
	limit 1;";
// Execute it, or return the error message if there's a problem.

	$con = mysql_connect($host, $login, $pass); 
	mysql_select_db($dbase, $con);
$result = mysql_query($query) or die(mysql_error());

$dropdown1 .= "<select class='form-control pull-left' id='clone_tpid'>";
//first option
//$dropdown1 .= "<option selected=''>". stripslashes($obj{"problem1"}). "</option>";
//create new option per row
while($row = mysql_fetch_assoc($result)) {
  $dropdown1 .= "\r\n<option value='{$row['form_id']}'>".$row['encounter']." ".$row['date']."</option>";
}
$dropdown1 .= "\r\n</select>";
mysql_close($con);
echo  "<b>OR</b><br><br>" ;
echo  "Copy a Previous TP/R to Create a TPR:<br><br>", $dropdown1, " " ;
?>				
				</div>
					<button class="btn btn-primary pull-left" type='button' onclick="sendService('H0032TS','Treatment Plan Review','clone');" ><span class="glyphicon glyphicon-copy" aria-hidden="true"></span> Copy</button>
				<!--<br><input type='button'  value="Print" onclick="window.print()" class="button-css">&nbsp;-->
					<button class="btn btn-danger" type='button' onclick="top.restoreSession();location='<?php echo "$rootdir/patient_file/encounter/$returnurl" ?>'">Cancel</button>

				<script language="JavaScript">
					// required for textbox date verification
					var mypcc = '<?php echo $GLOBALS['phone_country_code'] ?>';
					function sendService(code, name, mode) {
						$("#service_code").val(code);
						$("#service_name").val(name);
						mode = mode == 'new' ? '' : mode; //change 'new' to '' which is the command for new in savetp.php
						var clone_tpid = $("#clone_tpid").val();
						var encounter_name = $("#service_name").val();
						var formid = <?php echo attr($formid) ?>;
						//var clone_link = "<?php echo "$rootdir/forms/treatment_plan/savetp.php?id=" . attr($formid) ."&mode=" ?>" + mode
						var clone_link = "<?php echo "$rootdir/forms/treatment_plan/savetp.php?id=[0]&mode=[1]&clone_tpid=[2]&encounter_name=[3]" ?>";
						var tokens = [formid, mode, clone_tpid, encounter_name];
						for (var i = 0; i < tokens.length; i++) {
							clone_link = clone_link.replace("["+i+"]", tokens[i]);
						}
						//clone_link.replace(/\{(\d+)\}/, function(match, number) {
						//	if (+number > 0)
						//		return tokens[+number - 1];
						//});
						$("#sendServiceForm").attr("action", clone_link);
						$("#sendServiceForm").submit();
					}
				</script>
</form>
<script language="javascript">
required for popup calendar 
Calendar.setup({inputField:"admission_date", ifFormat:"%Y-%m-%d", button:"img_admission_date"});
</script>

<div id="errors" class="errors" ></div>
</div>
<?php
formFooter();
?>
