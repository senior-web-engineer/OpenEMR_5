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
$start_date = "2018-08-01";
$end_date = "2018-09-15";

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
	$sql = "SELECT ". 
	"fm.form_id, fm.form_name, fm.encounter AS fmencounter".
	", en.date, en.encounter AS enencounter, en.facility, en.last_level_billed".
	", pl.pid, pl.provider AS plprovider, pl.type, pl.plan_name AS plplan_name, pl.policy_number AS plpolicy_number, pl.date AS pldate".
	", po.id, po.name AS poname, po.billing_code_type AS pobilling_code_type".
	", pd.fname, pd.lname, pd.mname, pd.dob, pd.ss, pd.billing_note, pd.genericname1, pd.genericval1, pd.genericname2, pd.genericval2 ".
	"FROM forms AS fm ".
//	"JOIN forms AS fm ON fm.form_id = fr.id ".
//	"AND form_name = '$form_name' ".
//	$form_billing_status_select.
	//"AND billing_status NOT LIKE 'billed' ".
//	$provider_select.
	"JOIN form_encounter AS en ON en.encounter = fm.encounter ".
		"AND fm.pid = en.pid " .
	"JOIN patient_data AS pd ON pd.pid = fm.pid ".
//	"JOIN insurance_data AS pl ON pl.pid = fr.pid ".
	"LEFT JOIN insurance_data AS pl ON (pl.id =( ".
												"SELECT id ".
												"FROM insurance_data AS pl ".
												"WHERE pid = pd.pid AND type = 'primary' ".
												"ORDER BY date DESC ".
												"LIMIT 1".
												")".
											") ".
	"JOIN insurance_companies AS po ON po.id = pl.provider ".

	"AND en.date >= pl.date ".
	$billing_code_type_select.
	"WHERE en.date between '$start_date' AND '$end_date' ".
	"AND pl.type = 'primary' ".
	$encounter_already_billed_select.
	$form_status_select.
	$date_created_select.
	$patient_select.
	"GROUP BY fm.id LIMIT 10"
	;
//echo "VVVVVVVVVVVVVVV <br> ". $sql. "VVVVVVVVVVVVVVV <br> ";



				$i=0;
