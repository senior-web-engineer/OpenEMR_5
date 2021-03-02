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
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery.js"></script>
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-2.0.2.min.js"></script>
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-3.3.7/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-sidebar.js"></script>
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-datepicker.min.js"></script>
		<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery.columnizer.js" charset="utf-8"></script>
		
		<script type="text/javascript" src="edit.js"></script>
		
		<script language="JavaScript">
		// required for textbox date verification
		var mypcc = '<?php echo $GLOBALS['phone_country_code'] ?>';
		
		function PrintForm() {
		    newwin = window.open("<?php echo $rootdir."/forms/soap_pirc/print.php?id=".$_GET["id"]; ?>","mywin");
		}
		
		</script>

		<!-- Sig Script -->
		<script type="text/javascript" src="SigWebTablet.js"></script>
		<!-- SQL/PHP queries -->
		<?php $res = sqlStatement("SELECT fname,mname,lname,ss,sex,DOB,pid FROM patient_data WHERE pid = $pid");
		$result = SqlFetchArray($res); 
		$provider_results = sqlQuery("select fname, mname, lname from users where username='" . $_SESSION{"authUser"} . "'");
		$rendering_provider = sqlQuery("SELECT u.fname, u.mname, u.lname FROM (SELECT provider_id FROM form_encounter where encounter='$encounter') AS e LEFT JOIN (SELECT fname, mname, lname, id FROM  users) AS u ON e.provider_id = u.id");
		$dos = sqlQuery("select date from form_encounter where encounter=$encounter");
		$obj = formFetch("form_treatment_plan", $_GET["formid"]);
		?>
		
		<!-- Enable / Disable form elements -->
		<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
		<?php
			$form_status = stripslashes($obj{"status"});
			$form_user = stripslashes($obj{"user"});
			$billing_status = stripslashes($obj{"billing_status"});
			$enable_form = false;					// a user can edit.
			$can_override_editable = false;			// a user can override edit mode

			// if form is reading or updating after created.
			// check current logged in user is the user created this form
			if ($_SESSION{"authUser"} == $form_user) {
				// check billing status and form status to enable/disable form elemetns
				// When on edit/view mode, script checks if field billing_status is ‘Billed’ or field ‘status’ is ‘Ready for …’ and prevents edit if $form_lock  = 1 (global) 
				if ($form_lock && ( strpos($form_status, "Ready for") !== false || $billing_status == "Billed") ) {
					$enable_form = false;
					if ($form_lock_override && $form_lock_override_access) {
						$can_override_editable = true;
					}
				} else {
					$enable_form = true;
				}
			}
		?>
		<script>
			const CAN_EDIT = <?php echo $enable_form ? 'true' : 'false'; ?>;
			
			function update_form_enable(enable) {
				$("input, select, textarea, button").prop("disabled", !enable);
				if($("#activate")) {
					$("#activate").prop("disabled", false);
				}
			}
			$(function() {
				update_form_enable(CAN_EDIT);
			})
		</script>
		<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

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

		.right-button {
			float: right;
			margin-top: -8px;
		}

		li {
			line-height: 32px;
		}
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
				buildNewsletter();
			});
		</script>
		<script language="JavaScript">
			// required for textbox date verification
			var mypcc = '<?php echo $GLOBALS['phone_country_code'] ?>';
/*			
			$(function() {
			    $('input:checkbox').attr('disabled', true);
			    $('input:radio').attr('disabled', true);
			    $('input:text').attr('disabled', true);
			    $('select').attr('disabled', true);
			});
*/
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
<?php
	//if ($current_user_rights == 'reviewer' && ($form_status == 'Ready for Billing' || $form_status == 'Ready for Billing/Supervisor'|| $form_status == 'Ready for Review' )){
	if ($can_override_editable) {
?>
	<br>
	Edit/Activate form <input id="activate" name="activate"  class="element text medium" type="checkbox" onchange="update_form_enable(this.checked)" />
<?php
	}
