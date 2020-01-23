<?php
include_once("../../../globals.php");
//include_once ("$srcdir/sql.inc");
//require_once ("{$GLOBALS['srcdir']}/sql.inc");
include_once("$srcdir/api.inc");
require_once("$srcdir/patient.inc");
require_once("$srcdir/options.inc.php");
?>
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
		<!-- <link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/library/css/bootstrap-sidebar.css" type="text/css"> -->
		<!--[if lt IE 9]>
			<script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<!-- supporting javascript code -->
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-2.0.2.min.js"></script>
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-3.3.7/js/bootstrap.min.js"></script>
		<!-- <script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-sidebar.js"></script> -->
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-datepicker.min.js"></script>

<!-- supporting javascript code -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js " type="text/javascript"></script>
<!--<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery.js"></script>-->
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/textformat.js"></script>
<!-- pop up calendar -->
<style type="text/css">@import url(<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.css);
.auto-style1 {
	background-color: #A2F387;
}
input:invalid { background: red; }
.input-sm {
	padding: 2px;
}
.table td {
	padding: 2px !important;
}
</style>
<!-- <link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/interface/themes/style-form-print.css" type="text/css"> -->

<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.js"></script>
<?php include_once("{$GLOBALS['srcdir']}/dynarch_calendar_en.inc.php"); ?>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar_setup.js"></script>

</head>
<div class="container-fluid">
<input type="checkbox" id="checkAll"> <label for="checkAll">Check All</label>
<?php
$start_date = "$_REQUEST[start_date]";
$end_date = "$_REQUEST[end_date]";
$created_start_date = "$_REQUEST[created_start_date]";
$created_end_date = "$_REQUEST[created_end_date]";
$patientid = "$_REQUEST[patientid]";
$form_selected = "$_REQUEST[form_selected]";
$billing_code_type = "$_REQUEST[billing_code_type]";
$form_status = "$_REQUEST[form_status]";
$user_name = "$_REQUEST[form_doctor]";
$form_billing_status = "$_REQUEST[form_billing_status]";
$encounter_already_billed = "$_REQUEST[encounter_already_billed]";
echo $user_name;
switch ($form_selected) {
    case "form_psychosocial":
         $form_name = "Psychosocial Rehabilitation";
         $extra_fields = ", fr.diagnosis1, fr.diagnosis2, fr.diagnosis3, fr.diagnosis4, fr.clinical_intervention, fr.response_to_intervention, fr.credentials, fr.sig_date, fr.provider_id, fr.provider_print_name, fr.timestart, fr.timeend";
    break;
    case "form_soap_pirc":
         $form_name = "SOAP Notes";
         $extra_fields = ", fr.diagnosis1, fr.diagnosis2, fr.diagnosis3, fr.diagnosis4, fr.objective, fr.subjective, fr.assessment, fr.plan, provider_credentials, provider_signature_date, fr.provider_print_name, fr.timestart, fr.timeend";
    break;
    case "form_med_management":
         $form_name = "Medication Management";
         $extra_fields = ", fr.complaint";
    break;
    case "form_progress_note_ind":
    $form_selected = "form_progress_note";
         $form_name = "Progress Note - IND";
         $extra_fields = ", fr.diagnosis1, fr.diagnosis2, fr.diagnosis3, fr.diagnosis4, fr.subjective, fr.objective, fr.assessment, fr.plan, fr.provider_credentials, fr.provider_signature_date, fr.provider_print_name, fr.time_start, fr.time_end, fr.comments_log ";
    break;
	case "form_progress_note_psr":
	$form_selected = "form_progress_note";
         $form_name = "Progress Note - PSR";
         $extra_fields = ", fr.diagnosis1, fr.diagnosis2, fr.diagnosis3, fr.diagnosis4, fr.deficit_problems_behavior_addressed, fr.interventions, fr.response_to_intervention, fr.provider_credentials, fr.provider_signature_date, fr.provider_print_name, fr.time_start, fr.time_end, fr.comments_log";
    break;
	case "form_progress_note_day":
	$form_selected = "form_progress_note";
         $form_name = "Progress Note - DAY";
         $extra_fields = ", fr.diagnosis1, fr.diagnosis2, fr.diagnosis3, fr.diagnosis4, fr.provider_credentials, fr.provider_signature_date, fr.provider_print_name, fr.time_start, fr.time_end, fr.comments_log";
    break;
	case "form_progress_note_tbo":
	$form_selected = "form_progress_note";
         $form_name = "Progress Note - TBO";
         $extra_fields = ", fr.diagnosis1, fr.diagnosis2, fr.diagnosis3, fr.diagnosis4, fr.subjective, fr.objective, fr.assessment, fr.plan, provider_credentials, provider_signature_date, fr.provider_print_name, fr.time_start, fr.time_end, fr.comments_log";
    break;
	case "form_progress_note_ori":
	$form_selected = "form_progress_note";
         $form_name = "Progress Note - ORI";
         $extra_fields = ", fr.diagnosis1, fr.diagnosis2, fr.diagnosis3, fr.diagnosis4, fr.provider_credentials, fr.provider_signature_date, fr.provider_print_name, fr.time_start, fr.time_end, fr.comments_log";
    break;
	case "form_progress_note_grp":
	$form_selected = "form_progress_note";
         $form_name = "Progress Note - GRP";
         $extra_fields = ", fr.diagnosis1, fr.diagnosis2, fr.diagnosis3, fr.diagnosis4, fr.provider_credentials, fr.provider_signature_date, fr.provider_print_name, fr.time_start, fr.time_end, fr.comments_log";
    break;


   
}

