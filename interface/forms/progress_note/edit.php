<?php
//SANITIZE ALL ESCAPES
 $sanitize_all_escapes=true;
//STOP FAKE REGISTER GLOBALS
$fake_register_globals=false;
include_once("../../globals.php");
include_once("$srcdir/api.inc");
require_once("$srcdir/patient.inc");
require_once("$srcdir/options.inc.php");
require_once("$srcdir/cpt_diag.php");//openremr/library/cpt_diag.php


formHeader("Form:Progress Note");
$returnurl = $GLOBALS['concurrent_layout'] ? 'encounter_top.php' : 'patient_encounter.php';
$formid = 0 + (isset($_GET['id']) ? $_GET['id'] : '');
//echo $formid;
$obj = $formid ? formFetch("form_progress_note", $formid) : array();
$ures = sqlStatement("SELECT id, username, fname, lname FROM users WHERE " . "authorized != 0 AND active = 1 ORDER BY lname, fname");
$tp_form_id = stripslashes($obj{"tp_form_id"});
//$res = sqlStatement("SELECT fname,mname,lname,ss,sex,DOB,pid FROM patient_data WHERE pid = $pid");
//$result = SqlFetchArray($res); 
//$provider_results = sqlQuery("select fname, mname, lname, info, supervisor from users where username='" . $_SESSION{"authUser"} . "'");
// $rendering_provider = sqlQuery("SELECT u.fname, u.mname, u.lname FROM (SELECT provider_id FROM form_encounter where encounter='$encounter') AS e LEFT JOIN (SELECT fname, mname, lname, id FROM  users) AS u ON e.provider_id = u.id");
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
		<!--
		<link rel=stylesheet href="<?php echo $css_header;?>" type="text/css">
		-->
		<!-- stylesheets -->
		<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-3.3.7/css/bootstrap.min.css" type="text/css">
		<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-datepicker/bootstrap-datepicker.min.css" type="text/css">
		<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/library/css/bootstrap-sidebar.css" type="text/css">
		<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery.timeentry.package-2.0.1/jquery.timeentry.css" type="text/css">
		<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/library/js/toast/jquery.toast.min.css" type="text/css">
		<!--[if lt IE 9]>
			<script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<!-- supporting javascript code -->
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-2.0.2.min.js"></script>
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-3.3.7/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-sidebar.js"></script>
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-datepicker.min.js"></script>
<!-- Additional -->
<link rel="stylesheet" type="text/css" href="<?php echo $GLOBALS['webroot'] ?>/library/js/fancybox-2.1.5/jquery.fancybox.css" media="screen" />
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/fancybox-2.1.5/jquery.fancybox.pack.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/ui.dialog.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/signaturepad/SigWebTablet.js"></script>
<!-- supporting javascript code -->
<!--<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-1.6.4.min.js"></script>-->
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/textformat.js"></script>
<!--<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery.timeentry.package-1.4.9/jquery.timeentry.js"></script>-->
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery.timeentry.package-2.0.1/jquery.plugin.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery.timeentry.package-2.0.1/jquery.timeentry.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/colorbox-master/jquery.colorbox-min.js"></script>

<!-- AUTO SAVE -->
<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<script>
	var AUTOSAVE = true;
	var INTERVAL = '<?php echo $auto_save_timer; ?>';
	var FORM_SELECTOR = 'form';
</script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/toast/jquery.toast.min.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/auto-save.js"></script>
<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->


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

	#TimeUnits label, #TimeUnits input {
	display: block;
	float: left;
	margin-bottom: 10px;
}


	 
</style>
<style type="text/css">

</style>
<?php
include_once("time_signature.php");
?>
</head>

<body>
<?php
//include ("form_utilities.php");
$form_name = stripslashes($obj{"note_type"});
switch ($form_name){
			case 'IND':
				$service_code_fields = " AND (service_code = 'H2019HR' OR service_code LIKE '9083%') ";
				//$service_code_fields = " AND service_code LIKE '9083%' ";
				//$type_field = "AND type = 'fiscal' ";
				$type_field = "AND pid = $pid AND type = 'patient' ";

			break;
			case 'PSR';
				$service_code_fields = " AND (service_code = 'H2017' OR service_code = '90853') ";
				$type_field = "AND pid = $pid AND type = 'patient' ";
			break;
			case 'TBO';
				$service_code_fields = " AND service_code = 'H2019HO' OR service_code = 'H2019HN' ";
				$type_field = "AND pid = $pid AND type = 'patient' ";
			break;
			case 'GRP';
				$service_code_fields = " AND service_code = 'H2019HQ' OR service_code = '90853' ";
				$type_field = "AND pid = $pid AND type = 'patient' ";
			break;
			case 'DAY';
				$service_code_fields = " AND service_code = 'H2012' ";
				$type_field = "AND pid = $pid AND type = 'patient' ";
			break;

}
	