?>

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
				echo "<input type='hidden' id='form-id' value='" . $id . "'>";
				//---- Problems ----- 
				$sql = "SELECT tp.id, tp.Description AS tpdescription, tp.tp_problem_number AS tptp_problem_number, tp.form_id , tp.IsPrimary AS tpisrimary , tp.GroupID AS tpGroupID ".
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
					$tpGroupID      = $row['tpGroupID'];
					
					echo "<input type='hidden' id='problem-number-" . $problem_id . "' value='" . $tpproblem_number . "'>";
					echo "<input type='hidden' id='problem-group-" . $problem_id . "' value='" . $tpGroupID . "'>";
					
					
					//*************Problem***************************************
					if ($tpisprimary == "1") {
						echo "<h3>Primary Problem: </h3><h4>". $tpdescription . "</h4>";
				
					} else {
						echo "<h3>Secondary Problem: </h3><h4>". $tpdescription . "</h4>";
					}
					//*************Problem***************************************


					//*************Diagnosis***************************************
					$sql6 = "SELECT da.id, da.form_id, da.Description AS dadescription ".
							"FROM form_treatment_plan_diagnosis AS da ".
							"WHERE da.form_id = $id AND da.problem_id = $problem_id ".
							"AND (IsDeleted is Null or IsDeleted = 0) "
							;
					$result6=sqlStatement($sql6);
					echo "<br>";
					echo "<h3>Diagnosis: </h3>";
					echo '<button type="button" class="btn btn-primary btn-add-diagnosis" onclick="createNewDiagnosis(' . $problem_id . ')">Add New Axis I Diagnosis</button>';
					echo "<div id='dianosis-content-" . $problem_id . "'>";
					while ($row6 = sqlFetchArray($result6)){ 
							$dadescription = $row6['dadescription'];
							//echo "<span>".$dadescription . "</span>";
							echo "<li id='diagnosis-" . $row6['id'] . "'><span id='diagnosis-description-" . $row6['id'] . "'>" . $dadescription . "</span>" .
								 "<button type='button' class='btn btn-primary btn-sm right-button' onclick='editDiagnosis(" . $problem_id . ", "  . $row6['id'] . ")'>Edit</button>" .
								 "<button type='button' class='btn btn-danger btn-sm right-button' onclick='deleteDiagnosis(" . $problem_id . ", "  . $row6['id'] . ")'>Delete</button> </li>";
					}
					echo "</div>";
					
					
					//---- Behavioral Definitions ----- 
					$sql2 = "SELECT bd.Description AS bddescription, bd.id ".
							"FROM form_treatment_plan_behavioraldefinitions AS bd ".
							"WHERE bd.form_id = $id AND bd.problem_id = $problem_id and (IsDeleted is Null or IsDeleted = 0) ".
							"GROUP BY bddescription "
							;
					$result2 = sqlStatement($sql2);
					echo "<br>";
					echo "<h3>Definitions:</h3>";
					echo '<button type="button" class="btn btn-primary" onclick="createNewBehavior(' . $problem_id . ')">Add New Behavioral Definition</button>';
					
					echo "<div id='behavior-content-" . $problem_id . "'>";
					while ($row2 = sqlFetchArray($result2)) { 
						$bddescription = $row2['bddescription'];
						echo "<li style='list-style: none;' id='behavior-" . $row2['id'] . "'><span id='behavior-description-" . $row2['id'] . "'>" . $bddescription . "</span>" .
						"<button type='button' class='btn btn-primary btn-sm right-button' onclick='editBehavior(" . $problem_id . ", "  . $row2['id'] . ")'>Edit</button>" .
						"<button type='button' class='btn btn-danger btn-sm right-button' onclick='deleteBehavior(" . $problem_id . ", "  . $row2['id'] . ")'>Delete</button> </li>";
					}
					echo "</div>";
					

					
					//---- Goals ----- 
					$sql3 = "SELECT gl.Description AS gldescription, gl.goal_status AS glgoal_status, gl.goal_action AS glgoal_action, gl.review_status AS glreview_status, gl.id ".
							"FROM form_treatment_plan_goals AS gl ".
							"WHERE gl.form_id = $id AND gl.problem_id = $problem_id and (IsDeleted is Null or IsDeleted = 0) ".
							"GROUP BY gldescription "
							;
					$result3 = sqlStatement($sql3);

					echo "<br>";
					echo "<h3>Goals:</h3>";
					echo '<button type="button" class="btn btn-primary" onclick="createNewGoal(' . $problem_id . ')">Add Goal</button>';

					echo "<div id='goal-content-" . $problem_id . "'>";
					while ($row3 = sqlFetchArray($result3)) { 
						$gldescription = $row3['gldescription'];
						$goalaction = $row3['glgoal_action'];
						$goalstatus = $row3['glgoal_status'];
						$goalreviewstatus = $row3['glreview_status'];

						echo "<li style='list-style: none;' id='goal-" . $row3['id'] . "'><span id='goal-description-" . $row3['id'] . "'>" . $gldescription . "</span>" .
							"<div class='row'><div class='col-sm-8'><h4>Status: </h4>". $goalstatus ."<h4>Goal Action: </h4>".$goalaction."<h4>Status Description: </h4>".$goalreviewstatus."</div>".
							"<div class='col-sm-8'> <button type='button' class='btn btn-primary btn-sm right-button' onclick='editGoal(" . $problem_id . ", "  . $row3['id'] . ")'>Edit</button>" .
							"<button type='button' class='btn btn-danger btn-sm right-button' onclick='deleteGoal(" . $problem_id . ", "  . $row3['id'] . ")'>Delete</button> </div></div> </li>";
					}
					echo "</div>";
			

					//---- Objectives ----- 
					$sql4 = "SELECT oj.id AS ojid, oj.Description AS ojdescription, oj.ObjectiveNumber AS ojObjectiveNumber, oj.target_date AS ojtarget_date ".
							"FROM form_treatment_plan_objectives AS oj ".
							"WHERE oj.form_id = $id AND oj.problem_id = $problem_id and (IsDeleted is Null or IsDeleted = 0) ".
							"ORDER BY oj.id"
							;
					$result4 = sqlStatement($sql4);

					echo "<br>";
					echo "<h3>Objectives:</h3>";
					echo '<button type="button" class="btn btn-primary btn-add-objective" onclick="createNewObjective(' . $problem_id . ')">Add Objective</button>';
					echo "<div id='objective-content-" . $problem_id . "'>";

					$maxObjectiveNumber = 0;

					while ($row4 = sqlFetchArray($result4)) { 
						$ojdescription = $row4['ojdescription'];
						$objectivenumber = $row4['ojObjectiveNumber'];
						$ojtarget_date = $row4['ojtarget_date'];
						$ojid = $row4['ojid'];
						$maxObjectiveNumber = $objectivenumber > $maxObjectiveNumber ? $objectivenumber : $maxObjectiveNumber;

						echo "<div id='objective-" . $problem_id . "-" . $ojid . "'>";
						echo "<input type='hidden' id='objective-number-" . $problem_id . "-" . $ojid . "' value='" . $objectivenumber . "'>";

						echo "<div id='' class='form-group group dontsplit'><h4>Objective: </h4> <div class='row'> <div class='col-sm-9'> <span id='objective-description-" . $ojid . "'>". $ojdescription . "<b>Target Date:</b>". $ojtarget_date. "</span></div>" . 
							"<div class='col-sm-3'><button type='button' class='btn btn-primary btn-sm right-button' onclick='editObjective(" . $problem_id . ", "  . $ojid . ")'>Edit</button>" .
							"<button type='button' class='btn btn-danger btn-sm right-button' onclick='deleteObjective(" . $problem_id . ", "  . $ojid . ")'>Delete</button> </div> </div>";
						
						echo "<br>";
						echo "<h4>Interventions:</h4>";
						echo '<button type="button" class="btn btn-primary btn-add-objective" onclick="createNewIntervention(' . $problem_id . ',' . $ojid . ')">Add Intervention of Objective</button>';

						//*************INTERVENTIONS***************************************
						$sql5 = "SELECT it.form_id, it.Description AS itdescription, it.ObjectiveID AS itObjectiveID, it.id ".
								"FROM form_treatment_plan_interventions AS it ".
								"WHERE it.form_id = $id  AND it.ObjectiveID = $ojid and (IsDeleted is Null or IsDeleted = 0) ".
								"AND it.tp_problem_number = $tpproblem_number "
								;
						$result5 = sqlStatement($sql5);
						
						echo "<div id='intervention-content-" . $problem_id . "-" . $ojid . "'>";
						
						while ($row5 = sqlFetchArray($result5)){ 
							$itdescription = $row5["itdescription"];
							echo "<li style='list-style: none;' id='intervention-" . $ojid . "-" . $row5['id'] . "'><span id='intervention-description-" . $ojid . "-" . $row5['id'] . "'>" . $itdescription . "</span>" .
							"<button type='button' class='btn btn-primary btn-sm right-button' onclick='editIntervention(" . $problem_id . "," . $ojid . ", "  . $row2['id'] . ")'>Edit</button>" .
							"<button type='button' class='btn btn-danger btn-sm right-button' onclick='deleteIntervention(" . $problem_id . "," . $ojid . ", "  . $row2['id'] . ")'>Delete</button> </li>";
						}

						echo "</div>";
						echo "</div>";
					}
					echo "</div>";
					echo "<script> maxObjectiveNumber = $maxObjectiveNumber;</script>";
				

					//*************Modalities***************************************
					echo "<h3>Modalities: </h3>";
					echo '<button type="button" class="btn btn-primary" onclick="createNewModality(' . $problem_id . ')">Add Modality</button>';
					echo "<div id='modality-content-" . $problem_id . "'>";

					$sql7 = "SELECT mo.form_id, mo.start_date AS mostart_date, mo.end_date AS moend_date, mo.hcpt AS mohcpt, mo.intervals AS mointervals, mo.frequency AS mofrequency, mo.provider AS moprovider, mo.modality AS momodality, mo.id ".
							"FROM form_treatment_plan_modalities AS mo ".
							"WHERE mo.form_id = $id ".
							"AND mo.problem_id = $problem_id ".
							"AND (IsDeleted is Null or IsDeleted = 0) ";
					$result7 = sqlStatement($sql7);

					while ($row7 = SqlFetchArray($result7)){ 
						$mostart_date  = $row7['mostart_date'];
						$moend_date  = $row7['moend_date'];
						$momodality  = $row7['momodality'];
						$mohcpt      = $row7['mohcpt'];
						$mointervals = $row7['mointervals'];
						$mofrequency = $row7['mofrequency'];
						$moprovider  = $row7['moprovider'];
						
						$modal_description = "<b>Starting: </b>".$mostart_date ."<b> Ending: </b>".$moend_date ."<br><b> Service Description: </b>".$momodality . "<b> CPT\HCPCS Code: </b>".$mohcpt . "<b> Interval: </b>".$mointervals . "<b> Frequency: </b>".$mofrequency . "<br><b> Responsible Provider: </b>".$moprovider ."<br>";
						echo "<li style='list-style: none; margin-top: 15px' id='modality-" . $row7['id'] . "'> <div class='row'> <div class='col-sm-9'> <span id='modality-description-" . $row7['id'] . "'>" . $modal_description . "</span></div>" .
							"<div class='col-sm-3'> <button type='button' class='btn btn-primary btn-sm right-button' onclick='editModality(" . $problem_id . ", "  . $row7['id'] . ")'>Edit</button>" .
							"<button type='button' class='btn btn-danger btn-sm right-button' onclick='deleteModality(" . $problem_id . ", "  . $row7['id'] . ")'>Delete</button> </div> </div> </li>";
					}
					echo "</div>";	

					//*************Modality Note***************************************
					echo "<div id='' class='form-group group dontsplit'><h3>Modalities Note: </h3>";
					$sql8 = "SELECT mo.form_id, mo.notes AS monotes, mo.id ".
							"FROM form_treatment_plan_modalitynotes AS mo ".
							"WHERE mo.form_id = $id ".
							"AND mo.problem_id = $problem_id ".
							"AND (IsDeleted is Null or IsDeleted = 0) "
							;
					$result8 = sqlStatement($sql8);
					$isExist = false;
					while ($row8 = SqlFetchArray($result8)){ 
						if ($isExist)
							break;
						$monotes = $row8['monotes'];
						$isExist = true;
						echo "<div> <textarea type='text' id='modality-notes-$problem_id' class='form-control' rows='15'>$monotes</textarea></div>";
						echo "<div style='margin-top: 10px;'>
								<button type='button' class='btn btn-primary' id='btn-modality-save-$problem_id' onclick='saveModalityNote(" . $problem_id . ", " . $row8['id'] . ")'>Save</button>
								<button type='button' class='btn btn-danger'  id='btn-modality-delete-$problem_id' onclick='deleteModalityNote(" . $problem_id . ", " . $row8['id'] . ")'>Delete</button>
							</div>";
					}
					if (!$isExist) {
						echo "<div> <textarea type='text' id='modality-notes-$problem_id' class='form-control' rows='15'></textarea></div>";
						echo "<div style='margin-top: 10px;'>
								<button type='button' class='btn btn-primary' id='btn-modality-save-$problem_id' onclick='saveModalityNote(" . $problem_id . ")'>Save</button>
								<button type='button' class='btn btn-danger'  id='btn-modality-delete-$problem_id' onclick='deleteModalityNote(" . $problem_id . ")'>Delete</button>
							</div>";
					}
					echo "</div>";	

					//*************Discharge Criteria***************************************
					$sql9 = "SELECT dc.form_id, dc.criteria AS dccriteria, dc.id ".
							"FROM form_treatment_plan_dischargecriteria AS dc ".
							"WHERE dc.form_id = $id ".
							"AND dc.problem_id = $problem_id ".
							"AND (IsDeleted is Null or IsDeleted = 0) ";
					$result9 = sqlStatement($sql9);
					
					echo "<h3>Discharge Criteria: </h3>";
					echo '<button type="button" class="btn btn-primary" onclick="createNewDischarge(' . $problem_id . ')">Add Discharge Criteria</button>';
					echo "<div id='discharge-content-" . $problem_id . "'>";
					while ($row9 = SqlFetchArray($result9)){ 
						$dccriteria = $row9['dccriteria'];
						echo "<li style='list-style: none;' id='discharge-" . $row9['id'] . "'><span id='discharge-description-" . $row9['id'] . "'>" . $dccriteria . "</span>" .
							"<button type='button' class='btn btn-primary btn-sm right-button' onclick='editDischarge(" . $problem_id . ", "  . $row9['id'] . ")'>Edit</button>" .
							"<button type='button' class='btn btn-danger btn-sm right-button' onclick='deleteDischarge(" . $problem_id . ", "  . $row9['id'] . ")'>Delete</button> </li>";
					}
					echo "</div>";	
				};

						
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


