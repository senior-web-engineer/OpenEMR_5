<?php

include_once("../../../globals.php");
//include_once("$srcdir/api.inc");
//formHeader("Form: psychosocial");
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta charset="utf-8">
		<title>Kraken 1.2</title>
		<meta name="generator" content="OpenEMR" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link rel=stylesheet href="<?php echo $css_header;?>" type="text/css">
		<!-- stylesheets -->
		<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-3.3.7/css/bootstrap.min.css" type="text/css">
		<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-datepicker/bootstrap-datepicker.min.css" type="text/css">
		<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/library/css/bootstrap-sidebar.css" type="text/css">
		<!--[if lt IE 9]>
			<script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<!-- supporting javascript code -->
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-2.0.2.min.js"></script>
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-3.3.7/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-sidebar.js"></script>
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-datepicker.min.js"></script>


<!-- supporting javascript code 
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/textformat.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery.timeentry.package-1.4.9/jquery.timeentry.js"></script>-->



<script language="JavaScript">
function ActionDeterminator() {
  if(document.myform.form_selected[0].selected == true) {
    document.myform.action = 'kraken_psr_.php';
  }
  if(document.myform.form_selected[1].selected == true) {
    document.myform.action = 'kraken_progress_note.php';
    //document.myform.method = 'get';
  }
  if(document.myform.form_selected[2].selected == true) {
    document.myform.action = 'kraken_progress_note.php';
    //document.myform.method = 'get';
  }
  if(document.myform.form_selected[3].selected == true) {
    document.myform.action = 'kraken_progress_note.php';
    //document.myform.method = 'get';
  }
  if(document.myform.form_selected[4].selected == true) {
    document.myform.action = 'kraken_progress_note.php';
    //document.myform.method = 'get';
  }
  if(document.myform.form_selected[5].selected == true) {
    document.myform.action = 'kraken_progress_note.php';
    //document.myform.method = 'get';
  }
  if(document.myform.form_selected[6].selected == true) {
    document.myform.action = 'kraken_progress_note.php';
    //document.myform.method = 'get';
  }
  if(document.myform.form_selected[7].selected == true) {
    document.myform.action = 'kraken_psr.php';
    }
  if(document.myform.form_selected[8].selected == true) {
    document.myform.action = 'kraken_psr.php';
    }
  if(document.myform.form_selected[9].selected == true) {
    document.myform.action = 'kraken_progress_note.php';
   }
  if(document.myform.form_selected[10].selected == true) {
    document.myform.action = 'kraken_progress_note.php';
    }
  if(document.myform.form_selected[11].selected == true) {
    document.myform.action = 'kraken_progress_note.php';
    }
  if(document.myform.form_selected[12].selected == true) {
    document.myform.action = 'kraken_progress_note.php';
    }
    if(document.myform.form_selected[13].selected == true) {
    document.myform.action = 'kraken_progress_note.php';
    }
	 if(document.myform.form_selected[14].selected == true) {
    document.myform.action = 'kraken_progress_note.php';
    }



  return true;
}
</script>

	</head>

<BODY>

<form NAME="myform" ACTION="kraken_psr2.php" METHOD=POST TARGET="_blank" class="form-inline">

<div class="form-inline">
	<div class="form-group col-sm-6">
		<label for="start_date" class="col-sm-6 control-label">Enter DOS Start Date:</label>
		<div class="input-group date col-sm-6">
	  		<input name="start_date" type="text" class="form-control" data-date-format="MM/DD/YYYY" value=""><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
		</div>
		<!-- <INPUT TYPE=TEXT NAME=start_date VALUE="2017-04-01" class="form-control"> -->
	</div>
	<div class="form-group col-sm-6">
		<label for="end_date" class="col-sm-6 control-label">Enter DOS End Date:</label>
		<div class="input-group date col-sm-6">
	  		<input name="end_date" type="text" class="form-control" data-date-format="MM/DD/YYYY" value=""><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
		</div>
		<!--<INPUT TYPE=TEXT NAME=end_date VALUE="2017-05-01" class="form-control"> <br> -->
	</div>
</div>
<div class="form-inline">
	<div class="form-group col-sm-6">
		<label for="created_start_date" class="col-sm-6 control-label">Enter Created Date Starts:</label>
		<div class="input-group date col-sm-6">
	  		<input name="created_start_date" type="text" class="form-control" data-date-format="MM/DD/YYYY" value=""><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
		</div>
		<!--<INPUT TYPE=TEXT NAME=created_start_date VALUE="2017-04-01" class="form-control">&nbsp;&nbsp; <b> -->
	</div>
	<div class="form-group col-sm-6">
		<label for="created_end_date" class="col-sm-6 control-label">Enter Created Date Ends:</label>
		<div class="input-group date col-sm-6">
	  		<input name="created_end_date" type="text" class="form-control" data-date-format="MM/DD/YYYY" value=""><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
		</div>
		<!--<INPUT TYPE=TEXT NAME=created_end_date VALUE="2017-05-01" class="form-control"> <br><br> -->
	</div>
