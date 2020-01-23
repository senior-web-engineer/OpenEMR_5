<?php

//SANITIZE ALL ESCAPES
 $sanitize_all_escapes=true;

 //STOP FAKE REGISTER GLOBALS
 $fake_register_globals=false;
 
include_once("../../globals.php");
include_once("$srcdir/api.inc");
require_once("$srcdir/patient.inc");
require_once("$srcdir/options.inc.php");



?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php html_header_show();?>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>Session Note</title>
		<meta name="generator" content="OpenEMR" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link rel=stylesheet href="<?php echo $css_header;?>" type="text/css">
		<!-- stylesheets -->
		<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-3.3.7/css/bootstrap.min.css" type="text/css">
		<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-datepicker/bootstrap-datepicker.min.css" type="text/css">
		<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/library/css/bootstrap-sidebar.css" type="text/css">
		<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery.timeentry.package-2.0.1/jquery.timeentry.css" type="text/css">
		<!--[if lt IE 9]>
			<script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<!-- supporting javascript code -->
	

		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-2.0.2.min.js"></script>
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-3.3.7/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-sidebar.js"></script>
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-datepicker.min.js"></script>

<!-- Additional -->
<link rel="stylesheet" type="text/css" href="/openemr/library/js/fancybox-2.1.5/jquery.fancybox.css" media="screen" />

<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/fancybox-2.1.5/jquery.fancybox.pack.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/signaturepad/SigWebTablet.js"></script>
<!-- supporting javascript code -->
<!-- supporting javascript code -->
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>-->

<!--<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-1.6.4.min.js"></script>-->
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/textformat.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery.timeentry.package-2.0.1/jquery.plugin.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery.timeentry.package-2.0.1/jquery.timeentry.js"></script>

<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/colorbox-master/jquery.colorbox-min.js"></script>
<!-- Updated by dnunez 6/29/16-->
<style type="text/css">
.fancybox-skin {
 background-color: #FFF !important;
}
input:required{
	background-color: lightyellow;
}
textarea:required{
	background-color: lightyellow;
}

</style>




<script language="javascript">



// required for textbox date verification
var mypcc = '<?php echo $GLOBALS['phone_country_code'] ?>';
function PrintForm() {
    newwin = window.open("<?php echo $rootdir."/forms/progress_note/print.php?id=".$_GET["id"]; ?>","mywin");
}

//0 code, 1 minutes per unit, 2 max unit
var arCodes =[
			["H2019HR",15,4],
			["H2019HO",15,8],
			["H2019HM",15,8],
			["90806",  60,1],
			["90808",  60,1],
			["H2017", 15,32],
			["H2012",  60,8],
			["90853",  60,1]
			 ];

