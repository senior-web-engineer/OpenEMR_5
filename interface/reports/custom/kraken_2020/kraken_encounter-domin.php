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
		$insurance_companies = "$_REQUEST[insurance_companies]";
		$with_authorization	= "$_REQUEST[with_authorization]";
			
		echo "kkkkk".  $insurance_companies;
		echo $user_name;
		switch ($form_selected) {
		    case "form_psychosocial":
		         $form_name = "Psychosocial Rehabilitation";
		         $extra_fields = ", fr.servicecode, fr.units, fr.diagnosis1, fr.diagnosis2, fr.diagnosis3, fr.diagnosis4, fr.clinical_intervention, fr.response_to_intervention, fr.credentials, fr.sig_date, fr.provider_id, fr.provider_print_name, fr.timestart, fr.timeend, fr.created";
		    break;
		    case "form_soap_pirc":
		         $form_name = "SOAP Notes";
		         $extra_fields = ", fr.servicecode, fr.units, fr.diagnosis1, fr.diagnosis2, fr.diagnosis3, fr.diagnosis4, fr.objective, fr.subjective, fr.assessment, fr.plan, fr.created, provider_credentials, provider_signature_date, fr.provider_print_name, fr.timestart, fr.timeend";
		    break;
		    case "form_med_management":
		         $form_name = "Medication Management";
		         $extra_fields = ", fr.servicecode, fr.units, fr.complaint, fr.created";
		    break;
		     case "form_assessment_cmh":
		         $form_name = "In-Depth Assessment";
		         $extra_fields = ", fr.servicecode, fr.units, provider_credentials, provider_signature_date, fr.provider_print_name, fr.created";
		    break;
		    case "form_treatment_plan":
		    $form_selected = "form_treatment_plan";
		         $form_name = "Treatment Plan";
		         $extra_fields = ", fr.service_code, fr.unit, provider_credentials, provider_signature_date, fr.provider_print_name, fr.date_created ";
		    break;
		    case "form_treatment_plan_review":
		    $form_selected = "form_treatment_plan";
		         $form_name = "Treatment Plan Review";
		         $extra_fields = ", fr.service_code, fr.unit, provider_credentials, provider_signature_date, fr.provider_print_name, fr.date_created";
		    break;
			case "form_psychiatric_evaluation":
		    $form_selected = "form_psychiatric_evaluation";
		         $form_name = "Psychiatric Evaluation";
		         $extra_fields = ", fr.servicecode, fr.units, physician_credentials AS provider_credentials, physician_signature_date AS provider_signature_date, physician_print_name AS provider_print_name, fr.created";
		    break;
		
		
		    case "form_fars":
		    $form_selected = "form_cfars";
		         $form_name = "FARS";
		         $extra_fields = ", fr.servicecode, fr.units, fr.provider_print_name, fr.created";
		    break;
		    case "form_cfars":
		    $form_selected = "form_cfars";
		         $form_name = "CFARS";
		         $extra_fields = ", fr.servicecode, fr.units, fr.provider_print_name, fr.created";
		    break;
		    case "form_progress_note_ind":
		    $form_selected = "form_progress_note";
		         $form_name = "Progress Note - IND";
		         $extra_fields = ", fr.service_code, fr.units, fr.diagnosis1, fr.diagnosis2, fr.diagnosis3, fr.diagnosis4, fr.created, provider_credentials, provider_signature_date, fr.provider_print_name, fr.time_start, fr.time_end, fr.subjective, fr.objective, fr.assessment, fr.plan";
		    break;
			case "form_progress_note_psr":
			$form_selected = "form_progress_note";
		         $form_name = "Progress Note - PSR";
		         $extra_fields = ", fr.service_code, fr.units, fr.diagnosis1, fr.diagnosis2, fr.diagnosis3, fr.diagnosis4, fr.created, provider_credentials, provider_signature_date, fr.provider_print_name, fr.time_start, fr.time_end,fr.deficit_problems_behavior_addressed, fr.interventions, fr.response_to_intervention";
		    break;
			case "form_progress_note_day":
			$form_selected = "form_progress_note";
		         $form_name = "Progress Note - DAY";
		         $extra_fields = ", fr.service_code, fr.units, fr.diagnosis1, fr.diagnosis2, fr.diagnosis3, fr.diagnosis4, fr.created, provider_credentials, provider_signature_date, fr.provider_print_name, fr.time_start, fr.time_end, fr.deficit_problems_behavior_addressed, fr.interventions, fr.response_to_intervention";
		    break;
			case "form_progress_note_tbo":
			$form_selected = "form_progress_note";
		         $form_name = "Progress Note - TBO";
		         $extra_fields = ", fr.service_code, fr.units, fr.diagnosis1, fr.diagnosis2, fr.diagnosis3, fr.diagnosis4, fr.created, provider_credentials, provider_signature_date, fr.provider_print_name, fr.time_start, fr.time_end, fr.subjective, fr.objective, fr.assessment, fr.plan";
		    break;
			case "form_progress_note_ori":
			$form_selected = "form_progress_note";
		         $form_name = "Progress Note - ORI";
		         $extra_fields = ", fr.service_code, fr.units, fr.diagnosis1, fr.diagnosis2, fr.diagnosis3, fr.diagnosis4, fr.created, provider_credentials, provider_signature_date, fr.provider_print_name, fr.time_start, fr.time_end, fr.deficit_problems_behavior_addressed, fr.interventions, fr.response_to_intervention";
		    break;
			case "form_progress_note_grp":
			$form_selected = "form_progress_note";
		         $form_name = "Progress Note - GRP";
		         $extra_fields = ", fr.service_code, fr.units, fr.diagnosis1, fr.diagnosis2, fr.diagnosis3, fr.diagnosis4, fr.created, provider_credentials, provider_signature_date, fr.provider_print_name, fr.time_start, fr.time_end";
		    break;
			case "form_encounter":
			$form_selected = "form_encounter";
		         $form_name = "Progress Note - GRP";
		         $extra_fields = ", fr.service_code, fr.units, fr.diagnosis1, fr.diagnosis2, fr.diagnosis3, fr.diagnosis4, fr.created, provider_credentials, provider_signature_date, fr.provider_print_name, fr.time_start, fr.time_end";
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
if ($insurance_companies ==""){
		  $insurance_select= "";
}else{
	$insurance_select= "AND pl.provider = '$insurance_companies' ";		
}
if ($with_authorization ==""){
		  $authorization_select= "";
}else{
		$authorization_select= "AND sa.authorization_number <> '' ";		
}


$mysqli = new mysqli($host, $login, $pass, $dbase);
//echo "test";
//echo $mysqli;
//$connection = mysql_connect($host, $login, $pass); 
//$db = @mysql_select_db($dbase, $connection);

$sql1 = " CALL sp_exec_billing('$start_date', '$end_date'); ";
$sql2 =	" SELECT ".
		"en.date AS endate, en.encounter, en.reason, en.pid, en.provider_id, en.facility, en.billing_note, en.last_level_billed, ".
		"fm.form_id, fm.form_name, fm.formdir, fm.encounter AS fmencounter,".
		"fr.frid, fr.pid, fr.service_code, fr.units,fr.diagnosis1,fr.diagnosis2,fr.diagnosis3, fr.diagnosis4, fr.created ".
		", fr.status".
		", pl.pid, pl.provider AS plprovider, pl.type, pl.plan_name AS plplan_name, pl.policy_number AS plpolicy_number, pl.date AS pldate".
		", po.id, po.name AS poname, po.billing_code_type AS pobilling_code_type".
		", pd.fname, pd.lname, pd.mname, pd.dob, pd.ss, pd.billing_note, pd.genericname1, pd.genericval1, pd.genericname2, pd.genericval2".
		", sa.authorization_number, sa.service_code AS saservice_code, sa.service_name ".
	"FROM $form_selected AS en ".
	"JOIN forms AS fm ON fm.encounter = en.encounter ".
	"JOIN temp_forms AS fr ON fr.frid = fm.form_id ".
	$form_billing_status_select.
	$provider_select.
	"JOIN patient_data AS pd ON pd.pid = fr.pid ".
	"LEFT JOIN form_service_authorization AS sa ON (sa.id =( ".
												"SELECT id ".
												"FROM form_service_authorization AS sa ".
												"WHERE pid = pd.pid AND type = 'patient' ".
												"AND start_date >= '$start_date' ".
												"AND end_date <= '$end_date' ".
												"ORDER BY date DESC ".
												"LIMIT 1".
												")".
											") ".
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
	$insurance_select.
	$authorization_select. 
	$billing_code_type_select.
	"WHERE en.date between '$start_date' AND '$end_date' ".
	"AND pl.type = 'primary' ".
	$encounter_already_billed_select.
	$form_status_select.
	$patient_select.
	"GROUP BY fr.frid LIMIT 10; ";
$sql3 = "drop temporary table if exists temp_forms ";

$sqlTemp = "SELECT ".
	"en.date AS endate, en.encounter, en.reason, en.pid, en.provider_id, en.facility, en.billing_note, en.last_level_billed, ".
	"fm.form_id, fm.form_name, fm.formdir, fm.encounter AS fmencounter,".
	"fr.id AS frid, fr.pid, fr.user, fr.billing_id, fr.billing_status".
	$extra_fields.
	", fr.status, fr.encounter".
//	", pl.pid, MAX(pl.provider) AS plprovider, pl.type, pl.plan_name AS plplan_name, pl.policy_number AS plpolicy_number, MAX(pl.date) AS pldate".
	", pl.pid, pl.provider AS plprovider, pl.type, pl.plan_name AS plplan_name, pl.policy_number AS plpolicy_number, pl.date AS pldate".
	", po.id, po.name AS poname, po.billing_code_type AS pobilling_code_type".
//	", fm.form_id, fm.form_name, fm.encounter AS fmencounter".
//	", en.date, en.encounter AS enencounter, en.facility, en.last_level_billed".
	", pd.fname, pd.lname, pd.mname, pd.dob, pd.ss, pd.billing_note, pd.genericname1, pd.genericval1, pd.genericname2, pd.genericval2".
	", sa.authorization_number, sa.service_code AS saservice_code, sa.service_name ".
//	"FROM $form_selected AS fr ".
	"FROM $form_selected AS en ".
//	"JOIN forms AS fm ON fm.form_id = fr.id ".
	"JOIN forms AS fm ON fm.encounter = en.encounter ".
	"JOIN form_progress_note AS fr ON fr.id = fm.form_id ".
//	"AND form_name = '$form_name' ".
	$form_billing_status_select.
	//"AND billing_status NOT LIKE 'billed' ".
	$provider_select.
//	"JOIN form_encounter AS en ON en.encounter = fm.encounter ". 
	"JOIN patient_data AS pd ON pd.pid = fr.pid ".
//	"JOIN insurance_data AS pl ON pl.pid = fr.pid ".
	"LEFT JOIN form_service_authorization AS sa ON (sa.id =( ".
												"SELECT id ".
												"FROM form_service_authorization AS sa ".
												"WHERE pid = pd.pid AND type = 'patient' ".
												"AND start_date >= '$start_date' ".
												"AND end_date <= '$end_date' ".
												"ORDER BY date DESC ".
												"LIMIT 1".
												")".
											") ".

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
	$insurance_select.
	$authorization_select. 
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
	"GROUP BY fr.id LIMIT 10"
	;

//echo "<br>Connection:". $connection;
echo $sql;	

sqlStatement($sql1);
$generator = sqlStatement($sql2);
sqlStatement($sql3);

$i = 0;
$array = array();
while($row = sqlFetchArray($generator) ) {
	array_push($array, $row);
	$i++;
}

$data = [ 
	'generator' => $array
];

echo json_encode($data);

/*
//$result = @mysql_query($sql,$connection) or die(mysql_error());
$i=0;
$result = $mysqli -> query ($sql);
while ($row = mysqli_fetch_array($result))  {
	//$insurance = getInsuranceDataByDate(pid, '2017/04/29');
	//$billed = isEncounterBilled('pid', 'encounter');
	$form_id = $row['frid'];
	$fm_encounter = $row['fmencounter'];
	$en_encounter = $row['enencounter'];
	$f_billing_id = $row['fr.billing_id'];
	$provider_id = $row['fr.provider_id'];
	$pid = $row['pid'];
	$servicecode = $row['service_code'];
	$billing_code_type = $row['pobilling_code_type'];
	$starttimestamp = strtotime(stripslashes($row{"time_start"}));
	$endtimestamp = strtotime(stripslashes($row{"time_end"}));
	$totaltime = abs($endtimestamp - $starttimestamp)/60;

	if ($servicecode == ''){
					$servicecode = $row['servicecode'];
	}
	//$row['diagnosis1'] = "ICD10:F00.1 Conduct disorder, childhood-onset type";
	if ($billing_code_type=='CPT4' && $servicecode == 'H2019HR' && $totaltime >= '53'){
		$servicecode = '90837';
		$units = '1';
	}elseif ($billing_code_type=='CPT4' && $servicecode == 'H2019HR' && ($totaltime >= '38' && $totaltime <= '52')){
		$servicecode = '90834';
		$units = '1';
	}elseif ($billing_code_type=='CPT4' && $servicecode == 'H2019HR' && ($totaltime >= '15' && $totaltime <= '37')){
		$servicecode = '90832';
		$units = '1';
	}elseif ($billing_code_type=='CPT4' && $servicecode == 'T1015'){
		$servicecode = '99213';
		$units = '1';
	}elseif ($billing_code_type=='CPT4' && $servicecode == 'H2019HQ'){
		$servicecode = '90847';
		$units = '1';
	};
						

	if ($row['diagnosis1'] == ''){
	
			// Write out our query.
			$diagquery = "select fe.date, fe.encounter, pn.diagnosis1, pn.diagnosis2, pn.diagnosis3, pn.diagnosis4, pn.id  as form_id
				from form_encounter as fe inner join forms as f 
						on fe.encounter = f.encounter
					inner join form_progress_note as pn 
						on f.form_id = pn.id
				where fe.pid = $pid
					and f.form_name Like 'Progress Note%'
					and f.pid = $pid
				    and f.deleted = 0
				    and pn.diagnosis1 LIKE 'ICD10:%'
				    
				  
				Order by fe.date desc, pn.id desc
				limit 1;";
				//and pn.status = 'Ready for %'
			// Execute it, or return the error message if there's a problem.
			//echo "uuuuuuuuuuuuuuuuuuuuuuuuu<br><br>". $diagquery ."<br>";
				//$con = mysql_connect($host, $login, $pass); 
				//mysql_select_db($dbase, $con);
				//$result = mysql_query($query) or die(mysql_error());
			$diagmysqli = new mysqli($host, $login, $pass,$dbase);
			$diagresult = $diagmysqli -> query ($diagquery);
			
			
			
////			$dropdown1 .= "<select id='tp_form_id' name='tp_form_id' class='form-control'><option value=''>-None Selected- </option>"; 
			
			//first option
			//$dropdown1 .= "<option selected=''>". stripslashes($obj{"problem1"}). "</option>";
			//create new option per row
			//while($row = mysql_fetch_assoc($result)) {
			while ($diagrow = mysqli_fetch_array($diagresult)) {
			  $diagrows[] = $diagrow;
			  $row['diagnosis1'] =  $diagrow['diagnosis1'];
			  $row['diagnosis2'] =  $diagrow['diagnosis2'];
			  $row['diagnosis3'] =  $diagrow['diagnosis3'];
			  $row['diagnosis4'] =  $diagrow['diagnosis4'];
			}
////foreach ($diagrows as $diagrow) {
////			  $date = $diagrow['date'];
////			  $date_simple = substr($date ,0, 10);;
////			  $dropdown1 .= "\r\n<option value='{$diagrow['form_id']}'>".$date_simple."&nbsp;&nbsp;&nbsp;&nbsp;<strong>".$diagrow['encounter']." ".$diagrow['form_id']."</strong></option>";
////			}
////			$dropdown1 .= "\r\n</select>";
			mysqli_close($diagmysqli);
			
			///////////////echo  "<label for='tp_form_id'>Select Treatment Plan/Review to Continue : </label>";
			//echo " ";
			///////////////echo   $dropdown1, " " ;
			
			//echo $row['diagnosis1']. "<br>";
			//echo $row['diagnosis2']. "<br>";
			//echo $row['diagnosis3']. "<br>";
			//echo $row['diagnosis4']. "<br>";
//				$row['diagnosis1'] = "ICD10:F00.1 Conduct disorder, childhood-onset type";
	}


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

$patterns = array();
$patterns[0] = '/::::/';
$patterns[1] = '/:::/';
$patterns[2] = '/::/';
$replacements = ':';
$justify = preg_replace($patterns, $replacements, $justify5);
//$units = $row['units'];
if ($units == ''){
				$units = $row['unit'];
}


//****************************Calculations
if ($servicecode =='T1015' && $billing_code_type == 'CPT4'){
        $servicecode = '99213';
        $fee= 200.00*$units;
        $code_text = "MED MANAGEMENT";
        $code_type = "CPT4";
  }
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
	case "H0031HN":
        $fee= 96.00*$units;
        $code_text = "BIO-PSYCHOSOCIAL";
        $code_type = "HCPCS";
        break;
	case "H0031HO":
        $fee= 250.00*$units;
        $code_text = "IN-DEPTH ASSESSMENT - NEW PATIENT";
        $code_type = "HCPCS";
        break;
    case "H0031TS":
        $fee= 200.00*$units;
        $code_text = "IN-DEPTH ASSESSMENT - ESTABLISHED PATIENT";
        $code_type = "HCPCS";
        break;
    case "H0031":
        $fee= 30.00*$units;
        $code_text = "LIMITED FUNTIONAL ASSMNT - FARS/CFARS";
        $code_type = "HCPCS";
        break;
	case "T1015":
        $fee= 120.00*$units;
        $code_text = "MED MANAGEMENT";
        $code_type = "HCPCS";
        break;
    case "H0032":
        $fee= 194.00*$units;
        $code_text = "Treatment Plan";
        $code_type = "HCPCS";
        break;
	case "H0032TS":
        $fee= 97.00*$units;
        $code_text = "Treatment Plan Review";
        $code_type = "HCPCS";
        break;
	case "H200HO":
        $fee= 390.00*$units;
        $code_text = "Psychiatric Evaluation Non-MD";
        $code_type = "HCPCS";
        break;
	case "H200HP":
        $fee= 420.00*$units;
        $code_text = "Psychiatric Evaluation";
        $code_type = "HCPCS";
        break;
    case "99213":
        $fee= 120.00*$units;
        $code_text = "OFFICE VISIT/MED MANAGEMENT";
        $code_type = "CPT4";
        break;
	case "99214":
        $fee= 120.00*$units;
        $code_text = "OFFICE VISIT/MED MANAGEMENT";
        $code_type = "CPT4";
        break;
    
}
//$timediff = abs( (strtotime(stripslashes($row{"time_end"}))) - (strtotime(stripslashes($row{"time_start"}))) / 60);
?>
<form action="kraken_v2.php" method="post">
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
			<span><b>Code Type:&nbsp;</b></span><?php echo $row['pobilling_code_type'];?><br>
			<span><b>Encounter:&nbsp;</b></span><?php echo $row['encounter'];?>_<?php echo $fm_encounter;?>_<?php echo $en_encounter;?><br>
			<span><b>ID: </b><?php echo $row['pid'] ?> <b>Name: </b></span><?php echo $row['fname'] . '&nbsp' . $row['mname'] . '&nbsp;' . $row['lname'];?>
			&nbsp;<span><b>DOB:&nbsp;</b></span><?php echo $row['dob'];?><br>
			<span><b>DOS:&nbsp;</b></span><?php echo substr($row["date"], 0, 10); ?>
			<span><b>Provider:&nbsp;</b></span><?php echo stripslashes($row{"provider_print_name"});?>
			<span><br><b>POS:&nbsp;</b></span><?php echo $row['facility'];?>
			<span><b>Time Started:&nbsp;</b></span><?php echo stripslashes($row{"time_start"});?>
			<span><b>End Time:&nbsp;</b></span><?php echo stripslashes($row{"time_end"});?>
			<span><b>Total Time:&nbsp;</b></span><?php echo $totaltime;?>&nbsp;Minutes<br>
			<span><b>Authorization#:&nbsp;</b></span><?php echo $row['authorization_number'];?>
			<span><b>Service Authorized:&nbsp;</b></span><?php echo $row['saservice_code'];?>
			<span><b>Service description:&nbsp;</b></span><?php echo $row['service_name'];?><br>
			<span><b>Date Ceated:&nbsp;</b></span><?php echo substr($row["created"], 0, 10);?><br>
			<span><b>Status:&nbsp;</b></span><?php echo $row['status'];?>
			<span><b>Billing ID:&nbsp;</b></span><?php echo $row['billing_id'];?><br>
			<span><b>Billing Status:&nbsp;</b></span><?php echo $row['billing_status'];?><br>
		</div>
	</div>
	<!--<br class="clr">-->
</div>

<!-- Notes -->
<!--	<div class="notes">
<h2>List Specific Treatment Plan Deficit/Problems/Behavior Addressed</h2>
		<p><?php echo stripslashes($row{"problems"});?></p>
		<h2>Clinical Intervention</h2>
		<p><?php echo stripslashes($row{"clinical_intervention"});?></p>
		<h2>Response to Intervention</h2>
		<p><?php echo stripslashes($row{"response_to_intervention"});?></p>
</div>
<br class="clr">
-->
	<!-- Signature -->
	<!--<div class="info">-->
		<!--<div class="col1" style="width: 885px">-->
			
			
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
							         //echo "OOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO";
							   		 echo "<div class='well well-sm'>";
									echo $row['diagnosis1']. "<br>";
									 echo $row['diagnosis2']. "<br>";
									 echo $row['diagnosis3']. "<br>";
									 echo $row['diagnosis4']. "<br>";

									$count = 0;
									print "Med Management";
									$data2 = formFetch("form_med_management", $form_id);
									echo $data2;
									if ($data2) {
									
										foreach($data2 as $key2 => $value2) {
										if ($key2 == "id" || $key2 == "pid" || $key2 == "user" || $key2 == "groupname" || $key2 == "authorized" || $key2 == "activity" || $key2 == "date" || $value2 == "" || $value2 == "0000-00-00 00:00:00") {
											continue;
										}
										if ($value == "on") {
										$value = "yes";
										}
										$key=ucwords(str_replace("_"," ",$key2));
										//print "<td><span class=bold>$key2: </span><span class=text>$value2</span></td>";
										print "<span class=bold>$key2: </span><span class=text>$value2</span><br>";

										$count++;
										if ($count == $cols) {
										$count = 0;
										
														
										}
										}
										}
										//print "</tr></table>";
										 echo "</div>";

					    		break; 
					    		 case "form_assessment_cmh":
							    	 
							   		 echo "<div class='well well-sm'>";

									$count = 0;
									print "Assessment";
									$data2 = formFetch("form_assessment_cmh", $form_id);
									//echo $data2;
									if ($data2) {
									
										foreach($data2 as $key2 => $value2) {
										if ($key2 == "id" || $key2 == "pid" || $key2 == "user" || $key2 == "groupname" || $key2 == "authorized" || $key2 == "activity" || $key2 == "date" || $value2 == "" || $value2 == "0000-00-00 00:00:00") {
											continue;
										}
										if ($value == "on") {
										$value = "yes";
										}
										$key=ucwords(str_replace("_"," ",$key2));
										//print "<td><span class=bold>$key2: </span><span class=text>$value2</span></td>";
										print "<span class=bold>$key2: </span><span class=text>$value2</span><br>";

										$count++;
										if ($count == $cols) {
										$count = 0;
										
														
										}
										}
										}
										//print "</tr></table>";
										 echo "</div>";

					    		break;
					    		case "form_treatment_plan":
							    	
							   		 echo "<div class='well well-sm'>";

									$count = 0;
									print "Treatment Plan";
									$data2 = formFetch("form_treatment_plan", $form_id);
									//echo $data2;
									if ($data2) {
									
										foreach($data2 as $key2 => $value2) {
										if ($key2 == "id" || $key2 == "pid" || $key2 == "user" || $key2 == "groupname" || $key2 == "authorized" || $key2 == "activity" || $key2 == "date" || $value2 == "" || $value2 == "0000-00-00 00:00:00") {
											continue;
										}
										if ($value == "on") {
										$value = "yes";
										}
										$key=ucwords(str_replace("_"," ",$key2));
										//print "<td><span class=bold>$key2: </span><span class=text>$value2</span></td>";
										print "<span class=bold>$key2: </span><span class=text>$value2</span><br>";

										$count++;
										if ($count == $cols) {
										$count = 0;
										
														
										}
										}
										}
										//print "</tr></table>";
										 echo "</div>";

					    		break;
					    		case "form_psychiatric_evaluation":
							    	
							   		 echo "<div class='well well-sm'>";

									$count = 0;
									print "Psychiatric Evaluation";
									$data2 = formFetch("form_psychiatric_evaluation", $form_id);
									//echo $data2;
									if ($data2) {
									
										foreach($data2 as $key2 => $value2) {
										if ($key2 == "id" || $key2 == "pid" || $key2 == "user" || $key2 == "groupname" || $key2 == "authorized" || $key2 == "activity" || $key2 == "date" || $value2 == "" || $value2 == "0000-00-00 00:00:00") {
											continue;
										}
										if ($value == "on") {
										$value = "yes";
										}
										$key=ucwords(str_replace("_"," ",$key2));
										//print "<td><span class=bold>$key2: </span><span class=text>$value2</span></td>";
										print "<span class=bold>$key2: </span><span class=text>$value2</span><br>";

										$count++;
										if ($count == $cols) {
										$count = 0;
										
														
										}
										}
										}
										//print "</tr></table>";
										 echo "</div>";

					    		break;


					    		case "form_cfars":
							    	 
							   		 echo "<div class='well well-sm'>";

									$count = 0;
									print "FARS - CFARS";
									$data2 = formFetch("form_cfars", $form_id);
									//echo $data2;
									if ($data2) {
									
										foreach($data2 as $key2 => $value2) {
										if ($key2 == "id" || $key2 == "pid" || $key2 == "user" || $key2 == "groupname" || $key2 == "authorized" || $key2 == "activity" || $key2 == "date" || $value2 == "" || $value2 == "0000-00-00 00:00:00") {
											continue;
										}
										if ($value == "on") {
										$value = "yes";
										}
										$key=ucwords(str_replace("_"," ",$key2));
										//print "<td><span class=bold>$key2: </span><span class=text>$value2</span></td>";
										print "<span class=bold>$key2: </span><span class=text>$value2</span><br>";

										$count++;
										if ($count == $cols) {
										$count = 0;
										
														
										}
										}
										}
										//print "</tr></table>";
										 echo "</div>";

					    		break;



									}
							switch ($form_name) {
							    case "Progress Note - PSR":
							    	 echo "<div class='well well-sm'><br>";
							    	 echo $row['diagnosis1']. "<br>";
									 echo $row['diagnosis2']. "<br>";
									 echo $row['diagnosis3']. "<br>";
									 echo $row['diagnosis4']. "<br>";

							    	 echo "<span><b>Deficit Problems Behavior Addressed:</b>&nbsp;".$row['deficit_problems_behavior_addressed']. "<br>";

							    	 echo "<span><b>Clinical Intervention:</b>&nbsp;".$row['interventions']. "<br>";
							    	 echo "<b><br>Response To Intervention:</b>&nbsp;".$row['response_to_intervention']. "</span><br>"; 
							         echo "</div>";
							         //echo "<br class='clr'>";
							         echo "<div class='well well-sm'>";
							         echo "<b>Electronically Signed By:&nbsp;</b>";
							         echo "<span>". $row['provider_print_name']. "&nbsp;</span>";
							         echo "<span>&nbsp;&nbsp;". $row['credentials']. "</span>";
							    	 echo "<span><br><b>Signature Date:&nbsp;</b>". $row['provider_signature_date']. "</span>"; 
							    	 echo "<span><br><b>Credentials:&nbsp;</b>". $row['provider_credentials']. "</span>";
							    	 echo "</div>";
					    		break;
							    case "Progress Note - IND":
							   		 echo "<div class='well well-sm'><br>";
							    	 echo $row['diagnosis1']. "<br>";
									 echo $row['diagnosis2']. "<br>";
									 echo $row['diagnosis3']. "<br>";
									 echo $row['diagnosis4']. "<br>";
							    	 echo "<b>Subjective:--</b>&nbsp;".$row['subjective']. "<br>";
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
<!--			</div>
		<br class="clr">
		<div class="info">
			<b>Signature Date:</b>
			
			<span><?php 

						echo $row['provider_signature_date'];?></span>
			
		</div>
	</div>
-->
<?php
//************************************Insurance Verification**********************************************************
//$sql_insurance
//Other Forms*********************************************************************************************************
$sql_check_forms = "SELECT * FROM forms WHERE encounter = $en_encounter ".
					"AND deleted = '0' ".
					"AND form_name != 'New Patient Encounter'".
					"and formdir != 'newpatient' ".
					"and formdir != 'scanned_notes' ".
					"and formdir != 'misc_billing_options' " .
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

$result_check_forms =  $mysqli -> query ($sql_check_forms);
while ($row_check_forms = mysqli_fetch_array($result_check_forms)) 
{
echo "<div class='alert alert-warning'>";
echo "<b> ". $row_check_forms["form_name"]. " ". $row_check_forms["user"]. "</b>";
echo "</div>";
}

//Other Encounters*********************************************************************************************************
$client = $row['pid'];
$dateofservice = substr($row["date"], 0, 10)."%";
//$dateofservice = substr($row["date"], 0, 10);
$sql_check_encounters = "SELECT pid, reason, facility, date FROM form_encounter WHERE encounter != $en_encounter AND pid= $client AND date LIKE '$dateofservice' ";
//echo $sql_check_encounters;
$result_check_encounters =  $mysqli -> query ($sql_check_encounters);
while ($row_check_encounters = mysqli_fetch_array($result_check_encounters)) 
{
echo "<div class='alert alert-info'>";
//echo $sql_check_encounters;
echo "<b> Additional Encounters </b>". $row_check_encounters["reason"]. " ". $row_check_encounters["facility"]. " ". $row_check_encounters["status"]. "</b>";
echo "</div>";
}
//*****************************************************************************Display Existing Billing***************	
$sql_existing_billing = "SELECT * FROM billing WHERE encounter = $en_encounter AND code_type NOT LIKE 'ICD%'";
//$result_existing_billing = SqlFetchArray($existing_billing);
//$result_existing_billing = @mysql_query($sql_existing_billing, $connection) or die(mysql_error());
$result_existing_billing =  $mysqli -> query ($sql_existing_billing);
while ($row_existing_billing = mysqli_fetch_array($result_existing_billing)) 
{
echo "<div class='alert alert-danger'>";
echo "<b>Existing Billing: Date:</b> ". $row_existing_billing["date"]. "<b>Code Type:</b>". $row_existing_billing["code_type"]. "<b>Code:</b>". $row_existing_billing["code"]. "Modifier:</b>". $row_existing_billing["modifier"]. "<b>Description:</b>". $row_existing_billing["code_text"];
echo "<b>Units: </b>". $row_existing_billing["units"]. "<b>Fee : </b>$". $row_existing_billing["fee"]. "<b>Diag: </b>". $row_existing_billing["justify"]. "<b>Billed :</b>". $row_existing_billing["billed"];
echo "</div>";
}



//echo "existing:". $result_existing_billing["code_type"];


//****************************************************************************Add Billing****************************
//TO DO: Remove Database Security Info from page
// Disable form after 'Ready for Billing'
//NEED IN FORM billing_id, provider_id
//<input type="hidden" name="provider_id" id="provider_id" value="<?php echo $provider_results["id"]; 
//$providerIDres = getProviderIdOfEncounter($encounter);//Currently billing by the encounter creator, not form creator. To be fixed
////////////////////////////////////////////////////////////////////
//ALTER TABLE `openemr`.`form_XXX_XXXX`
//ADD COLUMN `provider_id` BIGINT(20) NULL AFTER `provider_print_name`,
//ADD COLUMN `billing_id` BIGINT(20) NULL DEFAULT '-99' AFTER `billing_status`, 
//ADD COLUMN `problem3` VARCHAR(255) NULL AFTER `problem2`,
//ADD COLUMN `problem4` VARCHAR(255) NULL AFTER `problem3`;
////////////////////////////////////////////////////////////////////
echo "<h3>Billing on Form:</h3>" . $f_billing_id;
echo "&nbsp;<b> Provider ID</b>" . $provider_id . "&nbsp;<b>Justify: </b>". $justify5 . "&nbsp;<b>Units: </b>". $units . "&nbsp;<b>Service Code: </b>" . $servicecode . "- ";
echo "<b>FEE: </b>". $fee . "&nbsp;<b>Service Name: </b> ". $code_text;
//echo "<br>_________________________________________________________________________________________________________<br>";
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

?>


<script language="JavaScript">
$("#checkAll").click(function () {
     $('input:checkbox').not(this).prop('checked', this.checked);
     var $inpts = $(this).closest('tr').find('input:text').prop('disabled', !this.checked);
	$('.selection').on('change', ':checkbox', function () {
       var $inpts = $(this).closest('tr').find('input:text').prop('disabled', !this.checked);
     }).find(':checkbox').change();
 });
 
   $('.selection').on('change', ':checkbox', function () {
       var $inpts = $(this).closest('tr').find('input:text').prop('disabled', !this.checked);
   
   }).find(':checkbox').change();

</script>
<br>
<input type="submit" class="btn btn-primary" type="submit" />
</form>


*/