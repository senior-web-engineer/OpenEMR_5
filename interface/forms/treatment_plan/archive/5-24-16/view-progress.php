<?php
 $sanitize_all_escapes=true;

 $fake_register_globals=false;
 
include_once("../../globals.php");
include_once("$srcdir/api.inc");
require_once("$srcdir/patient.inc");
require_once("$srcdir/options.inc.php");
formHeader("Form:Treatment Planning");
$returnurl = $GLOBALS['concurrent_layout'] ? 'encounter_top.php' : 'patient_encounter.php';
$formid = 0 + (isset($_GET['id']) ? $_GET['id'] : '');
$obj = $formid ? formFetch("form_treatment_plan", $formid) : array();


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


<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/interface/themes/style-form.css" type="text/css">
<link rel=stylesheet href="<?echo $css_header;?>" type="text/css">

<link rel="stylesheet" type="text/css" href="/openemr/library/js/fancybox/jquery.fancybox-1.2.6.css" media="screen" />
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dialog.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery.1.3.2.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/common.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/fancybox/jquery.fancybox-1.2.6.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-ui.js"></script>

<script language='JavaScript'>


$(document).ready(function(){

    // fancy box
    enable_modals();

    // special size for
	$(".addfac_modal").fancybox( {
		'overlayOpacity' : 0.0,
		'showCloseButton' : true,
		'frameHeight' : 460,
		'frameWidth' : 650
	});

    // special size for
	$(".medium_modal").fancybox( {
		'overlayOpacity' : 0.0,
		'showCloseButton' : true,
		'frameHeight' : 460,
		'frameWidth' : 650
	});
	 // special size for
	$(".small_modal").fancybox( {
		'overlayOpacity' : 0.0,
		'showCloseButton' : true,
		'frameHeight' : 80,
		'frameWidth' : 125
	});


});
</script>

<script type="text/javascript">

$(document).ready(function(){

    // fancy box
    enable_modals();

    // special size for
	$(".addfac_modal").fancybox( {
		'overlayOpacity' : 0.0,
		'showCloseButton' : true,
		'frameHeight' : 760,
		'frameWidth' : 650
	});

    // special size for
	$(".medium_modal").fancybox( {
		'overlayOpacity' : 0.7,
		'showCloseButton' : true,
		'frameHeight' : 760,
		'frameWidth' : 1000,
		'hideOnOverlayClick': false
	});

});
</script>
</head>
<body class="body_top">
<p><span class="forms-title"><?php echo xlt('Treatment Planning'); ?></span></p>
<!--
-->
<?php
echo "<form method='post' name='my_form' " .
  "action='$rootdir/forms/treatment_plan/savetp.php?mode=update&id=" . attr($formid) ."'>\n";
?>

<!---->


<div>
     <div class="tabContainer" style="width:550px;">
        <div>
      		<a href="<?php echo "$web_root";?>/interface/forms/treatment_plan/tabs3.php?dev=1&formid=<?php echo "$formid";?>" class="iframe medium_modal">
      		<span>Click Here to edit Treatment Plan</span></a>&nbsp;<br>
      		<a href="<?php echo "$web_root";?>/interface/forms/treatment_plan/treatment_plan.php?dev=1&formid=<?php echo "$formid";?>" class="iframe medium_modal">
      		<span>Click Here to Preview the entire Treatment Plan</span></a>&nbsp;<br>       
        </div>
    </div>
</div>



<div>
<span>Select the status of this document.<br> 
It will not be billed until signed and the status is 'Ready for Billing':<br></span>
		<div>
			<select name="status" id="status" >
				<option selected=""><?echo stripslashes($obj{"status"});?></option>
				<option value="Ready for Billing/Supervisor">Ready for Billing/Supervisor</option>
				<option value="Void/Delete Request">Void/Delete Request</option>
			</select>
		</div>
		<br>
		<br>
</div>
		
<!--
-->


<!-- -->


<div>
<?php echo xlt('Client Name' ); ?>:
		
			<label class="forms-data"> <?php if (is_numeric($pid)) {
    
    $result = getPatientData($pid, "fname,lname,squad");
   echo text($result['fname'])." ".text($result['lname']);}
   $patient_name=($result['fname'])." ".($result['lname']);
   ?>
   </label>
</div>
   
   <!--<input type="hidden" name="client_name" value="<?php echo attr($patient_name);?>">-->
		
		<b><?php echo xlt('DOB'); ?>:</b>
				<label class="forms-data"> <?php if (is_numeric($pid)) {
        														$result = getPatientData($pid, "*");
   																echo text($result['DOB']);}
  											 $dob=($result['DOB']);
   ?>
   </label>
     <!--<input type="hidden" name="DOB" value="<?php echo attr($dob);?>">-->
		 	
	
	
		<?php echo xlt('Client Number'); ?>:		
			<label class="forms-data" > <?php if (is_numeric($pid)) {
    
    $result = getPatientData($pid, "*");
   echo text($result['pid']);}
   $patient_id=$result['pid'];
   ?>
   </label>
    <!--<input type="hidden" name="client_number" value="<?php echo attr($patient_id);?>">-->
	


		<!--<td align="left" class="forms"><?php echo xlt('Admit Date'); ?>:</td>-->
		
<!--

	
	

-->
<body>


 

</body>


		
		
    <input type='submit'  value='<?php echo xlt('Save');?>' class="button-css">&nbsp;
	<input type='button'  value="Print" onclick="window.print()" class="button-css">&nbsp;
	<input type='button' class="button-css" value='<?php echo xlt('Cancel');?>'
    onclick="top.restoreSession();location='<?php echo "$rootdir/patient_file/encounter/$returnurl" ?>'" />

<div id="errors" class="errors" ></div>

<?php
formFooter();
?>
