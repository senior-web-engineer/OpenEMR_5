<?php
include_once("../../globals.php");
include_once("$srcdir/api.inc");
$obj = formFetch("form_treatment_plan", $_GET["id"]);
?>


<head>
	<!-- jquery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
	<!-- bootstrap -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<!-- print -->
	<!--<link rel="stylesheet" href="print.css" >-->

	<link rel=stylesheet href="<?echo $css_header;?>" type="text/css">
    <link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/interface/themes/style-form-print.css" type="text/css">

	
	<meta content="en-us" http-equiv="Content-Language">
	<style type="text/css">
.auto-style1 {
	text-align: center;
	font-size: xx-large;
}
</style>
	<div class="auto-style1">
		<strong><h1>Treatment Plan - Under Construction!</h1>
</strong></div>
</head>

<body <?echo $top_bg_line;?> topmargin=0 rightmargin=0 leftmargin=2 bottommargin=0 marginwidth=2 marginheight=0>

<?php $res = sqlStatement("SELECT fname,mname,lname,ss,street,city,state,postal_code,phone_home,DOB,sex FROM patient_data WHERE pid = $pid");
$result = SqlFetchArray($res);
$ins = sqlQuery("SELECT provider,plan_name,type FROM insurance_data WHERE pid = $pid");
//$time = sqlQuery("SELECT pc_startime, pc_endtime FROM openemr_postcalendar_limits WHERE encounter=$encounter");
$dos = sqlQuery("select date from form_encounter where encounter=$encounter");
?>

<!-- Info Header -->
<div class="header">
	<div class="info">
<!-- PIRC Info -->
		<div class="pirc-info">
		PIRC Clinic<br>
		817 North Dixie Highway<br>
		Pompano Beach, Florida 33060<br>
		Tel: 954.785.8285 | Fax: 954.928.0040
		</div>
				
<!-- Form Info -->
		<div class="form-info">
			<span>Client Name:</span><?php echo $result['fname'] . '&nbsp' . $result['mname'] . '&nbsp;' . $result['lname'];?>
			<span>DOB:</span><?php echo $result['DOB'];?><br>
			<span>SS#:</span><?php echo $result['ss'];?>
			<span>Plan Date:</span><?php echo substr($dos["date"], 0, 10); ?><br>
<!--			<span>INSURANCE:</span><?php echo substr($ins["plan_name"], 0, 10) . '&nbsp;' . substr($ins["provider"], 0, 10); ?><br>-->
			<span>Age:</span><?php echo $result['age'];?>
			<span>Sex:</span><?php echo $result['sex'];?><br>
			<span>Admission Date:</span><?echo stripslashes($obj{"admit_date"});?>
			<span>Therapist:</span><?php echo $_SESSION['date'] ?><? echo stripslashes($obj{"provider"});?><br>
			<span>Time Started:</span><?echo stripslashes($obj{"timestart"});?>
			<span>End Time:</span><?echo stripslashes($obj{"timeend"});?><br>
		</div>
		<br class="clr">
	</div>
	<br class="clr">
	<h1>Treatment Plan</h1>
</div>
<!-- Notes -->
<body <?echo $top_bg_line;?> topmargin=0 rightmargin=0 leftmargin=2 bottommargin=0 marginwidth=2 marginheight=0>

