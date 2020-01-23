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
<html>
	<head>
		<?php html_header_show();?>
		<script type="text/javascript" src="dialog.js"></script>
		<!-- pop up calendar -->
		<style type="text/css">@import url(<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.css);</style>
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.js"></script>
		<?php include_once("{$GLOBALS['srcdir']}/dynarch_calendar_en.inc.php"); ?>
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar_setup.js"></script>
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/textformat.js"></script>
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dialog.js"></script>
		
		<script src="<?php echo "$web_root";?>/library/textimporter/jquery-1.11.3.min.js"></script>
		<script src="<?php echo "$web_root";?>/library/textimporter/underscore.js"></script>
		<script src="<?php echo "$web_root";?>/library/textimporter/jquery-tmpl.js"></script>
		<script src="<?php echo "$web_root";?>/library/textimporter/knockout-3.3.0.debug.js"></script>
		<script src="<?php echo "$web_root";?>/library/textimporter/koExternalTemplateEngine_all.js"></script>
		<script src="<?php echo "$web_root";?>/library/textimporter/textimporter.js"></script>
		<link href="<?php echo "$web_root";?>/library/textimporter/textimporter.css" rel="stylesheet"></link>
		<link rel="stylesheet" href="<?php echo $css_header;?>" type="text/css">
	</head>
	<body class="body_top">
		<p><span class="forms-title"><?php echo xlt('Treatment Planning'); ?></span></p>
<?php
	echo "<form method='post' name='my_form' id='sendServiceForm' " .
	  "action='$rootdir/forms/treatment_plan/savetp.php?id=" . attr($formid) ."'>\n";
?>

	<!-- -->
	<table  border="0">
		<tr>
			<td align="left" class="forms" class="forms"><?php echo xlt('Client Name' ); ?>:</td>
			<td class="forms">
				<label class="forms-data"> <?php if (is_numeric($pid)) {
			    $result = getPatientData($pid, "fname,lname,squad");
			   echo text($result['fname'])." ".text($result['lname']);}
			   $patient_name=($result['fname'])." ".($result['lname']);
			   ?>
			   </label>
	   <!--<input type="hidden" name="client_name" value="<?php echo attr($patient_name);?>">-->
			</td>
			<td align="left"  class="forms"><?php echo xlt('DOB'); ?>:</td>
			<td class="forms">
				<label class="forms-data"> <?php if (is_numeric($pid)) {
			    $result = getPatientData($pid, "*");
			   echo text($result['DOB']);}
			   $dob=($result['DOB']);
			   ?>
			   </label>
		     <!--<input type="hidden" name="DOB" value="<?php echo attr($dob);?>">-->
			</td>
		</tr>
		<tr>
		 	<input type="hidden" name="service_code" id="service_code" value="H0032">
			<input type="hidden" name="service_name" id="service_name" value="Treatment Plan">
			<input type="hidden" name="status" value="In Progress">
			<td align="left"  class="forms"><?php echo xlt('Client Number'); ?>:</td>
			<td class="forms">
				<label class="forms-data" > <?php if (is_numeric($pid)) {
			    $result = getPatientData($pid, "*");
			   echo text($result['pid']);}
			   $patient_id=$result['pid'];
			   ?>
			   </label>
	    <!--<input type="hidden" name="client_number" value="<?php echo attr($patient_id);?>">-->
			</td>
			<td align="left" class="forms"><?php echo xlt('Admit Date'); ?>:</td>
			<td class="forms">
				<!--   <input type='text' size='10' name='admit_date' id='admission_date' <?php echo attr($disabled) ?>;
				   value='<?php echo attr($obj{"admit_date"}); ?>'   
				   title='<?php echo xla('yyyy-mm-dd Date of service'); ?>'
			       onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc)' />-->
			        <img src='show_calendar.gif' align='absbottom' width='24' height='22'
			        id='img_admission_date' border='0' alt='[?]' style='cursor:pointer;cursor:hand'
			        title='<?php echo xla('Click here to choose a date'); ?>'>
			</td> 
		</tr>
		<tr>
			<td align="left" class="forms"><?php echo xlt('Provider'); ?>:</td>
			<td class="forms" width="280px">
