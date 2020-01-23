hello
<div id="utilities">
<?php
include_once("../../globals.php");
$con = mysql_connect($host, $login, $pass); 
mysql_select_db($dbase, $con);





$dos = sqlQuery("select date from form_encounter where encounter=$encounter");
$client_service_code = sqlQuery("SELECT pid, type, code_type, start_date, end_date from service_authorization WHERE pid = $pid AND type = 'patient_code_type' AND end_date >= '$dos[date]' AND start_date <= '$dos[date]' ");
$client_insurance = sqlQuery("SELECT pid, provider, type, date FROM insurance_data WHERE pid = $pid AND type = 'primary' AND date <= '$dos[date]'");
$insurance_type = sqlQuery("SELECT id, name, billing_code_type FROM insurance_companies WHERE id = '$client_insurance[provider]'");
$yves1 = getInsuranceProvider('2735');
$yves = getInsuranceData($pid);
$client_service_code_authorized = sqlQuery("SELECT pid, service_code, units, type, code_type, start_date, end_date ".
										   "FROM service_authorization ". 
										   "WHERE pid = $pid AND type = 'patient' AND service_code = 'H2019HR' AND end_date >= '$dos[date]' AND start_date <= '$dos[date]' ");

$start_date = $client_service_code_authorized['start_date'];
$end_date = $client_service_code_authorized['end_date'];
$units_authorized = $client_service_code_authorized['units'];

//echo $end_date;
//echo $start_date;


?>


<!--	Treatment Plan Check	-->
			<div id="treatment_plan_alert_util">
							<?php
							//Treatment Plan Check
							echo "test";
							//$tpformid= stripslashes($obj{"tp_form_id"});
							$tpformid= = $_POST['tpformid'];
							$query_modality = sqlQuery("SELECT ".
										 			   "hcpt, modality, id, pid, start_date, end_date, IsDeleted ".
														"FROM form_treatment_plan_modalities ".
														//"JOIN forms AS fr ON fr.form_id = sp.id ".
														//"JOIN form_encounter AS en ON en.encounter = fr.encounter ".
												        //"JOIN patient_data AS p ON p.pid = sp.pid ".
														"WHERE form_id = '$tpformid' ". 
														"AND modality LIKE 'H2019HR%' ".
														"AND end_date >= '$dos[date]' AND start_date <= '$dos[date]' ".
														"AND IsDeleted = '0'")
												            ; 
							
							if ($query_modality['hcpt'] === NULL)
													{
														echo "<div class='alert alert-danger'><a href='#' class='close' data-dismiss='alert'>&times;</a>";
														echo "<strong><h4>oooooooooooooooWarning!</strong>Did not find service in Treatment Plan";
														echo "n". $query_modality['hcpt'];
														echo "0". $query_modality['modality'];
														echo "n". $query_modality['id'];
														echo "</h4></div>";
													}else {
														echo "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert'>&times;</a>";
														echo "<strong><h4>Exellent!</strong>Part of Treatment Plan";
														echo "n". $query_modality['modality'];
														echo "</h4></div>";
													 }
							
							?>
			</div>
</div>
