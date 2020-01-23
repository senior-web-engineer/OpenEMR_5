<!DOCTYPE html>
<html>
<head>
<style type="text/css">
body{
	font-family: 'trebuchet ms', verdana, arial;
	font-size: 16px;
}
table {
	background-color: #fff;
    margin: 10px 0 15px;
    text-align: left;
    border-spacing: 0;
}
th, td {
    border: #cdcdcd 1px solid;
}
th {background: #99bfe6}
tbody tr:nth-child(even) {background: #FFF}
tbody tr:nth-child(odd) {background: #ebf2fa}
tbody tr:hover {
  background: #cdcdcd;
}
</style>
</head>
<?php
include_once("../../globals.php");
$con = mysql_connect($host, $login, $pass); 
mysql_select_db($dbase, $con);
$patient_id = "$_POST[patient_id]";
$fiscal_year_starts = substr("$_POST[fiscal_year]" ,0, 10);
$fiscal_year_ends = substr("$_POST[fiscal_year]" ,-10, 10);
$service_code = substr("$_POST[service_code]", 0, strpos("$_POST[service_code]", "_"));
$service_form = substr("$_POST[service_code]", strpos("$_POST[service_code]", "_") + 1);
$program = "$_POST[program]";
$provider_id = "$_POST[form_doctor]";
$debug = "no";//Debug
echo "<br>";


if ($patient_id == ""){
		$patient_select = "";
						} else {
								$patient_select = "AND sp.pid = '$patient_id' ";
					  }

if ($provider_id) {
          $provider_select = " AND (p.providerID = '$provider_id' OR p.group_providerID = '$provider_id') ";
					} else {
							  $provider_select = "";
				  }

if ($program) {
          $program_select = " AND (p.program_0 = '$program' OR p.program_1 = '$program') ";
				} else {
							  $program_select = "";
			  }

 
switch ($service_code) {
	case "H2012":
		$units = '190';
		break;
	case "H2019HR":
		$units = '104';
		break;
	case "H2017":
		$units = '1920';
		break;
}
if ($debug == "yes"){
echo $patient_id;
echo "<br>";
echo $fiscal_year_starts;
echo "<br>";
echo $fiscal_year_ends;
echo "<br>";
echo $service_code;
echo "<br>";
echo $service_form;
echo "<br>";
echo $units;
echo "<br>";
echo "<br>";
echo $patient_id;
echo "<br>";
echo "PATIENT SELECT";
echo $patient_select;
echo "<br>";
echo "PROVIDER:";
echo $provider_id;
}
		
?>

<body>
<h1>Utilization Report</h1>
<h4>For info and estimate only:</h4>
<table class="style3">

<thead>
<tr>
	<th>Patient ID</th>
	<th>Patient Name</th>
	<th>Service Code</th>
	<th>Description/As Billed By Provider</th>
	
	<th>Units Billed</th>
<!--<th>Date Info</th>-->
	<th>Allowed Units</th>
	<th>Remaining Units</th>
</tr>
</thead>
<tbody>

<?php
// Make a MySQL Connection

//$query = "SELECT ".
//		"sp.pid, sp.servicecode, sp.units, sp.encounter, sp.date ". 
//		",fr.id, fr.form_id, fr.date, fr.encounter ".
//		",en.encounter, en.date ".
//		",SUM(sp.units) ". 
//		"FROM form_soap_pirc as sp ".
//		"JOIN forms AS fr ON fr.form_id = sp.id AND fr.pid = sp.pid ".
//		"JOIN form_encounter AS en ON en.encounter = fr.encounter ".
//		"WHERE sp.servicecode = 'H2019HR' ".
//		"AND en.date < '2016/07/01' ".
//		"AND en.date >= $fiscal_year ". 
//		"AND sp.pid = $pid ".
//		"GROUP BY sp.servicecode "
//		
//
//		; 
$query = "SELECT ".
	 	"p.pid, p.lname, p.fname, p.program_0, p.program_1, p.providerID, sp.pid, sp.servicecode, sp.units, sp.encounter, sp.date ".
					",fr.id, fr.form_id, fr.date, fr.encounter ".
					",en.encounter, en.date ".
					",SUM(sp.units) ".
					"FROM $service_form as sp ".
					"JOIN forms AS fr ON fr.form_id = sp.id AND fr.pid = sp.pid ".
					"JOIN form_encounter AS en ON en.encounter = fr.encounter ".
			        "JOIN patient_data AS p ON p.pid = sp.pid ".
					"WHERE sp.servicecode LIKE '$service_code' ".
			        "AND fr.deleted = 0 ".
					"AND en.date BETWEEN '$fiscal_year_starts' AND '$fiscal_year_ends' ".
//					"AND sp.pid BETWEEN 1 AND 3000 ".
//					"AND sp.pid = '$patient_id' ".
					$patient_select .
					$provider_select .
					$program_select .
			        "AND (p.program_0 = '$program' ".
			        "OR p.program_1 = '$program') ".
					"GROUP BY p.pid ".
					"ORDER BY p.lname"
			        ; 
	 
	 
$result = mysql_query($query) or die(mysql_error());

// Print out result
while($row = mysql_fetch_array($result)){
			$first_number = $units; 
			$second_number = ($row['SUM(sp.units)']);
			$sum_total = $first_number - $second_number;
			


	echo "<tr><td>".$row['pid']. "</td><td>". $row['lname']. ", ". $row['fname']. "<td> ". $row['servicecode']. "</td>". "</td><td>Unit(s) of service for ". $row['servicecode']. ", used for fiscal year <b>". substr("$_POST[fiscal_year]" ,0, 4). " :</b> </td> ". "<td><b>". $row['SUM(sp.units)']. "</td><td>". $units;
//	echo "</td><td>". ($sum_total). "</td>";	
if ($sum_total > 0){
		echo "</td><td>". ($sum_total). "</td>";
						} else {
								echo "</td><td> <strong><em>". ($sum_total). "*</strong></em><strong><em> Out Of Units</em></strong>
</td>";
					   };

	echo "</tr>";
}


?>
<script>
    document.write('<a href="' + document.referrer + '">Go Back</a>');
</script>

</tbody>
</table>


</body>
</html>

