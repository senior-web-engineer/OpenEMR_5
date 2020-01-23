<html>
<head>
	<meta charset="utf-8">
	<title>Provider Invoice Summary</title>


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
include_once("../../../globals.php");
?>

<?php
$mysqli = new mysqli($host, $login, $pass, $dbase);
$start_date = "$_REQUEST[start_date]";
$end_date = "$_REQUEST[end_date]";
$mod_start_date = "$_REQUEST[mod_start_date]";
$mod_end_date = "$_REQUEST[mod_end_date]";
$provider = "$_REQUEST[provider]";
echo "<br>BILLING:<br>";
echo "<table><td class='style4'>Provider</td><td class='style4'>DOS</td> <td class='style4'>Last Name</td><td class='style4'>First Name</td> <td class='style4'>M. Initial</td><td class='style4'>PID</td><td class='style4'> Encounter</td><td class='style4'>ServiceCode</td><td class='style4'>Fee</td> <td class='style4'>Units</td></tr>";

$sqlBilling = "SELECT ". 
   "b.pid, b.encounter, b.code, b.modifier, b.fee, b.units, b.code_type ".
   ",pd.fname, pd.lname, pd.mname ". 
   ",en.date, en.provider_id ". 
   ",u.id, u.username ".
   //", u.lname, u.fname ".	
   "FROM billing AS b ".
   "JOIN patient_data AS pd ON pd.pid = b.pid ".
   "JOIN form_encounter AS en ON en.encounter = b.encounter ". 
   "JOIN users AS u ON u.id = en.provider_id ".
   "AND en.date between '$start_date' AND '$end_date' ".
   //"AND ar.post_time between '$mod_start_date' AND '$mod_end_date' ".
    "AND u.username LIKE '$provider' ".
	"AND (b.code_type LIKE 'CPT4' OR b.code_type LIKE 'HCPCS') ".
	    
	//"AND ar.pid LIKE '206' ".
   "ORDER BY u.username, b.pid, en.date "
   ;
   //echo $sqlSelect;
$result = $mysqli -> query ($sqlBilling);
		while ($row1 = mysqli_fetch_array($result))
{
 $rows1[] = $row1;
 $pid = $row1['pid'];
 $encounter = $row1['encounter'];
 $code = $row1['code'];
 $modifier = $row1['modifier'];
 $fee = $row1['fee'];
 $units = $row1['units'];
 //$modified_time = $row['modified_time'];
 //$post_time = $row['post_time'];
 //$memo = $row['memo'];
echo "<tr><td class='style1'>". strtoupper($row1['username'])."</td><td class='style1'>". substr($row1['date'],0,10)."</td><td class='style1'>".ucwords(strtolower($row1['lname']))."</td><td class='style1'>".ucwords(strtolower($row1['fname']))."</td><td class='style1'>".$row1['mname']."</td><td class='style1'>".$row1['pid']."</td><td class='style1'>".$row1['encounter']."</td><td class='style1'>".$row1['code'].$row1['modifier']."</td> <td class='style1'>".$row1['fee']."</td> <td class='style1'>".substr($row1['units'],0,10)."</td>" ;
}
echo "</tr></td></table>";
echo "<br>PAYMENTS:<br>";
echo "<table><td class='style4'>Provider</td><td class='style4'>DOS</td> <td class='style4'>Last Name</td><td class='style4'>First Name</td> <td class='style4'>M. Initial</td><td class='style4'>PID</td><td class='style4'> Encounter</td><td class='style4'>ServiceCode</td><td class='style4'>Paid</td> <td class='style4'>Date Posted</td><td class='style4'>Memo</td></tr>";

$sqlSelect = "SELECT ". 
   "ar.pid, ar.encounter, ar.code, ar.modifier, ar.pay_amount, ar.modified_time, ar.post_time, memo ".
   ",pd.fname, pd.lname, pd.mname ". 
   ",en.date, en.provider_id ". 
   ",u.id, u.username ".
   //", u.lname, u.fname ".	
   "FROM ar_activity AS ar ".
   "JOIN patient_data AS pd ON pd.pid = ar.pid ".
   "JOIN form_encounter AS en ON en.encounter = ar.encounter ". 
   "JOIN users AS u ON u.id = en.provider_id ".
   //"WHERE ar.sequence_no = '1' " .
   // "WHERE ar.pay_amount = '1' " .
   "AND en.date between '$start_date' AND '$end_date' ".
  // "AND ar.post_time between '$mod_start_date' AND '$mod_end_date' ".
    "AND u.username LIKE '$provider' ".
    "AND ar.pay_amount NOT LIKE '0.00' ".
	//"AND ar.pid LIKE '206' ".
   "ORDER BY u.username, ar.pid, en.date "
   ;
   //echo $sqlSelect;
$result = $mysqli -> query ($sqlSelect);
		while ($row = mysqli_fetch_array($result))
{
 $rows[] = $row;
 $pid = $row['pid'];
 $encounter = $row['encounter'];
 $code = $row['code'];
 $modifier = $row['modifier'];
 $pay_amount = $row['pay_amount'];
 $modified_time = $row['modified_time'];
 $post_time = $row['post_time'];
 $memo = $row['memo'];
echo "<tr><td class='style1'>". strtoupper($row['username'])."</td><td class='style1'>". substr($row['date'],0,10)."</td><td class='style1'>".ucwords(strtolower($row['lname']))."</td><td class='style1'>".ucwords(strtolower($row['fname']))."</td><td class='style1'>".$row['mname']."</td><td class='style1'>".$row['pid']."</td><td class='style1'>".$row['encounter']."</td><td class='style1'>".$row['code'].$row['modifier']."</td> <td class='style1'>".$row['pay_amount']."</td> <td class='style1'>".substr($row['post_time'],0,10)."</td> <td class='style1'>".$row['memo']."" ;
echo "<br />";
}
echo "</tr></td></table>";

?>
