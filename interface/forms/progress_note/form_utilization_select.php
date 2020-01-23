<?php
$client_service_code = sqlQuery("SELECT pid, type, code_type, start_date, end_date from service_authorization WHERE pid = $pid AND type = 'patient' AND service_code = 'H02019HR' AND end_date >= '$dos[date]' AND start_date <= '$dos[date]' ");

?>
<head>
<meta content="en-us" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Untitled 1</title>
</head>

<body>
<h1>Utilization Report</h1>
<p>
<form action="form_utilization.php" method=post id="utilization_report" name="utilization_report">

	
Patient ID <input name="patient_id" type="text" />
<p>Select Fiscal Year: 
<select name="fiscal_year">
	<option></option>
	<option value="2015-07-01_2016-06-30">2015</option>
	<option value="2016-07-01_2017-06-30">2016</option>
	<option value="2017-07-01_2018-06-30">2017</option>
	<option value="2018-07-01_2019-06-30">2018</option>
	<option value="2019-07-01_2020-06-30">2019</option>
	<option value="2020-07-01_2021-06-30">2020</option>
	<option value="2021-07-01_2022-06-30">2021</option>
	<option value="2023-07-01_2024-06-30">2021</option>

</select>*(Required Field)
</p>
<p>
Select Program Enrollement: 
<select name="program">
	<option></option>
	<option value="day_services">Day Services</option>
	<option value="individual_therapy">Individual Therapy</option>
	
</select>
<p>
Select Service Provided: 
<select name="service_code">
	<option></option>
	<option value="H2017_form_psychosocial">Psycho Social Rehabilitation (H2017)</option>
	<option value="H2012_form_psychosocial">Day Treatment (H2012)</option>
	<option value="H2019HR_form_soap_pirc">Individual Therapy (H2019HR)</option>
	<option value="H2019HO_form_soap_pirc">TBOSS (H2019HO)</option>
</select>
*(Required Field)</p>
</p>

<td class='label'>
			   <?php xl('Provider','e'); ?>:
			</td>
			<td>
				<?php
				//if (acl_check('acct', 'rep_a')) {
					// Build a drop-down list of providers.
					//
					$query = "select id, lname, fname from users where " .
						"authorized = 1 order by lname, fname";
					$res = sqlStatement($query);
					echo "   &nbsp;<select name='form_doctor'>\n";
					echo "    <option value=''>-- " . xl('All Providers', 'e') . " --\n";
					while ($row = sqlFetchArray($res)) {
						$provid = $row['id'];
						echo "    <option value='$provid'";
						if ($provid == $_POST['form_doctor']) echo " selected";
						echo ">" . $row['lname'] . ", " . $row['fname'] . "\n";
					}
					echo "   </select>\n";
				//} else {
				//	echo "<input type='hidden' name='form_doctor' value='" . $_SESSION['authUserID'] . "'>";
				//}
			?>
			</td>
			<td>






<p>
<input id="SignBtn" name="SignBtn" type="submit" value="Submit"/>
</p>
</form>