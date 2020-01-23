<?php
include_once("../../../globals.php");
?>
<html>
<head>
	<meta charset="utf-8">
	<title>Provider Invoice Summary</title>
</head>
	<script src="<?php echo "$web_root";?>/library/js/jquery-ui-1.11.4/jquery-ui.js"></script>
	<link rel="stylesheet" href="<?php echo "$web_root";?>/library/css/bootstrap.min.css">
	<script src="<?php echo "$web_root";?>/library/js/bootstrap.min.js"></script>
	<script src="<?php echo "$web_root";?>/library/js/bootstrap-datepicker.js"></script>
	<!---->
	<script src="<?php echo "$web_root";?>/library/js/bt-datepicker.js"></script>
<BODY>
<FORM ACTION="payments_report.php" METHOD=POST id="PaymentInfo" name="PaymentInfo">
<br><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </b><br>
<br>Enter DOS Start Date:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<INPUT TYPE=DATE class="datepicker" data-date-format="yyyy/mm/dd" SIZE=117 NAME=start_date  style="width: 135px" required>&nbsp;&nbsp; Enter DOS End Date:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<INPUT TYPE=DATE class="datepicker" data-date-format="yyyy/mm/dd" SIZE=117 NAME=end_date  style="width: 135px" required> <br>
<!--
<br>Enter Modified Start Date:&nbsp;
<INPUT TYPE=DATE class="datepicker" data-date-format="yyyy/mm/dd" SIZE=117 NAME=mod_start_date  style="width: 135px"> &nbsp; Enter 
	Modified End Date:
<INPUT TYPE=DATE class="datepicker" data-date-format="yyyy/mm/dd" SIZE=117 NAME=mod_end_date  style="width: 135px"> <br>
-->
    <br>Please select provider:
     
	<?php
	//if (acl_check('acct', 'rep_a')) {
		// Build a drop-down list of providers.
		//
		$query = "select id, username, lname, fname from users where " .
			"authorized = 1 and active = '1' order by lname, fname";
		$res = sqlStatement($query);
		echo "<select name='provider' class='form-control' style='width: 265px' required>\n";
		echo "<option value=''>--" . xl('All Providers', 'e') . "--\n";
		while ($row = sqlFetchArray($res)) {
			$username = $row['username'];
			echo "    <option value='$username'";
			if ($username == $_POST['provider']) echo " selected";
			echo ">" . $row['lname'] . ", " . $row['fname'] . "\n";
		}
		echo "   </select>\n";
	//} else {
	//	echo "<input type='hidden' name='form_doctor' value='" . $_SESSION['authUserID'] . "'>";
	//}
?>
<br><br><br><br><br>
<input id="SignBtn" name="SignBtn" type="submit" value="Submit"  ><br><br>

</FORM>
