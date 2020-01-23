<!DOCTYPE html>
<html lang="en">
<head>
<?php

include_once("$srcdir/api.inc");
?>




	<title>Bootstrap Case</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  
	<!-- text importer -->
	<script src="<?php echo "$web_root";?>/openemr/library/textimporter/jquery-1.11.3.min.js"></script>
	<script src="<?php echo "$web_root";?>/openemr/library/textimporter/underscore.js"></script>
	<script src="<?php echo "$web_root";?>/openemr/library/textimporter/jquery-tmpl.js"></script>
	<script src="<?php echo "$web_root";?>/openemr/library/textimporter/knockout-3.3.0.debug.js"></script>
	<script src="<?php echo "$web_root";?>/openemr/library/textimporter/koExternalTemplateEngine_all.js"></script>
	<script src="<?php echo "$web_root";?>/openemr/library/textimporter/textimporter.js"></script>
	
	<script src="<?php echo "$web_root";?>/openemr/library/js/jquery-ui-1.11.4/jquery-ui.js"></script>
	
	<link href="<?php echo "$web_root";?>/openemr/library/textimporter/textimporter.css" rel="stylesheet">
	<!-- bootstrap -->
	<link rel="stylesheet" href="<?php echo "$web_root";?>/openemr/library/css/bootstrap.min.css">
	<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
	
	<script src="<?php echo "$web_root";?>/openemr/library/js/bootstrap.min.js"></script>
	<script src="<?php echo "$web_root";?>/openemr/library/js/bootstrap-datepicker.js"></script>

	<!---->
	<script src="<?php echo "$web_root";?>/openemr/library/js/bt-datepicker.js"></script>
	<!-- page querystring parameters -->
	<script type="text/javascript">
	<?php 
		$formid = 0 + (isset($_GET['formid']) ? $_GET['formid'] : 0); 
		$dev	= 0 + (isset($_GET['dev']) ? $_GET['dev'] : 0);
		
	?>
		var dev = <?php echo $dev ?>;
		$
	</script>
	
<style type="text/css">
.auto-style1 {
	text-decoration: underline;
}
.auto-style2 {
	background-color: #FF0000;
}
</style>
	
<button id="myButton">Development</button><br>
<script>
 $("#review").hide();
$(function() {
    $("#myButton").click(function() {
        $("#review").toggle();
        $("#review2").toggle();

    });
});
</script>
<?php
 
include_once("../../globals.php");
include_once("$srcdir/api.inc");
$obj = $formid ? formFetch("form_treatment_plan", $formid) : array();

?>




Service Code:
<?echo ($obj{"service_code"});?>

	
	
	<!-- resources for this page -->
	<link rel="stylesheet" href="tabs3.css" >
	<script src="tabs3api.js" type="text/javascript" ></script>
	<script src="tabs3scrape.js" type="text/javascript" ></script>
	<script src="tabs3.js" type="text/javascript" ></script>

