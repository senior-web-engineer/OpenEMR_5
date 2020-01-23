<?php
require_once("../../../globals.php");
//require_once("../../globals.php");
require_once("$srcdir/patient.inc");
include_once("$srcdir/api.inc");
?>
hi
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta charset="utf-8">
		<title>Kraken 1.2</title>
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
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery.js"></script>


<?php
$fname = $_POST["fname"];
$lname = $_POST["lname"];
$mname = $_POST["mname"];
$dob = $_POST["dob"];
$policy_number = $_POST["policy_number"];
$api_code = $_POST["api_code"];
echo "Success";
echo "<br>", $fname;
echo "<br>", $lname;
echo "<br>", $mname;
echo "<br>", $dob;
echo "<br>", $policy_number;
echo "<br>", $api_code;
?>
<?php
$coverage_check = sqlQuery("SELECT id, pid, policy_number, active, results_json FROM eligible WHERE pid = $pid ORDER BY id DESC LIMIT 1;");
$result_json = $coverage_check['results_json'];
//print_r $coverage_check;
//$result1 = json_encode($result);
//$json = json_decode($coverage_check['results_json'],true);

?>
<?php echo $result['fname'];?>
		<style type="text/css">
		.auto-style1 {
			font-size: medium;
			font-weight: bold;
		}
		.auto-style2 {
			font-size: medium;
			font-weight: normal;
		}

		</style>
		--<?php echo $result['mname'];?>--<?php echo $result['lname'];?>--<?php echo $result['DOB'];?>--<?php echo $insurance_test2['policy_number'];?><br>
<?php
$json = json_decode($result_json,true);
						echo "<b>Client ID        :</b>  ", $json['data']['client_id'], "<br>";
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
						echo $json['data']['coverage']['limitations'][1]['plan_description'], "<br>";
						echo $json['data']['coverage']['limitations'][3]['plan_description'], "<br>";
						echo $json['data'];
						$coverage_status = $json['data']['coverage']['active'];
						//$coverage_status = '0';



?>
<?php echo $coverage_check['id'];?>--
<?php echo $coverage_check['pid'];?>--
<?php echo $coverage_check['policy_number'];?>--
<?php echo $coverage_check['active'];?>--
<?php echo date_format($coverage_check['date'],"H:i:s");?><br>
<div class="header3">
	<h3>Result</h3>
	
<!-- Form Info -->
		<div class="panel panel-default">
			<div class="panel-heading"><?php echo $json['data']['subscriber']['first_name']," ",$json['data']['subscriber']['last_name']; ?></div>
				<?php if($coverage_status == '1' || $coverage_status == 'active'|| $coverage_status == 'true'){?>
						<div class="alert alert-success alert-dismissible">
						<?php }else{ ?>
						<div class="alert alert-warning alert-dismissible">
						<?php }?>
					
					<dl class="dl-horizontal">
					<!--<img src = /openemr/controller.php?document&retrieve&patient_id=2036&document_id=124841&as_file=false width=80 align="left">-->
					<dt class="auto-style1">Policy Number:</dt><dd class="auto-style2"><?php echo $json['data']['subscriber']['id']; ?></dd>
					<dt class="auto-style1"><b>Insurance:</b></dt><dd class="auto-style2"><?php echo $json['data']['benefit_related_entities'][0]['organization_name'];?></dd>
					<dt class="auto-style1"><b>DOB:</b></dt><dd class="auto-style2"><?php echo $json['data']['subscriber']['birth_date'];?></dd>
					<dt class="auto-style1"><b>Gender:</b></dt><dd class="auto-style2"><?php echo $json['data']['subscriber']['gender'];?></dd>
					<dt class="auto-style1"><b>Status:</b></dt><dd class="auto-style2"><?php echo $coverage_status;?></dd>
					<?php echo $json['data']['coverage']['limitations'][1]['plan_description'], "<br>";?>
					<?php echo $json['data']['coverage']['limitations'][3]['plan_description'], "<br>";?>
					<?php echo $json['data']['coverage']['insurance_type'], "<br>";?>
					<?php echo $json['data']['benefit_related_entities'][0]['eligibility_or_benefit_information'], "<br>";?>
					<?php echo $json['data']['coverage']['insurance_type'], "<br>";?>
					<?php echo "Plan Begin Date: ", $json['data']['coverage']['coinsurance'][0]['plan_begin_date'], "<br>";?>
					<?php echo "Plan end Date: ",   $json['data']['coverage']['coinsurance'][0]['plan_end_date'], "<br>";?>
													  
					<?php echo $json['data']['payer']['name'], "<br>";?>
					<?php echo $json['data']['coverage']['reject_reason'], "<br>";?>


					<?php echo "<span class='auto-style2'>", $json['meta']['message'], "</b></span><br>";?>

					
					
					</dl>
					
				</div>	
			<div class="panel-footer">Panel Footer</div>
		</div>
	
	<!--<br class="clr">-->
</div>