if ($created_start_date == "" OR $created_end_date == ""){
	$date_created_select = "";
						} else {
								$date_created_select = "AND fr.created between '$created_start_date' AND '$created_end_date' ";
						}

if ($patientid == ""){
		$patient_select = "";
						} else {
								$patient_select = "AND fr.pid = '$patientid' ";
					  }

if ($billing_code_type == ""){
		$billing_code_type_select = "";
						} else {
								$billing_code_type_select = "AND po.billing_code_type = '$billing_code_type' ";
					  }
if ($form_billing_status == ""){
		$form_billing_status_select = "";
						} else {
								$form_billing_status_select = "AND billing_status = '$form_billing_status' ";
					  }
if ($encounter_already_billed == ""){
		$encounter_already_billed_select = "";
						} else {
								$encounter_already_billed_select = "AND en.last_level_billed = '$encounter_already_billed' ";
					  }

if ($form_status == ""){
		$form_status_select = "";
						} else {
								$form_status_select = "AND fr.status = '$form_status' ";
					  }

if ($user_name) {
          $provider_select = "AND fr.user = '$user_name' ";					
          				} else {
							  	$provider_select = "";
				  }


				$mysqli = new mysqli($host, $login, $pass, $dbase);
				//echo "test";
				//echo $mysqli;
				//$connection = mysql_connect($host, $login, $pass); 
				//$db = @mysql_select_db($dbase, $connection);

