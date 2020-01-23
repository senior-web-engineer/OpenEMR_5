<?php
include_once("../../../globals.php");
include_once("$srcdir/api.inc");
require_once("$srcdir/patient.inc");
require_once("$srcdir/options.inc.php");
?>
<?php
$dos_start = '2018-07-01';
$dos_end = '2018-07-30';
$billable_forms = " 'progress_note',".
			   "'psychiatric_evaluation',".
			   "'med_management',".
			   "'treatment_plan',".
			   "'brief_mental_health_status',".
			   "'cfars',".
			   "'assessment_cmh'"



			   ;
//$billable_forms = "'psychiatric_evaluation'"
			   ;

			   
$mysqli = new mysqli($host, $login, $pass, $dbase);

$sql = "SELECT * FROM view_encounter_form ".
		"WHERE date BETWEEN '$dos_start' AND '$dos_end' ".
		"LIMIT 150 "
		;
    //echo $sql;
    $result = $mysqli -> query ($sql);
		while ($row = mysqli_fetch_array($result)){
				$dos = $row['date'];
				$encounter = $row['eencounter'];
				$pid = $row['epid'];
				$user = $row['user'];
				$formdir = $row['formdir'];
		echo "<br>_______________________________________________________________<br>";
		echo $dos ." ". $pid." ".$encounter." ".$user." ".$formdir. "<br>";
					$sql_forms = "SELECT * FROM view_form ".
							"WHERE encounter = $encounter ".
							"AND deleted = '0' ".
							"AND formdir IN ($billable_forms) "
							;
						$result_forms = $mysqli -> query ($sql_forms);
						while ($row_forms = mysqli_fetch_array($result_forms)){
							$form_name = $row_forms['form_name'];
						echo "<b>".$form_name."</b><br>";
							$form_selected = "form_".$row_forms['formdir'];
							$form_id = $row_forms['form_id'];
							if($form_selected == 'form_progress_note'){
								$extra_fields =",diagnosis1, diagnosis2, diagnosis3, diagnosis4";
								}else{
								$extra_fields ="";
								}
							if($form_selected =='form_fars'){
								$form_selected = 'form_cfars';
								}
									$sql_fr = "SELECT units, service_code, status ". 
													"$extra_fields ".
													"FROM $form_selected ".
													"WHERE id = $form_id "
													;
													//echo $sql_fr;
													$result_fr = $mysqli -> query ($sql_fr);
													while ($row_fr = mysqli_fetch_array($result_fr)){
													echo $row_fr['service_code'] .
													" ". $row_fr['units']."<br>".
													" ". $row_fr['diagnosis1']."<br>".
													" ". $row_fr['diagnosis2']."<br>".
													" ". $row_fr['diagnosis3']."<br>".
													" ". $row_fr['diagnosis4']."<br>".
													" ". $row_fr['status'].
													"<br>_______________________________________________________________<br>";
				}
			
			}

					
		
	}	
