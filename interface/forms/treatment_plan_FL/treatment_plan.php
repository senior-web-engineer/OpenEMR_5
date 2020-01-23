<?php
include_once("../../globals.php");
include_once("$srcdir/api.inc");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>Treatment Plan/Review - Print Form</title>
		<meta name="generator" content="OpenEMR" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link rel=stylesheet href="<?php echo $css_header;?>" type="text/css">
		<!-- stylesheets -->
		<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-3.3.7/css/bootstrap.min.css" type="text/css">
		<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-datepicker/bootstrap-datepicker.min.css" type="text/css">
		<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/interface/themes/style-form-print.css" type="text/css">
		<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/interface/themes/bootstrap_reset.css" type="text/css" media="screen" charset="utf-8">
		<!--[if lt IE 9]>
			<script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<!-- supporting javascript code -->
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-2.0.2.min.js"></script>
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-3.3.7/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-sidebar.js"></script>
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-datepicker.min.js"></script>
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery.columnizer.js" charset="utf-8"></script>
		<!-- Sig Script -->
		<script type="text/javascript" src="SigWebTablet.js"></script>
		<!-- SQL/PHP queries -->
		<?php $res = sqlStatement("SELECT fname,mname,lname,ss,sex,DOB,pid FROM patient_data WHERE pid = $pid");
		$result = SqlFetchArray($res); 
		$provider_results = sqlQuery("select fname, mname, lname from users where username='" . $_SESSION{"authUser"} . "'");
		$rendering_provider = sqlQuery("SELECT u.fname, u.mname, u.lname FROM (SELECT provider_id FROM form_encounter where encounter='$encounter') AS e LEFT JOIN (SELECT fname, mname, lname, id FROM  users) AS u ON e.provider_id = u.id");
		$dos = sqlQuery("select date from form_encounter where encounter=$encounter");
		$obj = formFetch("form_treatment_plan", $_GET["id"]);
		?>
		<!--PHP Signature-->
		<INPUT TYPE="HIDDEN" NAME="signatureid" id="signatureid" value="<?php echo $formid;?>">
	
		<style type="text/css">
		.page{ width: 692px; height: 937px; margin: 20px; position: relative; page-break-after:always;}
		.page .content {min-height: 700px;}
		.page .content .column{ text-align:left ; font-size: 10pt; }
		.page .content .column blockquote{ border-left: 2px solid #999999; background: #DEDEDE; padding: 10px; margin: 4px 20px; clear: both; }
		.page .content .column img{ float: left; margin: 10px; }
		.page .content .column p{ padding: 0 10px; margin: 10px 0; }
		.page .content .column h1{ padding: 0 10px; }
		.page .header{ text-align: center; font-size: 18pt; font-family: helvetica, arial; padding: 0px 0 0; }
		.page .header hr, .page .footer hr{ width: 400px; }
		.page .footer{ text-align: center; }
		.page .footer span{ position: absolute; bottom: 10px; right: 10px; }
		.page_template{ display: none; }
		
		.enclosure {border:1px dashed black}
		</style>

		<script>
			$(function(){
				var content_height = 700;	// the height of the content, discluding the header/footer
				var page = 1;				// the beginning page number to show in the footer
				function buildNewsletter(){
					if($('#newsletterContent').contents().length > 0){
						// when we need to add a new page, use a jq object for a template
						// or use a long HTML string, whatever your preference
						$page = $(".page_template:first").clone().addClass("page").css("display", "block");
						
						// fun stuff, like adding page numbers to the footer
						$page.find(".footer span").append(page);
						$("body").append($page);
						page++;
						
						// here is the columnizer magic
						$('#newsletterContent').columnize({
							columns: 1,
							target: ".page:last .content",
							overflow: {
								height: content_height,
								id: "#newsletterContent",
								doneFunc: function(){
									console.log("done with page");
									buildNewsletter();
								}
							}
						});
					}
				}
				setTimeout(buildNewsletter, 3000);
			});
		</script>
		<script language="JavaScript">
			// required for textbox date verification
			var mypcc = '<?php echo $GLOBALS['phone_country_code'] ?>';
			
			$(function() {
			    $('input:checkbox').attr('disabled', true);
			    $('input:radio').attr('disabled', true);
			    $('input:text').attr('disabled', true);
			    $('select').attr('disabled', true);
			});
		</script>
		<script language="Javascript">
		// Sig Script
		    var Index;
		  	var tmr;	   
			var tmr1;
			var cursig=0;
			    
		
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
			   				
		           	//  function onReturnSampleSigAll()
		        	//		{
		        	//		onReturnSampleSig3();
					//			setTimeout(function(){
					//		onReturnSampleSig4();		
					//			setTimeout(function(){
					//		onReturnSampleSig5();
					//				},1000);
					//			},1000);
		
		        	//		}
		        			            
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
	</head>

<body>
<form method=post action="<?php echo $rootdir?>/forms/psychiatric_evaluation/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="my_form">

<div class="page_template">  
<!--ORIGINAL HEADER	<div class='header'>This is a header<hr></div>   -->
	<div class='header'>
	<!-- Info Header -->
		<?php $obj = $formid ? formFetch("form_treatment_plan", $formid) : array();?>
		<h1>Treatment Plan <?php if(($obj{"service_code"}) == "H0032TS") {echo "Review";} ?></h1>
		<div class="info">
	<!-- FACILITY Info -->
		<?php 
		$facility = sqlQuery("SELECT name,attn,phone,fax,street,city,state,postal_code FROM facility WHERE facility_code = 'Print'");
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
				<span>Date of Service:</span><?php echo substr($dos["date"], 0, 10); ?><br>
				<span>Admission Date:</span><?php echo stripslashes($result{"admit_date"});?>
				<span>Clinician:</span><?php echo $rendering_provider["fname"].' '.$rendering_provider["mname"].' '.$rendering_provider["lname"]; ?><br>
				<span>Sex:</span><?php echo $result['sex'];?>
				<span>Referral Source:</span><?php echo $obj['referral_source'];?><br>				
			</div>
			<br class="clr">
		</div>
	<hr></div>  
	<div class='content'></div>  
	<div class='footer'><hr><span>Page: </span><?php echo $facility['attn']?></div>  
</div> 
<div id="newsletterContent">

	<form>
		<div id="content" class="form-group group">
			<?php
				
				$id = 0 + (isset($_GET['formid']) ? $_GET['formid'] : 0);
				
				//*************Diagnosis***************************************
				echo "<h3>Diagnosis: </h3>";
						$sql6 = "SELECT da.form_id, da.Description AS dadescription ".
								"FROM form_treatment_plan_diagnosis AS da ".
								"WHERE da.form_id = $id ".
								"AND (IsDeleted is Null or IsDeleted = 0) "
								;
						$result6=sqlStatement($sql6);
						$print3 = "";
						while ($row6 = sqlFetchArray($result6)){ 
						       $dadescription = $row6['dadescription'];
							   //echo "<span>".$dadescription . "</span>";
						       echo "<li class=''>".$dadescription . "</li>";
						}
						
			
				
				//---- Problems ----- 
				$sql = "SELECT tp.id, tp.Description AS tpdescription, tp.tp_problem_number AS tptp_problem_number, tp.form_id , tp.IsPrimary AS tpisrimary ".
						"FROM form_treatment_plan_problems AS tp ". 
						"WHERE tp.form_id = $id and (IsDeleted is Null or IsDeleted = 0) ".
						"ORDER BY tp.IsPrimary"
			    		;
				$result = sqlStatement($sql);
				while ($row = sqlFetchArray($result)) {
					$problem_id 	  = $row['id'];
					$tpproblem_number = $row['tptp_problem_number'];
					$tpdescription    = $row['tpdescription'];
					$tpisprimary      = $row['tpisrimary'];
					
				  //echo "<b><h3>Problem#". $tpproblem_number . "</h3></b><ul><li class=''><h4>". $tpdescription . "</h4></li>";
				  if ($tpisprimary == "1") {
				  	 echo "<h3>Primary Problem: </h3><h4>". $tpdescription . "</h4>";
			
				  } else {
					 //echo "<div class='header2'></div>";
			
					 echo "<h3>Secondary Problem: </h3><h4>". $tpdescription . "</h4>";
				  }
					//---- Behavioral Definitions ----- 
					$sql2 = "SELECT bd.Description AS bddescription ".
							"FROM form_treatment_plan_behavioraldefinitions AS bd ".
							"WHERE bd.form_id = $id AND bd.problem_id = $problem_id and (IsDeleted is Null or IsDeleted = 0) ".
							"GROUP BY bddescription "
							;
					$result2 = sqlStatement($sql2);
					$print = "";
					while ($row2 = sqlFetchArray($result2)) { 
						$bddescription = $row2['bddescription'];
						$print .= "<span>". $bddescription . "</span>";
					}
					if (strlen($print) > 0){
						echo "<h4>Definitions:</h4>";
						echo $print;
						echo "";
					}
			
					//---- Goals ----- 
					$sql3 = "SELECT gl.Description AS gldescription, gl.goal_status AS glgoal_status, gl.goal_action AS glgoal_action, gl.review_status AS glreview_status ".
							"FROM form_treatment_plan_goals AS gl ".
							"WHERE gl.form_id = $id AND gl.problem_id = $problem_id and (IsDeleted is Null or IsDeleted = 0) ".
							"GROUP BY gldescription "
							;
					$result3 = sqlStatement($sql3);
					$print = "";
					$print_review = "";
					while ($row3 = sqlFetchArray($result3)) { 
						$gldescription = $row3['gldescription'];
						$goalaction = $row3['glgoal_action'];
						$goalstatus = $row3['glgoal_status'];
						$goalreviewstatus = $row3['glreview_status'];
						$print .= "<span>". $gldescription ."</span>";
						$print_review .= "<span>". $gldescription ."</span><h4>Status: </h4>". $goalstatus ."<h4>Goal Action: </h4>".$goalaction."<h4>Status Description: </h4>".$goalreviewstatus."";
						$print_review2 .= "<h4>Status: </h4>". $goalstatus ."<h4>Goal Action: </h4>".$goalaction."<h4>Status Description: </h4>".$goalreviewstatus."" ;
					}
					if (strlen($print) > 0){
						echo "<h3>Goals:</h3>";
						echo $print_review;
						echo "";
					}
			
					//---- Objectives ----- 
					$sql4 = "SELECT oj.id AS ojid, oj.Description AS ojdescription, oj.ObjectiveNumber AS ojObjectiveNumber, oj.target_date AS ojtarget_date ".
							"FROM form_treatment_plan_objectives AS oj ".
							"WHERE oj.form_id = $id AND oj.problem_id = $problem_id and (IsDeleted is Null or IsDeleted = 0) ".
							"ORDER BY oj.id"
							;
					$result4 = sqlStatement($sql4);
					$print = "";
					while ($row4 = sqlFetchArray($result4)) { 
						$ojdescription = $row4['ojdescription'];
						$objectivenumber = $row4['ojObjectiveNumber'];
						$ojtarget_date = $row4['ojtarget_date'];
						$ojid = $row4['ojid'];
						//$print .= "<li class=''><b>Objective:</b> ". $ojdescription . "<span> <b>Target Date:</b> ". $ojtarget_date. "</span></li>";
						//Changed 1/11/16 dnunez
						$print .= "<div id='' class='form-group group dontsplit'><h4>Objective: </h4>". $ojdescription . "<b>Target Date:</b>". $ojtarget_date. "</div>";
						
						//*************INTERVENTIONS***************************************
						$sql5 = "SELECT it.form_id, it.Description AS itdescription, it.ObjectiveID AS itObjectiveID ".
								"FROM form_treatment_plan_interventions AS it ".
								"WHERE it.form_id = $id  AND it.ObjectiveID = $ojid and (IsDeleted is Null or IsDeleted = 0) ".
								"AND it.tp_problem_number = $tpproblem_number "
								;
						$result5 = sqlStatement($sql5);
						$print2 = "";
						while ($row5 = sqlFetchArray($result5)){ 
							$itdescription = $row5['itdescription'];
							$print2 .= "<span>". $itdescription ."</span>";
						}
						if(strlen($print2) > 0){
							$print .= "<h4>Interventions:</h4>";
							$print .= $print2;
							$print .= "";
						}
						//*************INTERVENTIONS*************************************** 
					}
					if (strlen($print) > 0){
						echo "<h3>Objectives:</h3>";
						echo $print;
						echo "";
					}
					//------ Objectives -------
					
					
					
				};

				//*************Modalities***************************************
				echo "<div id='' class='form-group group dontsplit'><h3>Modalities: </h3>";
						$sql7 = "SELECT mo.form_id, mo.start_date AS mostart_date, mo.end_date AS moend_date, mo.hcpt AS mohcpt, mo.intervals AS mointervals, mo.frequency AS mofrequency, mo.provider AS moprovider, mo.modality AS momodality ".
								"FROM form_treatment_plan_modalities AS mo ".
								"WHERE mo.form_id = $id ".
								"AND (IsDeleted is Null or IsDeleted = 0) ";
						$result7 = sqlStatement($sql7);
						$print3 = "";
						while ($row7 = SqlFetchArray($result7)){ 
							$mostart_date  = $row7['mostart_date'];
							$moend_date  = $row7['moend_date'];
							$momodality  = $row7['momodality'];
							$mohcpt      = $row7['mohcpt'];
							$mointervals = $row7['mointervals'];
							$mofrequency = $row7['mofrequency'];
							$moprovider  = $row7['moprovider'];
							
							//$print3 .= "<li class=''>". $dadescription ."</li>";
						 echo "<b>Starting: </b>".$mostart_date ."<b> Ending: </b>".$moend_date ."<br><b> Service Description: </b>".$momodality . "<b> CPT\HCPCS Code: </b>".$mohcpt . "<b> Interval: </b>".$mointervals . "<b> Frequency: </b>".$mofrequency . "<br><b> Responsible Provider: </b>".$moprovider ."<br>";
						}
				echo "</div>";	
				
				//*************Modality Note***************************************
				echo "<div id='' class='form-group group dontsplit'><h3>Modalities Note: </h3>";
						$sql8 = "SELECT mo.form_id, mo.notes AS monotes ".
								"FROM form_treatment_plan_modalitynotes AS mo ".
								"WHERE mo.form_id = $id ".
								"AND (IsDeleted is Null or IsDeleted = 0) "
								;
						$result8 = sqlStatement($sql8);
						$print3 = "";
						while ($row8 = SqlFetchArray($result8)){ 
							$monotes = $row8['monotes'];
							//$print3 .= "<li class=''>". $dadescription ."</li>";
						 echo "<span>".$monotes . "</span>";
						}
				echo "</div>";	
						
				//*************Discharge Criteria***************************************
				echo "<div id='' class='form-group group dontsplit'><h3>Discharge Criteria: </h3>";
						$sql9 = "SELECT dc.form_id, dc.criteria AS dccriteria ".
								"FROM form_treatment_plan_dischargecriteria AS dc ".
								"WHERE dc.form_id = $id ".
								"AND (IsDeleted is Null or IsDeleted = 0) "
								;
						$result9 = sqlStatement($sql9);
						$print3 = "";
						while ($row9 = SqlFetchArray($result9)){ 
							$dccriteria = $row9['dccriteria'];
					   echo "<span>".$dccriteria . "</span>";
						}
				echo "</div>";	
						
			//****************************    END FORM **************************************
			?>
		</div>
		<div class="columnbreak"></div>
		<div id="signature" class="form-group group">
			<h2>SIGNATURE PAGE</h2>
			<p>I, the patient or the patient's guardian reviewed and agreed to 
			participate in the interventions identified in the Individualized 
			Treatment Plan Review that is in <?php echo $facility['name']?>'s electronic medical records 
			system.</p>
			<div onload="onReturnSampleSigAll()">
				<!--PATIENT SIGNATURE-->
					<canvas id="sigplus1" width="400" height="80"></canvas>
					<br>
					<label class="description" for="patient_print_name"> </label>
						<div>
							<b>Client:&nbsp;</b><?php echo stripslashes($obj{"patient_print_name"});?>
							<b>&nbsp;Signature Date:&nbsp;</b><?php echo stripslashes($obj{"patient_signature_date"});?>
						</div>
					<!--<hr style="width: 610px; height: -12px">-->
				<!--END OF PATIENT SIGNATURE-->
				<!--GUARDIAN SIGNATURE-->
					<canvas id="sigplus2" width="400" height="80"></canvas>
					<br>
					<label class="description" for="guardian_print_name"> </label>
						<div>
							<b>Guardian:&nbsp;</b><?php echo stripslashes($obj{"guardian_print_name"});?>
							<b>&nbsp;Signature Date:&nbsp;</b><?php echo stripslashes($obj{"guardian_signature_date"});?>
						</div>
					<!--<hr style="width: 610px; height: -12px">-->
				<!--END OF GUARDIAN SIGNATURE-->
				<!-- CLINICIAN SIGNATURE-->
					<canvas id="sigplus3" width="400" height="80"></canvas>
					<br>
					<label class="description" for="provider_print_name"> </label>
						<div>
							<b>Clinician:&nbsp;</b>(Electronically signed by)<?php echo stripslashes($obj{"provider_print_name"});?>,&nbsp; <?php echo stripslashes($obj{"provider_credentials"});?>
							<b>&nbsp;Signature Date:&nbsp;</b><?php echo stripslashes($obj{"provider_signature_date"});?>
						</div>
					<!--<hr style="width: 610px; height: -12px">-->	
				<!--END OF CLINICIAN SIGNATURE-->
				<!-- SUPERVISOR SIGNATURE-->
					<canvas id="sigplus4" width="400" height="80"></canvas>
					<br>
					<label class="description" for="supervisor_print_name"> </label>
						<div>
							<b>Supervisor:&nbsp;</b>(Electronically signed by)<?php echo stripslashes($obj{"supervisor_print_name"});?>,&nbsp;<?php echo stripslashes($obj{"supervisor_credentials"});?>
							<b>&nbsp;Signature Date:&nbsp;</b><?php echo stripslashes($obj{"supervisor_signature_date"});?> 
						</div>
					<!--<hr style="width: 610px; height: -12px">-->
				<!--END OF CLINICIAN SIGNATURE-->
				<!--<canvas id="sigplus5" width="400" height="80"></canvas>-->
				<p>
				As the treating psychiatrist and/or licensed clinician for the 
				above referenced patient; I hereby certify this patient meets 
				the eligibility criteria and is in need of the behavioral health 
				services as outlined in this Individualized Treatment Plan 
				Review. I, additionally certify the specific treatment services 
				herein prescribed for the patient in this Treatment Plan Review 
				is medically necessary and appropriate to the patient diagnosis 
				and treatment needs starting from the date of admissions.
				</p>
				<label class="description" for="supervisor_print_name"> </label>
					<div>
						<b>Physician:&nbsp;</b>(Electronically signed by)<?php echo stripslashes($obj{"physician_print_name"});?>,&nbsp;<?php echo stripslashes($obj{"physician_credentials"});?>
						<b>&nbsp;Signature Date:&nbsp;</b><?php echo stripslashes($obj{"physician_signature_date"});?>
					</div>
			</div>
		</div>
	</form>

</div>
</body>
</html>