$sql = "SELECT ". 
	"fr.id AS frid, fr.pid, fr.user,  fr.service_code, fr.units, fr.billing_id, fr.billing_status".
	$extra_fields.
	", fr.status, fr.created, fr.encounter".
	", pl.pid, MAX(pl.provider) AS plprovider, pl.type, pl.plan_name AS plplan_name, pl.policy_number AS plpolicy_number, MAX(pl.date) AS pldate".
	", po.id, po.name AS poname, po.billing_code_type AS pobilling_code_type".
	", fm.form_id, fm.form_name, fm.encounter AS fmencounter".
	", en.date, en.encounter AS enencounter, en.facility, en.last_level_billed".
	", pd.fname, pd.lname, pd.mname, pd.dob, pd.ss, pd.billing_note, pd.genericname1, pd.genericval1, pd.genericname2, pd.genericval2 ".
	"FROM $form_selected AS fr ".
	"JOIN forms AS fm ON fm.form_id = fr.id ".
	"AND form_name = '$form_name' ".
	$form_billing_status_select.
	//"AND billing_status NOT LIKE 'billed' ".
	$provider_select.
	"JOIN form_encounter AS en ON en.encounter = fm.encounter ". 
	"JOIN patient_data AS pd ON pd.pid = fr.pid ".
	"JOIN insurance_data AS pl ON pl.pid = fr.pid ".
	"JOIN insurance_companies AS po ON po.id = pl.provider ".

	"AND en.date >= pl.date ".
	//"AND pl.provider = '5174' ".
	//"JOIN insurance_companies AS po ON po.id = pl.provider ".
	//"AND pl.date >= en.date ".
	//"AND en.date >= pl.date ".
	//"AND pl.provider = '5174' ".
	//"ORDER BY pl.date ".
	$billing_code_type_select.
	//"JOIN forms AS fm ON fm.form_id = fr.id ". 
	//"WHERE fr.pid = '$patientid'".
	"WHERE en.date between '$start_date' AND '$end_date' ".
	//"AND fr.status LIKE 'Ready for Billing%' ".
	//"AND fr.status LIKE '$form_status' ".
	//"AND fr.billing_id = 0 ".
	"AND pl.type = 'primary' ".
	//"AND pl.date <= en.date ".
	//"AND en.last_level_billed = 1 ".
	$encounter_already_billed_select.
	$form_status_select.
	//$billing_code_type_select.
	$date_created_select.
	$patient_select.
	"GROUP BY fr.id "
	;