<!-- Modal -->
<div class="modal fade" id="add-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="add-modal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title"></h5>
      </div>
      <div class="modal-body">
        <div class="form-horizontal">
          <div class="form-group" id='modal-first'>
            <label class="control-label col-sm-2" for="modal-first-select" id="modal-first-label"></label>
            <div class="col-sm-7">
              <select class="form-control" id="modal-first-select">
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-save">Save</button>
      </div>
    </div>
  </div>
</div>


<!-- Objective Modal -->
<div class="modal fade" id="objective-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="objective-modal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="objective-title"></h5>
      </div>
      <div class="modal-body">
        <div class="form-horizontal">
          <div class="form-group">
            <label class="control-label col-sm-3" for="objectiveTargetDate">Target Date</label>
            <div class="col-sm-8">
              <input type="date" class="form-control" id="objectiveTargetDate" name="objectiveTargetDate">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3" for="objectiveNoSession">Number of Session</label>
            <div class="col-sm-8">
              <input type="number" class="form-control" id="objectiveNoSession" name="objectiveNoSession" min="0">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3" for="objective-select" id="objective-label"></label>
            <div class="col-sm-8">
              <select class="form-control" id="objective-select">
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="object-save">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- Modality -->
<div class="modal fade" id="modality-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="modality-modal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modality-title"></h5>
      </div>
      <div class="modal-body">
        <div class="form-horizontal">
          <div class="form-group">
            <label class="control-label col-sm-3" for="modalityStartDate">Start Date</label>
            <div class="col-sm-8">
              <input type="date" class="form-control" id="modalityStartDate">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3" for="modalityEndDate">End Date</label>
            <div class="col-sm-8">
              <input type="date" class="form-control" id="modalityEndDate">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3" for="modality-service-select">Service And Code</label>
            <div class="col-sm-8">
              <select class="form-control" id="modality-service-select">
                <option value="-1" disabled selected>Service</option>
                <option>H2019HR - Individual Therapy</option>
                <option>H2017 - PSR</option>
                <option>H2012 - Day Treatment</option>
                <option>H2019HO - TBOSS</option>
                <option>H2019HQ - Group Therapy</option>
                <option>H2000HP - Psych Eval</option>
                <option>H0031HO - In-Depth Assessment - New Patient</option>
                <option>H0031TS - In-Depth Assessment - Established Patient</option>
                <option>H0031HN - Bio-Psychosocial Evaluation</option>
                <option>H0031 - CFARS/FARS</option>
                <option>H0032 - Treatment Plan</option>
                <option>H0032TS - Treatment Plan Review</option>
                <option>T1015 - Med Management</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3" for="modality-interval-select">Interval</label>
            <div class="col-sm-8">
              <select class="form-control" id="modality-interval-select">
                <option value="-1" disabled selected>Interval</option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                <option>6</option>
                <option>7</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-3" for="modality-frequency-select">Frequency</label>
            <div class="col-sm-8">
              <select class="form-control" id="modality-frequency-select">
                <option value="-1" disabled selected>Frequency</option>
                <option>BiMonthly</option>
                <option>Biweekly</option>
                <option>Daily</option>
                <option>Monthly</option>
                <option>Quaterly</option>
                <option>Weekly</option>
                <option>Yearly</option>
                <option>SemiYearly</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3" for="modality-duration-hour-select">Duration</label>
            <div class="col-sm-4">
              <select class="form-control" id="modality-duration-hour-select">
                <option value="-1" disabled selected>Duration(Hours)</option>
                <option>0</option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                <option>6</option>
                <option>7</option>
                <option>8</option>
              </select>
            </div>
            <div class="col-sm-4">
              <select class="form-control" id="modality-duration-min-select">
                <option value="-1" disabled selected>Duration(Minutes)</option>
                <option value="0">00</option>
                <option>15</option>
                <option>30</option>
                <option>45</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3" for="modalityProvider">Provider</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="modalityProvider">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="saveModality()">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="discharge-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="discharge-modal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="discharge-title"></h5>
      </div>
      <div class="modal-body">
        <div class="form-horizontal">
          <div class="form-group">
            <label class="control-label col-sm-3" for="discharge-criteria">Discharge Criteria</label>
            <div class="col-sm-8">
              <textarea type="text" class="form-control" id="discharge-criteria"></textarea>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-save-discharge">Save</button>
      </div>
    </div>
  </div>
</div>

</body>
</html>