<!-- -->		
<!DOCTYPE html>
<html lang="en">
	<head>
	  <title>Bootstrap Case</title>
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	</head>
	<body>
		<script language="JavaScript">
		// required for textbox date verification
		var mypcc = '<?php echo $GLOBALS['phone_country_code'] ?>';
		function EditTP() {
		  newwin = window.open("<?php echo $rootdir."/forms/treatment_plan/tabs3.php?id=".$_GET["id"]; ?>","mywin");
		}
		</script>
		<div style="margin: 10px;">
			<!--<input type="button" class="edittp" value="<?php xl('Edit TP','e'); ?>"> 
			<a href="<?php echo "$web_root";?>/interface/forms/treatment_plan/tabs3.php">tabs3.php</a>
			-->
		</div>
	</body>
</html>
		
		    <td>
				<br>
				<br><input type='button' onclick="sendService('H0032','Treatment Plan','new');" value='<?php echo xlt('Continue/New Treatment Plan');?>' class="button-css">&nbsp;<br>
				<?php echo "encounter $encounter" ?>
				<br>
<?php
// Write out our query.
$query = "select fe.date, fe.encounter, tp.id  as form_id
	from form_encounter as fe inner join forms as f 
			on fe.encounter = f.encounter
		inner join form_treatment_plan as tp 
			on f.form_id = tp.id
	where fe.pid = 1
		and f.form_name = 'treatment plan'
		and f.pid = 1
	    and f.deleted = 0
	    and tp.status = 'Ready for Billing/Supervisor'
	    and fe.encounter <> $encounter 
	Order by fe.date desc, tp.id desc
	limit 10;";
// Execute it, or return the error message if there's a problem.
$result = mysql_query($query) or die(mysql_error());

$dropdown1 .= "<select id='clone_tpid'>";
//first option
//$dropdown1 .= "<option selected=''>". stripslashes($obj{"problem1"}). "</option>";
//create new option per row
while($row = mysql_fetch_assoc($result)) {
  $dropdown1 .= "\r\n<option value='{$row['form_id']}'>".$row['encounter']." ".$row['date']."</option>";
}
$dropdown1 .= "\r\n</select>";

echo  "Clone from previous encounter:", $dropdown1, " " ;
?>					
					<input type='button' onclick="sendService('H0032TS','Treatment Plan Review','clone');" value='<?php echo xlt('Clone');?>' class="button-css">&nbsp;<br>
				<!--<br><input type='button'  value="Print" onclick="window.print()" class="button-css">&nbsp;-->
				<br><input type='button' class="button-css" value='<?php echo xlt('Cancel');?>'
					onclick="top.restoreSession();location='<?php echo "$rootdir/patient_file/encounter/$returnurl" ?>'" />

				<script language="JavaScript">
					// required for textbox date verification
					var mypcc = '<?php echo $GLOBALS['phone_country_code'] ?>';
					function sendService(code, name, mode) {
						$("#service_code").val(code);
						$("#service_name").val(name);
						mode = mode == 'new' ? '' : mode; //change 'new' to '' which is the command for new in savetp.php
						var clone_tpid = $("#clone_tpid").val();
						var formid = <?php echo attr($formid) ?>;
						//var clone_link = "<?php echo "$rootdir/forms/treatment_plan/savetp.php?id=" . attr($formid) ."&mode=" ?>" + mode
						var clone_link = "<?php echo "$rootdir/forms/treatment_plan/savetp.php?id=[0]&mode=[1]&clone_tpid=[2]" ?>";
						var tokens = [formid, mode, clone_tpid];
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
					
			</td>
		</tr>
	</table>
</form>
<script language="javascript">
required for popup calendar 
Calendar.setup({inputField:"admission_date", ifFormat:"%Y-%m-%d", button:"img_admission_date"});
</script>

<div id="errors" class="errors" ></div>

<?php
formFooter();
?>
