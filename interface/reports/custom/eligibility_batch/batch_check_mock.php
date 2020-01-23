<!--*******************************************************-->
<!--*******************************************************-->
<!--**                                                   **-->
<!--** Named in memory of Pipopo, aka Kraken.            **-->
<!--** When released, things happen, good and bad.       **-->
<!--** So be careful, when you 'Release The Kraken!'     **-->
<!--**                                                   **--> 
<!--*******************************************************-->
<!--*******************************************************-->
<?php
include_once("../../../globals.php");
require_once("$srcdir/patient.inc");
require_once("$srcdir/formatting.inc.php");
require_once("$srcdir/options.inc.php");
echo "<br>Number of Record:". count($_POST["pid"]);
echo $form_to_date;
for ($i = 0; $i < count($_POST["pid"]); ++$i)
				{
				//echo "<br>1 Form ID:". $_POST["form_id"][$i]. "<br>";
				//echo "<br>1 Encounter ID:". $_POST["en_encounter"][$i]. "<br>";
$pid = $_POST["pid"][$i];
$fname = $_POST["fname"][$i];
$lname = $_POST["lname"][$i];
$mname = $_POST["mname"][$i];
$dob = $_POST["dob"][$i];
$policy_number = $_POST["policy_number"][$i];
$api_code = $_POST["api_code"][$i];
$facility_name = $_POST["facility_name"][$i];
$facility_npi = $_POST["facility_npi"][$i];


echo "<br>Success2<br>";
echo "<br>", $pid;
echo "<br>", $fname;
echo "<br>", $lname;
echo "<br>", $mname;
echo "<br>", $dob;
echo "<br>", $policy_number;
echo "<br>", $api_code;
echo "<br>", $facility_name;
echo "<br>", $facility_npi;
}
?>
<form method="post" id="theForm" action="display_results.php">
<input type="hidden" name="tracking_id" value="15">
</form>
<script type="text/javascript">
document.getElementById('theForm').submit()
</script>
<!--
<script type="text/javascript">
function displayresults() {
				     window.location.href = 'display_results.php';
				     $('#progresswheel').show();
				  
				  }
</script>
<div id="progresswheel">
	<img height="32" src="ajax-loader.gif" width="32">
	</div>
<script type="text/javascript">
displayresults(); 
</script>
-->
