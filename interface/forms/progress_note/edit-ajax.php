<?php

//SANITIZE ALL ESCAPES
 $sanitize_all_escapes=true;

 //STOP FAKE REGISTER GLOBALS
 $fake_register_globals=false;
 
include_once("../../globals.php");
include_once("$srcdir/api.inc");
require_once("$srcdir/patient.inc");
require_once("$srcdir/options.inc.php");




formHeader("Form:Progress Note");
$returnurl = $GLOBALS['concurrent_layout'] ? 'encounter_top.php' : 'patient_encounter.php';
$formid = 0 + (isset($_GET['id']) ? $_GET['id'] : '');
$obj = $formid ? formFetch("form_soap", $formid) : array();
//$obj = formFetch("form_assessment_cmh", $_GET["id"]);
$ures = sqlStatement("SELECT id, username, fname, lname FROM users WHERE " . "authorized != 0 AND active = 1 ORDER BY lname, fname");

$res = sqlStatement("SELECT fname,mname,lname,ss,sex,DOB,pid FROM patient_data WHERE pid = $pid");
$result = SqlFetchArray($res); 
$provider_results = sqlQuery("select fname, mname, lname from users where username='" . $_SESSION{"authUser"} . "'");
// $rendering_provider = sqlQuery("SELECT u.fname, u.mname, u.lname FROM (SELECT provider_id FROM form_encounter where encounter='$encounter') AS e LEFT JOIN (SELECT fname, mname, lname, id FROM  users) AS u ON e.provider_id = u.id");
$dos = sqlQuery("select date from form_encounter where encounter=$encounter");
//$yves = getInsuranceProvider('2735');
$yves = getInsuranceData('1');
$form_name = stripslashes($obj{"note_type"});
echo $form_name;


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
		<!--[if lt IE 9]>
			<script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<!-- supporting javascript code -->
	

		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-2.0.2.min.js"></script>
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-3.3.7/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-sidebar.js"></script>
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-datepicker.min.js"></script>

<!-- Additional -->
<!--<link rel="stylesheet" type="text/css" href="/openemr/library/js/fancybox-2.1.5/jquery.fancybox.css" media="screen" />-->

<!--<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/fancybox-2.1.5/jquery.fancybox.pack.js"></script>-->
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/signaturepad/SigWebTablet.js"></script>
<!-- supporting javascript code -->
<!-- supporting javascript code -->

<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/textformat.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery.timeentry.package-1.4.9/jquery.timeentry.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/colorbox-master/jquery.colorbox-min.js"></script>
<!-- Updated by dnunez 6/29/16-->
<style type="text/css">
.fancybox-skin {
 background-color: #FFF !important;
}
</style>
<script language="javascript">



// required for textbox date verification
var mypcc = '<?php echo $GLOBALS['phone_country_code'] ?>';
function PrintForm() {
    newwin = window.open("<?php echo $rootdir."/forms/soap/print.php?id=".$_GET["id"]; ?>","mywin");
}

//0 code, 1 minutes per unit, 2 max unit
var arCodes =[
			["H2019HR",15,4],
			["H2019HO",15,8],
			["H2019HM",15,8],
			["90806",  60,1],
			["90808",  60,1],
			["H2017",15,32],
			["90853",  60,1]
			 ];

