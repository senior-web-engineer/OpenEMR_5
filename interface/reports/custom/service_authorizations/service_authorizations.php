<?php

include_once("../../../globals.php");
//include_once("$srcdir/api.inc");
//formHeader("Form: psychosocial");
?>

<!DOCTYPE html>
<html lang="en">
<title>Service Authorizations</title>

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


</head>

<body>

<p>
<form NAME="myform" ACTION="kraken_psr2.php" METHOD=POST TARGET="_blank" class="form-inline">

<div class="form-inline">

<div class="form-group col-sm-12">
   <label for="client" class="col-sm-3 control-label">Select Client:</label>
	 <select name="client" class="form-control">
		<option></option>
		<option value="1">AMY NUNEZ</option>
		<option value="831">SELENA HENRY</option>
	</select>
</div>


<div class="form-group col-sm-12">
   <label for="service_code" class="col-sm-3 control-label">Enter Service Code:</label>
	<select name="service_code" class="form-control">
		<option></option>
		<option value="H2019HR">H2019HR Individual Therapy</option>
		<option value="H2017">H2017 Psycho Social Rehabilitation(PSR)</option>
		<option value="H2019HO">H2019HO TBOSS</option>
	</select>
</div>
<div class="form-group col-sm-12">
	<label for="units" class="col-sm-3 control-label">Allowed Units:</label>
	<INPUT TYPE="number" NAME="units" class="form-control col-sm-3" style="width: 50px">
</div>

<div class="form-inline">
	<div class="form-group col-sm-6">
		<label for="start_date" class="col-sm-6 control-label">Enter Start Date:</label>
		<div class="input-group date col-sm-6">
	  		<input name="start_date" type="text" class="form-control" data-date-format="MM/DD/YYYY" value=""><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
		</div>
	</div>
	<div class="form-group col-sm-6">
		<label for="end_date" class="col-sm-6 control-label">Enter End Date:</label>
		<div class="input-group date col-sm-6">
	  		<input name="end_date" type="text" class="form-control" data-date-format="MM/DD/YYYY" value=""><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
		</div>
	</div>
</div>

</div>


</form>
<script language="javascript">
$('.input-group.date').datepicker({
    format: 'yyyy-mm-dd',
    todayHighlight: true
});
</script>

</BODY>
</html>


