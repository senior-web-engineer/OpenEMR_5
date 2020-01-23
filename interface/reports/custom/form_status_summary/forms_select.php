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
		<title>Forms Report Summary</title>
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
<?php
$userrights = sqlQuery("select info from users where username='" . $_SESSION{"authUser"} . "'");
//$userrights['info'] = '';
//echo "User Rights:". $userrights['info']."<br>";

?>


<script language="JavaScript">
function ActionDeterminator() {
		  if(document.myform.form_selected[0].selected == true) {
		    document.myform.action = 'form_summary.php.php';
		  }
			
		  if(document.myform.form_selected[1].selected == true) {
		    document.myform.action = 'form_summary.php.php';
		    //document.myform.method = 'get';
		  }
 

  }
  return true;
}
</script>

	</head>

<BODY>

<form NAME="myform" ACTION="form_summary.php" METHOD=POST TARGET="_blank" class="form-inline">

<div class="form-inline">
	<div class="form-group col-sm-6">
		<label for="start_date" class="col-sm-6 control-label">Enter DOS Start Date:</label>
		<div class="input-group date col-sm-6">
	  		<input name="start_date" type="text" class="form-control" data-date-format="MM/DD/YYYY" value="" required><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
		</div>
		<!-- <INPUT TYPE=TEXT NAME=start_date VALUE="2017-04-01" class="form-control"> -->
	</div>
	<div class="form-group col-sm-6">
		<label for="end_date" class="col-sm-6 control-label">Enter DOS End Date:</label>
		<div class="input-group date col-sm-6">
	  		<input name="end_date" type="text" class="form-control" data-date-format="MM/DD/YYYY" value="" required><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
		</div>
		<!--<INPUT TYPE=TEXT NAME=end_date VALUE="2017-05-01" class="form-control"> <br> -->
	</div>
</div>
<div class="form-group col-sm-12">
	<br><label for="form_doctor" class="col-sm-3 control-label">Provider:</label>
	<?php
	//echo "<br>1:".$_SESSION["authUser"]."<br>";
	$currentuser = $_SESSION["authUser"];
	//echo "<br>2:".$_SESSION["info"]."<br>";
	//echo "<br>3:".$_POST['form_doctor']."<br>";

	//if (acl_check('acct', 'rep_a')) {
		// Build a drop-down list of providers.
		//
	If ($userrights['info'] == 'reviewer'){
				$query = "select id, username, lname, fname from users where " .
				"authorized = 1 order by lname, fname";
			}else{
				$query = "select id, username, lname, fname from users where " .
			"username = '$currentuser' AND authorized = 1 order by lname, fname";

				}
		//echo $query;
		$res = sqlStatement($query);
		echo "<select name='form_doctor' class='form-control' >\n";
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
	<br><label for="form_selected" class="col-sm-3 control-label">Select Form:</label>
	<select name="form_selected" class="form-control" required>
	        <option value="">-----</option>
	        <option value="form_progress_note">Progress Note</option>
	      	<option value="form_treatment_plan">Treatment Plan/Review</option>
	</select>
</div>
<!--<input id="SignBtn" name="SignBtn" type="submit" value="Submit"  ><br><br>-->
<br>
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
