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
formHeader("Form:Progress Note");
$returnurl = $GLOBALS['concurrent_layout'] ? 'encounter_top.php' : 'patient_encounter.php';
$formid = 0 + (isset($_GET['id']) ? $_GET['id'] : '');
$obj = $formid ? formFetch("form_progress_note", $formid) : array();

// $query = "SELECT description FROM form_treatment_plan_sub_behavioral_definition WHERE form_id='$id' and pid = '{$GLOBALS['pid']}' " ;
// $result = mysql_query($query) or die(mysql_error());
// $row = mysql_fetch_array($result);
// //while($row = mysql_fetch_assoc($result)) {
//  $description = $row['description'];
//}

//echo $description;
//echo ($obj{"description"});

// Get the providers list.
$ures = sqlStatement("SELECT id, username, fname, lname FROM users WHERE " . "authorized != 0 AND active = 1 ORDER BY lname, fname");

$res = sqlStatement("SELECT fname,mname,lname,ss,sex,DOB,pid FROM patient_data WHERE pid = $pid");
$results = SqlFetchArray($res); 
$provider_results = sqlQuery("select fname, mname, lname from users where username='" . $_SESSION{"authUser"} . "'");
// $rendering_provider = sqlQuery("SELECT u.fname, u.mname, u.lname FROM (SELECT provider_id FROM form_encounter where encounter='$encounter') AS e LEFT JOIN (SELECT fname, mname, lname, id FROM  users) AS u ON e.provider_id = u.id");
$dos = sqlQuery("select date from form_encounter where encounter=$encounter");

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>SOAP Progress Note</title>
		<meta name="generator" content="OpenEMR" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link rel=stylesheet href="<?php echo $css_header;?>" type="text/css">
		<!-- stylesheets -->
		<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-3.3.7/css/bootstrap.min.css" type="text/css">
		<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-datepicker/bootstrap-datepicker.min.css" type="text/css">
		<!--[if lt IE 9]>
			<script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<!-- supporting javascript code -->
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-2.0.2.min.js"></script>
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-3.3.7/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-datepicker.min.js"></script>

<!-- Additional -->
		
		<script src="<?php echo "$web_root";?>/library/textimporter/jquery-1.11.3.min.js"></script>
		<script src="<?php echo "$web_root";?>/library/textimporter/underscore.js"></script>
		<script src="<?php echo "$web_root";?>/library/textimporter/jquery-tmpl.js"></script>
		<script src="<?php echo "$web_root";?>/library/textimporter/knockout-3.3.0.debug.js"></script>
		<script src="<?php echo "$web_root";?>/library/textimporter/koExternalTemplateEngine_all.js"></script>
		<script src="<?php echo "$web_root";?>/library/textimporter/textimporter.js"></script>
		<link href="<?php echo "$web_root";?>/library/textimporter/textimporter.css" rel="stylesheet">
	</head>
<body>

<div id="masthead">  
  <div class="container">
      <div class="row">
        <div class="col-md-7">
          <h1>Progress Note</h1>
<?php
	echo "<form method='post' name='my_form' class='form-inline' id='sendServiceForm' " . "action='$rootdir/forms/progress_note/savetp.php?id=" . attr($formid) ."'>\n";