$dos = sqlQuery("select date from form_encounter where encounter=$encounter");
$dos_pol = substr($dos["date"], 0, 10);
$client_insurance = getInsurancePnDataByDate($pid, $dos_pol, "primary", "provider", "subscriber_country", policy_number);
$insurance_test2 = getInsurancePnDataByDate($pid, $dos_pol, "primary", "provider", "subscriber_country", policy_number);

$insurance_type = sqlQuery("SELECT id, name, billing_code_type FROM insurance_companies WHERE id = '$client_insurance[provider]'");
		
		//Search for Insurance Restriction
		$insurance_restriction = sqlQuery("SELECT service_code, insurance_provider, type ".
										  "FROM form_service_authorization ".
										  "WHERE insurance_provider = '$client_insurance[provider]'".
										  $service_code_fields.
										  "AND type = 'insurance' ");
							if (isset($insurance_restriction["service_code"])){
										  echo "RESTRICTION EXIST: ". $insurance_restriction["service_code"]."<br>";
										  					$client_service_code_authorized = sqlQuery("SELECT pid, authorization_number, service_code, units, type, code_type, start_date, end_date ".
														   "FROM form_service_authorization ". 
														   "WHERE isDeleted = '0' ". 
														   $type_field.
														   "AND end_date >= '$dos[date]' ".
														   "AND start_date <= '$dos[date]' ".
														   $service_code_fields.
														   "AND code_type = '$insurance_type[billing_code_type]'");
												$encounters_start_date = $client_service_code_authorized['start_date'];//Use to count units from date
				//echo "bmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmb: ".$client_service_code_authorized["code_type"];

										  }else{
										  //echo "NO RESTRICTION<br>". $insurance_restriction["service_code"]."<br>";
										  $client_service_code_authorized = sqlQuery("SELECT pid, service_code, units, type, code_type, start_date, end_date ".
														   "FROM form_service_authorization ". 
														   "WHERE isDeleted = '0' ". 
														   "AND (type = 'fiscal' OR type = 'patient')  ".
														  // "OR type = 'patient' ".
														   "AND end_date >= '$dos[date]' ".
														   "AND start_date <= '$dos[date]' ".
														   $service_code_fields.
														   "AND code_type = '$insurance_type[billing_code_type]'");
											$encounters_start_date = $client_service_code_authorized['start_date'];//Use to count units
				//echo "bmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmb: ".$client_service_code_authorized["code_type"];
										  }
		
//				$client_service_code_authorized = sqlQuery("SELECT pid, service_code, units, type, code_type, start_date, end_date ".
//														   "FROM form_service_authorization ". 
//														   "WHERE isDeleted = '0' ". 
//														   $type_field.
//														   "AND end_date >= '$dos[date]' ".
//														   "AND start_date <= '$dos[date]' ".
//														   $service_code_fields.
//														   "AND code_type = '$insurance_type[billing_code_type]'");
//				echo "bmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmb: ".$client_service_code_authorized["code_type"];



//$client_service_code = sqlQuery("SELECT pid, service_code, units, type, code_type, start_date, end_date ".
//											"FROM form_service_authorization ".
//											"WHERE isDeleted = '0' ".
//											"AND pid = $pid ".
//											"AND end_date >= '$dos[date]' ".
//											"AND start_date <= '$dos[date]' ".
//											$extra_fields. 
//											"AND code_type = '$insurance_type[billing_code_type]'");
//		
	if ($form_name == 'IND')
			{
			$alternate_client_service_code_authorized = sqlQuery("SELECT pid, service_code, units, type, code_type, start_date, end_date ".
										   "FROM form_service_authorization ". 
										   "WHERE isDeleted = '0' ". 
										   "AND type = 'patient' ".
										   "AND end_date >= '$dos[date]' ".
										   "AND start_date <= '$dos[date]' ".
										   //$service_code_fields.
										   "AND code_type = '$insurance_type[billing_code_type]'");
			}
			//echo $alternate_client_service_code_authorized."<br>";
			//echo $alternate_client_service_code_authorized["type"]."<br>";

	//echo "<br>mmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmm: ".$alternate_client_service_code_authorized["code_type"];
			
		   