//echo "<br>Connection:". $connection;
//echo $sql;	
//$result = @mysql_query($sql,$connection) or die(mysql_error());
$result = $mysqli -> query ($sql);
while ($row = mysqli_fetch_array($result)) 
{
//$insurance = getInsuranceDataByDate(pid, '2017/04/29');
//$billed = isEncounterBilled('pid', 'encounter');
$form_id = $row['frid'];
$fm_encounter = $row['fmencounter'];
$en_encounter = $row['enencounter'];
$f_billing_id = $row['fr.billing_id'];
$provider_id = $row['fr.provider_id'];
$pid = $row['pid'];
$servicecode = $row['service_code'];
$justify1 = substr($row["diagnosis1"], 0, strpos($row["diagnosis1"], ' '));
$justify2 = substr($row["diagnosis2"], 0, strpos($row["diagnosis2"], ' '));
$justify3 = substr($row["diagnosis3"], 0, strpos($row["diagnosis3"], ' '));
$justify4 = substr($row["diagnosis4"], 0, strpos($row["diagnosis4"], ' '));
$justify5 = str_replace(':', '|', $justify1).":".str_replace(':', '|', $justify2).":".str_replace(':', '|', $justify3).":".str_replace(':', '|', $justify4).":";
$diag1 = substr($row["diagnosis1"], strpos($row["diagnosis1"], ' ') +1);
$diag2 = substr($row["diagnosis2"], strpos($row["diagnosis2"], ' ') +1);
$diag3 = substr($row["diagnosis3"], strpos($row["diagnosis3"], ' ') +1);
$diag4 = substr($row["diagnosis4"], strpos($row["diagnosis4"], ' ') +1);
$diag_code1 = substr($justify1, strpos($justify1, ':') +1);
$diag_code2 = substr($justify2, strpos($justify2, ':') +1);
$diag_code3 = substr($justify3, strpos($justify3, ':') +1);
$diag_code4 = substr($justify4, strpos($justify4, ':') +1);
$code_type1 = substr($row["diagnosis1"], 0, strpos($row["diagnosis1"], ':'));
$code_type2 = substr($row["diagnosis2"], 0, strpos($row["diagnosis2"], ':'));
$code_type3 = substr($row["diagnosis3"], 0, strpos($row["diagnosis3"], ':'));
$code_type4 = substr($row["diagnosis4"], 0, strpos($row["diagnosis4"], ':'));
$comments_log  = $row['fr.comments_log'];
$patterns = array();
$patterns[0] = '/::::/';
$patterns[1] = '/:::/';
$patterns[2] = '/::/';
$replacements = ':';
$justify = preg_replace($patterns, $replacements, $justify5);
$units = $row['units'];

//****************************Calculations
switch ($servicecode) {
    case "H2019HO":
        $fee= 32*$units;
        $code_text = "TBOSS";
        $code_type = "HCPCS";
        break;
    case "H2019HR":
        $fee= 36.66*$units;
        $code_text = "INDIVIDUAL THERAPY";
        $code_type = "HCPCS";
        break;
    case "H2019HQ":
        $fee= 13.34*$units;
        $code_text = "GROUP THERAPY";
        $code_type = "HCPCS";
        break;
    case "H2019HM":
        $fee= 20*$units;
        $code_text = "Home and Community based Rehabilitative";
        $code_type = "HCPCS";
        break;
    case "H2019HN":
        $fee= 13.34*$units;
        $code_text = "Home and Community based Rehabilitative";
        $code_type = "HCPCS";
        break;
    case "H2017":
        $fee= 18*$units;
        $code_text = "PSYCHO SOCIAL REHABILITATION";
        $code_type = "HCPCS";
        break;
    case "H2012":
        $fee= 25*$units;
        $code_text = "DAY TREATMENT";
        $code_type = "HCPCS";
        break;
     case "90832":
        $fee= 73.32*$units;
        $code_text = "*Psychotherapy 30 (16-37) min";
        $code_type = "CPT4";
        break;
    case "90834":
        $fee= 109.98*$units;
        $code_text = "*Psychotherapy 45 (38-52) min";
        $code_type = "CPT4";
        break;
	case "90837":
        $fee= 146.64*$units;
        $code_text = "*Psychotherapy 60 (53+) min";
        $code_type = "CPT4";
        break;
	case "90847":
        $fee= 95*$units;
        $code_text = "Family Therapy 2 MEMBERS";
        $code_type = "CPT4";
        break;
	case "90853":
        $fee= 53.36*$units;
        $code_text = "GROUP THERAPY";
        $code_type = "CPT4";
        break;



   
}
//$insurance_test2 = getInsuranceDataByDate($pid, (substr($row["date"], 0, 10)), "primary", "provider");

//foreach($insurance_test2 as $key => $value) {
  //echo "$key is at $value";
	//echo "VVVVVVVVVVVV..2 ". $insurance_test2[$key];
//	$company = getInsuranceProvider($insurance_test2[$key]);
//	echo $company; 
//}
//echo "VVVVVVVVVVVV..2 ". $insurance_test2[$key];


?>
<form action="kraken.php" method="post">
<hr/>
<!-- Info Header -->
<div class="header3">
<?php
$insurance_test2 = getInsuranceDataByDate($pid, (substr($row["date"], 0, 10)), "primary", "provider");

foreach($insurance_test2 as $key => $value) {
	$company = getInsuranceProvider($insurance_test2[$key]);
	echo $company; 
}
?>
	<h3><?php echo $row['form_name'];?></h3>
	<div class="info">
<!-- Form Info -->
		<div class="panel panel-default">
			<span><b>Form ID:&nbsp;</b></span><?php echo $row['frid'];?><br>
			<span><b>Ins:&nbsp;</b></span><?php echo $insurance;?>----<?php echo $billed;?>_-_<?php echo $row['plpolicy_number'];?>
<!--//in.pid, in.provider AS inprovider, in.type, in.policy_number-->
			<span><br><b>Insurance:&nbsp;</b></span><?php echo $row['plprovider'];?>-<?php echo $row['plplan_name'];?>-<?php echo $row['poname'];?>-<?php echo $row['pobilling_code_type'];?>-Effective 
			Date:<?php echo $row['pldate'];?><br>
			<b>Insurance API:</b><?php echo $company;?><br>
			<span><b>Encounter:&nbsp;</b></span><?php echo $row['encounter'];?>_<?php echo $fm_encounter;?>_<?php echo $en_encounter;?><br>
			<span><b>ID: </b><?php echo $row['pid'] ?> <b>Name: </b></span><?php echo $row['fname'] . '&nbsp' . $row['mname'] . '&nbsp;' . $row['lname'];?>
			&nbsp;<span><b>DOB:&nbsp;</b></span><?php echo $row['dob'];?><br>
			<span><b>DOS:&nbsp;</b></span><?php echo substr($row["date"], 0, 10); ?>
			<span><b>Provider:&nbsp;</b></span><?php echo stripslashes($row{"provider_print_name"});?>
			<span><br><b>POS:&nbsp;</b></span><?php echo $row['facility'];?>
			<span><b>Time Started:&nbsp;</b></span><?php echo stripslashes($row{"time_start"});?>
			<span><b>End Time:&nbsp;</b></span><?php echo stripslashes($row{"time_end"});?><br>
			<span><b>Date Ceated:&nbsp;</b></span><?php echo substr($row["created"], 0, 10);?><br>
			<span><b>Status:&nbsp;</b></span><?php echo $row['status'];?>
			<span><b>Billing ID:&nbsp;</b></span><?php echo $row['billing_id'];?><br>
			<span><b>Billing Status:&nbsp;</b></span><?php echo $row['billing_status'];?><br>
		</div>
	</div>
	<!--<br class="clr">-->
</div>
	
			<?php
			switch ($form_selected) {
							    case "form_psychosocial":
							    	 echo "<div class='well well-sm'>";
							    	 echo "<span><b>Clinical Intervention:</b>&nbsp;".$row['clinical_intervention']. "<br>";
							    	 echo "<b><br>Response To Intervention:</b>&nbsp;".$row['response_to_intervention']. "</span><br>"; 
							         echo "</div>";
							         //echo "<br class='clr'>";
							         echo "<div class='well well-sm'>";
							         echo "<b>Electronically Signed By:&nbsp;</b>";
							         echo "<span>". $row['provider_print_name']. "&nbsp;</span>";
							         echo "<span>&nbsp;&nbsp;". $row['credentials']. "</span>";
							    	 echo "<span><br><b>Signature Date:&nbsp;</b>". $row['sig_date']. "</span>"; 
							    	 echo "</div>";
					    		break;
							    case "form_soap_pirc":
							   		 echo "<div class='well well-sm'>";
							    	 echo "<b>Subjective:</b>&nbsp;".$row['subjective']. "<br>";
							    	 echo "<b>Objective:</b>&nbsp;".$row['objective']. "<br>"; 
							    	 echo "<b>Assessment:</b>&nbsp;".$row['assessment']. "<br>";
							    	 echo "<b>Plan:</b>&nbsp;".$row['plan']. "<br>"; 
							    	 echo "</div>";
							         //echo "<br class='clr'>";
							         echo "<div class='well well-sm'>";
							    	 echo "<b>Electronically Signed By:&nbsp;</b>";
									 echo $row['provider_print_name']. "&nbsp;";
							         echo $row['provider_credentials'];
							         echo "<span><br><b>Signature Date:&nbsp;</b>". $row['provider_signature_date']. "</span>";
							         echo "</div>";
					    		break;
					    		  case "form_med_management":
							   		 echo "<div class='well well-sm'>";
							    	 echo "<b>Complaint:</b>&nbsp;".$row['complaint']. "<br>";
							    	 echo "</div>";
							         //echo "<br class='clr'>";
							         echo "<div class='well well-sm'>";
							    	 echo "<b>Electronically Signed By:&nbsp;</b>";
									 echo $row['provider_print_name']. "&nbsp;";
							         echo $row['provider_credentials'];
							         echo "<span><br><b>Signature Date:&nbsp;</b>". $row['sig_date']. "</span>";
							         echo "</div>";
					    		break; 
					    			

									}
							switch ($form_name) {
							    case "Progress Note - PSR":
							    	 echo "<div class='well well-sm'>";
							    	 echo "<b>Diagnosis 1:</b>&nbsp;".$row['diagnosis1']. "<br>";
							   		 echo "<b>Diagnosis 2:</b>&nbsp;".$row['diagnosis2']. "<br>";
							   		 echo "<b>Diagnosis 3:</b>&nbsp;".$row['diagnosis3']. "<br>";
							   		 echo "<b>Diagnosis 4:</b>&nbsp;".$row['diagnosis4']. "<br>";
							   		 echo "<span><b>Deficit Problems Behavior Addressed:</b>&nbsp;".$row['deficit_problems_behavior_addressed']. "<br>";

							    	 echo "<span><b>Clinical Intervention:</b>&nbsp;".$row['interventions']. "<br>";
							    	 echo "<b><br>Response To Intervention:</b>&nbsp;".$row['response_to_intervention']. "</span><br>"; 
							         echo "</div>";
							         //echo "<br class='clr'>";
							         echo "<div class='well well-sm'>";
							        echo "<div class='well well-sm'>";
							    	 echo "<b>Electronically Signed By:&nbsp;</b>";
									 echo $row['provider_print_name']. "&nbsp;";
							         echo $row['provider_credentials'];
							         echo "<span><br><b>Signature Date:&nbsp;</b>". $row['provider_signature_date']. "</span>";
							         echo "</div>";
					    		break;
							    case "Progress Note - IND":
							   		 echo "<div class='well well-sm'>";
							   		 echo "<b>Diagnosis 1:</b>&nbsp;".$row['diagnosis1']. "<br>";
							   		 echo "<b>Diagnosis 2:</b>&nbsp;".$row['diagnosis2']. "<br>";
							   		 echo "<b>Diagnosis 3:</b>&nbsp;".$row['diagnosis3']. "<br>";
							   		 echo "<b>Diagnosis 4:</b>&nbsp;".$row['diagnosis4']. "<br>";
							    	 echo "<b>Subjective:</b>&nbsp;".$row['subjective']. "<br>";
							    	 echo "<b>Objective:</b>&nbsp;".$row['objective']. "<br>"; 
							    	 echo "<b>Assessment:</b>&nbsp;".$row['assessment']. "<br>";
							    	 echo "<b>Plan:</b>&nbsp;".$row['plan']. "<br>"; 
							    	 echo "</div>";
							         //echo "<br class='clr'>";
							         echo "<div class='well well-sm'>";
							    	 echo "<b>Electronically Signed By:&nbsp;</b>";
									 echo $row['provider_print_name']. "&nbsp;";
							         echo $row['provider_credentials'];
							         echo "<span><br><b>Signature Date:&nbsp;</b>". $row['provider_signature_date']. "</span>";
							         echo "</div>";
					    		break;
					    				}

									
									
									
			    			 echo "<div class='well well-sm'>";
					    	 echo "<b>Misc1:</b>&nbsp;".$row['genericname1']. "<br>";
					    	 echo "<b>Misc2:</b>&nbsp;".$row['genericval1']. "<br>"; 
					    	 echo "<b>Misc3:</b>&nbsp;".$row['genericname2']. "<br>";
					    	 echo "<b>Misc4:</b>&nbsp;".$row['genericval2']. "<br>"; 
					    	 echo "<b>Billing Note:</b>&nbsp;".$row['billing_note']. "<br>";
					    	 //echo "<br class='clr'>";
					    	 echo "</div>";
					         

			
			
			?>
<div class="table-responsive">
<table class="selection table" id="selection">
		<tr>
				<th>Select </th>
			    <th>PID</th>
			    <!--<th>PID</th>-->
			    <th>Encounter#</th>
			    <th>form id</th>
			    <th>Change Status to:</th>
				<th>Comments</th>
			    <!--
			    <th>Provider ID</th>
			    <th>Diag 1</th>
			    <th>Diag 2</th>
			    <th>Diag 3</th>
			    <th>Diag 4</th>
			    <th>Diag Desc 1</th>
			    <th>Diag Desc 2</th>
			    <th>Diag Desc 3</th>
			    <th>Diag Desc 4</th>
			    <th>Diag Type 1</th>
			    <th>Diag Type 2</th>
			    <th>Diag Type 3</th>
			    <th>Diag Type 4</th>

				-->
			    <!--<th>Justify 5</th>-->
			    <!--
			    <th>Justify</th>
			    <th>Code Type</th>
			    <th>Service Code</th>
			    <th>Modifier</th>
			    <th>Units</th>
			    <th>Fee</th>
			    <th>Service Description</th>
			    -->
		 </tr>
		 <td><input type="checkbox" class="boxes" id ="boxes" name="boxes" style="width: 21px"></td>

	<div>
		<!--<td><input type="checkbox" name="boxes[]" style="width: 21px"></td>-->
		<!--<td><input type="checkbox" name="pid[]" value="<?php echo $pid; ?>" style="width: 84px" readonly></td>-->
		<td><input class="form-control input-sm" type="text" name="pid[]" value="<?php echo $pid; ?>" style="width: 50px" readonly></td>
		<!--<td><?php echo $pid; ?>&nbsp;</td>-->
		<!--<td><?php echo $en_encounter; ?>&nbsp;</td>-->
		<td><input class="form-control input-sm" type="text" name="en_encounter[]" value="<?php echo $en_encounter; ?>" style="width: 85px" readonly></td>
		<td><input class="form-control input-sm" type="text" name="form_id[]" value="<?php echo $form_id; ?>" style="width: 78px" readonly></td>
		<td>
		<select class="form-control input-sm" id="status" name="status[]" style="width: 199px" required>
			<option selected=""><?php echo stripslashes($row{"status"});?></option>
			<option value="Ready for Billing">Ready for Billing</option>
			<option value="Ready for Billing/Supervisor">Ready for Billing/Supervisor</option>
			<option value="Error Report/Correction(s) Needed">Error Report/Correction(s) Needed</option>
			<option value="Void/Delete Request">Void/Delete Request</option>
		</select>
		</td>
		<td>
		Log:
		<textarea class="form-control input-sm" wrap=virtual name="comments_log_view[]" id="comments_log_view" style="height: 132px; width: 548px;" readonly><?php echo $row['comments_log'];?></textarea>
		New Entry:
		<textarea class="form-control input-sm" wrap=virtual name="comments_log[]" id="comments_log"style="height: 132px; width: 548px;"  ></textarea>
		</td>
		

		<!--
		<td><input class="form-control input-sm" type="text" name="comments_log[]" value="<?php echo $comments_log; ?>" style="width: 417px"></td>
		
		
		<td><input class="form-control input-sm" type="text" name="provider_id[]" value="<?php echo $provider_id; ?>" style="width: 40px"></td>
		<td><input class="form-control input-sm" type="text" name="justify1[]" value="<?php echo $diag_code1; ?>" style="width: 52px" required ></td>
		<td><input class="form-control input-sm" type="text" name="justify2[]" value="<?php echo $diag_code2; ?>" style="width: 48px"></td>
		<td><input class="form-control input-sm" type="text" name="justify3[]" value="<?php echo $diag_code3; ?>" style="width: 52px"></td>
		<td><input class="form-control input-sm" type="text" name="justify4[]" value="<?php echo $diag_code4; ?>" style="width: 52px"></td>
		<td><input class="form-control input-sm" type="text" name="diag1[]" value="<?php echo $diag1; ?>" style="width: 84px" required ></td>
		<td><input class="form-control input-sm" type="text" name="diag2[]" value="<?php echo $diag2; ?>" style="width: 84px"></td>
		<td><input class="form-control input-sm" type="text" name="diag3[]" value="<?php echo $diag3; ?>" style="width: 84px"></td>
		<td><input class="form-control input-sm" type="text" name="diag4[]" value="<?php echo $diag4; ?>" style="width: 84px"></td>
		<td><input class="form-control input-sm" type="text" name="code_type1[]" value="<?php echo $code_type1; ?>" style="width: 60px" ></td>
		<td><input class="form-control input-sm" type="text" name="code_type2[]" value="<?php echo $code_type2; ?>" style="width: 63px" ></td>
		<td><input class="form-control input-sm" type="text" name="code_type3[]" value="<?php echo $code_type3; ?>" style="width: 60px" ></td>
		<td><input class="form-control input-sm" type="text" name="code_type4[]" value="<?php echo $code_type4; ?>" style="width: 60px" ></td>
		-->
		<!--<td><input type="text" name="justify5[]" value="<?php echo $justify5; ?>"></td>-->
		<!--
		<td><input class="form-control input-sm" type="text" name="justify[]" value="<?php echo $justify; ?>" required ></td>
		<td><input class="form-control input-sm" type="text" name="code_type[]" value="<?php echo $code_type; ?>" style="width: 79px"></td>
		<td><input class="form-control input-sm" type="text" name="servicecode[]" value="<?php echo substr($servicecode,0,5); ?>" style="width: 79px" required ></td>
		<td><input class="form-control input-sm" type="text" name="modifier[]" value="<?php echo substr($servicecode,5,2); ?>" style="width: 53px"></td>
		<td><input class="form-control input-sm" type="text" name="units[]" value="<?php echo $units; ?>" style="width: 25px" required ></td>
		<td><input class="form-control input-sm" type="text" name="fee[]" value="<?php echo $fee;?>" style="width: 79px" required ></td>
		<td><input class="form-control input-sm" type="text" name="code_text[]" value="<?php echo $code_text; ?>" style="width: 217px"></td>
		-->
	</div>
</table>
</div>
</div>
<?php

}