$(document).ready(function(){
	//documentation for the time picker controls http://keith-wood.name/timeEntry.html
	//the settings below apply to both time pickers
	var timesettings1 = {
		spinnerImage: '<?php echo $GLOBALS['webroot'] ?>/library/js/jquery.timeentry.package-2.0.1/spinnerUpDown.png', 
		spinnerSize: [15, 16, 0], 
		spinnerBigSize: [30, 32, 0], 
		spinnerIncDecOnly: true,
		//show24Hours: true, 
		timeSteps: [1, 15, 0], 
		beforeShow: customRange
	};
	var timesettings2 = {
		spinnerImage: '<?php echo $GLOBALS['webroot'] ?>/library/js/jquery.timeentry.package-2.0.1/spinnerUpDown.png', 
		spinnerSize: [15, 16, 0], 
		spinnerBigSize: [30, 32, 0], 
		spinnerIncDecOnly: true,
		//show24Hours: true, 
		timeSteps: [1, 15, 0], 
		beforeShow: customRange
	};

	
	//initialize controls
	$('#time_start')
		.timeEntry(timesettings1)
		.blur(function(){ calcunits();});
	$('#time_end')
		.timeEntry(timesettings1)
		.blur(function(){ calcunits();});
	$("#service_code").change(function(){ calcunits();});
	$("#units").blur(function(){ calcunits();});
	
	//calculate the units
	function calcunits(){
		try{
			var code = "";
			var mpu =0;
			var maxunit = 0;
			var minutesdiff = 0;
			var time_start = "";
			var time_end = "";
			var start = new Date ();
			var end = new Date();
			var debug = "";
			var units = 0;
			
			//1) find out what code is selected
			code = $("#service_code").val();
			time_start = $("#time_start").val();
			time_end = $("#time_end").val();
			
			//check to see if we have a code and a start and end date
			if (code.length > 0 && time_start.length > 0 && time_end.length > 0) { 
				dbug = "code:" + code + " time_start:" + time_start + " time_end:" + time_end;
				
				//2) look up code in arCodes
				for (var i = 0; i < arCodes.length; i++) {
					if (arCodes[i][0] == code) {
						mpu = arCodes[i][1] ;
						maxunit = arCodes[i][2];
					}
				}
				dbug += " mpu:" + mpu + " maxunit:" + maxunit;

				//3) calculate how many minutes in the time range
				var ah = time_start.split(':');
				dbug += " h:" + ah[0] + " m:" + ah[1].replace("AM", "").replace("PM", "");
				start.setHours (ah[0], ah[1].replace("AM", "").replace("PM", ""));
				ah = time_end.split(':');
				end.setHours (ah[0], ah[1].replace("AM", "").replace("PM", ""));
				var nTotalDiff = end.getTime () - start.getTime ();
				minutesdiff =(nTotalDiff / 1000 / 60);				
				dbug += " minutesdiff:" + minutesdiff;
				
				//4) change the units based on the code
				if (minutesdiff > 0 && mpu > 0 && maxunit > 0){
					units = Math.floor(minutesdiff / mpu);
					if (units > maxunit) { units = maxunit; }
					$("#units").val( units);
				}
				//alert(dbug); //popup that shows numbers calculated
			} else { 
				//alert(' Please select code, start time, and end time.');
			}
		} catch(err) { alert('Error calcunits() : ' + err);}
	}
	
	//this is called by the time picker to make sure the hours dont cross
	function customRange(input) { 
    return {minTime: (input.id == 'time_end' ? 
        $('#time_start').timeEntry('getTime') : null),  
        maxTime: (input.id == 'time_start' ? 
        $('#time_end').timeEntry('getTime') : null)}; 
	}
});
</script>

