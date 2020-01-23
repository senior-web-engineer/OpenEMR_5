<?php
include_once("../../globals.php");
include_once("$srcdir/api.inc");
require_once("$srcdir/patient.inc");
require_once("$srcdir/options.inc.php");
?>
<!--												SIGNATURE CODE                         -->
<!DOCTYPE html>
<html lang="en">
<head>

<style type="text/css">@import url(<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.css);</style>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.js"></script>
<?php include_once("{$GLOBALS['srcdir']}/dynarch_calendar_en.inc.php"); ?>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar_setup.js"></script>
<script language="JavaScript">
// required for textbox date verification
var mypcc = '<?php echo $GLOBALS['phone_country_code'] ?>';
//}
</script>

<head>
<style type="text/css">
.auto-style1 {
	text-align: center;
}
.auto-style2 {
	font-size: x-large;
}
.auto-style3 {
	text-align: left;
}
</style>
</head>

<SCRIPT language="Javascript">




</script>

<!--<body onload="drivertest()">-->

						<?php /* From New */ ?>
						<INPUT TYPE=HIDDEN NAME="bioSigData2">
						
						<div class="auto-style1">
							<div class="auto-style1">
							<strong><span class="auto-style2">Signature<br><br></span>
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
						 <!--     PROVIDER SIGNATURE-->	
	<div id="physician_signature" class="">
				<h3>Provider's Signature</h3>
				<td valign="top" class="text"><b>
				<a href="<?php echo "$web_root";?>/interface/forms/progress_note/provider_signature.php?dev=1&formid=<?php echo "$formid";?>" class="provider_signature" data-fancybox-type="iframe">
				<span>+Click Here for Provider's Signature Page</span></a></b>&nbsp;</td>
    </div>
    <!--END  PROVIDER SIGNATURE-->
  						
						<hr style="
						width: 610px; height: -12px" class="auto-style1" >
						
						  <canvas id="sigplus3" width="400" height="80">
						
						</canvas>
						<br>
						<label class="description" for="provider_print_name"> </label>
					
							<b>Clinician Print Name:</b> <input id="provider_print_name" name="provider_print_name"  class="element text medium" type="text" value="<?php echo stripslashes($obj{"provider_print_name"});?>"   required />
							<b>Credentials:</b> 
							<input id="provider_credentials" name="provider_credentials"  class="element text medium" type="text" value="<?php echo stripslashes($obj{"provider_credentials"});?>" style="width: 75px"   required />
							<label>Signature Date:</label>
							<input type='text' size='10' name='provider_signature_date' id='provider_signature_date' value="<?php echo stripslashes($obj{"provider_signature_date"});?>" title='<?php xl('yyyy-mm-dd','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc)' required />
							<img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_provider_signature_date' border='0' alt='[?]' style='cursor:pointer;cursor:hand' title='<?php xl('Click here to choose a date','e'); ?>'>
						<div id="topaz">	
						
						</div>
										<br>
										<span class="auto-style2"></span>
									<!--     SUPERVISOR SIGNATURE-->	
	<div id="supervisor_signature" class="">
				<h3>Supervisor's Signature</h3>
				<td valign="top" class="text"><b>
				<a href="<?php echo "$web_root";?>/interface/forms/progress_note/supervisor_signature.php?dev=1&formid=<?php echo "$formid";?>" class="supervisor_signature" data-fancybox-type="iframe">
				<span>+Click Here for Supervisor's Signature Page</span></a></b>&nbsp;</td>
    </div>
    <!--END  SUPERVISOR SIGNATURE-->

									<hr style="	width: 610px; height: -12px">	
									
									
									<tr>
						    <td height="10" width="500">
						<!--<object id="sigplus1"  type="application/sigplus" width="500" height="100">
						    <param name="onload" value="onReturnSampleSig1" />
						</object>
						-->
		<div id="supervisor_signature">
						<canvas id="sigplus4" width="400" height="80">
						
						</canvas>
						<div id="topazsup">
						<label class="description" for="supervisor_print_name"> </label>
									<div>
										<b>Supervisor Print Name: </b><input id="supervisor_print_name" name="supervisor_print_name"  class="element text medium" type="text" value="<?php echo stripslashes($obj{"supervisor_print_name"});?>"   />
										<b>Credentials:</b> 
										<input id="supervisor_credentials" name="supervisor_credentials"  class="element text medium" type="text" value="<?php echo stripslashes($obj{"supervisor_credentials"});?>" style="width: 75px" >
										<label>Signature Date:</label>
										<input type='text' size='10' name='supervisor_signature_date' id='supervisor_signature_date' value="<?php echo stripslashes($obj{"supervisor_signature_date"});?>" title='<?php xl('yyyy-mm-dd','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc)' />
										<img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_supervisor_signature_date' border='0' alt='[?]' style='cursor:pointer;cursor:hand' title='<?php xl('Click here to choose a date','e'); ?>'> 
										<br>
									</div>
									
									<br>
							&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<br>
						
	
									<div>
										
										
										&nbsp;
										<br>
										<!--
										<label class="description" for="supervisor_sig_lock">Lock Supervisor's Signature</label>
						<input id="supervisor_sig_lock" name="supervisor_sig_lock" <?php if ($obj{"supervisor_sig_lock"} == "on") {echo "checked";};?> class="element text medium" type="checkbox"     />
										-->
						<br>				
						<!--<b>(2)</b><input id="button1" name="StopBtn" type="button" value="Save Supervisor's Signature" onclick="javascript:onDone4()"/>-->
						<br>
						</div>
		</div>
										
										<br>
						
						<INPUT TYPE=HIDDEN NAME="bioSigData">
						<INPUT TYPE=HIDDEN NAME="bioSigData1">
						<INPUT TYPE=HIDDEN NAME="sigStringData" id="sigStringData" value="<?php echo  stripslashes($obj{"provider_signature"});?>">
						<INPUT TYPE=HIDDEN NAME="sigStringData1" id="sigStringData1" value="<?php echo  stripslashes($obj{"supervisor_signature"});?>">
						<INPUT TYPE=HIDDEN NAME="sigString">
						<INPUT TYPE=HIDDEN NAME="sigImageData">
						
						<br>
						<br>
<?php
if ($provider_results["supervisor"] != "1")
{
?>
<script language="javascript">
	//$("#supervisor_signature *").attr("disabled", "disabled").off('click');
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
						    $("input").keydown(function() { $(".printform").attr("disabled","disabled"); });
						    $("select").change(function() { $(".printform").attr("disabled","disabled"); });
						    $("textarea").keydown(function() { $(".printform").attr("disabled","disabled"); });
						});
						
	


</script>
<!--												END OF SIGNATURE CODE                         -->
