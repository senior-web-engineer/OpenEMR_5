<?php
require("new.php");

// $fake_register_globals=false;
// $sanitize_all_escapes=true;

// include_once("../../globals.php");
// $returnurl = 'encounter_top.php';
?>
<!-- 
<html>
<head>
	<?php //html_header_show();?>
	<link rel="stylesheet" href="<?php //echo $css_header;?>" type="text/css">
</head>
<body class="body_top">
<?php
	// include_once("$srcdir/api.inc");
	// $obj = formFetch("form_service_authorization", $_GET["id"]);
?>
<form method=post action="<?php //echo $rootdir?>/forms/service_authorization/save.php?mode=update&id=<?php echo attr($_GET["id"]);?>" name="my_form">
	<span class="title"><?php //echo xlt('Service Authorization'); ?></span><Br><br>
	<span class=text><?php //echo xlt('Insurance Company: '); ?></span><br><input cols=80  wrap=virtual name="insurance_provider" value="<?php echo text($obj{"insurance_provider"});?>"><br>
	<span class=text><?php //echo xlt('Authorization Nunber: '); ?></span><br><input cols=80  wrap=virtual name="authorization_number" value ="<?php echo text($obj{"authorization_number"});?>"><br>
	<span class=text><?php //echo xlt('Service Code: '); ?></span><br><input cols=80  wrap=virtual name="service_code" value="<?php echo text($obj{"service_code"});?>"><br>
	<span class=text><?php //echo xlt('Service Name: '); ?></span><br><input cols=80  wrap=virtual name="service_name" value="<?php echo text($obj{"service_name"});?>"><br>
	<span class=text><?php //echo xlt('Code Type: '); ?></span><br>
			<select name="code_type">
				<option selected=""><?php //echo stripslashes($obj{"code_type"});?></option>
				<option value="HCPCS">HCPCS: Medicaid and MMA's</option>
				<option value="CPT4">CPT4: Medicare and most Commercial</option>
			</select><br>
	<span class=text><?php //echo xlt('Units/Visits Allowed: '); ?></span><br><input cols=80  wrap=virtual name="units" value ="<?php echo text($obj{"units"});?>"><br>
	<span class=text><?php //echo xlt('Start Date: '); ?></span><br><input cols=80  wrap=virtual name="start_date" value ="<?php echo text($obj{"start_date"});?>"><br>
	<span class=text><?php //echo xlt('End Date: '); ?></span><br><input cols=80  wrap=virtual name="end_date" value ="<?php echo text($obj{"end_date"});?>"><br>


	<br>
	<a href="javascript:top.restoreSession();document.my_form.submit();" class="link_submit">[<?php //echo xlt('Save'); ?>]</a>
	<br>
	<a href="<?php //echo "$rootdir/patient_file/encounter/$returnurl";?>" class="link"
	onclick="top.restoreSession()">[<?php //echo xlt('Don\'t Save Changes'); ?>]</a>
</form>
-->
<?php
//formFooter();
?>
