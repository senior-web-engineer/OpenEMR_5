<?php
include_once("../../../globals.php");
include_once("$srcdir/api.inc");
require_once("$srcdir/patient.inc");
require_once("$srcdir/options.inc.php");
?>
<?php
$dos_start = '2018-07-01';
$dos_end = '2018-07-10';
$mysqli = new mysqli($host, $login, $pass, $dbase);

$sql = "SELECT e.encounter, e.date AS edate, e.reason, e.pid, e.provider_id,". 
	"f.user, f.form_name, f.pid, f.formdir, f.encounter ".
 	"FROM form_encounter AS e ".
	"LEFT JOIN forms AS f ON f.encounter = e.encounter AND f.pid = e.pid ".
    "WHERE formdir = 'newpatient' ".
    "AND e.date BETWEEN '$dos_start' AND '$dos_end' ".
    "LIMIT 50";
    //echo $sql;
    $result = $mysqli -> query ($sql);
		while ($row = mysqli_fetch_array($result)){
				$dos = $row['edate'];
				$encounter = $row['encounter'];
				$pid = $row['pid'];
				$user = $row['user'];
				$formdir = $row['formdir'];
		echo $dos ." ". $pid." ".$encounter." ".$user." ".$formdir. "<br>";
		?>
		<?php
		//
		//Ensert conditions here
		//
		$sql_forms = "SELECT f.user, f.form_name, f.pid, f.formdir, f.encounter, ".
						"fr.service_code, fr.units ".
						"FROM forms AS f ".
						"JOIN 'form_'formdir AS fr ".
						"WHERE f.encounter = $encounter ".
						"AND formdir != 'newpatient' ".
						"AND formdir = 'progress_note' "
						;
			echo $sql_forms;
			$result_forms = $mysqli -> query ($sql_forms);
			while ($row_forms = mysqli_fetch_array($result_forms)){
				$form_name = $row_forms['form_name'];
			echo $form_name."<br>";
			
			}
		?>
		<?php

		
		
		
		
		
		
		
		
		
		}
		
		
?>