</head>
<body>
<div class="row">

	<div class="col-md-12">
		<h2>Treatment Plan</h2>
		<div class="tabbable">
			<!-- tabs left -->
			<ul id="problems_menu" class="nav nav-pills nav-stacked col-md-3 sortable">
				<!-- <li class="active"><span class='handle'></span><a href="#problemTab_1" data-toggle="tab">Problem</a></li> -->
			</ul>
                
			<!-- body right -->
			<div class="tab-content col-md-9">

				<div class="tab-pane active" id="problemTab_1">

						<div class="container">
							<!------tabs top---------->
							<div class="row">
							  <ul class="nav nav-pills">
								<li class="active"><a data-toggle="pill" href="#problem_definitions_1">Problems / Definitions</a></li>
								<li id="review" style="display:none;"><a data-toggle="pill" href="#reviews">Reviews</a></li>
								<li><a data-toggle="pill" href="#goals_1">Goals</a></li>
								<li><a data-toggle="pill" href="#objectives_1">Objectives / Interventions</a></li>
								<li><a data-toggle="pill" href="#modalities_1">Modality</a></li>
								<li><a data-toggle="pill" href="#modalitynotes_1">Modality Note</a></li>
								<!--<li id="review2" style="display:none;">-->
								<li><a data-toggle="pill" href="#discharge_criteria">Discharge Criteria</a></li>
								<li><a data-toggle="pill" href="#diagnosis">Diagnosis</a></li>
								<!--<li><a href="#approach_1" data-toggle="pill">Approach</a></li>
								<li><a href="#diagnosis_1" data-toggle="pill">Diagnosis</a></li>
								<li><a href="#response_1" data-toggle="pill">Response</a></li>
								<li><a href="#signatures_1" data-toggle="pill">Signatures</a></li>-->
							  </ul>
							</div>
							<!------end tabs top---------->
							
							<!------Problem header---------->
							<div class="row">
								<div class="col-md-9">
									<h3><span id="problemheader"></span></h3>
									<span class="dev" >Select Problem &nbsp; </span>
									<select id="availableProblems" class="dev"></select> &nbsp;
									<span  class="dev" >saved form id </span><input id="form_id" class="dev" value="<?php echo $formid ?>" /> &nbsp;
									<span  class="dev" >tp_problem_number </span><input type='text' class="dev" id='tp_problem_number' />
								</div>
							</div>
						 	<!------End Problem header---------->
							 
							<div class="tab-content row">

								<!------Tab pane 1 ---------->
								<div id="problem_definitions_1" class="tab-pane fade in active col-md-9">
									<div class="section">
										<h3>Problem</h3>
										<button id="addProblem" class="btn" >Add Problem</button><br/>
										<ul class="list-unstyled" id="problems_list" >
											<li class="itemList" editortype="problem_item" recid="1" ></li>
										</ul>
										
										<div class="section hidden editor" >
											<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											<textarea class="textarea-sm"  id="problems_Description"  ></textarea><br/>
											<div data-bind="tiControl: {
																id: 'problems_Description',
																page: 'treatment_plan/edit.php',
																storeid: ['problems_GroupID','problems_ProblemNumber'] ,
																appendvalue: false,
																params: {id1: 0}
																}, tiVM: $data"></div>
											IsPrimary <input type='text' id='problems_IsPrimary'  />																
											<span  class="dev" >
												id <input type='text' id='problems_id' />
												GroupID <input type='text' id='problems_GroupID' />
												ProblemNumber <input type='text' id='problems_ProblemNumber' />
												approach_note <input type='text' id='problems_approach_note' />
												IsCustom <input type='text' id='problems_IsCustom'  />
											</span>
											<div class="clear text-right">
												<button class="btn postproblem" action="delete">Delete</button>
												<button class="btn cancel">Cancel</button>
												<button class="btn postproblem" action="save">Save Problem</button>
											</div>
										</div>
									</div>
									
									<div class="section">
										<h3>Behavioral Definitions</h3>
										<button id="addBD" class="btn">Add Beh. Def.</button><br/>
										<ul class="list-unstyled"  id="bd_list" >
											<li class="itemList" editortype="bd_item" recid="1" ></li>
										</ul>
										
										<div class="section editor hidden">
											<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											<textarea class="textarea-lg" id="definitions_Description" ></textarea><br/>
											<div data-bind="tiControl: {
																id: 'definitions_Description',
																page: 'treatment_plan/edit.php',
																storeid: ['definitions_DefinitionNumber'] ,
																appendvalue: false,
																params: {id1: 0}
																}, tiVM: $data"></div>
											<span  class="dev" >
												id <input type='text' id='definitions_id' />
												GroupID <input type='text' id='definitions_GroupID' />
												ProblemNumber <input type='text' id='definitions_ProblemNumber' />
												DefinitionNumber <input type='text' id='definitions_DefinitionNumber' />
												IsCustom <input type='text' id='definitions_IsCustom'  />
											</span>
											<div class="clear text-right">
												<button class="btn postdefinition" action="delete" >Delete</button>
												<button class="btn cancel">Cancel</button>
												<button class="btn postdefinition" action="save" >Save Beh. Def.</button>
											</div>
										</div>
									</div>
								</div>
								<!------End Tab pane 1 ---------->
								
								<!------Tab Reviews  ---------->
								<div id="reviews" class="tab-pane col-md-9">
									
									<div class="row">
							  <ul class="nav nav-tabs">
								<li class="active"><a data-toggle="pill" href="#strength">Strength and Assets</a></li>
								<li><a href="#weakness" data-toggle="pill">Weaknesses (Limitations) or Special Needs</a></li>
								<li><a href="#summary" data-toggle="pill">Summary of Patient's Progress</a></li>
							  </ul>
							</div>
						<!------Tab Strengths ---------->
							<!------Sub-Tab Content (Container) ---------->
							<div class="tab-content row">
							   <div id="strength" class="tab-pane fade in active col-md-9">
									<div class="section">
										<h3>List any change in Strengths and Assets</h3>		
									<button id="addStrength" class="btn" >Add Strength</button><br/>
										<ul class="list-unstyled" id="strength_list" >
											<li class="itemList" editortype="strength_item" recid="1" ></li>
										</ul>
										
										<div class="section hidden editor" >
											<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											<textarea class="textarea-sm"  id="strength_Description"  ></textarea><br/>
											<div data-bind="tiControl: {
																id: 'strength_Description',
																page: 'treatment_plan/edit.php',
																storeid: ['strength_Description'] ,
																appendvalue: false,
																params: {id1: <?php echo $formid; ?>}
																}, tiVM: $data"></div>
											
											<span  class="dev" >
												id <input type='text' id='strength_id' />
												<!--GroupID <input type='text' id='strength_GroupID' />
												LegalCode <input type='text' id='diagnosis_LegalCode' />-->
											</span>
											<!--<input type="hidden" id="diagnosis_Axis" value="1">-->
																						
											<div class="clear text-right">
												<button class="btn poststrength" action="delete">Delete</button>
												<button class="btn cancel">Cancel</button>
												<button class="btn poststrength" action="save">Save Strength</button>
											</div>
										</div>
									</div>
								</div>
							<!------End Tab Strengths ---------->							
						
							<!------Tab Weakness ---------->
							<!--weakness is from strength table -->

							<div id="weakness" class="tab-pane fade col-md-9">
									<div class="section">
										<h3>List any change in Limitations (Weaknesses) and Needs</h3>		
									<button id="addWeakness" class="btn" >Add Weakness</button><br/>
										<ul class="list-unstyled" id="weakness_list" >
											<li class="itemList" editortype="weakness_item" recid="1" ></li>
										</ul>
										
										<div class="section hidden editor" >
											<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											<textarea class="textarea-sm"  id="weakness_Description"  ></textarea><br/>
											<div data-bind="tiControl: {
																id: 'weakness_Description',
																page: 'treatment_plan/edit.php',
																storeid: ['weakness_Description'] ,
																appendvalue: false,
																params: {id1: <?php echo $formid; ?>}
																}, tiVM: $data"></div>
											<span  class="dev" >
												id <input type='text' id='weakness_id' /> 
												<!--GroupID <input type='text' id='strength_GroupID' />
												LegalCode <input type='text' id='diagnosis_LegalCode' />-->
											</span>
											<!--<input type="hidden" id="diagnosis_Axis" value="1">-->
																						
											<div class="clear text-right">
												<button class="btn postweakness" action="delete">Delete</button>
												<button class="btn cancel">Cancel</button>
												<button class="btn postweakness" action="save">Save Weakness</button>
											</div>
										</div>
									</div>
								</div>
								<!------End Tab Weaknesses ---------->	
							<!------Tab Summary ---------->
							

							<div id="summary" class="tab-pane fade col-md-9">
									<div class="section">
										<h3>Provide a summary of Patient's progress in Treatment</h3>		
									<button id="addSummary" class="btn" >Add Summary</button><br/>
										<ul class="list-unstyled" id="summary_list" >
											<li class="itemList" editortype="summary_item" recid="1" ></li>
										</ul>
										
										<div class="section hidden editor" >
											<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											<textarea class="textarea-sm"  id="summary_Description" style="height: 248px"  ></textarea><br/>
											
											<span  class="dev" >
												id <input type='text' id='summary_id' /> 
												<!--GroupID <input type='text' id='strength_GroupID' />
												LegalCode <input type='text' id='diagnosis_LegalCode' />-->
											</span>
											<!--<input type="hidden" id="diagnosis_Axis" value="1">-->
																						
											<div class="clear text-right">
												<button class="btn postsummary" action="delete">Delete</button>
												<button class="btn cancel">Cancel</button>
												<button class="btn postsummary" action="save">Save Summary</button>
											</div>
										</div>
									</div>
								</div>
								<!------End Tab Summary ---------->
								</div>
								<!------End Sub-Tab Content ---------->	
									
									
									
									
									
								</div>
								<!------End Tab Reviews ---------->
								
								<!------Tab pane 2 ---------->
								<div id="goals_1" class="tab-pane col-md-9">
									<div class="section">
										<h3>Goals for Problem</h3>
										<button id="addGoal" class="btn">Add Goal</button><br/>
										<ul class="list-unstyled" id="goals_list" >
											<li class="itemList" editortype="goal_item" recid="1" ></li>
										</ul>
										
										<div class="section editor hidden">
											<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											<textarea class="textarea-lg" id="goals_Description" ></textarea><br/>
											<div data-bind="tiControl: {
																id: 'goals_Description',
																page: 'treatment_plan/edit.php',
																storeid: ['goals_GoalNumber'] ,
																appendvalue: false,
																params: {id1: 0}
																}, tiVM: $data"></div>
											<span  class="dev" >
												id <input type='text' id='goals_id' />
												GroupID <input type='text' id='goals_GroupID' />
												ProblemNumber <input type='text' id='goals_ProblemNumber' />
												GoalNumber <input type='text' id='goals_GoalNumber' />
												IsCustom <input type='text' id='goals_IsCustom'  />
											</span>
											<br>
											<div id="review2" style="display:none;">
											<!--<div id="review"  style="display:none;">-->
												
												<strong>Status:</strong><select id="goal_status">
													<option>Achived</option>
													<option>Improved</option>
													<option>No Change</option>
													<option>Worse</option>
												</select>
									<strong>Goal Action:</strong><select id="goal_action">
													<option>Continue</option>
													<option>Discontinue</option>
												</select>
			
											
											<br><br>Describe Status along with any Successes and Barriers <br>Use the '<strong><em>Objectives/Interventions</em></strong>' tab to record Upcoming Intervention Strategies:<br>
											<textarea class="textarea-lg" id="review_status"></textarea>
											
											
											</div>
											<div class="clear text-right">
												<button class="btn postgoal" action="delete" >Delete</button>
												<button class="btn cancel">Cancel</button>
												<button class="btn postgoal" action="save" >Save Goal</button>
											</div>
										</div>
									</div>
								</div>
								<!------End Tab pane 2 ---------->
								
								<!------Tab pane 3 ---------->
								


								<div id="objectives_1" class="tab-pane fade col-md-9">
									<div class="section">
										<h3>Objectives for Problem</h3>
										<button id="addObjective" class="btn">Add Objective</button><br/>
										<span >Please click on Objectives to see their Interventions</span><br/>
										<ul class="list-unstyled" id="objectives_list" >
											<li class="itemList" editortype="objective_item" recid="1" ></li>
										</ul>
										
										<div class="section editor hidden">
											<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											<textarea class="textarea-lg" id="objectives_Description"  ></textarea><br/>
											<div data-bind="tiControl: {
																id: 'objectives_Description',
																page: 'treatment_plan/edit.php',
																storeid: ['objectives_ObjectiveNumber'] ,
																appendvalue: false,
																params: {id1: 0}
																}, tiVM: $data"></div>
											Target Date: <input class="datepicker" data-date-format="yyyy/mm/dd" id='objectives_target_date' />
											
											Number of Sessions: <input type='text' id='objectives_sessions' />

											<span  class="dev" >
												id <input type='text' id='objectives_id' />
												target_date <input type='text' id='objectives_target_date' />
												sessions <input type='text' id='objectives_sessions' />
												IsCritical <input type='text' id='objectives_IsCritical' />
												GroupID <input type='text' id='objectives_GroupID' />
												ProblemNumber <input type='text' id='objectives_ProblemNumber' />
												ObjectiveNumber <input type='text' id='objectives_ObjectiveNumber' />
												IsCustom <input type='text' id='objectives_IsCustom'  />
												IsEvidenceBased <input type='text' id='objectives_IsEvidenceBased' />
											</span>
											<div class="clear text-right">
												<button class="btn postobjective" action="delete" >Delete</button>
												<button class="btn cancel">Cancel</button>
												<button class="btn postobjective" action="save" >Save Objective</button>
											</div>
										</div>
									</div>
									
									<div class="section hidden" id="interventionsection" >
										<h3>Interventions for Objective</h3>
										<button id="addIntervention" class="btn">Add Intervention</button><br/>
										<span >Please click on Objectives to see their Interventions</span><br/>
										<ul class="list-unstyled"  id="interventions_list" >
											<li class="itemList" editortype="intervention_item" recid="1" ></li>
										</ul>
										
										<div class="section editor hidden">
											<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											<textarea class="textarea-lg" id="interventions_Description" ></textarea><br/>
											<div data-bind="tiControl: {
																id: 'interventions_Description',
																page: 'treatment_plan/edit.php',
																storeid: ['interventions_InterventionNumber'] ,
																appendvalue: false,
																params: {id1: 0}
																}, tiVM: $data"></div>
											<span  class="dev" >
												id <input type='text' id='interventions_id' />
												sessions <input type='text' id='interventions_sessions' />
												user <input type='text' id='interventions_user' />
												GroupID <input type='text' id='interventions_GroupID' />
												ObjectiveID <input type='text' id='interventions_ObjectiveID' />
												ProblemNumber <input type='text' id='interventions_ProblemNumber' />
												InterventionNumber <input type='text' id='interventions_InterventionNumber' />
												ShortDescription <input type='text' id='interventions_ShortDescription' />
												IsCustom <input type='text' id='interventions_IsCustom'  />
												IsEvidenceBased <input type='text' id='interventions_IsEvidenceBased' />
											</span>
											<div class="clear text-right">
												<button class="btn postintervention" action="delete" >Delete</button>
												<button class="btn cancel">Cancel</button>
												<button class="btn postintervention" action="save" >Save Intervention</button>
											</div>
										</div>
									</div>
								</div>
								<!------End Tab pane 3 ---------->

								<!------Tab pane 4 ---------->
								<div id="modalities_1" class="tab-pane col-md-9">
									<div class="section" > 
										<h3>Modalities</h3>
										<script src="<?php echo "$web_root";?>/openemr/library/js/bt-datepicker.js"></script>
										
										<button id="addModality" class="btn">Add Modality</button><br/>
										<p>Service &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Code &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Interval &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Frequency &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Provider</p>
											
										<ul class="list-unstyled" id="modalities_list" >
											<li class="itemList" editortype="modality_item" recid="1" ></li>
										</ul>
													
										<div class="section editor hidden">
											<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											<p>Start Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
											End DateService &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
											<input type='text' class="datepicker" data-date-format="yyyy/mm/dd" id="modalities_start_date">
											<input class="datepicker" data-date-format="yyyy/mm/dd" id="modalities_end_date">
																						<br>
											Service&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Code &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Interval &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Frequency &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
											Duration&nbsp;&nbsp;&nbsp;<br>
											<select id="modalities_modality">
													<option value="" disabled selected>Service</option>
													<option>H2019HR - Individual Therapy</option>
													<option>H2017 - PSR</option>
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
												<!--
											<select id="modalities_hcpt">
													<option value="" disabled selected>Code</option>
													<option>H2019HR</option>
													<option>H2017</option>
													<option>H2019HO</option>
													<option>H2019HQ</option>
													<option>H2000HP</option>
												</select>
												-->
											<select id="modalities_intervals">
													<option value="" disabled selected>Interval</option>
													<option>1</option>
													<option>2</option>
													<option>3</option>
													<option>4</option>
													<option>5</option>
													<option>6</option>
													<option>7</option>
												</select>
											<select id="modalities_frequency">
													<option value="" disabled selected>Frequency</option>
													<option>BiMonthly</option>
													<option>Biweekly</option>
													<option>Daily</option>
													<option>Monthly</option>
													<option>Quaterly</option>
													<option>Weekly</option>
													<option>Yearly</option>
													<option>SemiYearly</option>
												</select>
											<select id="duration_hour">
													<option value="" disabled selected>Duration(Hours)</option>
													<option>00</option>
													<option>01</option>
													<option>02</option>
													<option>03</option>
													<option>04</option>
													<option>05</option>
													<option>06</option>
													<option>07</option>
													<option>08</option>
												</select>
											<select id="duration_minute">
													<option value="" disabled selected>Duration(Minutes)</option>
													<option>00</option>
													<option>15</option>
													<option>30</option>
													<option>45</option>
												</select>
												<br>
												<br>Provider<br>

											<input class="textarea-lg" id="modalities_provider" placeholder="Provider" style="width: 207px; height: 24px"  >	
		
											<span  class="dev" >
												id <input type='text' id='modalities_id' />
											</span>
											<div class="clear text-right">
												<button class="btn postmodality" action="delete" >Delete</button>
												<button class="btn cancel">Cancel</button>
												<button class="btn postmodality" action="save" >Save Modality</button>
											</div>
										</div>							
									</div>
								</div>
								<!------End Tab pane 4 ---------->
								
								<!------Tab pane 5 ---------->
								<div id="modalitynotes_1" class="tab-pane col-md-9">
									<div class="section" id="modalitynotessection" >
										<h3>Modality Notes</h3>
										<button id="addModalityNote" class="btn">Add Modality Note</button><br/>
										<ul class="list-unstyled"  id="modalitynotes_list" >
											<li class="itemList" editortype="modalitynote_item" recid="1" ></li>
										</ul>
										
										<div class="section editor hidden">
											<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											<textarea class="textarea-lg" id="modalitynotes_Notes"  ></textarea><br/>

											<span  class="dev" >
												id <input type='text' id='modalitynotes_id' />
											</span>
											<div class="clear text-right">
												<button class="btn postmodalitynote" action="delete" >Delete</button>
												<button class="btn cancel">Cancel</button>
												<button class="btn postmodalitynote" action="save" >Save Modality Note</button>
											</div>
										</div>
									</div>
								</div>
								<!------End Tab pane 5 ---------->
								<!------Tab pane 6 ---------->
								<div id="discharge_criteria" class="tab-pane col-md-9">
									<div class="section" id="discharge" >
										<h3>Discharge Criteria</h3>
										<button id="addDischargeCriteria" class="btn">Add Discharge Criteria</button><br/>
										<ul class="list-unstyled"  id="dischargecriteria_list" >
											<li class="itemList" editortype="dischargecriteria_item" recid="1" ></li>
										</ul>
										
										<div class="section hidden editor">
											<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											<textarea class="textarea-lg" id="dischargecriteria_Criteria"  ></textarea><br/>

											<span  class="dev" >
												id <input type='text' id='dischargecriteria_id' />
											</span>
											<div class="clear text-right">
												<button class="btn postdischargecriteria" action="delete" >Delete</button>
												<button class="btn cancel">Cancel</button>
												<button class="btn postdischargecriteria" action="save" >Save discharge Note</button>
											</div>
										</div>
									</div>
								</div>
								<!------End Tab pane 6 ---------->


								<!------Tab pane 7 ---------->
								<div id="diagnosis" class="tab-pane col-md-9">
									
									<!------AXIS I ---------->
									<div class="section" id="diagnosissection1">
										<h3>Axis I Diagnosis</h3>
										<button id="addDiagnosis" class="btn" >Add Axis I</button><br/>
										<ul class="list-unstyled" id="diagnosis_list" >
											<li class="itemList" editortype="diagnosis_item" recid="1" ></li>
										</ul>
										
										<div class="section hidden editor" >
											<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											<textarea class="textarea-sm"  id="diagnosis_Description"  disabled></textarea><br/>
											<div data-bind="tiControl: {
																id: 'diagnosis_Description',
																page: 'treatment_plan/edit.php',
																storeid: ['diagnosis_LegalCode'] ,
																appendvalue: false,
																params: {id1: <?php echo $formid; ?>}
																}, tiVM: $data"></div>
											<span  class="dev" >
												id <input type='text' id='diagnosis_id' />
												GroupID <input type='text' id='diagnosis_GroupID' />
												LegalCode <input type='text' id='diagnosis_LegalCode' />
											</span>
											<input type="hidden" id="diagnosis_Axis" value="1">
																						
											<div class="clear text-right">
												<button class="btn postdiagnosis" action="delete">Delete</button>
												<button class="btn cancel">Cancel</button>
												<button class="btn postdiagnosis" action="save">Save Diagnosis</button>
											</div>
										</div>
									</div>
									
									<!------AXIS II ----------><!--
									<div class="section" id="diagnosissection2">
										<h3>Axis II Diagnosis</h3>
										<button id="addDiagnosis2" class="btn" >Add Axis II</button><br/>
										<ul class="list-unstyled" id="diagnosis2_list" >
											<li class="itemList" editortype="diagnosis2_item" recid="1" ></li>
										</ul>
										
										<div class="section hidden editor" >
											<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											<textarea class="textarea-sm"  id="diagnosis2_Description"  disabled></textarea><br/>
											<div data-bind="tiControl: {
																id: 'diagnosis2_Description',
																page: 'treatment_plan/edit.php',
																storeid: ['diagnosis2_LegalCode'] ,
																appendvalue: false,
																params: {id1: 0}
																}, tiVM: $data"></div>
											<span  class="dev" >
												id <input type='text' id='diagnosis2_id' />
												GroupID <input type='text' id='diagnosis2_GroupID' />
												LegalCode <input type='text' id='diagnosis2_LegalCode' />
											</span>
											<input type="hidden" id="diagnosis2_Axis" value="2">
																						
											<div class="clear text-right">
												<button class="btn postdiagnosis2" action="delete">Delete</button>
												<button class="btn cancel">Cancel</button>
												<button class="btn postdiagnosis2" action="save">Save Diagnosis</button>
											</div>
      									  </div>
									 </div> 
									 
									<!------AXIS III ---------->
									<!---MUST BE ONE LINE----><!--
									<div class="section" id="diagnosticsection3">
										<h3>Axis III Physical Diorders</h3>
										<button id="addDiagnosis3" class="btn">Add Axis III</button><br/>
										<ul class="list-unstyled"  id="diagnosis3_list" >
											<li class="itemList" editortype="diagnosis3_item" recid="1" ></li>
										</ul>
										
										<div class="section editor hidden">
											<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											<textarea class="textarea-sm"  id="diagnosis3_Description" ></textarea><br/>

											<span  class="dev" >
												id <input type='text' id='diagnosis3_id' />
											</span>
											<input type="hidden" id="diagnosis3_Axis" value="3">
																						
											<div class="clear text-right">
												<button class="btn postdiagnosis3" action="delete">Delete</button>
												<button class="btn cancel">Cancel</button>
												<button class="btn postdiagnosis3" action="save">Save Diagnosis</button>
											</div>	
										</div>
									</div>
									
									<!------AXIS IV ---------->		
									<!---MULTIPLE TIED TO lib_stressor ----><!--
									<div class="section" id="diagnosissection4">
										<h3>Axis IV Stressors</h3>
										<button id="addDiagnosis4" class="btn" >Add Axis IV</button><br/>
										<ul class="list-unstyled" id="diagnosis4_list" >
											<li class="itemList" editortype="diagnosis4_item" recid="1" ></li>
										</ul>
										
										<div class="section hidden editor" >
											<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											<textarea class="textarea-sm"  id="diagnosis4_Description"  disabled></textarea><br/>
											<div data-bind="tiControl: {
																id: 'diagnosis4_Description',
																page: 'treatment_plan/edit.php',
																storeid: ['diagnosis4_LegalCode'] ,
																appendvalue: false,
																params: {id1: 0}
																}, tiVM: $data"></div>
											<span  class="dev" >
												id <input type='text' id='diagnosis4_id' />
												GroupID <input type='text' id='diagnosis4_GroupID' />
												LegalCode <input type='text' id='diagnosis4_LegalCode' />
											</span>
											<input type="hidden" id="diagnosis4_Axis" value="4">
																						
											<div class="clear text-right">
												<button class="btn postdiagnosis4" action="delete">Delete</button>
												<button class="btn cancel">Cancel</button>
												<button class="btn postdiagnosis4" action="save">Save Diagnosis</button>
											</div>
										</div>
									</div>
						
									<!------AXIS V ---------->
									<!---MUST BE ONE LINE----><!--
									<div class="section" id="diagnosissection5">
										<h3>Axis V Functioning Level (GAF Score)</h3>
																				
										<button id="addDiagnosis5" class="btn">Add Axis V</button><br/>
										<ul class="list-unstyled" id="diagnosis5_list" >
											<li class="itemList" editortype="diagnosis5_item" recid="1" ></li>
										</ul>
										<div class="section editor hidden">
											<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  										    Current:<select id="diagnosis5_cgaf_score">
													<option></option>
													<option>1-10</option>
													<option>11-20</option>
													<option>21-30</option>
													<option>31-40</option>
													<option>41-50</option>
													<option>51-60</option>
													<option>61-70</option>
													<option>71-80</option>
													<option>81-90</option>
													<option>91-100</option>
													</select>
										    Prior:<select id="diagnosis5_pgaf_score">
													<option></option>
													<option>1-10</option>
													<option>11-20</option>
													<option>21-30</option>
													<option>31-40</option>
													<option>41-50</option>
													<option>51-60</option>
													<option>61-70</option>
													<option>71-80</option>
													<option>81-90</option>
													<option>91-100</option>
													</select>
											Stress Severity Rating:<select id="diagnosis5_stress_rating">
													<option></option>
													<option>None</option>
													<option>Mild</option>
													<option>Moderate</option>
													<option>Severe</option>
													<option>Extreme</option>
													</select>
													<br>
											<input type="hidden" id="diagnosis5_Axis" value="5">
																								
											<div class="clear text-right">
												<button class="btn postdiagnosis5" action="delete" >Delete</button>
												<button class="btn cancel">Cancel</button>
												<button class="btn postdiagnosis5" action="save" >Save Axis V</button>
											</div>
										</div>
            			            </div>
									-->
							</div>	
                	    	<!------Tab pane 7 ---------->

						</div><!-- end tab-content row -->

					</div><!-- end container -->

				</div><!-- end tab-pane active -->

			</div><!-- end body right -->
	
		</div><!-- end tabbable -->
	</div><!-- end col-md-12 -->
</div>
<!--
<script>
 $('#objectives_target_date').datepicker({
				format: 'yyyy-mm-dd'
			});
</script>
-->

	
</body>
</html>
