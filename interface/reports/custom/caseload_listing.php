 

<head>

<style type="text/css">
.style1 {
	border-left: 2px solid #C0C0C0;
	border-right-style: solid;
	border-right-width: 1px;
	border-top: 2px solid #C0C0C0;
	border-bottom-style: solid;
	border-bottom-width: 1px;
	background-color: #CCCCCC;
}
.style3 {
	border-style: solid;
	border-width: 1px;
}
.style4 {
	border-left: 2px solid #C0C0C0;
	border-right-style: solid;
	border-right-width: 1px;
	border-top: 2px solid #C0C0C0;
	border-bottom-style: solid;
	border-bottom-width: 1px;
	background-color: #99CCFF;
}
</style>
</head>

<table style="width: 60%" class="style3">

<?php

require_once("../../globals.php");
// require_once("$srcdir/patient.inc");
// require_once("$srcdir/formatting.inc.php");
// require_once("$srcdir/options.inc.php");
?>
<span class="title"><?php echo xlt('My Caseload Listing'); ?></span>
<?php
echo "<td class='style4'>Count</td><td class='style4'>Patient ID</td><td class='style4'>Last Name</td><td class='style4'>First Name</td><td class='style4'>DOB</td><td class='style4'>Provider ID</td> <td class='style4'>Provider</td></tr>";

$db_name = "openemr";
$provider = $_SESSION["authId"];
$connection = new mysqli($host, $login, $pass, $dbase); 
//echo $provider;
$sql = "SELECT ". 
   "pd.pid, pd.fname, pd.lname, pd.mname, pd.dob, pd.providerid, patient_active ". 
   ",u.id, u.username ".
   "FROM patient_data AS pd ".
   "JOIN users AS u ON u.id = pd.providerid ".
   "WHERE pd.providerid='$provider' ".
   "AND pd.patient_active = 'YES' ".
   "ORDER BY pd.lname, pd.fname "
   ;
//echo $sql;
$result = $connection -> query ($sql) ;
$count = 1;
//$result = @mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysqli_fetch_array($result)) 
{
//echo "<tr><td class='style1'>".$count."</td><td class='style1'><a target='_blank' href='../../patient_file/summary/demographics.php?set_pid=". ucwords(strtolower($row['pid'])) ."'>". ucwords(strtolower($row['pid']))."</a></td><td class='style1'>". ucwords(strtolower($row['lname']))."</td><td class='style1'>". ucwords(strtolower($row['fname']))."</td><td class='style1'>".$row['dob']."</td><td class='style1'>".$provider."</td><td class='style1'>".$row['username']. " " ;
echo "<tr><td class='style1'>".$count."</td><td class='style1'>". ucwords(strtolower($row['pid'])) ."</a></td><td class='style1'>". ucwords(strtolower($row['lname']))."</td><td class='style1'>". ucwords(strtolower($row['fname']))."</td><td class='style1'>".$row['dob']."</td><td class='style1'>".$provider."</td><td class='style1'>".$row['username']. " " ;

echo "<br />";
$count = $count + 1;
}

//echo "$display_block_details";

?>
