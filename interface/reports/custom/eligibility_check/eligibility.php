<br>
<?php
//require_once("../../../globals.php");
require_once("../../globals.php");
require_once("$srcdir/patient.inc");
include_once("$srcdir/api.inc");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta charset="utf-8">
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
		<!-- supporting javascript code -->
		

<?php
$current_date = date("Y/m/d");							  
$result = getPatientData($pid, "fname,mname,lname,pid,pubpid,phone_home,pharmacy_id,DOB,DATE_FORMAT(DOB,'%Y%m%d') as DOB_YMD");
$insurance = getInsuranceDataByDate($pid, "02/19/2018", "primary", "provider");
$insurance_test2 = getInsurancePnDataByDate($pid, $current_date, "primary", "provider", policy_number);
	foreach($insurance_test2 as $key => $value){
			$company = getInsuranceProvider($insurance_test2[$key]);
	}

$api_code_select = $insurance_test2['provider'];
$coverage_check = sqlQuery("SELECT id, pid, policy_number, active, results_json FROM eligible WHERE pid = $pid ORDER BY id DESC LIMIT 1;");
$result_json = $coverage_check['results_json'];
if (isset($api_code_select)){
	$api_code = sqlQuery("SELECT id, name, api_code FROM insurance_companies WHERE id = '$api_code_select' ORDER BY id DESC LIMIT 1;");
}
$recid = $coverage_check['id'];
?>
 <!-- RESULTS TEMPLATE 
        REQUIREMENTS: 
        1) Bootstrap 3 js and css must be included in the header of this file
        2) Each element must have a 'detailRow' class and an id. example:
            echo "<tr class='auto-style1 detailRow' id='" . $recid . "'>".
    -->
    <script>
        var WEBROOT = '<?php echo $GLOBALS['webroot'] ?>/interface/reports/custom/eligibility_batch';
    </script>
    <script src="<?php echo $GLOBALS['webroot'] ?>/interface/reports/custom/eligibility_batch/templateModal/handlebars-v4.1.2.js"></script><!-- template engine -->
	<script src="<?php echo $GLOBALS['webroot'] ?>/interface/reports/custom/eligibility_batch/templateModal/handlebar-pretty-json.js"></script><!-- template engine -->
	<script src="<?php echo $GLOBALS['webroot'] ?>/interface/reports/custom/eligibility_batch/templateModal/resultsModal.js"></script><!-- logic -->
	<link href="<?php echo $GLOBALS['webroot'] ?>/interface/reports/custom/eligibility_batch/templateModal/resultsTemplate.css" rel="stylesheet">
    <div id="results_div"></div><!-- placeholder for the data popup for results -->
    <div id="loading_div"></div><!-- placeholder for the loading popup for results -->
    <!-- END RESULTS TEMPLATE -->
<form method=post name="SigForm" id="SigForm">
<input class="form-control validate" name="fname" id="fname" type="hidden" style="width: 216px"  value="<?php echo $result['fname'];?>">
<input class="form-control validate" name="lname" id="lname" type="hidden" style="width: 212px" readonly value="<?php echo $result['lname'];?>">
<input class="form-control validate" name="mname" id="mname" type="hidden" style="width: 208px" readonly value="<?php echo $result['mname'];?>">
<input class="form-control validate" name="dob" id="dob" type="hidden" style="width: 207px" readonly value="<?php echo $result['DOB'];?>">
<input class="form-control validate" name="policy_number" id="policy_number" type="text" style="width: 204px" readonly value="<?php echo $insurance_test2['policy_number'];?>"><br>
<input class="form-control validate" name="api_code" id="api_code" type="text" style="width: 204px" value="<?php echo $api_code['api_code'];?>"><br>


<!--<?php echo $result['fname'];?>--<?php echo $result['mname'];?>--<?php echo $result['lname'];?>--<?php echo $result['DOB'];?>--<?php echo $insurance_test2['policy_number'];?><br>-->

<?php
$json = json_decode($result_json,true);
						//echo "<class='auto-style1 detailRow' id='" . $recid . "'>";b
					If (isset($recid)){
						echo "<div id='eligibility'>";
						echo "<span class='auto-style1 detailRow' id='" . $recid . "'><a><b>Click Here For Previous Result:</b></a></span><br><br>";//. $coverage_check['id']."</a></span><br><br>";
					//	echo "<b>Client ID        :</b>  ", $json['data']['client_id'], "<br>";
						echo "<b>City             :</b>  ", $json['data']['benefit_related_entities'][0]['address']['city'], "<br>";
						echo "<b>Coverage Level   :</b>  ", $json['data']['benefit_related_entities'][0]['coverage_level'], "<br>";
						echo "<b>Organization Name:</b>  ", $json['data']['benefit_related_entities'][0]['organization_name'], "<br>";
						echo "<b>active           :</b>  ", $json['data']['coverage']['active'], "<br>";
						echo "<b>Last Name:</b>  ", $json['data']['subscriber']['last_name'], "<br>";
						echo "<b>First Name:</b> ", $json['data']['subscriber']['first_name'], "<br>";
						echo "<b>MI:</b>         ", $json['data']['subscriber']['middle_name'], "<br>";
						
						echo "<b>DOB:</b>        ", $json['data']['subscriber']['birth_date'], "<br>";
						echo "<b>Gender:</b>        ", $json['data']['subscriber']['gender'], "<br>";
						echo "<b>ID:</b>         ", $json['data']['subscriber']['id'], "<br>";
						echo "</div>";
						}
				
				
?>

<input id="button" name="StopBtn" type="button" value="Quick Check" onclick="QuickCheck()"/>
<?php
						//}
?>	
	<div id="progresswheel">
	<img height="32" src="ajax-loader.gif" width="32">
	</div>
	</form>
<script language="JavaScript">
$('#progresswheel').hide();
		function QuickCheck()
							{
	           					$('#progresswheel').show();
								$.post("../../reports/custom/eligibility_check/check.php?", {fname: $("#fname").val() ,lname: $("#lname").val() , mname: $("#mname").val(), dob: $('#dob').val(), policy_number: $('#policy_number').val(), api_code: $('#api_code').val()},
											function(data) 
												{
													
										  			$('#progresswheel').hide();
										  			
										  			//alert(data);
										  			//$data = data;
										  			//echo $data;
													ResultsPopper(data);
										  			//window.location.href = '../../reports/custom/eligibility_check/result.php';
										  			//var result="<?php php_func();?>";
										  			//alert(result);
										  			return false;
										  			
												}									
										);		
								    }
								    
</script>
<?php
	function php_func()
			{
				echo "<html>hello ";
			}
 ?>

<?php echo $data; ?>



