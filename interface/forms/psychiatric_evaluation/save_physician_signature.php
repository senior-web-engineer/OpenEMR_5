<?php

include_once("../../globals.php");
include_once("$srcdir/api.inc");
include_once("$srcdir/forms.inc");
//$patient_signature = ($_REQUEST[sigStringData]);
//$guardian_signature = ($_REQUEST[sigStringData1]);
//$provider_signature = ($_REQUEST[sigStringData2]);
//$supervisor_signature = ($_REQUEST[sigStringData3]);
//$physician_signature = ($_REQUEST[sigStringData4]);



foreach ($_POST as $k => $var) {
	$_POST[$k] = add_escape_custom($var);

	echo "$var\n";
}
if ($encounter == "")
	$encounter = date("Ymd");
if ($_GET["mode"] == "update") {
		
	$var1 = "update form_psychiatric_evaluation  set pid = {$_SESSION["pid"]}, 
		groupname='".$_SESSION["authProvider"]."',
		user='".$_SESSION["authUser"]."',
		authorized=$userauthorized,
		activity=1, 
		date = NOW(), 
physician_signature = '".$_POST["physician_signature"]."',
physician_print_name = '".$_POST["physician_print_name"]."', 
physician_credentials = '".$_POST["physician_credentials"]."', 
physician_signature_date = '".$_POST["physician_signature_date"]."'
		where id='".$_POST["form_id"]."' ";
			echo "$var1";
	sqlInsert("$var1");
}
$_SESSION["encounter"] = $encounter;
//formHeader("Redirecting....");
//formJump();
//formFooter();
?>