</div>
<div class="form-group col-sm-12">
	<label for="patientid" class="col-sm-3 control-label">Enter Patient ID:</label>
	<INPUT TYPE="text" NAME="patientid" class="form-control col-sm-3">
</div>
<div class="form-group col-sm-12">
	<label for="form_doctor" class="col-sm-3 control-label">Provider:</label>
	<?php
	//if (acl_check('acct', 'rep_a')) {
		// Build a drop-down list of providers.
		//
		$query = "select id, username, lname, fname from users where " .
			"authorized = 1 order by lname, fname";
		$res = sqlStatement($query);
		echo "<select name='form_doctor' class='form-control'>\n";
		echo "<option value=''>--" . xl('All Providers', 'e') . "--\n";
		while ($row = sqlFetchArray($res)) {
			$username = $row['username'];
			echo "    <option value='$username'";
			if ($username == $_POST['form_doctor']) echo " selected";
			echo ">" . $row['lname'] . ", " . $row['fname'] . "\n";
		}
		echo "   </select>\n";
	//} else {
	//	echo "<input type='hidden' name='form_doctor' value='" . $_SESSION['authUserID'] . "'>";
	//}
?>
</div>
<div class="form-group col-sm-12">
	<label for="form_selected" class="col-sm-3 control-label">Select Form:</label>
	<select name="form_selected" class="form-control">
	        <option value="">-----</option>
	        <option value="form_progress_note_ind">Progress Notes - IND</option>
	        <option value="form_progress_note_psr">Progress Notes - PSR</option>
			<option value="form_progress_note_day">Progress Notes - DAY</option>
			<option value="form_progress_note_grp">Progress Notes - GRP</option>
			<option value="form_progress_note_ori">Progress Notes - ORI</option>
			<option value="form_progress_note_tbo">Progress Notes - TBO</option>
	        <option value="form_soap_pirc">SAOP Notes</option>
	        <option value="form_psychosocial">PSR Notes</option>
	        <option value="form_med_management">Med Management</option>
	        <option value="form_assessment_cmh">Assessment - Old Form</option>
	        <option value="form_fars">FARS</option>
			<option value="form_cfars">CFARS</option>
			<option value="form_treatment_plan">Treatment Plan</option>
			<option value="form_treatment_plan_review">Treatment Plan Review</option>




	
	</select>
</div>
<div class="form-group col-sm-12">
	<label for="form_status" class="col-sm-3 control-label">Form Status Completion Status:</label>
	<select name="form_status" class="form-control">
	        <option value="">-----</option>
	        <option value="Ready for Billing/Supervisor">Ready for 
			Billing/Supervisor</option>
			<option value="Ready for Billing">Ready for Billing</option>
			<option value="Ready for Review">Ready for Review</option>
	        <option value="In Progress">In Progress</option>
	</select>
</div>
<div class="form-group col-sm-12">
	<label for="form_billing_status" class="col-sm-3 control-label">Form Billing Status:</label>
	<select name="form_billing_status" class="form-control">
	        <option value="">-----</option>
	        <option value="Not Billed">Not Billed</option>
	        <option value="Billed">Billed</option>
	</select>
</div>
<div class="form-group col-sm-12">
	<label for="encounter_already_billed" class="col-sm-3 control-label">Encounter Billing Status:</label>
	<select name="encounter_already_billed" class="form-control">
	        <option value="">-----</option>
	        <option value="0">Encounter Not Yet Billed</option>
	        <option value="1">Encounter Already Billed</option>
	</select>
</div>
<div class="form-group col-sm-12">
	<label for="billing_code_type" class="col-sm-3 control-label">Insurance Billing Code Type:</label>
	<select name="billing_code_type" class="form-control">
	        <option value="">-----</option>
	        <option value="HCPCS">HCPCS - Medicaid and MMA's</option>
	        <option value="CPT4">Medicare and Most Commercial</option>
	</select>
</div>

<!--<input id="SignBtn" name="SignBtn" type="submit" value="Submit"  ><br><br>-->
<input type="submit" value="Run Report" class="btn btn-primary" onClick="return ActionDeterminator();">
</form>
<script language="javascript">
$('.input-group.date').datepicker({
    format: 'yyyy-mm-dd',
    todayHighlight: true
});
</script>

</BODY>
</html>