$provider_results = sqlQuery("select fname, mname, lname, info, supervisor from users where username='" . $_SESSION{"authUser"} . "'");
$result = getPatientData($pid, "fname,lname,ss,pid,pubpid,sex,phone_home,pharmacy_id,DOB,DATE_FORMAT(DOB,'%Y%m%d') as DOB_YMD");
//echo "FORM NAME: ". $form_name;
?>
<?php
//echo $test
$form_pid = $_SESSION["pid"];
$form_encounter = $_SESSION["encounter"];
$v_current_session = stripslashes(json_encode(session_id()));
$current_user = $_SESSION["authUser"];
$form_user = stripslashes($obj{"user"});
$current_user_rights = stripslashes($provider_results{"info"});
$form_status = stripslashes($obj{"status"});
$insurance_type = sqlQuery("SELECT id, name, billing_code_type FROM insurance_companies WHERE id = '$insurance_test2[provider]'");
//$total_visits = 3; //Must be calculated
//$authorized_visits = 4;
//$authorized_service = '90806';
//$authorization_start = '2018-05-01';
//$authorization_end = '2018-05-10';
//$authorization_type = 'visit';
//$visit_number = 2; //must be calculated
//$remaining_visits = $authorized_visits-$total_visits;
?>
<div id="utilizationcalc">
<?php
// Make a MySQL Connection
$mysqli = new mysqli($host,$login,$pass,$dbase);
//echo "<br>1<br>";
$service_code = stripslashes($obj{"service_code"});
$query = "SELECT ".
		"sp.pid, sp.service_code, sp.units, sp.date ". 
		",fr.id, fr.form_id, fr.date, fr.encounter ".
		",en.encounter, en.date ".
		",SUM(sp.units) ". 
		"FROM forms as fr ".
		"JOIN form_progress_note AS sp ON sp.id= fr.form_id AND sp.pid = fr.pid ".
		"JOIN form_encounter AS en ON en.encounter = fr.encounter ".
		"WHERE sp.service_code = '$client_service_code_authorized[service_code]' ".
		//"WHERE sp.service_code = '$service_code' ".
		//"WHERE sp.service_code LIKE '%' ".
		"AND sp.status LIKE '%Ready for%' ".
		"AND en.date >= '$encounters_start_date' ".
		"AND sp.pid = $pid ".
		"GROUP BY sp.service_code "
		;
//echo $query;
$result_unit = $mysqli -> query ($query) ;
// Print out result
while($row = mysqli_fetch_array($result_unit)){
	$first_number = $client_service_code_authorized['units']; 
	$second_number = ($row['SUM(sp.units)']);
	$total_units =  ($row['SUM(sp.units)']);
	$sum_total = $first_number - $second_number;
}
$total_visits =  $row['SUM(sp.units)']; //Must be calculated
//$authorized_visits = 4;
//$authorized_service = '90806';
//$authorization_start = '2018-05-01';
//$authorization_end = '2018-05-10';
//$authorization_type = 'visit';
//$visit_number = 2; //must be calculated
$remaining_visits = $authorized_visits-$total_visits;

?>
</div>
<nav class="navbar navbar-default navbar-fixed-top" role="banner">
  <div class="container">
    <div class="navbar-header">
      <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="#" class="navbar-brand">Progress Note</a>
    </div>
    <nav class="collapse navbar-collapse" role="navigation">
      <ul class="nav navbar-nav">
        <li>
          <a href="#GroupE">Billing Status</a>
        </li>
<!--        <li>
		  <a href="javascript:top.restoreSession();document.SigForm.submit();">Save</a>
		  <a href="javascript:top.restoreSession();document.SigForm.submit();" class="link_submit">Save2</a>
		  <a href="javascript:top.restoreSession();document.my_form.submit();" class="link_submit">[Save]</a>
        </li>
