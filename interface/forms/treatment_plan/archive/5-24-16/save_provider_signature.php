<?php

include_once("../../globals.php");
include_once("$srcdir/api.inc");
include_once("$srcdir/forms.inc");
$fid = '164';
formfetch;
echo '1';
echo $_POST["form_id"];
echo $fid;
echo $formid;
echo $_GET["id"];
echo $_SESSION["authProvider"];
echo $_SESSION["id"];
echo '2';
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
provider_signature = '".$_POST["provider_signature"]."',
provider_print_name ='".$_POST["provider_print_name"]."',
provider_credentials ='".$_POST["provider_credentials"]."',
provider_signature_date ='".$_POST["provider_signature_date"]."'
where id='".$_POST["form_id"]."' ";
	echo "$var1";
	sqlInsert("$var1");
}
$_SESSION["encounter"] = $encounter;
//formHeader("Redirecting....");
//formJump();
//formFooter();
?>