?>
<script language="JavaScript">
$("#checkAll").click(function () {
     $('input:checkbox').not(this).prop('checked', this.checked);
     var $inpts = $(this).closest('tr').find('input:text').prop('disabled', !this.checked);
     var $tarea = $(this).closest('tr').find('#comments_log').prop('disabled', !this.checked);
     var $tareav = $(this).closest('tr').find('#comments_log_view').prop('disabled', !this.checked);
     var $slect = $(this).closest('tr').find('#status').prop('disabled', !this.checked);

	$('.selection').on('change', ':checkbox', function () {
       var $inpts = $(this).closest('tr').find('input:text').prop('disabled', !this.checked);
       var $tarea = $(this).closest('tr').find('#comments_log').prop('disabled', !this.checked);
       var $tareav = $(this).closest('tr').find('#comments_log_view').prop('disabled', !this.checked);
       var $slect = $(this).closest('tr').find('#status').prop('disabled', !this.checked);

     }).find(':checkbox').change();
 });
 
   $('.selection').on('change', ':checkbox', function () {
       var $inpts = $(this).closest('tr').find('input:text').prop('disabled', !this.checked);
       var $tarea = $(this).closest('tr').find('#comments_log').prop('disabled', !this.checked);
   	   var $tareav = $(this).closest('tr').find('#comments_log_view').prop('disabled', !this.checked);
   	   var $slect = $(this).closest('tr').find('#status').prop('disabled', !this.checked);

   }).find(':checkbox').change();

</script>
<br>
---------------------------------------------------------------------
<br>
<input type="hidden" name="form_selected" value="<?php echo $form_selected; ?>" />
<input type="submit" class="btn btn-primary" type="submit" />
</form>