-->        <li>
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
          <h2>Progress Note<?php echo " - ". $form_name;?>
            <p class="lead"><?php echo $provider_results["fname"].' '.$provider_results["mname"].' '.$provider_results["lname"]; ?></p>
          </h2>
          	<?php
				if ($current_user_rights == 'reviewer' && ($form_status == 'Ready for Billing' || $form_status == 'Ready for Billing/Supervisor'|| $form_status == 'Ready for Review' )){
			?>
				<br>
				Edit/Activate form <input id="activate" name="activate"  class="element text medium" type="checkbox" />
			<?php
				}
			?>

        </div>
        <div class="row">
	        <div class="col-md-7">
				<div id="utilization">
					<div class="well well-lg">
						 <dl class="dl-horizontal">
							<dt>Service Selected: </dt><dd><?php echo stripslashes($obj{"service_code"});?></dd>
							<dt>Authorization Type: </dt><dd><?php echo ucwords($client_service_code_authorized['type']);?></dd>
							<dt>Authorization #: </dt><dd><?php echo $client_service_code_authorized['authorization_number'];?></dd>
							<dt>Authorized Service: </dt><dd><?php echo $client_service_code_authorized['service_code'];?></dd>
		   		            <dt>Authorized Units/Visits: </dt><dd><?php echo $client_service_code_authorized['units'];?></dd>
				            <!--Last Visit #: <b><?php echo $visit_number;?></b><br>-->
				            <dt>Units/Visits Used #: </dt><dd><?php echo $total_units;?></dd>
				            <dt>Units/Visits Remaining: </dt><dd><?php echo $sum_total;?></dd>
				         </dl>
			         </div> 
				</div>
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
						<dd><?php echo $encounter; ?></dd>
						<dt>Transcription: </dt>
						<dd><?php echo $provider_results["fname"].' '.$provider_results["mname"].' '.$provider_results["lname"]; ?></dd>
					<!--<dt>Insurance: </dt>
						<dd><?php echo $insurance_test2["provider"].' '.$insurance_test2["policy_number"].' '.$insurance_test2["subscriber_lname"].' '.$insurance_test2["subscriber_fname"].
						' '.$insurance_test2["subscriber_DOB"].' '.$insurance_test2["subscriber_street"].' '.$insurance_test2["subscriber_postal_code"].' '.$insurance_test2["subscriber_city"].
						' '.$insurance_test2["subscriber_state"].' '.$insurance_test2["subscriber_country"].' '.$insurance_test2["subscriber_sex"].
						' '.$insurance_test2["subscriber_relationship"].' '.$insurance_test2["date"]; ; ?></dd>-->
						<?php
							if ($insurance_test2["provider"] == '' 
								|| $insurance_test2["policy_number"] == '' || $insurance_test2["subscriber_lname"] == ''
								|| $insurance_test2["subscriber_fname"] == '' || $insurance_test2["subscriber_DOB"] == '0000-00-00'
								|| $insurance_test2["subscriber_street"] == '' || $insurance_test2["subscriber_postal_code"] == ''
								|| $insurance_test2["subscriber_city"] == '' || $insurance_test2["subscriber_state"] == ''
								|| $insurance_test2["subscriber_country"] == '' || $insurance_test2["subscriber_sex"] == ''
								|| $insurance_test2["subscriber_relationship"] == '' || $insurance_test2["date"] == '0000-00-00'
							
								)
							{
						?>
							<div id="insurance_warning" class="alert alert-danger">
							<strong>Alert!</strong> There seems to be incomplete insurance information for this client. You will not be able to change the status of this form to 'Ready for Review/Billing' 
							until this issue has been resolved. You may save it as 'In Progress' for now, and change it to 'Ready for Review/Billing' when the issue is resolves.
							</div>
						<?php
							}
						?>

						<?php
								//Display Alerts
							if (isset($client_service_code_authorized[code_type]))
								{	
								echo "<br>Client Service Code Type1:". $client_service_code_authorized["code_type"];
								}else{
								echo "<br>Client Service Code Type2:". $alternate_client_service_code_authorized["code_type"];
								}
								echo "<br>Insurance:". $insurance_test2['provider'];//$client_insurance["provider"];
								echo "<br>". $insurance_type["name"]. "&nbsp; ". $insurance_type["billing_code_type"];
											if (($client_service_code_authorized["code_type"]) != ($insurance_type["billing_code_type"]))
												{
													echo "<br><div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert'>&times;</a>".
														"<strong>Warning!</strong>There is a mismatch between insurance and client code type</div>";
												}
											if ((isset($insurance_restriction["service_code"])) && (empty($client_service_code_authorized["service_code"]))) 
												{						
													echo "<div class='alert alert-danger'><a href='#' class='close' data-dismiss='alert'>&times;</a>".
														"<strong>Warning!</strong>There are NO AUTHORIZATION on file</div>";
												}
						
						?><!--
						<div id="brian">
						<dt>Form_pid: </dt><dd><?php echo $form_pid;?></dd>
						<dt>Form_encounter: </dt><dd><?php echo $form_encounter;?></dd>
						<dt>V_Name: </dt><dd><?php echo stripslashes($obj{"v_client_name"});?> Current: <?php echo stripslashes($obj{"v_client_name"});?></dd>
						<dt>V_PID: </dt><dd><?php echo stripslashes($obj{"v_pid"});?> Current: <?php echo $_SESSION["pid"];?></dd>
						<dt>V_DOS: </dt><dd><?php echo stripslashes($obj{"v_dos"});?></dd>
						<dt>V_Encounter</dt><dd><?php echo stripslashes($obj{"v_encounter"});?> Current: <?php echo $_SESSION["encounter"];?></dd>
						<dt>V_session: </dt><dd><?php echo $v_current_session;?> Current: <?php echo $v_current_session;?></dd>
						-->
					</dl>
				</div>
			</div>
		</div> 
	</div>
  </div><!--/container-->
