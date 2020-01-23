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
 $ures = sqlStatement("SELECT id, username, fname, lname FROM users WHERE " .
  "authorized != 0 AND active = 1 ORDER BY lname, fname");
?>
<html><head>
<?php html_header_show();?>
<script type="text/javascript" src="dialog.js"></script>
<!-- pop up calendar -->
<style type="text/css">@import url(<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.css);</style>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.js"></script>
<?php include_once("{$GLOBALS['srcdir']}/dynarch_calendar_en.inc.php"); ?>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar_setup.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/textformat.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dialog.js"></script>

<!--<script src="<?php echo "$web_root";?>/library/textimporter/jquery-1.11.3.min.js"></script>
        <script src="<?php echo "$web_root";?>/library/textimporter/underscore.js"></script>
        <script src="<?php echo "$web_root";?>/library/textimporter/jquery-tmpl.js"></script>
        <script src="<?php echo "$web_root";?>/library/textimporter/knockout-3.3.0.debug.js"></script>
        <script src="<?php echo "$web_root";?>/library/textimporter/koExternalTemplateEngine_all.js"></script>
        <script src="<?php echo "$web_root";?>/library/textimporter/textimporter.js"></script>
        <link href="<?php echo "$web_root";?>/library/textimporter/textimporter.css" rel="stylesheet"></link>
-->

<!-- Changed FancyBox to 1.3.2 dnunez 1/11/16-->
<link rel="stylesheet" href="/openemr/interface/themes/style_metal.css" type="text/css">
<link rel="stylesheet" type="text/css" href="/openemr/library/js/fancybox-1.3.4/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dialog.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery.1.3.2.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/common.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/fancybox-1.3.4/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/signaturepad/SigWebTablet.js"></script>


<script type="text/javascript">
$(document).ready(function(){

    // resized fancybox 1/11/16
	$(".medium_modal").fancybox( {
		openEffect: 'elastic',
	    closeEffect: 'elastic',
	    fitToView: false,
	    width: "90%",
	    maxWidth: 1080,
	    height: "95%",
	    type: 'iframe'
	});
	$(".small_modal").fancybox( {
		openEffect: 'elastic',
	    closeEffect: 'elastic',
	    fitToView: false,
	    width: "75%",
	    maxWidth: 1080,
	    height: "80%",
	    type: 'iframe'
	});


});
</script>

<div>
    
    <div class="tabContainer" style="width:550px;">
        <div>
<table cellpadding="1" cellspacing="0" class="showborder">
	<tr class="showborder_head" height="22">
		    </tr>
         <tr height="22">
       <td valign="top" class="text"><b><a href="<?php echo "$web_root";?>/interface/forms/treatment_plan/tabs3.php?dev=1&formid=<?php echo "$formid";?>" class="iframe medium_modal"><span>Click Here to edit Treatment Plan</span></a></b>&nbsp;</td>
       <tr height="22">
       <td valign="top" class="text"><b><a href="<?php echo "$web_root";?>/interface/forms/treatment_plan/signature.php?dev=1&formid=<?php echo "$formid";?>" class="iframe small_modal"><span>Click Here for Signature Page</span></a></b>&nbsp;</td>
       
       <tr height="22">
       <td valign="top" class="text"><b><a href="<?php echo "$web_root";?>/interface/forms/treatment_plan/treatment_plan.php?dev=1&formid=<?php echo "$formid";?>" class="iframe medium_modal"><span>Click Here to Preview the entire Treatment Plan</span></a></b>&nbsp;</td>
       

       <td>&nbsp;</td>
      

    </tr>
    
    </table>
        </div>
    </div>
</div>







<link rel="stylesheet" href="<?php echo $css_header;?>" type="text/css">
</head>
<body class="body_top">
<p><span class="forms-title"><?php echo xlt('Treatment Planning'); ?></span></p>

<?php
echo "<form method='post' name='my_form' " .
  "action='$rootdir/forms/treatment_plan/savetp.php?mode=update&id=" . attr($formid) ."'>\n";
?>




<!----><br><span><br><br>Select the status of this document.<br> 
			It will not be billed until signed and the status is 'Ready for Billing':</span><br>
		<select name="status" id="status" >
			<option selected=""><?echo stripslashes($obj{"status"});?></option>
			<option value="In Progress">In Progress</option>
			<option value="Ready for Billing/Supervisor">Ready for Billing/Supervisor</option>
			<option value="Void/Delete Request">Void/Delete Request</option>
		</select>
		Service Code:<?echo stripslashes($obj{"service_code"});?>
		<br>
		<br>
<!--
-->










<!-- -->
<table  border="0">

<tr>
<td align="left" class="forms" class="forms"><b><?php echo xlt('Client Name' ); ?>:</b></td>
		<td class="forms">
			<label class="forms-data"> <?php if (is_numeric($pid)) {
    
    $result = getPatientData($pid, "fname,lname,squad");
   echo text($result['fname'])." ".text($result['lname']);}
   $patient_name=($result['fname'])." ".($result['lname']);
   ?>
   </label>
   
   <!--<input type="hidden" name="client_name" value="<?php echo attr($patient_name);?>">-->
		</td>
		<td align="left"  class="forms"><b><?php echo xlt('DOB'); ?>:</b></td>
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
 	
	
	
		<td align="left"  class="forms"><b><?php echo xlt('Client Number'); ?>:</b></td>
		<td class="forms">
			<label class="forms-data" > <?php if (is_numeric($pid)) {
    
    $result = getPatientData($pid, "*");
   echo text($result['pid']);}
   $patient_id=$result['pid'];
   ?>
   </label>
    <!--<input type="hidden" name="client_number" value="<?php echo attr($patient_id);?>">-->
		</td>


		<!--<td align="left" class="forms"><?php echo xlt('Admit Date'); ?>:</td>-->
		
</html>



<!--

	
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


-->
<body>


 

</body>
</html>

		
		
    <td><input type='submit'  value='<?php echo xlt('Save');?>' class="button-css">&nbsp;
	<input type='button'  value="Print" onclick="window.print()" class="button-css">&nbsp;
	<input type='button' class="button-css" value='<?php echo xlt('Cancel');?>'
 onclick="top.restoreSession();location='<?php echo "$rootdir/patient_file/encounter/$returnurl" ?>'" /></td>
	</tr>
</table>
</form>

<div id="errors" class="errors" ></div>

<?php
formFooter();
?>