<?php
	$db_name = "openemr";
	
	$connection = @mysql_connect("localhost", "root", "4050sierra") or die(mysql_error());
	$db = @mysql_select_db($db_name, $connection) or die(mysql_error());
	
	//$yves= "$_GET["id"]"; 
	//echo $yves;
	$id = 0 + (isset($_GET['formid']) ? $_GET['formid'] : 0);
	
	//---- Problems ----- 
	$sql = "SELECT tp.id, tp.Description AS tpdescription, tp.tp_problem_number AS tptp_problem_number, tp.form_id , tp.IsPrimary AS tpisrimary ".
			"FROM form_treatment_plan_problems AS tp ". 
			"WHERE tp.form_id = $id and (IsDeleted is Null or IsDeleted = 0) ".
			"ORDER BY tp.IsPrimary"
    		;
	$result = @mysql_query($sql,$connection) or die(mysql_error());
	while ($row = mysql_fetch_array($result)) {
		$problem_id 	  = $row['id'];
		$tpproblem_number = $row['tptp_problem_number'];
		$tpdescription    = $row['tpdescription'];
		$tpisprimary      = $row['tpisrimary'];
		
	  //echo "<b><h3>Problem#". $tpproblem_number . "</h3></b><ul><li class=''><h4>". $tpdescription . "</h4></li>";
	  if ($tpisprimary == "1") {
	  	 echo "<b><h3>Primary Problem: </h3></b><ul><li class=''><h4>". $tpdescription . "</h4></li>";

	  } else {
		 echo "<b><h3>Secondary Problem: </h3></b><ul><li class=''><h4>". $tpdescription . "</h4></li>";
	  }
		//---- Behavioral Definitions ----- 
		$sql2 = "SELECT bd.Description AS bddescription ".
				"FROM form_treatment_plan_behavioraldefinitions AS bd ".
				"WHERE bd.form_id = $id AND bd.problem_id = $problem_id and (IsDeleted is Null or IsDeleted = 0) ".
				"GROUP BY bddescription "
				;
		$result2 = @mysql_query($sql2,$connection) or die(mysql_error());
		$print = "";
		while ($row2 = mysql_fetch_array($result2)) { 
			$bddescription = $row2['bddescription'];
			$print .= "<li class=''>". $bddescription . "</li>";
		}
		if (strlen($print) > 0){
			echo "<li><b><h3>Definitions:</h3></b><ul>";
			echo $print;
			echo "</ul></li>";
		}

		//---- Goals ----- 
		$sql3 = "SELECT gl.Description AS gldescription ".
				"FROM form_treatment_plan_goals AS gl ".
				"WHERE gl.form_id = $id AND gl.problem_id = $problem_id and (IsDeleted is Null or IsDeleted = 0) ".
				"GROUP BY gldescription "
				;
		$result3 = @mysql_query($sql3,$connection) or die(mysql_error());
		$print = "";
		while ($row3 = mysql_fetch_array($result3)) { 
			$gldescription = $row3['gldescription'];
			$print .= "<li class=''>". $gldescription ."</li>";
		}
		if (strlen($print) > 0){
			echo "<li><b><h3>Goals:</h3></b><ul>";
			echo $print;
			echo "</ul></li>";
		}

		//---- Objectives ----- 
		$sql4 = "SELECT oj.id AS ojid, oj.Description AS ojdescription, oj.ObjectiveNumber AS ojObjectiveNumber, oj.target_date AS ojtarget_date ".
				"FROM form_treatment_plan_objectives AS oj ".
				"WHERE oj.form_id = $id AND oj.problem_id = $problem_id and (IsDeleted is Null or IsDeleted = 0) ".
				"ORDER BY oj.id"
				;
		$result4 = @mysql_query($sql4,$connection) or die(mysql_error());
		$print = "";
		while ($row4 = mysql_fetch_array($result4)) { 
			$ojdescription = $row4['ojdescription'];
			$objectivenumber = $row4['ojObjectiveNumber'];
			$ojtarget_date = $row4['ojtarget_date'];
			$ojid = $row4['ojid'];
			//$print .= "<li class=''><b>Objective:</b> ". $ojdescription . "<span> <b>Target Date:</b> ". $ojtarget_date. "</span></li>";
			//Changed 1/11/16 dnunez
			$print .= "<li class='row'><div class='col-md-1'><b>Objective:</b></div> <div class='col-md-4'>". $ojdescription . "</div><div class='col-md-2'><b>Target Date:</b></div> <div class='col-md-2'>". $ojtarget_date. "</div><div class='col-md-2'></div></li>";
			
			//*************INTERVENTIONS***************************************
			$sql5 = "SELECT it.form_id, it.Description AS itdescription, it.ObjectiveID AS itObjectiveID ".
					"FROM form_treatment_plan_interventions AS it ".
					"WHERE it.form_id = $id  AND it.ObjectiveID = $ojid and (IsDeleted is Null or IsDeleted = 0) ".
					"AND it.tp_problem_number = $tpproblem_number "
					;
			$result5 = @mysql_query($sql5,$connection) or die(mysql_error());
			$print2 = "";
			while ($row5 = mysql_fetch_array($result5)){ 
				$itdescription = $row5['itdescription'];
				$print2 .= "<li class=''>". $itdescription ."</li>";
			}
			if(strlen($print2) > 0){
				$print .= "<li><b><h4>Interventions:</h4></b><ul>";
				$print .= $print2;
				$print .= "</ul></li><br>";
			}
			//*************INTERVENTIONS*************************************** 
		}
		if (strlen($print) > 0){
			echo "<li><b><h3>Objectives:</h3></b><ul>";
			echo $print;
			echo "</ul></li>";
		}
		//------ Objectives -------
		
 		echo "</ul><br>";
	};
	//------ Problems ------
	
	//*************Diagnosis***************************************
	echo "<b><h3>Diagnosis: </h3></b><ul>";
			$sql6 = "SELECT da.form_id, da.Description AS dadescription ".
					"FROM form_treatment_plan_diagnosis AS da ".
					"WHERE da.form_id = $id ".
					"AND (IsDeleted is Null or IsDeleted = 0) "
					;
			$result6 = @mysql_query($sql6,$connection) or die(mysql_error());
			$print3 = "";
			while ($row6 = mysql_fetch_array($result6)){ 
				$dadescription = $row6['dadescription'];
				//$print3 .= "<li class=''>". $dadescription ."</li>";
			 echo "<li class=''>".$dadescription . "</li>";

			}
			
	
	
	
 
//****************************    END FORM **************************************
?>

 




 

