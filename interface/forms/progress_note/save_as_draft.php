<?php
include_once("../../globals.php");
include_once("$srcdir/api.inc");
include_once("$srcdir/forms.inc");
foreach ($_POST as $k => $var) {
	$_POST[$k] = add_escape_custom($var);
	echo "$var\n";
}
$id = 0 + (isset($_GET['id']) ? $_GET['id'] : '');
if ($encounter == "")
	$encounter = date("Ymd");
if ($_GET["mode"] == ""){
	$note_type = "Progress Note - ". $_POST["note_type"];
	$newid = formSubmit("form_progress_note", $_POST, $_GET["id"], $userauthorized);
	print 'formSubmitt';  /*debugging */
	addForm($encounter, $note_type, $newid, "progress_note", $pid, $userauthorized);
}elseif ($_GET["mode"] == "update") {
//	sqlInsert("update form_progress_note set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, date = NOW(),
	sqlInsert("update form_progress_note set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',authorized=$userauthorized,activity=1, date = NOW(),
	service_code ='".$_POST["service_code"]."',
	time_start ='".$_POST["time_start"]."',
	time_end ='".$_POST["time_end"]."',
	units ='".$_POST["units"]."', 
	diagnosis1 ='".$_POST["diagnosis1"]."', 
	diagnosis2 ='".$_POST["diagnosis2"]."', 
	diagnosis3 ='".$_POST["diagnosis3"]."', 
	diagnosis4 ='".$_POST["diagnosis4"]."',
	problem ='".$_POST["problem"]."',
	goal ='".$_POST["goal"]."',
	subjective ='".$_POST["subjective"]."',
	assessment ='".$_POST["assessment"]."',
	objective ='".$_POST["objective"]."',
	plan ='".$_POST["plan"]."',
	deficit_problems_behavior_addressed ='".$_POST["deficit_problems_behavior_addressed"]."',
	topic ='".$_POST["topic"]."',							  
    interventions ='".$_POST["interventions"]."',
	response_to_intervention ='".$_POST["response_to_intervention"]."',
	provider_print_name ='".$_POST["provider_print_name"]."',
	provider_credentials ='".$_POST["provider_credentials"]."',
	supervisor_credentials ='".$_POST["supervisor_credentials"]."',
	provider_signature_date ='".$_POST["provider_signature_date"]."',
	supervisor_print_name ='".$_POST["supervisor_print_name"]."',
	supervisor_signature_date ='".$_POST["supervisor_signature_date"]."',
	status='".$_POST["status"]."',
	comments_log = CONCAT('".$_POST["comments_log_view"]."', NOW(), ' ','".$_SESSION["authUser"]."',' :', '".$_POST["comments_log"]."','\n' )
	where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
if ($_GET["mode"] == ""){
	$address = "{$GLOBALS['rootdir']}/forms/progress_note/view.php?id=$newid";
	echo "\n<script language='Javascript'>top.restoreSession();window.location='$address';</script>\n";
}elseif ($_GET["mode"] == "update") {
	formJump();
}
formFooter();
?>