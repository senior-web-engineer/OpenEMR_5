<?php
//SANITIZE ALL ESCAPES
// $sanitize_all_escapes=true;
//STOP FAKE REGISTER GLOBALS
$fake_register_globals=false;
include_once("../../../globals.php");
include_once("$srcdir/api.inc");
require_once("$srcdir/patient.inc");
require_once("$srcdir/options.inc.php");
//require_once("$srcdir/cpt_diag.php");//openremr/library/cpt_diag.php

// posted variables
$v_pid = $_POST['v_pid'];
$v_dos = $_POST['v_dos'];
$form_pid = $_POST['form_pid'];
$form_encounter = $_POST['form_encounter'];
$v_client_name = $_POST['v_client_name'];
$v_encounter = $_POST['v_encounter'];
$tpformid = $_POST['tpformid'];
$v_current_session = $_POST['v_current_session'];

// session variables
$system_encounter = $_SESSION["encounter"];
$system_pid = $_SESSION["pid"];
$system_session = stripslashes(json_encode(session_id()));

$concurrent_session = "false";

if ($form_pid != $system_pid || $form_encounter != $system_encounter || $system_session != $v_current_session) {
//		$var1 = "insert form_error set session_pid = {$_SESSION["pid"]}, session_user='".$_SESSION["authUser"]."', 
//			session_encounter='".$_SESSION["encounter"]."',
//		 	system_session = $system_session, 
//		 	v_pid = $form_pid,
//		 	v_encounter = $form_encounter, 
//		 	v_session = $v_current_session";
//		echo "$var1";
//		sqlInsert("$var1");
//		echo $web_root."/interface/forms/progress_note/provider_signature.php?dev=1&formid=".$formid." class='provider_signature' data-fancybox-type='iframe'>";
    $concurrent_session = "true";
}
    
$data = [ 
    'system_encounter' => $system_encounter,
    'system_pid' => $system_pid,
    'concurrent_session' => $concurrent_session
];

echo json_encode($data); // NOTE: to avoid confusing the $.post this should be the only echo in the file
?>