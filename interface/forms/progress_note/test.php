<html lang="en">
	<head>
		<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-3.3.7/css/bootstrap.min.css" type="text/css">
		<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-datepicker/bootstrap-datepicker.min.css" type="text/css">
		<!--<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/library/css/bootstrap-sidebar.css" type="text/css">-->
		<!--[if lt IE 9]>
			<script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<!-- supporting javascript code -->
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-2.0.2.min.js"></script>
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-3.3.7/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="/openemr/library/js/fancybox-2.1.5/jquery.fancybox.css" media="screen" />
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/fancybox-2.1.5/jquery.fancybox.pack.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-ui.js"></script>

<!-- Updated by dnunez 6/29/16-->
<style type="text/css">
.fancybox-skin {
 background-color: #FFF !important;
}
</style>

<script type="text/javascript">
$(document).ready(function() {
	
	$(".various").fancybox({
		maxWidth	: 800,
		maxHeight	: 600,
		fitToView	: false,
		width		: '70%',
		height		: '70%',
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none'
	});
	
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
	    width: "40%",
	    maxWidth: 1080,
	    height: "70%",
	    type: 'iframe'
	});

});
</script>

<?php
//SANITIZE ALL ESCAPES
// $sanitize_all_escapes=true;
//STOP FAKE REGISTER GLOBALS
$fake_register_globals=false;
include_once("../../globals.php");
include_once("$srcdir/api.inc");
require_once("$srcdir/patient.inc");
require_once("$srcdir/options.inc.php");
//require_once("$srcdir/cpt_diag.php");//openremr/library/cpt_diag.php
$v_pid = $_POST['v_pid'];
$v_dos = $_POST['v_dos'];
$form_pid = $_POST['form_pid'];
$form_encounter = $_POST['form_encounter'];
$v_client_name = $_POST['v_client_name'];
$v_encounter = $_POST['v_encounter'];
$tpformid = $_POST['tpformid'];
$v_current_session = $_POST['v_current_session'];
$system_encounter = $_SESSION["encounter"];
$system_pid = $_SESSION["pid"];
$system_session = stripslashes(json_encode(session_id()));
//formHeader("Form:Progress Note");
//$returnurl = $GLOBALS['concurrent_layout'] ? 'encounter_top.php' : 'patient_encounter.php';
//$formid = 0 + (isset($_GET['id']) ? $_GET['id'] : '');
//echo $formid;
//$obj = $formid ? formFetch("form_progress_note", $formid) : array();
$ures = sqlStatement("SELECT id, username, fname, lname FROM users WHERE " . "authorized != 0 AND active = 1 ORDER BY lname, fname");
$tp_form_id = stripslashes($obj{"tp_form_id"});
//$res = sqlStatement("SELECT fname,mname,lname,ss,sex,DOB,pid FROM patient_data WHERE pid = $pid");
//$result = SqlFetchArray($res); 
//$provider_results = sqlQuery("select fname, mname, lname, info, supervisor from users where username='" . $_SESSION{"authUser"} . "'");
// $rendering_provider = sqlQuery("SELECT u.fname, u.mname, u.lname FROM (SELECT provider_id FROM form_encounter where encounter='$encounter') AS e LEFT JOIN (SELECT fname, mname, lname, id FROM  users) AS u ON e.provider_id = u.id");
?>
<br>kk<br>
	<dt>Form_pid: </dt><dd><?php echo $form_pid;?></dd>
	<dt>Form_encounter: </dt><dd><?php echo $form_encounter;?></dd>
	<dt>V_Name: </dt><dd><?php echo $v_client_name;?> Current: <?php echo $v_client_name;?></dd>
	<dt>V_PID: </dt><dd><?php echo $v_pid;?> Current: <?php echo $system_pid;?></dd>
	<dt>V_DOS: </dt><dd><?php echo $v_dos;?></dd>
	<dt>V_Encounter</dt><dd><?php echo $v_encounter;?> Current: <?php echo $system_encounter;?></dd>
    <dt>V_session: </dt><dd><?php echo $v_current_session;?> Current: <?php echo $system_session; ?></dd>
	
<?php
	if ($form_pid != $system_pid || $form_encounter != $system_encounter || $system_session != $v_current_session)
	{
		echo "BUSTED";
		echo "<script>top.restoreSession();</script>";
		echo "<script>$('#draft').attr('disabled',true);</script>";
		echo "<script>$('#submit').attr('disabled',true);</script>";
		echo "<script>$('textarea').attr('readonly',true);</script>";
//		$var1 = "insert form_error set session_pid = {$_SESSION["pid"]}, session_user='".$_SESSION["authUser"]."', 
//			session_encounter='".$_SESSION["encounter"]."',
//		 	system_session = $system_session, 
//		 	v_pid = $form_pid,
//		 	v_encounter = $form_encounter, 
//		 	v_session = $v_current_session";
//		echo "$var1";
//		sqlInsert("$var1");
//		echo $web_root."/interface/forms/progress_note/provider_signature.php?dev=1&formid=".$formid." class='provider_signature' data-fancybox-type='iframe'>";

		


	}
	//header("Location: $web_root."/interface/forms/progress_note/provider_signature.php?dev=1&formid=". $formid." class='provider_signature' data-fancybox-type='iframe'>"); 
	header('Location: you_are_confirmed.html');
	?>		
		