</div><!--/masthead-->
<!--main-->

<form method=post action="<?php echo $rootdir?>/forms/progress_note/savetp.php?mode=update&id=<?php echo $_GET["id"];?>" name="SigForm" id="SigForm">


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
<!--<?php echo "<form method='post' name='sigform' " .  "action='$rootdir/forms/form_progress_note/savetp.php?mode=update&id=" . attr($formid) ."'>\n";?>-->
<script type="text/javascript">
  function submitForm(action) {
    var form = document.getElementById('SigForm');
    form.action = action;
    form.submit();
  }
</script>
<form method=post action="<?php echo $rootdir?>/forms/progress_note/savetp.php?mode=update&id=<?php echo $_GET["id"];?>" name="SigForm" id="SigForm">

	<br>
	<div id="service_header">
	
	<?php
//$mysqli = new mysqli($host, $login, $pass, $dbase); 

// Write out our query.
if ($client_service_code_authorized[code_type] == '')
		{
			$query = "SELECT type, form, service_code, code_type, service_name FROM form_service_authorization where isDeleted = '0' AND form = '$form_name' AND type = 'form'";
		}else{
			$query = "SELECT type, form, service_code, code_type, service_name FROM form_service_authorization where isDeleted = '0' AND form = '$form_name' AND type = 'form' AND code_type = '$client_service_code_authorized[code_type]' ".
						"AND code_type = '$insurance_type[billing_code_type]'";
					 

		}
		
// Execute it, or return the error message if there's a problem.
$result = $mysqli -> query ($query);

$dropdown .= "<select name='service_code' id='service_code'><option selected=''>". stripslashes($obj{"service_code"}). "</option>";
	
while($row = mysqli_fetch_array($result)) {
  $dropdown .= "\r\n<option value='{$row['service_code']}'>{$row['service_code']}". "  "."{$row['service_name']}</option>";
  
}
$dropdown .= "\r\n</select>";

?>   
		
		<div id ="TimeUnits">
			<dl class="dl-horizontal">
			<?php echo "<dt>Service Code:</dt><dd>",$dropdown, "(TBD: To Be Determined. No billing until actual service code)</dd><p>" ;?>

				<dt>Time Started:</dt>
				<dd><input name="time_start" id="time_start" type="text" value="<?php echo stripslashes($obj{"time_start"});?>" required style="width: 81px" /></dd>
				<dt>End Time:</dt>
				<dd><input name="time_end" id="time_end" type="text" value="<?php echo stripslashes($obj{"time_end"});?>" required style="width: 81px" /></dd>			
				<dt>Units:</dt>
				<dd><input name="units" id="units" type="number" value="<?php echo stripslashes($obj{"units"});?>" maxlength="2" required style="width: 47px; height: 22px" /></dd>			
			</dl>
		</div>	
		
	
		
<!--
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
-->
     
