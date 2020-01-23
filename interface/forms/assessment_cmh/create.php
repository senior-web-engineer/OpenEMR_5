<?php

include_once("../../globals.php");
include_once("$srcdir/api.inc");
include_once("$srcdir/forms.inc");
foreach ($_POST as $k => $var) {
	$_POST[$k] = add_escape_custom($var);

	echo "$var\n";
}
$service_code = $_POST["service_code"];
switch ($service_code) {
    case "H0031HO":
         $note_type = "In-Depth Assessment-New Patient" ;
        break;
    case "H0031TS":
        $note_type = "In-Depth Assessment-Established Patient";
        break;
    case "H0031HN":
        $note_type = "Bio-Psychosocial";
        break;
}
if ($encounter == "")
	$encounter = date("Ymd");
if ($_GET["mode"] == ""){
	//$note_type = $_POST["note_type"];
	$newid = formSubmitCustom("form_assessment_cmh", $_POST, $_GET["id"], $userauthorized);
	print 'formSubmitt';  /*debugging */
	addForm($encounter, $note_type, $newid, "assessment_cmh", $pid, $userauthorized);
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");

if ($_GET["mode"] == ""){
	$address = "{$GLOBALS['rootdir']}/forms/assessment_cmh/view.php?id=$newid";
	echo "\n<script language='Javascript'>top.restoreSession();window.location='$address';</script>\n";
}elseif ($_GET["mode"] == "update") {
	formJump();
}

formFooter();
?>