</head>
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


	<br>
	<div id="service_header">
	
		<p>
		
		<p>
			<label class="name"><strong>Service Code:</strong></label>
			<select name="service_code" id="service_code" type="text">
			<option selected=""><?php echo stripslashes($obj{"service_code"});?></option>
			<option value="H2019HO">H2019HO TBOSS</option>
			<option value="H2019HM">H2019HM TBOSS (Bachelor's)</option>
			<option value="H2019HR">H2019HR Individual Therapy(1 Hour Max)</option>
			<option value="90806">90806 Individual Therapy 45-50 minutes</option>
			<option value="90808">90808 Individual Therapy 75-80 minutes</option>
			</select><em><span class="style1">(H2019HR, H2019HO or 9080X for Medicare)</span></em><br>
		</p>
		
		<div>
			<label class="name1"><strong>Time Started:</strong></label> 
			<input name="time_start" id="time_start" type="text" value="<?php echo stripslashes($obj{"time_start"});?>" required /><br>
			<br>
		</div>
		<div>
			<label class="name"><strong>End Time: </strong></label>
			<input name="time_end" id="time_end" type="text" value="<?php echo stripslashes($obj{"time_end"});?>" required /><br>
		</div>

		
		
		
		
		
		</p>
<div id="treatment_plan_alert">
	

	
</div>
</div>




		<p>
			<label class="name"><strong>Units:</strong></label>
			<input name="units" id="units" type="number" value="<?php echo stripslashes($obj{"units"});?>" maxlength="2" required /><br>
		</p>

			<div class="tabContainer">
        <div>
			<table cellpadding="1" cellspacing="0" class="showborder">
				<tr class="showborder_head"></tr>
         		<tr height="22">
       				<td valign="top" class="text"><b><a href="<?php echo "$web_root";?>/interface/forms/treatment_plan/tabs3.php?dev=1&formid=<?php echo "$formid";?>" class="iframe medium_modal"><span>Click Here to edit Treatment Plan</span></a></b>&nbsp;</td>
		        <tr height="22">
        			<td valign="top" class="text"><b><a href="<?php echo "$web_root";?>/interface/forms/treatment_plan/patient_signature.php?dev=1&formid=<?php echo "$formid";?>" class="various" data-fancybox-type="iframe"><span>Click Here for Patient Signature Page</span></a></b>&nbsp;</td>
       			<tr height="22">
       				<td valign="top" class="text"><b><a href="<?php echo "$web_root";?>/interface/forms/treatment_plan/guardian_signature.php?dev=1&formid=<?php echo "$formid";?>" class="various" data-fancybox-type="iframe"><span>Click Here for Guardian Signature Page</span></a></b>&nbsp;</td>
       			<tr height="22">
       				<td valign="top" class="text"><b><a href="<?php echo "$web_root";?>/interface/forms/treatment_plan/provider_signature.php?dev=1&formid=<?php echo "$formid";?>" class="various" data-fancybox-type="iframe"><span>Click Here for Provider Signature Page</span></a></b>&nbsp;</td>
       			<tr height="22">
       				<td valign="top" class="text"><b><a href="<?php echo "$web_root";?>/interface/forms/treatment_plan/supervisor_signature.php?dev=1&formid=<?php echo "$formid";?>" class="various" data-fancybox-type="iframe"><span>Click Here for Supervisor Signature Page</span></a></b>&nbsp;</td>
       			<tr height="22">
       				<td valign="top" class="text"><b><a href="<?php echo "$web_root";?>/interface/forms/treatment_plan/physician_signature.php?dev=1&formid=<?php echo "$formid";?>" class="various" data-fancybox-type="iframe"><span>Click Here for Physician Signature Page</span></a></b>&nbsp;</td>
       			<tr height="22">
       				<td valign="top" class="text"><b><a href="<?php echo "$web_root";?>/interface/forms/treatment_plan/treatment_plan.php?dev=1&formid=<?php echo "$formid";?>" target="_blank" class="various"><span>Click Here to Preview the entire Treatment Plan</span></a></b>&nbsp;</td>
       			<tr height="22">
       				<td>&nbsp;</td>
      			</tr>
    
    		</table>
        </div>
    </div>

	



	
	
	
<!--<input id="UpdateBtn" name="UpdateBtn" type="button" value="Update"  onclick="javascript:Update()"/>-->
	
    <div class="tabContainer">
        <div>
       			<a href="<?php echo "$web_root";?>/interface/forms/form_progress_note/tabs4.php?dev=1&formid=<?php echo "$formid";?>&pid=<?php echo "$pid";?>&encounter=<?php echo "$encounter";?>&tpformid=<?php echo stripslashes($obj{"tp_form_id"});?>" 
					   class="iframe medium_modal pull-right"><span>*</span></a>
        </div>
    </div>
		
		
		
		
				<a href="<?php echo "$web_root";?>/interface/forms/form_progress_note/tabs3.php?dev=1&formid=<?php echo "$formid";?>&pid=<?php echo "$pid";?>&encounter=<?php echo "$encounter";?>&tpformid=<?php echo stripslashes($obj{"tp_form_id"});?>"class="medium_modal"><strong>Click Here to edit Problems</strong></a>
		

		
		
		

		
		


	

<!--/row-->
<!--/container-->
<script language="javascript">
//document.getElementById('status').setAttribute('disabled','enabled');
document.getElementById('status').setAttribute('disabled','disabled');
//document.getElementById('status').removeAttr('disabled');
</script>


<?php
formFooter();
?>