?>
		 	<input type="hidden" name="service_code" id="service_code" value="H0032">
			<input type="hidden" name="service_name" id="service_name" value="Progress Note">
			<input type="hidden" name="status" value="In Progress">
				<script language="JavaScript">
				// required for textbox date verification
				var mypcc = '<?php echo $GLOBALS['phone_country_code'] ?>';
				function EditTP() {
				  newwin = window.open("<?php echo $rootdir."/forms/progress_note/tabs3.php?id=".$_GET["id"]; ?>","mywin");
				}
				</script>
				<div style="margin: 10px;">
					<!--<input type="button" class="edittp" value="<?php xl('Edit TP','e'); ?>"> 
					<a href="<?php echo "$web_root";?>/interface/forms/treatment_plan/tabs3.php">tabs3.php</a>
					-->
				</div>
		   <!---->
			<?php
			// Write out our query.
			$query = "select fe.date, fe.encounter, tp.id  as form_id
				from form_encounter as fe inner join forms as f 
						on fe.encounter = f.encounter
					inner join form_treatment_plan as tp 
						on f.form_id = tp.id
				where fe.pid = $pid
					and f.form_name Like 'treatment plan%'
					and f.pid = $pid
				    and f.deleted = 0
				    and tp.status = 'Ready for Billing/Supervisor'
				    and fe.encounter <> $encounter 
				Order by tp.id desc, fe.date desc
				limit 1;";
			// Execute it, or return the error message if there's a problem.
			
				//$con = mysql_connect($host, $login, $pass); 
				//mysql_select_db($dbase, $con);
				//$result = mysql_query($query) or die(mysql_error());
			$mysqli = new mysqli($host, $login, $pass,$dbase);
			$result = $mysqli -> query ($query);
			$dropdown1 .= "<select id='tp_form_id' name='tp_form_id' class='form-control'><option value=''>-None Selected- </option>";
			//first option
			//$dropdown1 .= "<option selected=''>". stripslashes($obj{"problem1"}). "</option>";
			//create new option per row
			//while($row = mysql_fetch_assoc($result)) {
			while ($row = mysqli_fetch_array($result)) {
			  $rows[] = $row;
}
foreach ($rows as $row) {
			  $date = $row['date'];
			  $date_simple = substr($date ,0, 10);;
			  $dropdown1 .= "\r\n<option value='{$row['form_id']}'>".$date_simple."&nbsp;&nbsp;&nbsp;&nbsp;<strong>".$row['encounter']."</strong></option>";
			}
			$dropdown1 .= "\r\n</select>";
			mysqli_close($mysqli);
			
			//////////echo  "<label for='tp_form_id'>Select Treatment Plan/Review to Continue : </label>";
			//echo " ";
			/////////echo   $dropdown1, " " ;
			?>
			<!---->
			<script language="JavaScript">
				// required for textbox date verification
			$("submit").attr('disabled',true)
			</script>

			You must first select the type of note you want to create to 
			continue:<br>
			<p>
			<label class="name"><strong>Select Note Type:</strong></label>
			<select required name="note_type" id="note_type" class="form-control" type="text" >
			<option value="">-None Selected-</option>
			<option value="IND">IND - Individual Therapy</option>
			<option value="TBO">TBO - Therapeutic Behavioral On-Site Service(TBOSS)</option>
			<option value="PSR">PSR - Psycho Social Rehabilitation(PSR not Day Treatment)</option>
			<option value="ORI">ORI - Orientation(PSR done as part of the Intake process)</option>
			<option value="DAY">DAY - Day Treatment</option>
			<option value="GRP">GRP - Group or Family Therapy(Not PSR)</option>
			</select><em><span class="style1"><br>(Once created, the Note type can't be changed)</span></em><br>
		</p>

			<input id="btnSubmit" type="submit" class="form-control btn btn-primary" onclick="sendService('TBD','Progress Note');" value='<?php echo xlt('Create Progress Note');?>' class="button-css">
			<!--<br><input type='button' onclick="sendService('H0032TS','Treatment Plan Review');" value='<?php echo xlt('Continue/Treatment Plan Review');?>' class="button-css">&nbsp;<br>-->
			<!--<br><input type='button'  value="Print" onclick="window.print()" class="button-css">&nbsp;-->
			<input type='button' class="button-css form-control btn btn-default" value='<?php echo xlt('Cancel');?>' onclick="top.restoreSession();location='<?php echo "$rootdir/patient_file/encounter/$returnurl" ?>'" />
			<script language="JavaScript">
				// required for textbox date verification
			$("#btnSubmit").attr('disabled',true)
			</script>

			
			<script language="JavaScript">
				// required for textbox date verification
				var mypcc = '<?php echo $GLOBALS['phone_country_code'] ?>';
				function sendService(code, name, form) {
					//$("#tp_form_id").val(form);
					$("#service_code").val(code);
					$("#service_name").val(name);
					$("#sendServiceForm").submit();
				}
				
				$(document).ready(function(){	
					$("#btnSubmit").attr('disabled',true)
					$("#note_type").on('change',function(){
					   if($(this).find('option:selected').text()=="-None Selected-")
					       $("#btnSubmit").attr('disabled',true)
					   else
					       $("#btnSubmit").attr('disabled',false)
					});
			});				</script>
			<input type="hidden" id="v_client_name" name="v_client_name" value="<?php echo $results['fname'] . ' ' . $results['lname'];?>">
			<input type="hidden" id="v_pid" name="v_pid" value="<?php echo $pid;?>">
			<input type="hidden" id="v_encounter" name="v_encounter" value="<?php echo $encounter;?>">
			<input type="hidden" id="v_dos" name="v_dos" value="<?php echo $dos['date'];?>">
			<input type="hidden" name="tp_form_id" value="<?php echo $row['form_id'];?>">
</form>
        </div>
        <div class="col-md-5">
            <div class="well well-lg"> 
	        	<dl class="dl-horizontal">
	            	<dt>Patient Name:</dt>
	            	<dd><?php echo $results['fname'] . '&nbsp' . $results['mname'] . '&nbsp;' . $results['lname'];?></dd>
	            	<dt>DOB:</dt>
	            	<dd><?php echo $results['DOB'];?></dd>
	            	<dt>Sex: </dt>
	            	<dd><?php echo $results['sex'];?></dd>
	            	<dt>Encounter: </dt>
	            	<dd><?php echo $encounter; ?></dd>
	          	</dl>
            </div>
        </div>
      </div> 
  </div><!--/container-->
</div><!--/masthead-->

<script language="javascript">
required for popup calendar 
Calendar.setup({inputField:"admission_date", ifFormat:"%Y-%m-%d", button:"img_admission_date"});
</script>

<div id="errors" class="errors" ></div>

<?php
formFooter();
?>
