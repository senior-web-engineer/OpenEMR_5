<?php

include_once("../../globals.php");
include_once("$srcdir/api.inc");
include_once("$srcdir/forms.inc");

foreach ($_POST as $k => $var) {
	$_POST[$k] = add_escape_custom($var);

	echo "$var\n";
}
if ($encounter == "")
	$encounter = date("Ymd");
if ($_GET["mode"] == "update") {
		
	$var1 = "update form_treatment_plan  set pid = {$_SESSION["pid"]}, 
		groupname='".$_SESSION["authProvider"]."',
		user='".$_SESSION["authUser"]."',
		authorized=$userauthorized,
		activity=1, 
		date = NOW(), 
		
		guardian_signature = '".$_POST["guardian_signature"]."',
		guardian_print_name ='".$_POST["guardian_print_name"]."',
		guardian_signature_date ='".$_POST["guardian_signature_date"]."'
		where id='".$_POST["form_id"]."' ";
	echo "$var1";
	sqlInsert("$var1");
}
$_SESSION["encounter"] = $encounter;
//formHeader("Redirecting....");
//formJump();
//formFooter();
?>