</div>
<br>		
<?php
//echo $insurance_type["billing_code_type"];

		if ($insurance_type["billing_code_type"] == 'CPT')
				{
				$valid_diag = $cpt_diag;
				}else{
				$valid_diag = $hcpcs_diag;
				}
				//echo $insurance_type["billing_code_type"];
			

		//$invalid_diag = "'F80','F84','ICD10:G00.0'";//MOVED TO cpt_diag.php
		//$invalid_diag = "'F80','F84',
		//				 'ICD10:G00.0'";
		//$invalid_diag_as_string = implode( ',', $invalid_diag);
		//echo $invalid_diag_as_string;
		
	//	$query = "SELECT pid, title, diagnosis, type, enddate FROM lists where type = 'medical_problem' and pid = $pid and diagnosis != '' and enddate IS NULL and diagnosis LIKE '%ICD10%'and diagnosis NOT LIKE '%F7%' and diagnosis NOT LIKE '%F80%' and diagnosis NOT LIKE '%F84%' and diagnosis NOT LIKE '%F99%';";
		$query = "SELECT pid, title, diagnosis, type, enddate FROM lists where pid = $pid AND diagnosis IN ($valid_diag);";
		//echo $query;
		// Execute it, or return the error message if there's a problem.
		$result = $mysqli -> query($query);
			$dropdown1 .= "<select id='diagnosis1' name='diagnosis1' required ><option selected=''>". stripslashes($obj{"diagnosis1"}). "</option>";
			$dropdown2 .= "<select name='diagnosis2'><option selected=''>". stripslashes($obj{"diagnosis2"}). "</option>";
			$dropdown3 .= "<select name='diagnosis3'><option selected=''>". stripslashes($obj{"diagnosis3"}). "</option>";
			$dropdown4 .= "<select name='diagnosis4'><option selected=''>". stripslashes($obj{"diagnosis4"}). "</option>";
		while($row = mysqli_fetch_array($result)) {
			$dropdown1 .= "\r\n<option value='{$row['diagnosis']}". "  "."{$row['title']}'>{$row['diagnosis']}". "  "."{$row['title']}</option>";
			$dropdown2 .= "\r\n<option value='{$row['diagnosis']}". "  "."{$row['title']}'>{$row['diagnosis']}". "  "."{$row['title']}</option>";
			$dropdown3 .= "\r\n<option value='{$row['diagnosis']}". "  "."{$row['title']}'>{$row['diagnosis']}". "  "."{$row['title']}</option>";
			$dropdown4 .= "\r\n<option value='{$row['diagnosis']}". "  "."{$row['title']}'>{$row['diagnosis']}". "  "."{$row['title']}</option>";
		}
			$dropdown1 .= "\r\n</select>";
			$dropdown2 .= "\r\n</select>";
			$dropdown3 .= "\r\n</select>";
			$dropdown4 .= "\r\n</select>";
			echo  "<dl class='dl-horizontal'><dt>Diagnosis 1:</dt><dd>",$dropdown1, "<b>*Choose at least one.</b></dd>" ;?><br>
								<?php echo "<dt>Diagnosis 2:</dt><dd>", $dropdown2, " Can't duplicate Diagnosis 1</dd>" ;?>
								<p>
								<?php echo "<dt>Diagnosis 3:</dt><dd>", $dropdown3, "</dd>" ;?>
								<p>
								<?php echo "<dt>Diagnosis 4:</dt><dd>", $dropdown4, "</dd></dl></div>" ;?>
		
	
	</div>
	</div>
<?php
			if ($form_name == "IND" || $form_name == "TBO"|| $form_name == "GRP")
			{
			include_once("soap.php");
			}
?>

<?php
			if ($form_name == "PSR"|| $form_name == "DAY")
			{
			include_once("psr.php");
			}
?>
<?php
			if ($form_name == "ORI")
			{
			include_once("psr_orientation.php");
			}
?>

	
	<div class="clearfix"></div>

	</div>
	

	
    <div class="tabContainer">
        <div>
       			<a href="<?php echo "$web_root";?>/interface/forms/form_progress_note/tabs4.php?dev=1&formid=
       					 <?php echo "$formid";?>&pid=<?php echo "$pid";?>&encounter=<?php echo "$encounter";?>&tpformid=<?php echo stripslashes($obj{"tp_form_id"});?>" 
					   class="iframe medium_modal pull-right"><span>*</span></a>
        </div>
    </div>