$result = $mysqli -> query ($sql);
while ($row = mysqli_fetch_array($result)) 
{
$en_encounter = $row['enencounter'];
$pid = $row['pid'];
				
				
	//Other Forms*********************************************************************************************************
$sql_check_forms = "SELECT * FROM forms WHERE encounter = $en_encounter AND deleted = '0' AND form_name != 'New Patient Encounter'";
$result_check_forms =  $mysqli -> query ($sql_check_forms);
while ($row_check_forms = mysqli_fetch_array($result_check_forms)) 
{
echo "<div class='alert alert-warning'>";
echo "<b> ". $row_check_forms["form_name"]. " ". $row_check_forms["user"]. "</b>";
//echo " ". $row_check_forms["form_name"]. " ". $row_check_forms["user"]. " ";

echo "</div>";
}
?>
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
				
				
				
//$sqlSelect = "SELECT form_name, form_id, user, formdir FROM forms where deleted = '0' and pid = $pid and encounter = $encounter and formdir != 'newpatient'";
$sqlSelect = "SELECT form_name, form_id, user, formdir FROM forms ". 
				"where deleted = '0' ".
				"and pid = $pid ".
				"and encounter = $en_encounter ". 
				"and formdir != 'newpatient' and formdir != 'scanned_notes' and formdir != 'misc_billing_options' " .
				"and formdir != 'prior_auth' ".
				"and formdir != 'LBFMYForm' ".
				"and formdir != 'drug_alcohol_screening' ".
				"and formdir != 'hiv_aids_screening' ".
				"and formdir != 'consent_for_treatment' ".
				"and formdir != 'mental_health_screening' ".
				"and formdir != 'statement_of_rights_notice_of_privacy' ".
				"and formdir != 'psych_eval_simple' ".
				"and formdir != 'psych_eval_upload' ".
				"and formdir != 'individualized_treatment_plan_upload' ".
				"and formdir != 'assessment_intake' ".
				"and formdir != 'suicide_risk_assessment' ".
				"and formdir != 'individual_treatment_plan' ".
				"and formdir != 'soap' ".
				"and formdir != 'care_plan' ".
				"and formdir != 'service_authorizations' ".
				"and formdir != 'service_authorization' ".
				"and formdir != 'authorization' ".
				"and formdir != 'med_management_upload' ".
				"and formdir != 'ankleinjury' "
				;
//echo $sqlSelect;
		// Execute it, or return the error message if there's a problem.
		$result1 = $mysqli -> query ($sqlSelect);
		while ($row1 = mysqli_fetch_array($result1)) {
		    $rows1[] = $row1;
		}
				
		foreach ($rows1 as $row1)  {
			 $form_name = $row1['form_name']; 
			 $form_id = $row1['form_id'];
			 $user = $row1['user'];
			 $formdir = $row1['formdir'];
			 $form_table = 'form_'.$row1['formdir'];
			 echo $row1['form_name'] ." " . $row1['form_id']." ".$row1['user']." ".$row1['formdir']. " ".$form_table."<br>";
			 
			 
		//$sqlSelect2 = "SELECT servicecode, units, status FROM $form_table where id = $form_id ";
		//$result2 = $mysqli -> query ($sqlSelect2);
		//while ($row2 = mysqli_fetch_array($result2)) {
		//    $rows2[] = $row2;
		//}
				
		//foreach ($rows2 as $row2)  {

		//echo $row2['servicecode'] ." " . $row2['units']." ".$row2['status']. "<br><br>";
		
		//}
		$servicecode_cl = 'servicecode';
		$units_cl = 'units';
		$extra_fields = '';
		switch ($form_table){
			case 'form_fars':
				$form_table = 'form_cfars';
			break;
			case 'form_treatment_plan';
				$servicecode_cl = 'service_code';
				$units_cl = 'unit';
			break;
			case "form_psychosocial":
	         	$extra_fields = ", problem1 AS diagnosis1, problem2 AS diagnosis2, problem3 AS diagnosis3, problem4 AS diagnosis4, timestart, timeend";
	         break;
		    case "form_soap_pirc":
		        $extra_fields = ", problem1, problem2, problem3, problem4, timestart, timeend";
		    break;
			case 'form_progress_note';
				$servicecode_cl = 'service_code';
				$units_cl = 'units';
			break;
			case 'form_assessment_cmh';
				$servicecode_cl = 'servicecode';
			break;
			

			
			case 'form_psycho_education';
				$extra_fields = ", problem1, problem2, problem3, problem4, timestart, timeend";
				$form_table = 'form_psychosocial';
			break;
			case 'form_vitals';
				$servicecode_cl = 'service_code';
				//$units_cl = 'units';
			break;

			
			


						}
		

		$tobill = sqlQuery("SELECT user, $servicecode_cl, $units_cl $extra_fields, status FROM $form_table where id = $form_id ");
		echo $tobill[$servicecode_cl] ." " . $tobill[$units_cl]." ".$tobill['status']. "<br><br>";
		$servicecode = $tobill[$servicecode_cl];
		$units = $tobill[$units_cl];
		$provider_id = $tobill['user'];
		//$en_encounter = $encounter;
		
		$justify1 = substr($tobill["problem1"], 0, strpos($tobill["problem1"], ' '));
		$justify2 = substr($tobill["problem2"], 0, strpos($tobill["problem2"], ' '));
		$justify3 = substr($tobill["problem3"], 0, strpos($tobill["problem3"], ' '));
		$justify4 = substr($tobill["problem4"], 0, strpos($tobill["problem4"], ' '));
		$justify5 = str_replace(':', '|', $justify1).":".str_replace(':', '|', $justify2).":".str_replace(':', '|', $justify3).":".str_replace(':', '|', $justify4).":";
		$diag1 = substr($tobill["problem1"], strpos($tobill["problem1"], ' ') +1);
		$diag2 = substr($tobill["problem2"], strpos($tobill["problem2"], ' ') +1);
		$diag3 = substr($tobill["problem3"], strpos($tobill["problem3"], ' ') +1);
		$diag4 = substr($tobill["problem4"], strpos($tobill["problem4"], ' ') +1);
		$diag_code1 = substr($justify1, strpos($justify1, ':') +1);
		$diag_code2 = substr($justify2, strpos($justify2, ':') +1);
		$diag_code3 = substr($justify3, strpos($justify3, ':') +1);
		$diag_code4 = substr($justify4, strpos($justify4, ':') +1);
		$code_type1 = substr($tobill["problem1"], 0, strpos($tobill["problem1"], ':'));
		$code_type2 = substr($tobill["problem2"], 0, strpos($tobill["problem2"], ':'));
		$code_type3 = substr($tobill["problem3"], 0, strpos($tobill["problem3"], ':'));
		$code_type4 = substr($tobill["problem4"], 0, strpos($tobill["problem4"], ':'));
//$justify1 = substr($row1["diagnosis1"], 0, strpos($row1["diagnosis1"], ' '));
//$justify2 = substr($row1["diagnosis2"], 0, strpos($row1["diagnosis2"], ' '));
//$justify3 = substr($row1["diagnosis3"], 0, strpos($row1["diagnosis3"], ' '));
//$justify4 = substr($row1["diagnosis4"], 0, strpos($row1["diagnosis4"], ' '));
//$justify5 = str_replace(':', '|', $justify1).":".str_replace(':', '|', $justify2).":".str_replace(':', '|', $justify3).":".str_replace(':', '|', $justify4).":";
//$diag1 = substr($row1["diagnosis1"], strpos($row1["diagnosis1"], ' ') +1);
//$diag2 = substr($row1["diagnosis2"], strpos($row1["diagnosis2"], ' ') +1);
//$diag3 = substr($row1["diagnosis3"], strpos($row1["diagnosis3"], ' ') +1);
//$diag4 = substr($row1["diagnosis4"], strpos($row1["diagnosis4"], ' ') +1);
//$diag_code1 = substr($justify1, strpos($justify1, ':') +1);
//$diag_code2 = substr($justify2, strpos($justify2, ':') +1);
//$diag_code3 = substr($justify3, strpos($justify3, ':') +1);
//$diag_code4 = substr($justify4, strpos($justify4, ':') +1);
//$code_type1 = substr($row1["diagnosis1"], 0, strpos($row1["diagnosis1"], ':'));
//$code_type2 = substr($row1["diagnosis2"], 0, strpos($row1["diagnosis2"], ':'));
//$code_type3 = substr($row1["diagnosis3"], 0, strpos($row1["diagnosis3"], ':'));
//$code_type4 = substr($row1["diagnosis4"], 0, strpos($row1["diagnosis4"], ':'));

		
		$patterns = array();
		$patterns[0] = '/::::/';
		$patterns[1] = '/:::/';
		$patterns[2] = '/::/';
		$replacements = ':';
		$justify = preg_replace($patterns, $replacements, $justify5);
				
		switch ($servicecode) {
    case "H2019HO":
        $fee= 32*$units;
        $code_text = "TBOSS";
        $code_type = "HCPCS";
        break;
    case "H2019HQ":
        $fee= 13.34*$units;
        $code_text = "GROUP THERAPY";
        $code_type = "HCPCS";
        break;
    case "H2019HR":
        $fee= 36.66*$units;
        $code_text = "INDIVIDUAL THERAPY";
        $code_type = "HCPCS";
        break;
    case "H2017":
        $fee= 18*$units;
        $code_text = "PSYCHO SOCIAL REHABILITATION";
        $code_type = "HCPCS";
        break;
    case "H0032TS":
        $fee= 97*$units;
        $code_text = "TREATMENT PLAN REVIEW";
        $code_type = "HCPCS";
        break;
	case "H0032":
        $fee= 194*$units;
        $code_text = "TREATMENT PLAN";
        $code_type = "HCPCS";
        break;
	case "H0031":
        $fee= 30*$units;
        $code_text = "FARS CFARS LIMITED FUNCTIONAL ASSMNT";
        $code_type = "HCPCS";
        break;
	case "H0031HN":
	    $fee= 96*$units;
	    $code_text = "BIO-PSYCHOSOCIAL";
	    $code_type = "HCPCS";
	    break;
	case "H0031HO":
	    $fee= 250*$units;
	    $code_text = "IN-DEPTH ASSESSMENT-NEW PATIENT";
	    $code_type = "HCPCS";
	    break;
	case "H0031TS":
	    $fee= 200*$units;
	    $code_text = "IN-DEPTH ASSESSMENT-ESTABLISED PAT";
	    $code_type = "HCPCS";
	    break;
	case "H2000HP":
	    $fee= 420*$units;
	    $code_text = "PSYCHIATRIC EVALUATION-MD";
	    $code_type = "HCPCS";
	    break;
	 case "H2000HO":
	    $fee= 400*$units;
	    $code_text = "PSYCHIATRIC EVALUATION-NON-MD";
	    $code_type = "HCPCS";
	    break;
	case "H2000":
	    $fee= 52*$units;
	    $code_text = "PSYCHIATRIC REVIEW OF RECORDS";
	    $code_type = "HCPCS";
	    break;
	case "T1015":
	    $fee= 60*$units;
	    $code_text = "MED MANAGEMENT";
	    $code_type = "HCPCS";
	    break;

   
}

		
		
?>
<?php
$displythis = 'n';
if($displythis =='y'){
?>

		<div class="table-responsive">
<table class="selection table" id="selection" style="width: 832px">
		<tr>
				
			     <!--<th class="auto-style1">PID</th>
			   <th>PID</th>
			    <th class="auto-style1">Encounter#</th>
			    <th class="auto-style1">form id</th>-->
			    <th class="auto-style1">Provider ID</th>
			    <th class="auto-style1">Diag 1</th>
			    <th class="auto-style1">Diag 2</th>
			    <th class="auto-style1" style="width: 101px">Diag Desc 1</th>
			    <th class="auto-style1" style="width: 107px">Diag Desc 2</th>
			    <!--<th>Justify 5</th>-->
			    <th class="auto-style1"><strong>Justify</strong></th>
			    <th class="auto-style1"><strong>Code Type</strong></th>
			    <th class="auto-style1"><strong>Service Code</strong></th>
			    <th class="auto-style1"><strong>Modifier</strong></th>
			    <th class="auto-style1"><strong>Units</strong></th>
			    <th class="auto-style1" style="width: 66px"><strong>Fee</strong></th>
			    <th class="auto-style1"><strong>Service Description</strong></th>
		 </tr>
		 
	<div>
		<!--<td><input type="checkbox" name="boxes[]" style="width: 21px"></td>-->
		<!--<td><input type="checkbox" name="pid[]" value="<?php echo $pid; ?>" style="width: 84px" readonly></td>-->
		<!--<td class="auto-style2"><?php echo $pid; ?></td>
		<!--<td><?php echo $pid; ?>&nbsp;</td>-->
		<!--<td><?php echo $en_encounter; ?>&nbsp;</td>-->
		<!--<td class="auto-style2"><?php echo $en_encounter; ?></td>
		<td class="auto-style2"><?php echo $form_id; ?></td>-->
		<td class="auto-style2"><?php echo $provider_id; ?></td>
		<td class="auto-style2"><?php echo $diag_code1; ?></td>
		<td class="auto-style2"><?php echo $diag_code2; ?></td>
		
		<td class="auto-style2" style="width: 101px"><?php echo $diag1; ?></td>
		<td class="auto-style2" style="width: 107px"><?php echo $diag2; ?></td>
		
		
		
		<!--<td><input type="text" name="justify5[]" value="<?php echo $justify5; ?>"></td>-->
		<td class="auto-style2"><?php echo $justify; ?></td>
		<td class="auto-style2"><?php echo $code_type; ?></td>
		<td class="auto-style2"><?php echo substr($servicecode,0,5); ?></td>
		<td class="auto-style2"><?php echo substr($servicecode,5,2); ?></td>
		<td class="auto-style2"><?php echo $units; ?></td>
		<td class="auto-style2"><?php echo $fee;?></td>
		<td class="auto-style2"><?php echo $code_text; ?></td>
	</div>
</table>
</div>
<?php
}
?>
<div class="table-responsive">
<table class="selection table" id="selection">
		<tr>
				<th>Select </th>
			    <th>PID</th>
			    <!--<th>PID</th>-->
			    <th>Encounter#</th>
			    <th>form id</th>
			   <!-- <th>form selected</th>-->
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


			    <!--<th>Justify 5</th>-->
			    <th>Justify</th>
			    <th>Code Type</th>
			    <th>Service Code</th>
			    <th>Modifier</th>
			    <th>Units</th>
			    <th>Fee</th>
			    <th>Service Description</th>
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
		<input class="form-control input-sm" type="hidden" name="form_selected[]" value="<?php echo $form_selected; ?>" style="width: 78px" readonly>
		<td><input class="form-control input-sm" type="text" name="provider_id[]" value="<?php echo $provider_id; ?>" style="width: 40px"></td>
		<td><input class="form-control input-sm" type="text" name="justify1[]" value="<?php echo $diag_code1; ?>" style="width: 52px" required ></td>
		<td><input class="form-control input-sm" type="text" name="justify2[]" value="<?php echo $diag_code2; ?>" style="width: 48px"></td>
		<td><input class="form-control input-sm" type="text" name="justify3[]" value="<?php echo $diag_code3; ?>" style="width: 52px"></td>
		<td><input class="form-control input-sm" type="text" name="justify4[]" value="<?php echo $diag_code4; ?>" style="width: 52px"></td>
		<td><input class="form-control input-sm" type="text" id="diag1" name="diag1[]" value="<?php echo $diag1; ?>" style="width: 84px" required ></td>
		<td><input class="form-control input-sm" type="text" name="diag2[]" value="<?php echo $diag2; ?>" style="width: 84px"></td>
		<td><input class="form-control input-sm" type="text" name="diag3[]" value="<?php echo $diag3; ?>" style="width: 84px"></td>
		<td><input class="form-control input-sm" type="text" name="diag4[]" value="<?php echo $diag4; ?>" style="width: 84px"></td>
		<td><input class="form-control input-sm" type="text" id="code_type1" name="code_type1[]" value="<?php echo $code_type1; ?>" style="width: 60px" ></td>
		<td><input class="form-control input-sm" type="text" name="code_type2[]" value="<?php echo $code_type2; ?>" style="width: 63px" ></td>
		<td><input class="form-control input-sm" type="text" name="code_type3[]" value="<?php echo $code_type3; ?>" style="width: 60px" ></td>
		<td><input class="form-control input-sm" type="text" name="code_type4[]" value="<?php echo $code_type4; ?>" style="width: 60px" ></td>
		<!--<td><input type="text" name="justify5[]" value="<?php echo $justify5; ?>"></td>-->
		<td><input class="form-control input-sm" type="text" name="justify[]" value="<?php echo $justify; ?>" required ></td>
		<td><input class="form-control input-sm" type="text" name="code_type[]" value="<?php echo $code_type; ?>" style="width: 79px"></td>
		<td><input class="form-control input-sm" type="text" name="servicecode[]" value="<?php echo substr($servicecode,0,5); ?>" style="width: 79px" required ></td>
		<td><input class="form-control input-sm" type="text" name="modifier[]" value="<?php echo substr($servicecode,5,2); ?>" style="width: 53px"></td>
		<td><input class="form-control input-sm" type="text" name="units[]" value="<?php echo $units; ?>" style="width: 25px" required ></td>
		<td><input class="form-control input-sm" type="text" name="fee[]" value="<?php echo $fee;?>" style="width: 79px" required ></td>
		<td><input class="form-control input-sm" type="text" name="code_text[]" value="<?php echo $code_text; ?>" style="width: 217px"></td>



		</div>
	</table>
</div>







		
<?php
		}
		}
			
?>




