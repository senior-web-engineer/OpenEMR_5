<div id="utilities">
<?php
include_once("../../globals.php");

$tpformid = $_POST['tpformid'];
$con = mysql_connect($host, $login, $pass); 
mysql_select_db($dbase, $con);
$service_code = $_POST['service_code'];




$dos = sqlQuery("select date from form_encounter where encounter=$encounter");
$client_service_code = sqlQuery("SELECT pid, type, code_type, start_date, end_date from service_authorization WHERE pid = $pid AND type = 'patient_code_type' AND end_date >= '$dos[date]' AND start_date <= '$dos[date]' ");
$client_insurance = sqlQuery("SELECT pid, provider, type, date FROM insurance_data WHERE pid = $pid AND type = 'primary' AND date <= '$dos[date]'");
$insurance_type = sqlQuery("SELECT id, name, billing_code_type FROM insurance_companies WHERE id = '$client_insurance[provider]'");
$yves1 = getInsuranceProvider('2735');
$yves = getInsuranceData($pid);
//Display Alerts-------------------------------------------------------------------------------------------------------
		
		
					if (($client_service_code["code_type"]) != ($insurance_type["billing_code_type"]))
						{
							echo "<div class='alert alert-danger'><a href='#' class='close' data-dismiss='alert'>&times;</a>";
							echo "<strong><h4>Warning!</strong>There is a mismatch between insurance and client code type";
							echo "<br><b>Primary Insurance Provider:</b>". $insurance_type["name"]. "&nbsp; ". $insurance_type["billing_code_type"];
							echo "<br><b>Client Service Code Type:</b>". $client_service_code["code_type"];
							echo "<br><b>Insurance:</b>". $client_insurance["provider"];
							echo "</h4></div>";
							
						}
//End of Allerts-------------------------------------------------------------------------------------------------------	

//echo "<br> yves1:". $yves1;
//echo "<br> yves:". $yves;
//echo "<br> yves():". $yves['provider'];
//echo "<br> yves2():". getInsuranceProvider($yves['provider']);

//echo "<br>";
$client_service_code_authorized = sqlQuery("SELECT pid, service_code, units, type, code_type, start_date, end_date ".
										   "FROM service_authorization ". 
										   "WHERE pid = $pid AND type = 'patient' AND service_code = '$service_code%' AND end_date >= '$dos[date]' AND start_date <= '$dos[date]' ");

$start_date = $client_service_code_authorized['start_date'];
$end_date = $client_service_code_authorized['end_date'];
$units_authorized = $client_service_code_authorized['units'];

//echo $end_date;
//echo $start_date;

$query_auth = "SELECT ".
	 		  "p.pid, p.lname, p.fname, sp.pid, sp.service_code, sp.units, sp.date ".
					",fr.id, fr.form_id, fr.date, fr.encounter ".
					",en.encounter, en.date ".
					",SUM(sp.units) ".
						"FROM form_progress_note as sp ".
						"JOIN forms AS fr ON fr.form_id = sp.id ".
						"JOIN form_encounter AS en ON en.encounter = fr.encounter ".
				        "JOIN patient_data AS p ON p.pid = sp.pid ".
						"WHERE sp.service_code LIKE '$service_code%' ".
				        "AND fr.deleted = 0 ".
						"AND en.date BETWEEN '$start_date' AND '$end_date' ".
						"AND sp.pid = $pid ".
						"GROUP BY p.pid ".
						"ORDER BY p.lname"
			        ; 
	; 
	 
$result_auth = mysql_query($query_auth) or die(mysql_error());

// Print out result
while($row = mysql_fetch_array($result_auth)){
			$first_number = $units_authorized; 
			$second_number = ($row['SUM(sp.units)']);
			$remaining_units = $first_number - $second_number;
//	echo "<br>first_number:". $first_number. "<br>second_number:". $second_number. "<br>sum_total<br>". $sum_total. "<br>";		
}
if ($units_authorized < $second_number)
						{
							echo "<div class='alert alert-danger'><a href='#' class='close' data-dismiss='alert'>&times;</a>";
							echo "<strong><h4>Warning!</strong>No units available for this service";
							echo "<br><b>Units Authorized:</b>". $first_number;
							echo "<br><b>Units Used:</b>". $second_number;
							echo "</h4></div>";
						}elseif ($remaining_units > 0 && $remaining_units < 5 ){
							echo "<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert'>&times;</a>";
							echo "<strong><h4>Warning!</strong>Low units available for this service";
							echo "<br><b>Units Authorized:</b>". $first_number;
							echo "<br><b>Units Used:</b>". $second_number;
							echo "<br><b>Units Remaining:</b>". $remaining_units;
							echo "</h4></div>";
						 }

							
?>
<div id="treatment_plan_util">
<?php						


						//$service_code = $_POST['service_code'];
							
							if ($tpformid == ''){
							$tpformid= stripslashes($obj{"tp_form_id"});
												}
							//echo $tpformid;
							$query_modality = sqlQuery("SELECT ".
										 			   "hcpt, modality, id, pid, start_date, end_date, IsDeleted ".
														"FROM form_treatment_plan_modalities ".
														"WHERE form_id = $tpformid ". 
														"AND modality LIKE '$service_code%' ".
														"AND end_date >= '$dos[date]' AND start_date <= '$dos[date]' ".
														"AND IsDeleted = '0'")
												            ; 
							
							if ($query_modality['hcpt'] === NULL)
													{
														echo "<div class='alert alert-danger'><a href='#' class='close' data-dismiss='alert'>&times;</a>";
														echo "<strong>Warning!</strong>Did not find service in Treatment Plan";
														echo "n". $query_modality['hcpt'];
														echo "0". $query_modality['modality'];
														echo "n". $query_modality['id'];
														echo $service_code. "</div>";
													}else {
														echo "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert'>&times;</a>";
														echo "<strong>Exellent!</strong>mmmPart of Treatment Plan";
														echo "n". $query_modality['modality'];
														echo $service_code. "</div>";
													 }

?>
							
</div>
			