<?php
include_once("../../globals.php");
include_once("$srcdir/api.inc");
require_once("$srcdir/patient.inc");
require_once("$srcdir/options.inc.php");
?>
<!-- SIGNATURE CODE  -->
<!DOCTYPE html>
<html lang="en">
	<head>
<style type="text/css">
.fancybox-slide--iframe .fancybox-content {
	width: 500px !important;
	max-height: 100%;
	margin: 0;
  	background: #FFF;
}
</style>
<script type="text/javascript">
$(document).ready(function() {
	$('.fancybox').fancybox({
		toolbar  : false,
		smallBtn : true,
		iframe : {
			preload : false
		}
	});
	// $(".various").fancybox({
	// 	maxWidth	: 1400,
	// 	maxHeight	: 1000,
	// 	fitToView	: false,
	// 	width		: '50%',
	// 	height		: '50%',
	// 	autoSize	: false,
	// 	closeClick	: false,
	// 	openEffect	: 'none',
	// 	closeEffect	: 'none',
	// 	type: 'iframe'
	// });
	
	// $(".medium_modal").fancybox( {
	// 	openEffect: 'elastic',
	//     closeEffect: 'elastic',
	//     fitToView: false,
	//     width: "50%",
	//     height: "50%",
	//     type: 'iframe',
	//     autoSize: false
	// });
	// $(".small_modal").fancybox( {
	// 	openEffect: 'elastic',
	//     closeEffect: 'elastic',
	//     fitToView: false,
	//     width: "40%",
	//     maxWidth: 1080,
	//     height: "70%",
	//     type: 'iframe'
	// });
});
</script>

</head>

<script language="JavaScript">
// required for textbox date verification
var mypcc = '<?php echo $GLOBALS['phone_country_code'] ?>';
//}
</script>

						<?php /* From New */ ?>
						<INPUT TYPE=HIDDEN NAME="bioSigData2">
						
						<div class="auto-style1">
							<div class="auto-style1">
							<hr style="width: 610px; height: -12px" class="auto-style1" >
							<strong><span class="auto-style2">Signature<br>					
						 	   <br></span>
							</div>
							<div class="auto-style3">
							Please, read 
							carefully:</strong>
							
							</div>
							
							<li class="auto-style3">You have the option of signing, or loading previously 
							saved signature.</li>
							<li class="auto-style3">You must click on 'Save Signature' 
							after you sign.</li>
							<li class="auto-style3">You may only save one signature at a time.</li>
						      
							<strong><span class="auto-style2"><br></span>
						</div>
	<div id="physician_signature" class="">
		<h3>Provider's Signature</h3>
    </div>
<!--END  PROVIDER SIGNATURE-->
  						
	<b>Clinician Print Name:</b> <input id="provider_print_name" name="provider_print_name"  class="element text medium" type="text" value="<?php echo stripslashes($obj{"provider_print_name"});?>"   required />
	<b>Credentials:</b> 
	<input id="provider_credentials" name="provider_credentials"  class="element text medium" type="text" value="<?php echo stripslashes($obj{"provider_credentials"});?>" style="width: 75px"   required />
	<label>Signature Date:</label>
	<input type='text' size='10' name='provider_signature_date' id='provider_signature_date' value="<?php echo stripslashes($obj{"provider_signature_date"});?>" title='<?php xl('yyyy-mm-dd','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc)' required />
	<img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_provider_signature_date' border='0' alt='[?]' style='cursor:pointer;cursor:hand' title='<?php xl('Click here to choose a date','e'); ?>'>
	 <?php 
    if ($signature_pad == "1"){                    
    ?>

	<a data-fancybox data-type="iframe" data-src="<?php echo "$web_root";?>/interface/forms/assessment_cmh/provider_signature.php?dev=1&formid=<?php echo "$formid";?>" class="list-group-item" href="javascript:;">
		<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>+Click Here for Provider's Signature Pad</a>
	<?php
    }
    ?>

	<span class="auto-style2"></span>
<!--     SUPERVISOR SIGNATURE-->						      
	<strong><hr style="width: 610px; height: -12px" class="auto-style1" >

		<div id="supervisor_signature" class="">
				<h3>Supervisor's Signature</h3>
				<td valign="top" class="text"><b>
	    </div>
   

									<tr>
						    <td height="10" width="500">
						
		<div id="supervisor_signature">
			<div id="topazsup">
				<label class="description" for="supervisor_print_name"> </label>
					<div>
					<b>Supervisor Print Name: </b>
					<input id="supervisor_print_name" name="supervisor_print_name"  class="element text medium" type="text" value="<?php echo stripslashes($obj{"supervisor_print_name"});?>"   />
					<b>Credentials:</b> 
					<input id="supervisor_credentials" name="supervisor_credentials"  class="element text medium" type="text" value="<?php echo stripslashes($obj{"supervisor_credentials"});?>" style="width: 75px" >
					<label>Signature Date:</label>
					<input type='text' size='10' name='supervisor_signature_date' id='supervisor_signature_date' value="<?php echo stripslashes($obj{"supervisor_signature_date"});?>" title='<?php xl('yyyy-mm-dd','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc)' />
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_supervisor_signature_date' border='0' alt='[?]' style='cursor:pointer;cursor:hand' title='<?php xl('Click here to choose a date','e'); ?>'> 
    <?php 
    if ($signature_pad == "1"){                    
    ?>
						<a data-fancybox data-type="iframe" data-src="<?php echo "$web_root";?>/interface/forms/assessment_cmh/supervisor_signature.php?dev=1&formid=<?php echo "$formid";?>" class="list-group-item" href="javascript:;">	<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>+Click Here for Supervisor's Signature Pad</a>  
    <?php
    }
    ?>
    						<br>
					</div>
			</div>			
<!--END  SUPERVISOR SIGNATURE-->				

	<?php
		//if ($provider_results["supervisor"] != "1")
       //$Test1 = acl_check('signature_pad', 'supervisor', $_SESSION{"authUser"});
        //echo "Test1". $Test1;
        if (acl_check('signature_pad', 'supervisor', $_SESSION{"authUser"})=='1')                       
		{
	?>
		<script language="javascript">
			//$("#supervisor_signature *").attr("disabled", "disabled").off('click');
            $('a').attr('disabled', true);
			$("#supervisor_print_name").attr("readonly", true);
			$("#supervisor_credentials").attr("readonly", true);
		</script>		
	<?php
		}
	?>		

						
<script language="javascript">
	/* required for popup calendar */
	Calendar.setup({inputField:"provider_signature_date", ifFormat:"%Y-%m-%d", button:"img_provider_signature_date"});
	Calendar.setup({inputField:"supervisor_signature_date", ifFormat:"%Y-%m-%d", button:"img_supervisor_signature_date"});
	// jQuery stuff to make the page a little easier to use
	$(document).ready(function(){
		$(".save").click(function() { top.restoreSession(); document.SigForm.submit(); });
		$(".dontsave").click(function() { location.href='<?php echo $GLOBALS['form_exit_url']; ?>'; });
		$(".printform").click(function() { PrintForm(); });
		// disable the Print ability if the form has changed
		// this forces the user to save their changes prior to printing
		$("#img_date_of_signature").click(function() { $(".printform").attr("disabled","disabled"); });
	});
</script>
<!--												END OF SIGNATURE CODE                         -->
		</div>