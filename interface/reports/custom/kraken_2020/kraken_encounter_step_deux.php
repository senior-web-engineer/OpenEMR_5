<?php
include_once("../../../globals.php");
//include_once ("$srcdir/sql.inc");
//require_once ("{$GLOBALS['srcdir']}/sql.inc");
include_once("$srcdir/api.inc");
require_once("$srcdir/patient.inc");
require_once("$srcdir/options.inc.php");
?>
<!DOCTYPE html>
hello
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
	
	echo "1";
	$mysqli = new mysqli($host, $login, $pass, $dbase);
	$sql1 = "SELECT batch_id,".
		   "en_date, en_encounter, en_reason, en_pid".
		   " FROM openemr.billing_batch ".
		   "WHERE batch_id = '37' ".
		   "GROUP BY en_encounter"
			;
	echo $sql1;
	$result1 = $mysqli -> query ($sql1);

		while ($row1 = mysqli_fetch_array($result1)){
			$en_encounter_select = $row1['en_encounter']
			?>
	<form action="kraken_v2.php" method="post">
	<hr/>
<!-- Info Header -->
<div class="header3">	<h3><?php echo $row1['form_name'];?></h3>
	<div class="info">
<!-- Form Info -->
		<div class="panel panel-default">
			<span><b>Form ID:&nbsp;</b></span><?php echo $row1['frid'];?><br>
			<span><b>Ins:&nbsp;</b></span><?php echo $insurance;?>----<?php echo $billed;?>_-_<?php echo $row1['pl_policy_number'];?>
<!--//in.pid, in.provider AS inprovider, in.type, in.policy_number-->
			<span><br><b>Insurance:&nbsp;</b></span><?php echo $row['pl_provider'];?>-<?php echo $row['pl_plan_name'];?>-<?php echo $row['po_name'];?>-<?php echo $row['po_billing_code_type'];?>-Effective 
			Date:<?php echo $row['pldate'];?><br>
			<span><b>Encounter:&nbsp;</b></span><?php echo $row1['en_counter'];?>_<?php echo $fm_encounter;?>_<?php echo $en_encounter;?><br>
			<span><b>ID: </b><?php echo $row1['pid'] ?> <b>Name: </b></span><?php echo $row1['fname'] . '&nbsp' . $row1['mname'] . '&nbsp;' . $row1['lname'];?>
			&nbsp;<span><b>DOB:&nbsp;</b></span><?php echo $row1['dob'];?><br>
		
		</div>
	</div>
	<!--<br class="clr">-->
</div>		
			<?php
	
	$sql = "SELECT batch_id,".
		   "en_date, en_encounter, en_reason, en_pid, en_provider_id, en_facility, en_billing_note, en_last_level_billed, ".
			"fm_form_id, fm_form_name, fm_formdir, fm_encounter, ".
			"fr_frid, fr_pid, fr_service_code, fr_units, fr_diagnosis1, fr_diagnosis2, fr_diagnosis3, fr_diagnosis4, fr_created, fr_status, ". 
			"pl_pid, pl_provider, pl_type, pl_plan_name, pl_policy_number, pl_date, ".
			"po_id, po_name, po_billing_code_type, ".
			"pd_fname, pd_lname, pd_mname, pd_dob, pd_ss, pd_billing_note, pd_genericname1, pd_genericval1, pd_genericname2, pd_genericval2, ".
			"sa_authorization_number, sa_service_code, sa_service_name ".
			"FROM openemr.billing_batch ".
			"WHERE batch_id = '37' ".
			"AND en_encounter = '$en_encounter_select'"
			;
	echo $sql;
	$result = $mysqli -> query ($sql);

		while ($row = mysqli_fetch_array($result)){
				$form_id = $row['fm_form_id'];
				$fm_encounter = $row['fm_encounter'];
				$en_encounter = $row['en_encounter'];
				$f_billing_id = $row['fr_billing_id'];
				$provider_id = $row['fr_provider_id'];
				$pid = $row['en_pid'];
				$servicecode = $row['fr_service_code'];
				$units = $row['fr_units'];
				$billing_code_type = $row['po_billing_code_type'];
				$starttimestamp = strtotime(stripslashes($row{"fm_time_start"}));
				$endtimestamp = strtotime(stripslashes($row{"fm_time_end"}));
				$totaltime = abs($endtimestamp - $starttimestamp)/60;
	?>
	
<?php
$insurance_test2 = getInsuranceDataByDate($pid, (substr($row["date"], 0, 10)), "primary", "provider");

foreach($insurance_test2 as $key => $value) {
	$company = getInsuranceProvider($insurance_test2[$key]);
	echo $company; 
}
	
				
				
				
				
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
								
	//
		
	if ($row['fr_diagnosis1'] == ''){
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
			$diagmysqli = new mysqli($host, $login, $pass,$dbase);
			$diagresult = $diagmysqli -> query ($diagquery);
			while ($diagrow = mysqli_fetch_array($diagresult)) {
			  $diagrows[] = $diagrow;
			  $row['fr_diagnosis1'] =  $diagrow['diagnosis1'];
			  $row['fr_diagnosis2'] =  $diagrow['diagnosis2'];
			  $row['fr_diagnosis3'] =  $diagrow['diagnosis3'];
			  $row['fr_diagnosis4'] =  $diagrow['diagnosis4'];
			}
			mysqli_close($diagmysqli);
	}

		$justify1 = substr($row["fr_diagnosis1"], 0, strpos($row["fr_diagnosis1"], ' '));
		$justify2 = substr($row["fr_diagnosis2"], 0, strpos($row["fr_diagnosis2"], ' '));
		$justify3 = substr($row["fr_diagnosis3"], 0, strpos($row["fr_diagnosis3"], ' '));
		$justify4 = substr($row["fr_diagnosis4"], 0, strpos($row["fr_diagnosis4"], ' '));
		$justify5 = str_replace(':', '|', $justify1).":".str_replace(':', '|', $justify2).":".str_replace(':', '|', $justify3).":".str_replace(':', '|', $justify4).":";
		$diag1 = substr($row["fr_diagnosis1"], strpos($row["fr_diagnosis1"], ' ') +1);
		$diag2 = substr($row["fr_diagnosis2"], strpos($row["fr_diagnosis2"], ' ') +1);
		$diag3 = substr($row["fr_diagnosis3"], strpos($row["fr_diagnosis3"], ' ') +1);
		$diag4 = substr($row["fr_diagnosis4"], strpos($row["fr_diagnosis4"], ' ') +1);
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
<!--<form action="kraken_v2.php" method="post">-->
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

$result_existing_billing =  $mysqli -> query ($sql_existing_billing);
while ($row_existing_billing = mysqli_fetch_array($result_existing_billing)) 
{
echo "<div class='alert alert-danger'>";
echo "<b>Existing Billing: Date:</b> ". $row_existing_billing["date"]. "<b>Code Type:</b>". $row_existing_billing["code_type"]. "<b>Code:</b>". $row_existing_billing["code"]. "Modifier:</b>". $row_existing_billing["modifier"]. "<b>Description:</b>". $row_existing_billing["code_text"];
echo "<b>Units: </b>". $row_existing_billing["units"]. "<b>Fee : </b>$". $row_existing_billing["fee"]. "<b>Diag: </b>". $row_existing_billing["justify"]. "<b>Billed :</b>". $row_existing_billing["billed"];
echo "</div>";
}


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
	<?php

}
?>
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