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
    <script type="text/javascript" src="SigWebTablet.js"></script>

	<link rel=stylesheet href="<?php echo $css_header;?>" type="text/css">
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

<body <?php echo $top_bg_line;?> topmargin=0 rightmargin=0 leftmargin=2 bottommargin=0 marginwidth=2 marginheight=0>

<?php $res = sqlStatement("SELECT fname,mname,lname,ss,street,city,state,postal_code,phone_home,DOB,sex FROM patient_data WHERE pid = $pid");
$result = SqlFetchArray($res);
$ins = sqlQuery("SELECT provider,plan_name,type FROM insurance_data WHERE pid = $pid");
//$time = sqlQuery("SELECT pc_startime, pc_endtime FROM openemr_postcalendar_limits WHERE encounter=$encounter");
$dos = sqlQuery("select date from form_encounter where encounter=$encounter");
?>

<!-- Info Header -->
<div class="header">
	<div class="info">
<!-- FACILITY Info -->
		<?php 
		$facility = sqlQuery("SELECT name,phone,fax,street,city,state,postal_code FROM facility WHERE facility_code = 'Print'");
		?>
		<div class="facility-info">
		<?php echo $facility['name']?><br>
		<?php echo $facility['street']?><br>
		<?php echo $facility['city']?>, <?php echo $facility['state']?> <?php echo $facility['postal_code']?><br>
		Tel: <?php echo $facility['phone']?> | Fax: <?php echo $facility['fax']?>
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
			<span>Admission Date:</span><?php echo stripslashes($obj{"admit_date"});?>
			<span>Therapist:</span><?php echo $_SESSION['date'] ?><?php echo stripslashes($obj{"provider"});?><br>
			<span>Time Started:</span><?php echo stripslashes($obj{"timestart"});?>
			<span>End Time:</span><?php echo stripslashes($obj{"timeend"});?><br>
		</div>
		<br class="clr">
	</div>
	<br class="clr">
	<h1>Treatment Plan</h1>
</div>
<!-- Notes -->
<body <?php echo $top_bg_line;?> topmargin=0 rightmargin=0 leftmargin=2 bottommargin=0 marginwidth=2 marginheight=0>

