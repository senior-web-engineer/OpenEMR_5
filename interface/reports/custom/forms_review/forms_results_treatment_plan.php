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
input:invalid { background: red; }
.input-sm {
	padding: 2px;
}
.table td {
	padding: 2px !important;
}
.auto-style2 {
	background-color: #FFFF00;
}
.auto-style3 {
	background-color: #00FF00;
}
.auto-style4 {
	color: #000000;
	background-color: #FF0000;
}
.auto-style5 {
	font-size: x-large;
	font-family: "Blackadder ITC";
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
$provider_results = sqlQuery("select fname, mname, lname, provider_signature, provider_print_name from users where username='" . $_SESSION{"authUser"} . "'");
echo "<p>". $provider_results['provider_print_name']."</p>";
echo "<p>". $provider_results['provider_signature']."</p>";

switch ($form_selected) {
   	case "form_treatment_plan":
	$form_selected = "form_treatment_plan";
         $form_name = "Treatment Plan";
         $extra_fields = ", fr.provider_credentials, fr.provider_signature_date, fr.provider_print_name,".
			 			"fr.physician_print_name,fr.physician_credentials,".
			 			"fr.physician_signature_date,fr.supervisor_signature_date,fr.supervisor_credentials,".
			 			"fr.supervisor_print_name,fr.guardian_print_name,supervisor_signature,".
			 			"fr.guardian_signature_date,".
			 			"fr.patient_print_name,".
			 			"fr.patient_signature_date,".
			 			"fr.service_name, ".
			 			"fr.signatures_on_file, ".
			 			"fr.comments_log ";
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
	"fr.id AS frid, fr.pid, fr.user,  fr.service_code, fr.unit, fr.billing_id, fr.billing_status".
	$extra_fields.
	", fr.status, fr.date_created, fr.encounter".
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
//$id = $row['frid'];	
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
    case "H2017":
        $fee= 18*$units;
        $code_text = "PSYCHO SOCIAL REHABILITATION";
        $code_type = "HCPCS";
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
<form action="kraken_treatment_plan.php" method="post">
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
			<span class="auto-style3">
			<span><b>Encounter:&nbsp;</b></span><?php echo $row['encounter'];?>_<?php echo $fm_encounter;?>_<?php echo $en_encounter;?><br>
			<span><b>ID: </b><?php echo $row['pid'] ?> <b>Name: </b></span><?php echo $row['fname'] . '&nbsp' . $row['mname'] . '&nbsp;' . $row['lname'];?>
			&nbsp;<span><b>DOB:&nbsp;</b></span><?php echo $row['dob'];?><br>
			<span><b>DOS:&nbsp;</b></span><?php echo substr($row["date"], 0, 10); ?></span>
			<span><b>Provider:&nbsp;</b></span><?php echo stripslashes($row{"provider_print_name"});?>
			<span><br><b>POS:&nbsp;</b></span><?php echo $row['facility'];?>
			<span><b>Time Started:&nbsp;</b></span><?php echo stripslashes($row{"time_start"});?>
			<span><b>End Time:&nbsp;</b></span><?php echo stripslashes($row{"time_end"});?><br>
			<span><b>Date Ceated:&nbsp;</b></span><?php echo substr($row["created"], 0, 10);?><br>
			<span><b>Status:&nbsp;</b></span><span class="auto-style2"><?php echo $row['status'];?></span>
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
		


		<div class='well well-sm'>
			<?php
				echo "<h2>".stripslashes($row{"service_name"})."</h2>";
				//$id = 0 + (isset($_GET['formid']) ? $_GET['formid'] : 0);
				//*************Diagnosis***************************************
				echo "<b>Diagnosis: </b>";
						$tpsql6 = "SELECT da.form_id, da.Description AS dadescription ".
								"FROM form_treatment_plan_diagnosis AS da ".
								"WHERE da.form_id = $form_id ".
								"AND (IsDeleted is Null or IsDeleted = 0) "
								;
						$tpresult6=sqlStatement($tpsql6);
						$print3 = "";
						while ($tprow6 = sqlFetchArray($tpresult6)){ 
						       $dadescription = $tprow6['dadescription'];
							   //echo "<span>".$dadescription . "</span>";
						       echo "<li class=''>".$dadescription . "</li>";
						}
						
			
				
				//---- Problems ----- 
				$tpsql = "SELECT tp.id, tp.Description AS tpdescription, tp.tp_problem_number AS tptp_problem_number, tp.form_id , tp.IsPrimary AS tpisrimary ".
						"FROM form_treatment_plan_problems AS tp ". 
						"WHERE tp.form_id = $form_id and (IsDeleted is Null or IsDeleted = 0) ".
						"ORDER BY tp.IsPrimary"
			    		;
				$tpresult = sqlStatement($tpsql);
				while ($tprow = sqlFetchArray($tpresult)) {
					$problem_id 	  = $tprow['id'];
					$tpproblem_number = $tprow['tptp_problem_number'];
					$tpdescription    = $tprow['tpdescription'];
					$tpisprimary      = $tprow['tpisrimary'];
					
				  //echo "<b><h3>Problem#". $tpproblem_number . "</h3></b><ul><li class=''><h4>". $tpdescription . "</h4></li>";
				  if ($tpisprimary == "1") {
				  	 echo "<b><p>Primary Problem: </b>". $tpdescription . "</p>";
			
				  } else {
					 //echo "<div class='header2'></div>";
			
					 echo "<b><p>Secondary Problem: </b>". $tpdescription . "</p>";
				  }
					//---- Behavioral Definitions ----- 
					$tpsql2 = "SELECT bd.Description AS bddescription ".
							"FROM form_treatment_plan_behavioraldefinitions AS bd ".
							"WHERE bd.form_id = $form_id AND bd.problem_id = $problem_id and (IsDeleted is Null or IsDeleted = 0) ".
							"GROUP BY bddescription "
							;
					
					$tpresult2 = sqlStatement($tpsql2);
					$print = "";
					while ($tprow2 = sqlFetchArray($tpresult2)) { 
						$bddescription = $tprow2['bddescription'];
						$print .= "<span>". $bddescription . "</span>";
					}
					if (strlen($print) > 0){
						echo "<b>Definitions:</b>";
						echo $print;
						echo "";
					}
			
					//---- Goals ----- 
					$tpsql3 = "SELECT gl.Description AS gldescription, gl.goal_status AS glgoal_status, gl.goal_action AS glgoal_action, gl.review_status AS glreview_status ".
							"FROM form_treatment_plan_goals AS gl ".
							"WHERE gl.form_id = $form_id AND gl.problem_id = $problem_id and (IsDeleted is Null or IsDeleted = 0) ".
							"GROUP BY gldescription "
							;
					$tpresult3 = sqlStatement($tpsql3);
					$print = "";
					$print_review = "";
					while ($tprow3 = sqlFetchArray($tpresult3)) { 
						$gldescription = $tprow3['gldescription'];
						$goalaction = $tprow3['glgoal_action'];
						$goalstatus = $tprow3['glgoal_status'];
						$goalreviewstatus = $tprow3['glreview_status'];
						$print .= "<span>". $gldescription ."</span>";
						$print_review .= "<span>". $gldescription ."</span><b><p>Status: </b>". $goalstatus ."</p><b>Goal Action: </b>".$goalaction."<b><p>Status Description: </b>".$goalreviewstatus."</p>";
						$print_review2 .= "<b>Status: </b>". $goalstatus ."<b>Goal Action: </b>".$goalaction."<b>Status Description: </b>".$goalreviewstatus."" ;
					}
					if (strlen($print) > 0){
						echo "<br><b>Goals:</b>";
						echo $print_review;
						echo "";
					}
			
					//---- Objectives ----- 
					$tpsql4 = "SELECT oj.id AS ojid, oj.Description AS ojdescription, oj.ObjectiveNumber AS ojObjectiveNumber, oj.target_date AS ojtarget_date ".
							"FROM form_treatment_plan_objectives AS oj ".
							"WHERE oj.form_id = $form_id AND oj.problem_id = $problem_id and (IsDeleted is Null or IsDeleted = 0) ".
							"ORDER BY oj.id"
							;

					$tpresult4 = sqlStatement($tpsql4);
					$print = "";
					while ($tprow4 = sqlFetchArray($tpresult4)) { 
						$ojdescription = $tprow4['ojdescription'];
						$objectivenumber = $tprow4['ojObjectiveNumber'];
						$ojtarget_date = $tprow4['ojtarget_date'];
						$ojid = $tprow4['ojid'];
						//$print .= "<li class=''><b>Objective:</b> ". $ojdescription . "<span> <b>Target Date:</b> ". $ojtarget_date. "</span></li>";
						//Changed 1/11/16 dnunez
						$print .= "<div id='' class='form-group group dontsplit'><b>Objective: </b>". $ojdescription . "<b>Target Date:</b>". $ojtarget_date. "</div>";
						
						//*************INTERVENTIONS***************************************
						$tpsql5 = "SELECT it.form_id, it.Description AS itdescription, it.ObjectiveID AS itObjectiveID ".
								"FROM form_treatment_plan_interventions AS it ".
								"WHERE it.form_id = $form_id  AND it.ObjectiveID = $ojid and (IsDeleted is Null or IsDeleted = 0) ".
								"AND it.tp_problem_number = $tpproblem_number "
								;
						$tpresult5 = sqlStatement($tpsql5);
						$print2 = "";
						while ($tprow5 = sqlFetchArray($tpresult5)){ 
							$itdescription = $tprow5['itdescription'];
							$print2 .= "<span>". $itdescription ."</span>";
						}
						if(strlen($print2) > 0){
							$print .= "<b>Interventions:</b>";
							$print .= $print2;
							$print .= "";
						}
						//*************INTERVENTIONS*************************************** 
					}
					if (strlen($print) > 0){
						echo "<b>Objectives:</b>";
						echo $print;
						echo "";
					}
					//------ Objectives -------
					
					
					
				};

				//*************Modalities***************************************
				echo "<div id='' class='form-group group dontsplit'><b>Modalities: </b>";
						$tpsql7 = "SELECT mo.form_id, mo.start_date AS mostart_date, mo.end_date AS moend_date, mo.hcpt AS mohcpt, mo.intervals AS mointervals, mo.frequency AS mofrequency, mo.provider AS moprovider, mo.modality AS momodality ".
								"FROM form_treatment_plan_modalities AS mo ".
								"WHERE mo.form_id = $form_id ".
								"AND (IsDeleted is Null or IsDeleted = 0) ";
						$tpresult7 = sqlStatement($tpsql7);
						$print3 = "";
						while ($tprow7 = SqlFetchArray($tpresult7)){ 
							$mostart_date  = $tprow7['mostart_date'];
							$moend_date  = $tprow7['moend_date'];
							$momodality  = $tprow7['momodality'];
							$mohcpt      = $tprow7['mohcpt'];
							$mointervals = $tprow7['mointervals'];
							$mofrequency = $tprow7['mofrequency'];
							$moprovider  = $tprow7['moprovider'];
							
							//$print3 .= "<li class=''>". $dadescription ."</li>";
						 echo "<b>Starting: </b>".$mostart_date ."<b> Ending: </b>".$moend_date ."<br><b> Service Description: </b>".$momodality . "<b> CPT\HCPCS Code: </b>".$mohcpt . "<b> Interval: </b>".$mointervals . "<b> Frequency: </b>".$mofrequency . "<br><b> Responsible Provider: </b>".$moprovider ."<br>";
						}
				echo "</div>";	
				
				//*************Modality Note***************************************
				echo "<div id='' class='form-group group dontsplit'><b>Modalities Note: </b>";
						$tpsql8 = "SELECT mo.form_id, mo.notes AS monotes ".
								"FROM form_treatment_plan_modalitynotes AS mo ".
								"WHERE mo.form_id = $form_id ".
								"AND (IsDeleted is Null or IsDeleted = 0) "
								;
						$tpresult8 = sqlStatement($tpsql8);
						$print3 = "";
						while ($tprow8 = SqlFetchArray($tpresult8)){ 
							$monotes = $tprow8['monotes'];
							//$print3 .= "<li class=''>". $dadescription ."</li>";
						 echo "<span>".$monotes . "</span>";
						}
				echo "</div>";	
						
				//*************Discharge Criteria***************************************
				echo "<div id='' class='form-group group dontsplit'><b>Discharge Criteria: </b>";
						$tpsql9 = "SELECT dc.form_id, dc.criteria AS dccriteria ".
								"FROM form_treatment_plan_dischargecriteria AS dc ".
								"WHERE dc.form_id = $form_id ".
								"AND (IsDeleted is Null or IsDeleted = 0) "
								;
						$tpresult9 = sqlStatement($tpsql9);
						$print3 = "";
						while ($tprow9 = SqlFetchArray($tpresult9)){ 
							$dccriteria = $tprow9['dccriteria'];
					   echo "<span>".$dccriteria . "</span>";
						}
				echo "</div>";	
						
			//****************************    END FORM **************************************
			?>
		
		<div class="columnbreak"></div>
		<div id="signature" class="form-group group">
			<b><p>SIGNATURE PAGE</p>
			</b>
				<!--SIGNATURE PAGE ON FILE -->
				<span>
			<input id="signatures_on_file" name="signatures_on_file" class="element checkbox" type="checkbox"<?php if ($row{"signatures_on_file"} == "on") {echo "checked";};?> disabled style="width: 27px; height: 26px"/><label class="choice" for="signatures_on_file"> Scanned signatures, on File.</label></span>
				

			
				<!--PATIENT SIGNATURE-->
					
					<label class="description" for="patient_print_name"> </label>
						<div>
							<b>Client:&nbsp;</b><?php echo stripslashes($row{"patient_print_name"});?>
							<b>&nbsp;Signature Date:&nbsp;</b><?php echo stripslashes($row{"patient_signature_date"});?>
							<?php if (isset($row['patient_signature'])){
																		echo "<br><span class='auto-style5'>".stripslashes($row{"patient_print_name"})."</span>";
																		}else{
																		echo "<span class='auto-style2'>ELECTRONIC SINATURE NOT PRESENT</span>";};?>

						</div>
					
				<!--END OF PATIENT SIGNATURE-->
				<!--GUARDIAN SIGNATURE-->
					
					<label class="description" for="guardian_print_name"> </label>
						<div>
							<b>Guardian:&nbsp;</b><?php echo stripslashes($row{"guardian_print_name"});?>
							<b>&nbsp;Signature Date:&nbsp;</b><?php echo stripslashes($row{"guardian_signature_date"});?>
						</div>
					
				<!--END OF GUARDIAN SIGNATURE-->
				<!-- CLINICIAN SIGNATURE-->
					
					<label class="description" for="provider_print_name"> </label>
						<div>
							<b>Clinician:&nbsp;</b><?php if ($row['provider_print_name']==''){
																								echo "<span class='auto-style4'>MISSING BUT REQUIRED</span>";
																								}else{
																								echo stripslashes($row{"provider_print_name"});};?>,&nbsp; 
							<?php if ($row['provider_credentials']==''){
																			echo "<span class='auto-style4'>MISSING BUT REQUIRED</span>";
																			}else{
																			echo stripslashes($row{"provider_credentials"});};?>
							
							<b>&nbsp;Signature Date:&nbsp;</b>
							<?php if ($row['provider_signature_date']==''){
																			echo "<span class='auto-style4'>MISSING BUT REQUIRED</span>";
																			}else{
																			echo stripslashes($row{"provider_signature_date"});};?>
							<?php if (isset($row['provider_signature'])){
																			echo "<br><span class='auto-style5'>".stripslashes($row{"provider_print_name"})."</span>";
																			}else{
																			echo "<span class='auto-style2'>ELECTRONIC SINATURE NOT PRESENT</span>";};?>
						</div>
					
				<!--END OF CLINICIAN SIGNATURE-->
				<!-- SUPERVISOR SIGNATURE-->
				<label class="description" for="supervisor_print_name"> </label>
						<div>
							<b>Supervisor:&nbsp;</b><?php echo stripslashes($row{"supervisor_print_name"});?>,&nbsp;<?php echo stripslashes($row{"supervisor_credentials"});?>
							<b>&nbsp;Signature Date:&nbsp;</b><?php echo stripslashes($row{"supervisor_signature_date"});?>
							<?php if (isset($row['supervisor_signature'])){
																			echo "<br><span class='auto-style5'>".stripslashes($row{"supervisor_print_name"})."</span>";
																			}else{
																			echo "<span class='auto-style2'>ELECTRONIC SINATURE NOT PRESENT</span>";};?>
						</div>
				<!--END OF CLINICIAN SIGNATURE-->
				<label class="description" for="supervisor_print_name"> </label>
					<div>
						<b>Physician:&nbsp;</b><?php echo stripslashes($row{"physician_print_name"});?>,&nbsp;<?php echo stripslashes($row{"physician_credentials"});?>
						<b>&nbsp;Signature Date:&nbsp;</b><?php echo stripslashes($row{"physician_signature_date"});?>
						<?php if (isset($row['physician_signature'])){
																			echo "<br><span class='auto-style5'>".stripslashes($row{"physician_print_name"})."</span>";
																			}else{
																			echo "<span class='auto-style2'>ELECTRONIC SINATURE NOT PRESENT</span>";};?>
					</div>
			</div>
		</div>
	</div>	
	
		<?php
			switch ($form_selected) {
							    case "form_psychosocial":
							    	 echo "<div class='well well-sm'>";
							    	 //echo "<span><b>Service:</b>&nbsp;".$row['servicecode']. " ";
							    	 //echo "<b>Units:</b>&nbsp;".$row['units']. "</span><br>";
							    	 echo "<b>Time Started:</b>&nbsp;".$row['timestart']. "</span>";
							    	 echo "<b>&nbsp;Time Ended:</b>&nbsp;".$row['timeend']. "</span>";
							    	 
							    	 echo "<b><br>Diag 1:</b>&nbsp;".$row['problem1']. "</span>";
							    	 echo "<b><br>Diag 2:</b>&nbsp;".$row['problem2']. "</span>";
							    	 echo "<b><br>Diag 3:</b>&nbsp;".$row['problem3']. "</span>";
							    	 echo "<b><br>Diag 4:</b>&nbsp;".$row['problem4']. "</span>";
							         echo "</div>";

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
							    	 //echo "<span><b>Service:</b>&nbsp;".$row['servicecode']. " ";
							    	 //echo "<b>Units:</b>&nbsp;".$row['units']. "</span><br>";
							    	 echo "<b>Time Started:</b>&nbsp;".$row['timestart']. "</span>";
							    	 echo "<b>&nbsp;Time Ended:</b>&nbsp;".$row['timeend']. "</span>";
							    	 
							    	 echo "<b><br>Diag 1:</b>&nbsp;".$row['problem1']. "</span>";
							    	 echo "<b><br>Diag 2:</b>&nbsp;".$row['problem2']. "</span>";
							    	 echo "<b><br>Diag 3:</b>&nbsp;".$row['problem3']. "</span>";
							    	 echo "<b><br>Diag 4:</b>&nbsp;".$row['problem4']. "</span>";
							         echo "</div>";

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
							    	 echo "<b>Diagnosis 1:</b>&nbsp;";
										if ($row['diagnosis1'] ==''){echo "<span class='auto-style4'>MISSING BUT REQUIRED</span>";}else{echo $row['diagnosis1'];}; echo "<br>";
							   		 echo "<b>Diagnosis 2:</b>&nbsp;".$row['diagnosis2']. "<br>";
							   		 echo "<b>Diagnosis 3:</b>&nbsp;".$row['diagnosis3']. "<br>";
							   		 echo "<b>Diagnosis 4:</b>&nbsp;".$row['diagnosis4']. "<br>";
									 echo "<span><b>Deficit Problems Behavior Addressed:</b>&nbsp;";
										if ($row['deficit_problems_behavior_addressed']==''){echo "<span class='auto-style4'>MISSING BUT REQUIRED</span>";}else{echo $row['deficit_problems_behavior_addressed'];};echo "<br>";

							    	 echo "<span><b>Clinical Intervention:</b>&nbsp;";
										if ($row['interventions']==''){echo "<span class='auto-style4'>MISSING BUT REQUIRED</span>";}else{echo $row['interventions'];};echo "<br>";
							    	 echo "<b><br>Response To Intervention:</b>&nbsp;";
										if ($row['response_to_intervention']==''){echo "<span class='auto-style4'>MISSING BUT REQUIRED</span>";}else{echo $row['response_to_intervention'];};echo "<br>";
									 echo "</div>";
							         //echo "<br class='clr'>";
							         echo "<div class='well well-sm'>";
							         echo "<b>Electronically Signed By:&nbsp;</b>";
							         echo "<span>". $row['provider_print_name']. "&nbsp;</span>";
							         echo "<span>&nbsp;&nbsp;". $row['provider_credentials']. "</span>";
							    	 echo "<span><br><b>Signature Date:&nbsp;</b>". $row['provider_signature_date']. "</span>"; 
							    	 echo "</div>";
					    		break;
					    		case "Progress Note - DAY":
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
							         echo "<b>Electronically Signed By:&nbsp;</b>";
							         echo "<span>". $row['provider_print_name']. "&nbsp;</span>";
							         echo "<span>&nbsp;&nbsp;". $row['provider_credentials']. "</span>";
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
					    		case "Progress Note - TBO":
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
<!--			</div>
		<br class="clr">
		<div class="info">
			<b>Signature Date:</b>
			
			<span><?php 

						echo $row['provider_signature_date'];?></span>
			
		</div>
	</div>
-->
<!--
<?php
//************************************Insurance Verification**********************************************************
//$sql_insurance
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
-->
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
		
<?php
		$status=stripslashes($row{"status"});
		if($status=='Ready for Review')
			{
?>
		<select class="form-control input-sm" id="status" name="status[]" style="width: 199px" required>
			<option selected=""><?php echo stripslashes($row{"status"});?></option>
			<option value="Ready for Billing">Ready for Billing</option>
		<!--<option value="Ready for Billing/Supervisor">Ready for Billing/Supervisor</option>-->
			<option value="Error Report/Correction(s) Needed">Error Report/Correction(s) Needed</option>
			<option value="Void/Delete Request">Void/Delete Request</option>
		</select>
<?php
			}else{
?>
		<select class="form-control input-sm" id="status" name="status[]" style="width: 199px" required>
			<option selected=""><?php echo stripslashes($row{"status"});?></option>
		
		<!--<option value="Ready for Billing/Supervisor">Ready for Billing/Supervisor</option>-->
			<option value="Error Report/Correction(s) Needed">Error Report/Correction(s) Needed</option>
			<option value="Void/Delete Request">Void/Delete Request</option>
		</select>
<?php
			};
?>
		<input class="form-control input-sm" type="text" name="provider_print_name[]" value="<?php echo stripslashes($row{"provider_print_name"}); ?>" style="width: 199px" >
		<textarea class="form-control input-sm" wrap=virtual name="supervisor_signature[]" id="supervisor_signature" style="height: 132px; width: 199px;" readonly><?php echo $row['supervisor_signature'];?></textarea>
		</td>
		<td>
		Log:
		<textarea class="form-control input-sm" wrap=virtual name="comments_log_view[]" id="comments_log_view" style="height: 132px; width: 548px;" readonly><?php echo $row['comments_log'];?></textarea>
		New Entry:
		<textarea class="form-control input-sm" wrap=virtual name="comments_log[]" id="comments_log"style="height: 132px; width: 548px;"  ></textarea>
		</td>
		



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
<input type="hidden" name="electronic_signature" value="<?php echo $provider_results['provider_signature']?>"/>
<input type="hidden" name="form_selected" value="<?php echo $form_selected; ?>" />

<input type="submit" class="btn btn-primary" type="submit" />
</form>