$(document).ready(function(){
	//documentation for the time picker controls http://keith-wood.name/timeEntry.html
	//the settings below apply to both time pickers
	var timesettings = {
		spinnerImage: '<?php echo $GLOBALS['webroot'] ?>/library/js/jquery.timeentry.package-1.4.9/spinnerUpDown.png', 
		spinnerSize: [15, 16, 0], 
		spinnerBigSize: [30, 32, 0], 
		spinnerIncDecOnly: true,
		//show24Hours: true, 
		timeSteps: [1, 15, 0], 
		beforeShow: customRange
	};
	
	//initialize controls
	$('#time_start')
		.timeEntry(timesettings)
		.blur(function(){ calcunits();});
	$('#time_end')
		.timeEntry(timesettings)
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
////////////////////////////////////////////////////////////////
//Disable Select Ready for Billing
//
//////////////////////////////////////////////////
//  01-14-2017									//
//  Y. Charles									//
//  Need to fix sig_date						//
//  Future Improvement:                         //
//       Check 'Quality of content              //
//////////////////////////////////////////////////
//$(document).ready(function() {
//$(function() {
//    $("#status").attr('disabled', 'disabled');
//});
//$("#time_start, #time_end, #service_code, #units, #subjective, #objective, #assessment, #plan").keyup(function() {     
//      if ($("#time_start").val() != "" && 
//      	  $("##time_end").val() != "" &&
//      	  $("#units").val() != "" &&
//      	  $("#servicecode").val() != "" &&
//      	  $("#subjective").val() != "" &&
//		  $("#objective").val() != "" &&
//		  $("#assessment").val() != "" &&
//      	  $("#plan").val() != "" ) {
//		          $("#status").removeAttr('disabled');
//		           } else {
//		          $("#status").attr('disabled', 'disabled');
//		         }
//    });
//    });
    
//End of Disable Select// 
</script>
<script>

function Update()
							{
	                   				document.SigForm.bioSigData.value = GetSigString();
	                   				document.SigForm.sigStringData.value  = document.SigForm.bioSigData.value;
								$.post("<?php echo $GLOBALS['webroot'] ?>/interface/forms/soap/save_provider_signature.php?mode=update&id=<?php echo $_GET['id'];?>",
										{provider_print_name: $("#provider_print_name").val() ,provider_credentials: $("#provider_credentials").val() , provider_signature_date: $("#provider_signature_date").val(), provider_signature: $('#sigStringData').val()},
											function(data) 
												{
										  			alert("Provider Signature Saved");
												}								
										);		
									
						    }

</script>
<!--
<script type="text/javascript">
$(document).ready(function(){
  var interval = setInterval(refresh_box(), 10000);
  function refresh_box() {
      $("#problem").load("<?php echo $GLOBALS['webroot'] ?>/interface/forms/soap/problem.php");
  }
} /*<= The closer ) bracket is missing in this line*/
</script>
-->
<!--
<script type="text/javascript">
$("document").ready(function()
{
  alert("start");

  var interval = setInterval(refresh_box(), 10000);
  function refresh_box() {
  	$.ajax({
  		type : "GET",
  		url: 'problem.php',
  		success: function(data) {
    	$('#problem').html(data);
    							}
    		});
  						}
alert("end");
} 

</script>
-->


<script>

    $(document).ready(
            function() {
                setInterval(function() {
                    var randomnumber = Math.floor(Math.random() * 100);
                   // $('#problem').text(
                   //         'I am getting refreshed every 3 seconds..! Random Number ==> '
                   //                 + randomnumber);
                                    
                     $('#problem').load('<?php echo $GLOBALS['webroot'] ?>/interface/forms/soap/problem.php', {fid:'<?php echo $formid;?>', form_name:'<?php echo $form_name;?>'});               
                }, 10);
            });
</script>

<!-- AUTO SAVE -->
<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<script>
	var AUTOSAVE = true;
	var INTERVAL = '<?php echo $auto_save_timer; ?>';
	var FORM_SELECTOR = 'form';
</script>
<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/library/js/toast/jquery.toast.min.css" type="text/css">
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/toast/jquery.toast.min.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/auto-save.js"></script>
<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

</head>

<body>

<nav class="navbar navbar-default navbar-fixed-top" role="banner">
  <div class="container">
    <div class="navbar-header">
      <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="#" class="navbar-brand">SOAP Note</a>
    </div>
    <nav class="collapse navbar-collapse" role="navigation">
      <ul class="nav navbar-nav">
        <li>
          <a href="#GroupE">Billing Status</a>
        </li>
        <li>
		  <a href="javascript:top.restoreSession();document.SigForm.submit();">Save</a>
        </li>
        <li>
		  <a href="<?php echo $GLOBALS['form_exit_url']; ?>" onclick="top.restoreSession()">Don't Save</a>
        </li>
      </ul>
    </nav>
  </div>
</nav>

<div id="masthead">  
  <div class="container">
      <div class="row">
        <div class="col-md-7">
          <h1>Progress Note
            <p class="lead"><?php echo $provider_results["fname"].' '.$provider_results["mname"].' '.$provider_results["lname"]; ?></p>
          </h1>
        </div>
        <div class="col-md-5">
            <div class="well well-lg"> 
	        	<dl class="dl-horizontal">
	            	<dt>Patient Name:</dt>
	            	<dd><?php echo $result['fname'] . '&nbsp' . $result['mname'] . '&nbsp;' . $result['lname'];?></dd>
	            	<dt>DOB:</dt>
	            	<dd><?php echo $result['DOB'];?></dd>
	            	<dt>Sex: </dt>
	            	<dd><?php echo $result['sex'];?></dd>
	            	<dt>Encounter: </dt>
	            	<dd><?php echo $encounter; ?></dd>Test:<?php echo $yves; ?>
	          	</dl>
            </div>
        </div>
      </div> 
  </div><!--/container-->
</div><!--/masthead-->

<!--main-->
<div class="container">
	<div class="row">
	
	<!--left-->
	<div class="col-xs-12">
<!-- -->
<div class="panel panel-primary"> 
	<div class="panel-heading">
		<h3 class="panel-title pull-left">Service Details:</h3>
			
	<div class="clearfix"></div>

	</div>
<!--<?php echo "<form method='post' name='sigform' " .  "action='$rootdir/forms/soap/savetp.php?mode=update&id=" . attr($formid) ."'>\n";?>-->
<form method=post action="<?php echo $rootdir?>/forms/soap/savetp.php?mode=update&id=<?php echo $_GET["id"];?>" name="SigForm" id="SigForm">
<style type="text/css">
.name{
font-weight: bold;
text-align: left;
float: left;
.value{
text-align:left;
float:left;
}
}</style>

	<br>
	<div id="service_header">
	
		<p>
			<label class="name">Time Started:</label> 
			<input name="time_start" id="time_start" type="text" value="<?php echo stripslashes($obj{"time_start"});?>">
			<label class="name"><strong>End Time: </strong></label>
			<input name="time_end" id="time_end" type="text" value="<?php echo stripslashes($obj{"time_end"});?>"><br>
		</p>

<?php
if ($form_name == "IND")
{
?>

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
<?php
}
?>
<?php
if ($form_name == "PSR")
{
?>

		<p>
			<label class="name"><strong>Service Code:</strong></label>
			<select name="service_code" id="service_code" type="text">
			<option selected=""><?php echo stripslashes($obj{"service_code"});?></option>
			<option value="H2017">H2017 PSR</option>
			<option value="90853">90853 Group Therapy</option>
			</select><em><span class="style1">(H2017 or 9080X for Medicare)</span></em><br>
		</p>
<?php
}
?>




		<p>
			<label class="name"><strong>Units:</strong></label>
			<input name="units" id="units" type="number" value="<?php echo stripslashes($obj{"units"});?>" maxlength="2"><br>
		</p>
<?php
$con = mysql_connect($host, $login, $pass); 
mysql_select_db($dbase, $con);

// Write out our query.
$query = "SELECT pid, title, diagnosis, type, enddate FROM lists where type = 'medical_problem' and pid = $pid and diagnosis != '' and enddate IS NULL and diagnosis LIKE '%ICD10%'and diagnosis NOT LIKE '%F7%' and diagnosis NOT LIKE '%F80%' and diagnosis NOT LIKE '%F84%' and diagnosis NOT LIKE '%F99%';";
// Execute it, or return the error message if there's a problem.
$result = mysql_query($query) or die(mysql_error());

$dropdown1 .= "<select name='diagnosis1'><option selected=''>". stripslashes($obj{"diagnosis1"}). "</option>";
$dropdown2 .= "<select name='diagnosis2'><option selected=''>". stripslashes($obj{"diagnosis2"}). "</option>";
$dropdown3 .= "<select name='diagnosis3'><option selected=''>". stripslashes($obj{"diagnosis3"}). "</option>";
$dropdown4 .= "<select name='diagnosis4'><option selected=''>". stripslashes($obj{"diagnosis4"}). "</option>";
	
while($row = mysql_fetch_assoc($result)) {
  $dropdown1 .= "\r\n<option value='{$row['diagnosis']}". "  "."{$row['title']}'>{$row['diagnosis']}". "  "."{$row['title']}</option>";
  $dropdown2 .= "\r\n<option value='{$row['diagnosis']}". "  "."{$row['title']}'>{$row['diagnosis']}". "  "."{$row['title']}</option>";
  $dropdown3 .= "\r\n<option value='{$row['diagnosis']}". "  "."{$row['title']}'>{$row['diagnosis']}". "  "."{$row['title']}</option>";
  $dropdown4 .= "\r\n<option value='{$row['diagnosis']}". "  "."{$row['title']}'>{$row['diagnosis']}". "  "."{$row['title']}</option>";
}
$dropdown1 .= "\r\n</select>";
$dropdown2 .= "\r\n</select>";
$dropdown3 .= "\r\n</select>";
$dropdown4 .= "\r\n</select>";

echo  "<p>Diagnosis 1:",$dropdown1, "*Choose at least one." ;
?>
<br>
<?php

echo "<p>Diagnosis 2:", $dropdown2, "" ;

?>
<br>
<?php

echo "<p>Diagnosis 3:", $dropdown3, "" ;

?>
<br>
<?php

echo "<p>Diagnosis 4:", $dropdown4, "" ;

?>

	</div>

	</div>

<div class="panel panel-primary"> 
	<div class="panel-heading">
	<script>
			$(document).ready(function(){
				//Examples of how to assign the Colorbox event to elements
				$(".group1").colorbox({rel:'group1'});
				$(".group2").colorbox({rel:'group2', transition:"fade"});
				$(".group3").colorbox({rel:'group3', transition:"none", width:"75%", height:"75%"});
				$(".group4").colorbox({rel:'group4', slideshow:true});
				$(".ajax").colorbox();
				$(".youtube").colorbox({iframe:true, innerWidth:640, innerHeight:390});
				$(".vimeo").colorbox({iframe:true, innerWidth:500, innerHeight:409});
				$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
				$(".inline").colorbox({inline:true, width:"50%"});
				$(".callbacks").colorbox({
					onOpen:function(){ alert('onOpen: colorbox is about to open'); },
					onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
					onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
					onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
					onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
				});

				$('.non-retina').colorbox({rel:'group5', transition:'none'})
				$('.retina').colorbox({rel:'group5', transition:'none', retinaImage:true, retinaUrl:true});
				
				//Example of preserving a JavaScript event for inline calls.
				$("#click").click(function(){ 
					$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
					return false;
				});
			});
		</script>
<!--
<body>
		<h1>Colorbox Demonstration</h1>
		<h2>Elastic Transition</h2>
		<p><a class="group1" href="../content/ohoopee1.jpg" title="Me and my grandfather on the Ohoopee.">Grouped Photo 1</a></p>
		<p><a class="group1" href="../content/ohoopee2.jpg" title="On the Ohoopee as a child">Grouped Photo 2</a></p>
		<p><a class="group1" href="../content/ohoopee3.jpg" title="On the Ohoopee as an adult">Grouped Photo 3</a></p>
		
		<h2>Fade Transition</h2>
		<p><a class="group2" href="../content/ohoopee1.jpg" title="Me and my grandfather on the Ohoopee">Grouped Photo 1</a></p>
		<p><a class="group2" href="../content/ohoopee2.jpg" title="On the Ohoopee as a child">Grouped Photo 2</a></p>
		<p><a class="group2" href="../content/ohoopee3.jpg" title="On the Ohoopee as an adult">Grouped Photo 3</a></p>
		
		<h2>No Transition + fixed width and height (75% of screen size)</h2>
		<p><a class="group3" href="../content/ohoopee1.jpg" title="Me and my grandfather on the Ohoopee.">Grouped Photo 1</a></p>
		<p><a class="group3" href="../content/ohoopee2.jpg" title="On the Ohoopee as a child">Grouped Photo 2</a></p>
		<p><a class="group3" href="../content/ohoopee3.jpg" title="On the Ohoopee as an adult">Grouped Photo 3</a></p>
		
		<h2>Slideshow</h2>
		<p><a class="group4"  href="../content/ohoopee1.jpg" title="Me and my grandfather on the Ohoopee.">Grouped Photo 1</a></p>
		<p><a class="group4"  href="../content/ohoopee2.jpg" title="On the Ohoopee as a child">Grouped Photo 2</a></p>
		<p><a class="group4"  href="../content/ohoopee3.jpg" title="On the Ohoopee as an adult">Grouped Photo 3</a></p>
		
		<h2>Other Content Types</h2>
		<p><a class='ajax' href=<?php echo "$web_root";?>/interface/forms/soap/tabs3.php?dev=1&formid=<?php echo "$formid";?>&pid=<?php echo "$pid";?>&encounter=<?php echo "$encounter";?>&tpformid=<?php echo stripslashes($obj{"tp_form_id"});?>"class="medium_modal" title="Homer Defined">Outside HTML (Ajax)</a></p>
		<a href="<?php echo "$web_root";?>/interface/forms/soap/tabs3.php?dev=1&formid=<?php echo "$formid";?>&pid=<?php echo "$pid";?>&encounter=<?php echo "$encounter";?>&tpformid=<?php echo stripslashes($obj{"tp_form_id"});?>"class="medium_modal"><strong>Click Here to edit Problems</strong></a>
		

		<p><a class='youtube' href="http://www.youtube.com/embed/VOJyrQa_WR4?rel=0&amp;wmode=transparent">Flash / Video (Iframe/Direct Link To YouTube)</a></p>
		<p><a class='vimeo' href="http://player.vimeo.com/video/2285902" title="R&ouml;yksopp: Remind Me">Flash / Video (Iframe/Direct Link To Vimeo)</a></p>
		<p><a class='iframe' href="http://wikipedia.com">Outside Webpage (Iframe)</a></p>
		<p><a class='inline' href="#inline_content">Inline HTML</a></p>
		
		<h2>Demonstration of using callbacks</h2>
		<p><a class='callbacks' href="../content/marylou.jpg" title="Marylou on Cumberland Island">Example with alerts</a>. Callbacks and event-hooks allow users to extend functionality without having to rewrite parts of the plugin.</p>
		

		<h2>Retina Images</h2>
		<p><a class="retina" href="../content/daisy.jpg" title="Retina">Retina</a></p>
		<p><a class="non-retina" href="../content/daisy.jpg" title="Non-Retina">Non-Retina</a></p>

		<!-- This contains the hidden content for inline calls -->
<!--		<div style='display:none'>
			<div id='inline_content' style='padding:10px; background:#fff;'>
			<p><strong>This content comes from a hidden element on this page.</strong></p>
			<p>The inline option preserves bound JavaScript events and changes, and it puts the content back where it came from when it is closed.</p>
			<p><a id="click" href="#" style='padding:5px; background:#ccc;'>Click me, it will be preserved!</a></p>
			
			<p><strong>If you try to open a new Colorbox while it is already open, it will update itself with the new content.</strong></p>
			<p>Updating Content Example:<br />
			<a class="ajax" href="../content/ajax.html">Click here to load new content</a></p>
			</div>
		</div>
	</body>
-->
	



<?php
			if ($form_name == "PSR")
			{
?>		<!--BUTTON DOESNOT OPEN FANCYBOX <a class="btn btn-default pull-right" href="<?php echo "$web_root";?>/interface/forms/soap/tabs3.php?dev=1&formid=<?php echo "$formid";?>&pid=<?php echo "$pid";?>&encounter=<?php echo "$encounter";?>&tpformid=<?php echo stripslashes($obj{"tp_form_id"});?>"class="medium_modal">Click Here to edit Problems</a>-->
				<p><a class='callbacks' href=<?php echo "$web_root";?>/interface/forms/soap/tabs3.php?dev=1&formid=<?php echo "$formid";?>&pid=<?php echo "$pid";?>&encounter=<?php echo "$encounter";?>&tpformid=<?php echo stripslashes($obj{"tp_form_id"});?>"class="medium_modal" title="Homer Defined">Outside HTML (Ajax)</a></p>
		
				<a href="<?php echo "$web_root";?>/interface/forms/soap/tabs3.php?dev=1&formid=<?php echo "$formid";?>&pid=<?php echo "$pid";?>&encounter=<?php echo "$encounter";?>&tpformid=<?php echo stripslashes($obj{"tp_form_id"});?>"class="medium_modal"><strong>Click Here to edit Problems</strong></a>
		
<?php
			}else{
?>
				<a class="btn btn-default pull-right" href="<?php echo "$web_root";?>
			/interface/forms/soap/tabs3.php?dev=1&formid=<?php echo "$formid";?>
			&pid=<?php echo "$pid";?>&encounter=<?php echo "$encounter";?>
			&tpformid=<?php echo stripslashes($obj{"tp_form_id"});?>
			"class="iframe various">Click Here to edit Problems and Goals</a>

<?php
			}

?>

	
				
<!--			<a class="btn btn-default pull-right" href="<?php echo "$web_root";?>
			/interface/forms/soap/tabs3.php?dev=1&formid=<?php echo "$formid";?>
			&pid=<?php echo "$pid";?>&encounter=<?php echo "$encounter";?>
			&tpformid=<?php echo stripslashes($obj{"tp_form_id"});?>
			"class="iframe various">Click Here to edit Problems and Goals+</a>
-->	
	
	<div class="clearfix"></div>

	</div>
	

	
	
<div id="problem">
	<div class="panel-body">
		<ul>
		

		
		<?php 
				$db = @mysql_select_db($dbase, $con) or die(mysql_error());
				
							  $query = "SELECT id, IsPrimary, description FROM form_progress_problems WHERE (form_id='$id' AND pid = '{$GLOBALS['pid']}') AND IsDeleted = 0 ORDER BY IsPrimary " ;
								 $result = mysql_query($query) or die(mysql_error());
							 			while($row = mysql_fetch_assoc($result)) {
							   			$problem_id 	  = $row['id'];
							   			echo "<li><h4>Problem: <i>".$row['description']."</i></h4></li>";
										//---- Goals---- ----- 
										if ($form_name == "IND")
											{
														echo "<ul><li><h5>Goal(s):<h5></li></ul>";
														 $query_2 = "SELECT id, problem_id, description AS goaldescription ".
																	"FROM form_progress_notes_goals ".
																	"WHERE (form_id='$id' AND problem_id = $problem_id) AND IsDeleted = 0 " ;
								 							$result_2 = mysql_query($query_2) or die(mysql_error());
							 									while($row_2 = mysql_fetch_assoc($result_2)) {
							   										echo "<ul>";
							   										echo "<ul><li><i>".$row_2['goaldescription']."</i></li></ul>";
																	echo "</ul>";
																				 							 }
										
										//---- Objectives ----- 
														echo "<ul><li><h5>Objective(s):<h5></li></ul>";
														$query_3 = "SELECT oj.id AS ojid, oj.Description AS ojdescription, oj.ObjectiveNumber AS ojObjectiveNumber ".
																	"FROM form_progress_notes_objectives AS oj ".
																	"WHERE oj.form_id = $id AND oj.problem_id = $problem_id and (IsDeleted is Null or IsDeleted = 0) ".
																	"ORDER BY oj.id";
															$result_3 = @mysql_query($query_3) or die(mysql_error());
																while ($row_3 = mysql_fetch_array($result_3)) { 
																	echo "<ul>";
																	echo "<ul><li><i>".$row_3['ojdescription']."</i></li></ul>";
																	echo "</ul>";
																				}
											}								
										//***************************************************
										
																				}
			?>
		
		</ul>
	</div>
</div>
<!--<input id="UpdateBtn" name="UpdateBtn" type="button" value="Update"  onclick="javascript:Update()"/>-->
	
    <div class="tabContainer">
        <div>
       			<a href="<?php echo "$web_root";?>/interface/forms/soap/tabs4.php?dev=1&formid=<?php echo "$formid";?>&pid=<?php echo "$pid";?>&encounter=<?php echo "$encounter";?>&tpformid=<?php echo stripslashes($obj{"tp_form_id"});?>" 
					   class="iframe medium_modal pull-right"><span>*</span></a>
        </div>
    </div>
</div>
<!--<?php echo "<form method='post' name='sigform' " .  "action='$rootdir/forms/soap/savetp.php?mode=update&id=" . attr($formid) ."'>\n";?>-->
<?php
if ($form_name == "IND")
{
?>

		<div id="GroupA" class="form-group group">
			<h3>Subjective:</h3>
			<textarea name="subjective" id="subjective" class="form-control" cols="40" rows="10"><?php echo stripslashes($obj{"subjective"});?></textarea>
		</div>
		<div id="GroupB" class="form-group group">
			<h3>Objective:</h3>
			<textarea name="objective" id="objective" class="form-control" cols="40" rows="10"><?php echo stripslashes($obj{"objective"});?></textarea>
		</div>
		<div id="GroupC" class="form-group group">
			<h3>Assessment:</h3>
			<textarea name="assessment" id="assessment" class="form-control" cols="40" rows="10"><?php echo stripslashes($obj{"assessment"});?></textarea>
		</div>
		<div id="GroupD" class="form-group group">
			<h3>Plan:</h3>
			<textarea name="plan" id="plan" class="form-control" cols="40" rows="10"><?php echo stripslashes($obj{"plan"});?></textarea>
		</div>
<?php
}
?>
		
		
<?php
if ($form_name == "PSR")
{
?>
<div id="GroupD" class="form-group group">
			<h3>Response To Intervention:</h3>
			<textarea name="response_to_intervention" id="response_to_intervention" class="form-control" cols="40" rows="10"><?php echo stripslashes($obj{"response_to_intervention"});?></textarea>
</div>

		
		
		
		
<?php
}
?>		
		
		
		
		
		
		
		
		
		
		
		
		<?php
		include ("signature.php");
		?>

		
		<div id="GroupE" class="form-group group form-inline">
			<strong>Status:</strong>
			<select class="form-control" name="status" id="status" >
				<option selected=""><?php echo stripslashes($obj{"status"});?></option>
				<option value="In Progress">In Progress</option>
				<option value="Ready for Billing/Supervisor">Ready for Billing/Supervisor</option>
				<option value="Void/Delete Request">Void/Delete Request</option>
			</select>
			<em><span>Select the status of this document. It will not be billed until signed and the status is 'Ready for Billing'</span></em>
			<input type="hidden" name="encounter" id="encounter" value="<?php echo $encounter; ?>" readonly="readonly">
		</div>
		
		<label>Service Code: </label><?php echo stripslashes($obj{"service_code"});?>
		<label>tp_form_id: </label><?php echo stripslashes($obj{"tp_form_id"});?>
		<br>
	    <input class="btn btn-default" type='submit'  value='<?php echo xlt('Save');?>' class="button-css">&nbsp;
		<input class="btn btn-default" type='button'  value="Print" onclick="window.print()" class="button-css">&nbsp;
		<input type="button" class="printform" value="<?php xl('Print','e'); ?>"> &nbsp; 

		<input class="btn btn-default" type='button' class="button-css" value='<?php echo xlt('Cancel');?>' onclick="top.restoreSession();location='<?php echo "$rootdir/patient_file/encounter/$returnurl" ?>'" >
	


</div>

</form>

<div id="errors" class="errors" ></div>

	</div><!--/col-->

</div><!--/row-->
<!--/container-->



<?php
formFooter();
?>