</div>
<!--<?php echo "<form method='post' name='sigform' " .  "action='$rootdir/forms/form_progress_note/savetp.php?mode=update&id=" . attr($formid) ."'>\n";?>-->
<br>
		</div>
	
<script language="javascript">
 $(document).ready(
            function() {
                setInterval(function() {
                      // $("#signature").load('signature.php'});
                      function reload_messages(){
    					$.get("signature.php", function(data) {
    					 $("#signature").html(data);
    					});
					}
                      
                   
                      }, 600);
            });

</script>

	<div class="container">
		<div id="signature">
		<?php
		include ("signature.php");
		?>
		</div>
		
		<div id="problem">
			<div class="panel-body">

				<div id="GroupE" class="form-group group form-inline">
				 <div id="status">
					<strong>Status:</strong>
					<select class="form-control" id="status" name="status" >
						<option selected=""><?php echo stripslashes($obj{"status"});?></option>
						<option value="In Progress">In Progress</option>
						<option value="Ready for Review">Ready for Review</option>
						<?php
							if ($current_user_rights == 'reviewer'){
						?>
						<option value="Ready for Billing">Ready for Billing</option>
						<option value="Error Report/Correction(s) Needed">Error Report/Correction(s) Needed</option>
					<?php
						}
					?>
					<option value="Void/Delete Request">Void/Delete Request</option>
					</select>
					<em><span>Select the status of this document. It will not be billed until signed and the status is 'Ready for Billing'</span></em>
					</div>
				 </div>
			</div>
			<div id="GroupPlan" class="form-group group">
				<h3>Review Log:</h3>
				<textarea name="comments_log_view" class="form-control" cols="40" readonly rows="10"><?php echo stripslashes($obj{"comments_log"});?></textarea>
			</div>
			<?php
			if ($form_status == 'Error Report/Correction(s) Needed'){
			?>
			
			<div id="GroupPlan" class="form-group group">
						<h3>New Review Entry:</h3>
						<textarea name="comments_log" class="form-control" cols="40" rows="10"></textarea>
					</div>
			<?php
			}
			?>

		
		<input type="hidden" name="encounter" id="encounter" value="<?php echo $encounter; ?>" readonly="readonly">	

		
		<label>Service Code: </label><?php echo stripslashes($obj{"service_code"});?>
		<label>tp_form_id: </label><?php echo stripslashes($obj{"tp_form_id"});?>
		<br>
	    <input class="btn btn-default" id="submit" type="submit"  value="Save" class="button-css">&nbsp;
		<input class="btn btn-default" id="draft" type="submit"  value="Save As Draft" class="button-css" onclick="submitForm('<?php echo $rootdir?>/forms/progress_note/save_as_draft.php?mode=update&id=<?php echo $_GET["id"];?>')" formnovalidate>&nbsp;
		<input class="btn btn-default" type='button'  value="Print" onclick="PrintForm()" class="button-css">&nbsp;
		<input class="btn btn-default" type='button' class="button-css" value='<?php echo xlt('Cancel');?>' onclick="top.restoreSession();location='<?php echo $GLOBALS['form_exit_url']; ?>'" >

	<br>
		<br> 


</div>

<div id="alerts" class="alerts" >
</div>
</div>
<?php

?>
<script language="javascript">
//			$(document).ready(function() {
//			    setInterval(function() {
			       // $("#verify").load("thecontent.php"); 
//			         $("div#brian").hide();  
//			    }, 3000);
//			});
</script>
<!--
<script language="javascript" type="text/javascript">
			function loadlink(){
			    $('#brian').load('<?php //echo $GLOBALS['webroot'] ?>/interface/forms/progress_note/testn.php',function () {
			    //  $('#brian').load('<?php //echo $GLOBALS['webroot'] ?>/interface/forms/progress_note/test.php', {v_client_name:'<?php //echo stripslashes($obj{"v_client_name"});?>',v_dos:'<?php //echo stripslashes($obj{"v_dos"});?>',v_pid:'<?php //echo stripslashes($obj{"v_pid"});?>', v_encounter:'<?php //echo stripslashes($obj{"v_encounter"});?>',function () {

			         $(this).unwrap();
			    });
			}
			
			loadlink(); // This will run on page load
			setInterval(function(){
			    loadlink() // this will run after every 5 seconds
			}, 3000);