<?php
	//$db_name = "openemr";
	
	//$connection = @mysql_connect("localhost", "root", "4050") or die(mysql_error());
	//$db = @mysql_select_db($db_name, $connection) or die(mysql_error());
	$connection = new mysqli($host, $login, $pass, $dbase) or die($connection->connect_error());
	//$db = @mysql_select_db($db_name, $connection) or die(mysql_error());

	
	
	//$yves= "$_GET["id"]"; 
	//echo $yves;
	$id = 0 + (isset($_GET['formid']) ? $_GET['formid'] : 0);
	$id = '2571';
	echo $id;
	//*************Diagnosis***************************************
	echo "<b><h3>Diagnosis: </h3></b>";
			$sql6 = "SELECT da.form_id, da.Description AS dadescription ".
					"FROM form_treatment_plan_diagnosis AS da ".
					"WHERE da.form_id = $id ".
					"AND (IsDeleted is Null or IsDeleted = 0) "
					;
			//$result = $mysqli -> query ($sqlSelect);
		
			$result6 = $connection->query($sql6) or die($connection->connect_error());
			$print3 = "";
			while ($row6 = mysqli_fetch_array($result6)){ 
				$dadescription = $row6['dadescription'];
				//$print3 .= "<li class=''>". $dadescription ."</li>";
			 echo "<li class=''>".$dadescription . "</li>";

			}
			

	
	//---- Problems ----- 
	$sql = "SELECT tp.id, tp.Description AS tpdescription, tp.tp_problem_number AS tptp_problem_number, tp.form_id , tp.IsPrimary AS tpisrimary ".
			"FROM form_treatment_plan_problems AS tp ". 
			"WHERE tp.form_id = $id and (IsDeleted is Null or IsDeleted = 0) ".
			"ORDER BY tp.IsPrimary"
    		;
	//$result = @mysql_query($sql,$connection) or die(mysql_error());
	$result = $connection->query($sql) or die($connection->connect_error());
	while ($row = mysqli_fetch_array($result)) {
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
		//$result2 = @mysql_query($sql2,$connection) or die(mysql_error());
		$result2 = $connection->query($sql2) or die($connection->error);
		$print = "";
		while ($row2 = mysqli_fetch_array($result2)) { 
			$bddescription = $row2['bddescription'];
			$print .= "<li class=''>". $bddescription . "</li>";
		}
		if (strlen($print) > 0){
			echo "<ul><li><b><h3>Definitions:</h3></b><ul>";
			echo $print;
			echo "</ul></li></ul>";
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
			echo "<ul><li><b><h3>Goals:</h3></b><ul>";
			echo $print;
			echo "</ul></li></ul>";
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
				$print .= "<li><b><h3>Interventions:</h3></b><ul>";
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
		
		
		//*************Modalities***************************************
	echo "<b><h3>Modalities: </h3></b><ul>";
			$sql7 = "SELECT mo.form_id, mo.start_date AS mostart_date, mo.end_date AS moend_date, mo.hcpt AS mohcpt, mo.intervals AS mointervals, mo.frequency AS mofrequency, mo.provider AS moprovider, mo.modality AS momodality ".
					"FROM form_treatment_plan_modalities AS mo ".
					"WHERE mo.form_id = $id AND mo.problem_id = $problem_id and (IsDeleted is Null or IsDeleted = 0) ".
					"AND mo.tp_problem_number = $tpproblem_number "

					;
			$result7 = @mysql_query($sql7,$connection) or die(mysql_error());
			$print3 = "";
			while ($row7 = mysql_fetch_array($result7)){ 
				$mostart_date  = $row7['mostart_date'];
				$moend_date  = $row7['moend_date'];
				$momodality  = $row7['momodality'];
				$mohcpt      = $row7['mohcpt'];
				$mointervals = $row7['mointervals'];
				$mofrequency = $row7['mofrequency'];
				$moprovider  = $row7['moprovider'];
				
				//$print3 .= "<li class=''>". $dadescription ."</li>";
			 echo "<li class=''><b>Starting: </b>".$mostart_date ."<b> Ending: </b>".$moend_date ."<br><b> Service Description: </b>".$momodality . "<b> CPT\HCPCS Code: </b>".$mohcpt . "<b> Interval: </b>".$mointervals . "<b> Frequency: </b>".$mofrequency . "<br><b> Responsible Provider: </b>".$moprovider ."</li><br>";

			}

		
		
		
		
		
		
		
		
		
 		echo "</ul><br>";
	};
	//------ Problems ------
	
	//*************Modalities***************************************
	echo "<b><h3>Modalities: </h3></b><ul>";
			$sql7 = "SELECT mo.form_id, mo.modality AS momodality ".
					"FROM form_treatment_plan_modalities AS mo ".
					"WHERE mo.form_id = $id ".
					"AND (IsDeleted is Null or IsDeleted = 0) "
					;
			$result7 = @mysql_query($sql7,$connection) or die(mysql_error());
			$print3 = "";
			while ($row7 = mysql_fetch_array($result6)){ 
				$momodality = $row7['momodality'];
				//$print3 .= "<li class=''>". $dadescription ."</li>";
			 echo "<li class=''>".$momodality . "</li>";

			}
			
	
	
	
 
//****************************    END FORM **************************************

?>
<?php
//include_once("$srcdir/api.inc");

//$obj = formFetch("form_soap_pirc", $_GET["id"]);
//$obj = $formid ? formFetch("form_treatment_plan", $formid) : array();
$obj = $formid ? formFetch("form_treatment_plan", $formid) : array();
?>

	<div class="style5">

<!-- HEADER2 -->
<div class="header2"></div>
<br>
<br>
<h1>SIGNATURE PAGE</h1>
	<!-- Signature -->


	</div>
<form method=post action="<?php echo $rootdir?>/forms/treatment_plan/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="SigForm" id="SigForm">


<?php /* From New */ ?>
<!--
<?php $res = sqlStatement("SELECT fname,mname,lname,ss,street,city,state,postal_code,phone_home,DOB FROM patient_data WHERE pid = $pid");
$result = SqlFetchArray($res); 

echo $formid;

?>
<!--
Encounter#:<?php echo $encounter; ?><input type="hidden" name="encounter" id="encounter" value="<?php echo $encounter; ?>" readonly="readonly">(System use only)
<?php echo "hello". $_GET["id"];?>
<INPUT NAME="signatureid" id="signatureid" value="<?php echo $formid;?>">
-->
<script type="text/javascript" src="SigWebTablet.js"></script>
<SCRIPT language="Javascript">
// required for textbox date verification
    var Index;
  	var tmr;	   
	var tmr1;
	
	    

		      function onReturnSampleSig1()
					{
					 	SetSigCompressionMode(1);
					 	SetTabletState(0, tmr);
					 	var ctx1 = document.getElementById('sigplus1').getContext('2d'); 
					 	   SetDisplayXSize( 500 );
						   SetDisplayYSize( 100 );
						   SetJustifyMode(0);      
						   ClearTablet();
						   tmr = SetTabletState(1, ctx1, 50) || tmr;
     					var mySig1 = "<?php echo  stripslashes($obj{"patient_signature"});?>";
	   						SetSigString(mySig1, ctx1);
	   				}

          	  function onReturnSampleSig2()
					{
					 	SetSigCompressionMode(1);
					 	SetTabletState(0, tmr);
					 	var ctx2 = document.getElementById('sigplus2').getContext('2d'); 
					 	   SetDisplayXSize( 500 );
						   SetDisplayYSize( 100 );
						   SetJustifyMode(0);      
						   ClearTablet();
						   tmr = SetTabletState(1, ctx2, 50) || tmr;
     					var mySig2 = "<?php echo  stripslashes($obj{"guardian_signature"});?>";
	   						SetSigString(mySig2, ctx2);
	   				}
				
			  function onReturnSampleSig3()
					{
					 	SetSigCompressionMode(1);
					 	SetTabletState(0, tmr);
					 	var ctx3 = document.getElementById('sigplus3').getContext('2d'); 
					 	   SetDisplayXSize( 500 );
						   SetDisplayYSize( 100 );
						   SetJustifyMode(0);      
						   ClearTablet();
						   tmr = SetTabletState(1, ctx3, 50) || tmr;
     					var mySig3 = "<?php echo  stripslashes($obj{"provider_signature"});?>";
	   						SetSigString(mySig3, ctx3);
	   				}
	   				
              function onReturnSampleSig4()
					{
					 	SetSigCompressionMode(1);
					 	SetTabletState(0, tmr);
					 	var ctx4 = document.getElementById('sigplus4').getContext('2d');
                           SetDisplayXSize( 500 );
						   SetDisplayYSize( 100 );
						   SetJustifyMode(0);    
						   ClearTablet();
						   tmr = SetTabletState(1, ctx4, 50) || tmr;
					 	var mySig4 = "<?php echo  stripslashes($obj{"supervisor_signature"});?>";
	   						SetSigString(mySig4, ctx4);
                     }
                     
              function onReturnSampleSig5()
					{
					 	SetSigCompressionMode(1);
					 	SetTabletState(0, tmr);
					 	var ctx5 = document.getElementById('sigplus5').getContext('2d'); 
					 	   SetDisplayXSize( 500 );
						   SetDisplayYSize( 100 );
						   SetJustifyMode(0);      
						   ClearTablet();
						   tmr = SetTabletState(1, ctx5, 50) || tmr;
     					var mySig5 = "<?php echo  stripslashes($obj{"physician_signature"});?>";
	   						SetSigString(mySig5, ctx5);
	   				}
	   				
          
       		  function onReturnSampleSigAll()
        			{
	        			onReturnSampleSig5();
						setTimeout(function(){
							onReturnSampleSig4();		
							setTimeout(function(){
								onReturnSampleSig3();
								setTimeout(function(){
									onReturnSampleSig2();
									setTimeout(function(){
										onReturnSampleSig1();
										
									},1000);
								},1000);
							},1000);
						},1000);
        			}

 							
	

</script>


<p class="clr">I, the patient or the patient's guardian reviewed and agreed to participate in the interventions identified in the Individualized Treatment Plan Review that is in <?php echo $facility['name']?> electronic medical records system (Open EMR). </p>
	
		
<br>

<body onload="onReturnSampleSigAll()">
	<!--PATIENT SIGNATURE-->

<canvas id="sigplus1" width="400" height="80">

</canvas>

<br>

<label class="description" for="patient_print_name"> </label>
			<div>
				<label>Client:&nbsp;</label><?php echo stripslashes($obj{"patient_print_name"});?>
				<label>&nbsp;Signature Date:&nbsp;</label><?php echo stripslashes($obj{"patient_signature_date"});?>
			</div>
			<br>
			<br>
<hr style="width: 610px; height: -12px">
<!--END OF PATIENT SIGNATURE-->
<!-- GUARDIAN SIGNATURE-->
<canvas id="sigplus2" width="400" height="80">

</canvas>

<br>
<label class="description" for="guardian_print_name"> </label>
			<div>
				<label>Guardian:&nbsp;</label><?php echo stripslashes($obj{"guardian_print_name"});?>
				<label>&nbsp;Signature Date:&nbsp;</label><?php echo stripslashes($obj{"guardian_signature_date"});?>
			</div>
		
<!--END OF GUARDIAN SIGNATURE-->

	
	<hr style="width: 610px; height: -12px">

  <tr>
    <td height="10" width="500">
<canvas id="sigplus3" width="400" height="80">

</canvas>
<br>
<label class="description" for="provider_print_name"> </label>


			<div>
				<label>Clinician:&nbsp;</label><?php echo stripslashes($obj{"provider_print_name"});?>,&nbsp; <?php echo stripslashes($obj{"provider_credentials"});?>
				<label>&nbsp;Signature Date:&nbsp;</label><?php echo stripslashes($obj{"provider_signature_date"});?>
				<br>
	</div>
	
				
				<br>
			<hr style="width: 610px; height: -12px">	
			
			
			<tr>
    <td height="10" width="500">
<canvas id="sigplus4" width="400" height="80">
</canvas>

<br>

<label class="description" for="supervisor_print_name"> </label>
			<div>
				<label>Supervisor:&nbsp;</label><?php echo stripslashes($obj{"supervisor_print_name"});?>,&nbsp;<?php echo stripslashes($obj{"supervisor_credentials"});?>
				<label>&nbsp;Signature Date:&nbsp;</label><?php echo stripslashes($obj{"supervisor_signature_date"});?> 
				<br>
			</div>
				<hr style="width: 610px; height: -12px">
			<div>
				
				<br>
				
<br>

<canvas id="sigplus5" width="400" height="80">

</canvas>
<br>


<label class="description" for="supervisor_print_name"> </label>
			<div>
				<label>Physician:&nbsp;</label><?php echo stripslashes($obj{"physician_print_name"});?>,&nbsp;<?php echo stripslashes($obj{"physician_credentials"});?>
				<label>&nbsp;Signature Date:&nbsp;</label><?php echo stripslashes($obj{"physician_signature_date"});?> 
				<br>
			</div>
				
<br>
						
				
<hr style="width: 659px">	
						
	