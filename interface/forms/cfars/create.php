<?php

include_once("../../globals.php");
include_once("$srcdir/api.inc");
include_once("$srcdir/forms.inc");
foreach ($_POST as $k => $var) {
	$_POST[$k] = add_escape_custom($var);

	echo "$var\n";
}
$service_code = $_POST["service_code"];
$service_name = $_POST["service_name"];
switch ($service_name) {
    case "CFARS":
         $service_code = "H0031" ;
        break;
    case "FARS":
        $service_code = "H0031";
        break;
}

if ($encounter == "")
	$encounter = date("Ymd");
if ($_GET["mode"] == ""){
	//$note_type = $_POST["note_type"];
	$newid = formSubmit("form_cfars", $_POST, $_GET["id"], $userauthorized);
	print 'formSubmitt';  /*debugging */
	
	addForm($encounter, $service_name, $newid, "cfars", $pid, $userauthorized);
	 //addForm($encounter, "Work/School Note", $newid, "note", $pid, $userauthorized);

}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");

if ($_GET["mode"] == ""){
	$address = "{$GLOBALS['rootdir']}/forms/cfars/view.php?id=$newid";
	echo "\n<script language='Javascript'>top.restoreSession();window.location='$address';</script>\n";
}elseif ($_GET["mode"] == "update") {
	formJump();
}

formFooter();
?>

echo "<br>1". $_POST["service_code"];
echo "<br>2". $_POST["service_name"];
echo "<br>3". $_POST["note_type"];
echo "<br> encounter:". $encounter;
?>