</script>
-->
<script>
/*
    $(document).ready(
            function() {
                setInterval(function() {
                    var randomnumber = Math.floor(Math.random() * 100);
                   // $('#problem').text(
                   //         'I am getting refreshed every 3 seconds..! Random Number ==> '
                   //                 + randomnumber);
                                    
                    $('div#brian').load('<?php echo $GLOBALS['webroot'] ?>/interface/forms/progress_note/test.php',{
                     form_pid:'<?php echo $form_pid;?>',
                     form_encounter:'<?php echo $form_encounter;?>',
                     v_client_name:'<?php echo (stripslashes($obj{"v_client_name"}));?>',
                     v_current_session:'<?php echo $v_current_session;?>',
                     v_dos:'<?php echo stripslashes($obj{"v_dos"});?>',
                     v_pid:'<?php echo stripslashes($obj{"v_pid"});?>', 
                     v_encounter:'<?php echo stripslashes($obj{"v_encounter"});?>'
                     }); 
                    //$('div#brian').text('Hello world');               
                }, 1000);
						});
*/
</script>

<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/interface/forms/progress_note/session_detector/session_detector.js"></script>
<script  type="text/javascript">
	// these are the pre-requisites for Session_detector.js
	// also make sure this file has all the fancybox includes
	var session_detector_options = {
		form_pid:'<?php echo $form_pid;?>',
		form_encounter:'<?php echo $form_encounter;?>',
		v_client_name:'<?php echo (stripslashes($obj{"v_client_name"}));?>',
		v_current_session:'<?php echo $v_current_session;?>',
		v_dos:'<?php echo stripslashes($obj{"v_dos"});?>',
		v_pid:'<?php echo stripslashes($obj{"v_pid"});?>', 
		v_encounter:'<?php echo stripslashes($obj{"v_encounter"});?>'
	};
	var WEBROOT = '<?php echo $GLOBALS['webroot'] ?>';
</script>
<!-- 
	TODO: jquery dialog
	<div id="session_detector_dialog" title="Session Conflict">
	<p>There is another session open in this browser.</p>
</div> -->


<?php
if ($obj{"service_code"} == "TBD")
{
?>
<script language="javascript">
$("#submit").attr('disabled',true);
</script>
<?php
}
?>		

</div>

	</div><!--/col-->

</div><!--/row-->
<!--/container-->
<script language="javascript">
$(document).ready(function(){
    $("#service_code").click(function() {
     //$("div#utilization").hide();
    // $("div#utilizationcalc");
    	$("div#utilizationcalc").html();
    	$("div#utilization").html();

    			
    });
});
</script>

<script language="javascript">
//$("#submit").attr('disabled',true);
$("#service_code").on('change',function(){
   if($(this).find('option:selected').text()=="TBD")
       $("#submit").attr('disabled',true)
   else
       $("#submit").attr('disabled',false)
});
function disableForm(SigForm){
  $('#' + SigForm).children(':input').attr('disabled', 'disabled');
}
//Check if Problems are present
//document.forms['SigForm']['goal'].readOnly = true;
//document.forms['SigForm']['objective'].readOnly = true;
$(document).ready(function() { 
  if ( $("#goal").text() ){ 
    $('input#submit').attr('disabled',true);
  } else { 
    $('input#submit').attr('disabled',false)

  }
});
//document.getElementById('status').setAttribute('disabled','enabled');
document.getElementById('status').setAttribute('disabled','disabled');
//document.getElementById('status').removeAttr('disabled');
</script>
<?php
echo $current_user;
echo $current_user_rights;
echo $provider_results["supervisor"];
echo $form_status; 
/*
if ($current_user_rights != 'reviewer') 
		{
	?>
	<script language="javascript">
		$(document).ready(function(){
			$("select").find("option[value='Ready for Billing']").attr("disabled", true);
			//}else{
			//$("select").find("option[value='Ready for Billing']").attr("disabled", false);
			});
	</script>
<?php
//}
?>
<!--
<script language="javascript" type="text/javascript">
function loadlink(){
    $('#brian').load('test.php',function () {
         $(this).unwrap();
    });
}

loadlink(); // This will run on page load
setInterval(function(){
    loadlink() // this will run after every 5 seconds
}, 5000);

</script>
-->










<?php
formFooter();
?>