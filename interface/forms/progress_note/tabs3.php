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
		//$dev	= 0 ;
		$pid =  0 + (isset($_GET['pid']) ? $_GET['pid'] : 0);
		$encounter = 0 + (isset($_GET['encounter']) ? $_GET['encounter'] : 0);
		$tpformid = 0 + (isset($_GET['tpformid']) ? $_GET['tpformid'] : 0);
	?>
		var dev = <?php echo $dev ?>;
	</script>
	
<style type="text/css">
.wrapper {
    text-align: center;
  
}

	

</style>
	
<?php
 
include_once("../../globals.php");
include_once("$srcdir/api.inc");
$obj = $formid ? formFetch("form_progress_note", $formid) : array();
$form_name = stripslashes($obj{"note_type"});
?>

<!-- <button id="myButton">Development</button><br> -->
<script>
 //$("#review").hide();
$(function() {
/*
    $("#myButton").click(function() {
        $("#review").toggle();
        $("#review2").toggle();
    });
*/    
    var service_code = '<php? echo ($obj{"service_code"});?>';
    if(service_code == "H0032"){
        $("#review").hide();
        $("#review2").hide();
    } else {
        $("#review").show();
        $("#review2").show();
    }
    
});
</script>

<div class="wrapper">
<!--
<input type="button" onclick="location.href='/openemr/interface/patient_file/encounter/view_form.php?formname=progress_note&id=<?php echo $formid?>';" value="Back to Progress Note" style="width: 367px" />
-->
</div>
<p>&nbsp;</p>
<!--DEBUG-------------------------------------
Service Code:
<?php echo ($obj{"service_code"});?>
<p>Note Type:</p>
<?php echo $form_name;?>
---DEBUG------------------------------------->	
	
	<!-- resources for this page -->
	<link rel="stylesheet" href="tabs3.css" >
	<script src="tabs3api.js" type="text/javascript" ></script>
	<script src="tabs3scrape.js" type="text/javascript" ></script>
	<script src="tabs3.js" type="text/javascript" ></script>

</head>
<body>
<div class="row">

	<div class="col-md-12">
<?php
if ($form_name == "IND" OR $form_name == "GRP"|| $form_name == "TBO")
{
?>
		<h2>Progress Note (Select Problem Area(s)&amp; Treatment Goal(s)):</h2>
<?php
}
?>
<?php
if ($form_name == "PSR")
{
?>
		<h2>Progress Note (Select Problem Area(s)):</h2>
<?php
}
?>

		
		<?php echo $tpformid;?>
		
		<div class="tabbable">
			<!-- tabs left -->
			<ul id="problems_menu" class="nav nav-pills nav-stacked col-md-2 sortable">
				<!-- <li class="active"><span class='handle'></span><a href="#problemTab_1" data-toggle="tab">Problem</a></li> -->
			</ul>
                
			<!-- body right -->
			<div class="tab-content col-md-9">

				<div class="tab-pane active" id="problemTab_1">

						<div class="container">
							<!------tabs top---------->
							<div class="row">
							  <ul class="col-md-9 nav nav-pills">
								<li class="active"><a data-toggle="pill" href="#problem_definitions_1">Problem Areas</a></li>
								<!--<li><a data-toggle="pill" href="#interventions_psr">Interventions(PSR)</a></li>-->
								<!--<li><a data-toggle="pill" href="#modalities_1">InterventionsII(PSR)</a></li>-->
								<!--<li id="review" style="display:none;"><a data-toggle="pill" href="#reviews">Reviews</a></li>-->
<?php
if ($form_name == "IND" OR $form_name == "GRP"|| $form_name == "TBO")
{
?>
							
								<li><a data-toggle="pill" href="#goals_1">Treatment Goal(s)</a></li>
								<!--<li><a data-toggle="pill" href="#objectives_1">Objectives</a></li>-->
<?php
}
?>
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
								<div id="problem_definitions_1" class="tab-pane fade in active col-md-7">
									<div class="section">
										<h3>Problem</h3>
										<button id="addProblem" class="btn" >Add Problem</button><br/>
										<ul class="list-unstyled" id="problems_list" >
											<li class="itemList" editortype="problem_item" recid="1" ></li>
										</ul>
										
										<div class="section hidden editor" >
											<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											<textarea class="textarea-sm"  id="problems_Description_2"  ></textarea><br/>
											<div data-bind="tiControl: {
																id: 'problems_Description_2',
																page: 'soap/edit.php',
																storeid: ['problems_ProblemNumber'] ,
																appendvalue: false,
																params: {pid: <?php echo $pid; ?>, encounter: <?php echo $encounter; ?>, tpformid: <?php echo $tpformid; ?>},
																<!--params: {id1: <?php echo $tpformid; ?>},-->
																<!--params: {id1: 0},-->
																version: 2
																}, tiVM: $data"></div>																				
											<span  class="dev" >
												IsPrimary <input type='text' id='problems_IsPrimary'  />
												Copied Form Id <input type='text' id='65_form_id'>
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
									
									
								</div>
								<!------End Tab pane 1 ---------->
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
											<textarea class="textarea-sm" id="goals_Description_2" ></textarea><br/>
											<div data-bind="tiControl: {
																id: 'goals_Description_2',
																page: 'soap/edit.php',
																storeid: ['goals_GoalNumber'] ,
																appendvalue: false,
																params: {pid: <?php echo $pid; ?>, encounter: <?php echo $encounter; ?>, tpformid: <?php echo $tpformid; ?>},
																version: 2
																}, tiVM: $data"></div>
											<span  class="dev" >
												id <input type='text' id='goals_id' />
												GroupID <input type='text' id='goals_GroupID' />
												ProblemNumber <input type='text' id='goals_ProblemNumber' />
												GoalNumber <input type='text' id='goals_GoalNumber' />
												IsCustom <input type='text' id='goals_IsCustom'  />
											</span>
											
											<div class="clear text-right">
												<button class="btn postgoal" action="delete" >Delete</button>
												<button class="btn cancel">Cancel</button>
												<button class="btn postgoal" action="save" >Save Goal</button>
											</div>
										</div>
									</div>
								</div>
								<!------End Tab pane 2 ---------->
								<!------Tab pane 4 ---------->
								<div id="modalities_1" class="tab-pane col-md-9">
									<div class="section" > 
										<h3>Intervention</h3>
										<!--<script src="<?php echo "$web_root";?>/openemr/library/js/bt-datepicker.js"></script>-->
										
										<button id="addModality" class="btn">Add Modality</button><br/>
										<p>Intervention:</p>
											
										<ul class="list-unstyled" id="modalities_list" >
											<li class="itemList" editortype="modality_item" recid="1" ></li>
										</ul>
										<div class="section editor hidden">
											<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											
																						<br>
											Intervention:<br>
											<select id="modalities_Description" style="width: 200px">
													<option value="" disabled selected>Service</option>
													<option>Enhancement of social skills and communication skills through group activities role play and group discussion.</option>
													<option>Educating the client on appropriate emotions, respect, matches actions to specific people. Open discussion to develop communication changing bad habits, negotiation, self-respect and expressing feelings.</option>
													<option>"Educational interaction and Social Interaction Counselor attempt to read with sammie and helps him to vocalize letters and words.Sammie was very difficult unable to remain seated. sammie attention span is very limited. Counselor workd with sammie to build his socialization skills."</option>
													
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
											<!--
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
											<select id="modalities_duration_hour">
													<option value="" disabled selected>Duration(Hours)</option>
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
											<select id="modalities_duration_minute">
													<option value="" disabled selected>Duration(Minutes)</option>
													<option>00</option>
													<option>15</option>
													<option>30</option>
													<option>45</option>
												</select>
												<br>
												<br>Provider<br>

											<input class="textarea-lg" id="modalities_provider" placeholder="Provider" style="width: 207px; height: 24px"  >	
													-->
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
								<!------Tab pane 2 ---------->
								<div id="interventions_psr" class="tab-pane col-md-9">
									<div class="section">
										<h3>Interventions</h3>
										<button id="addIntervention" class="btn">Add Intervention</button><br/>
										<ul class="list-unstyled" id="interventions_list" >
											<li class="itemList" editortype="intervention_item" recid="1" ></li>
										</ul>
										
										<div class="section editor hidden">
											<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											<textarea class="textarea-lg" id="interventions_Description_2" ></textarea><br/>
											<div data-bind="tiControl: {
																id: 'interventions_Description_2',
																page: 'soap/edit.php',
																storeid: ['interventions_InterventionNumber'] ,
																appendvalue: false,
																<!--params: {id1: <?php echo $formid; ?>},-->
																params: {pid: <?php echo $pid; ?>, encounter: <?php echo $encounter; ?>, tpformid: <?php echo $tpformid; ?>},
																version: 2
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
								<!------End Tab pane 2 ---------->

								<!------Tab pane 3 ---------->
								


								<div id="objectives_1" class="tab-pane fade col-md-9">
									<div class="section">
										<h3>Objectives </h3>
										<button id="addObjective" class="btn">Add Objective</button><br/>
										<ul class="list-unstyled" id="objectives_list" >
											<li class="itemList" editortype="objective_item" recid="1" ></li>
										</ul>
										
										<div class="section editor hidden">
											<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											<textarea class="textarea-lg" id="objectives_Description_2"  ></textarea><br/>
											<div data-bind="tiControl: {
																id: 'objectives_Description_2',
																page: 'soap/edit.php',
																storeid: ['objectives_ObjectiveNumber'] ,
																appendvalue: false,
																params: {pid: <?php echo $pid; ?>, encounter: <?php echo $encounter; ?>, tpformid: <?php echo $tpformid; ?>},
																version: 2
																}, tiVM: $data"></div>
											

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
									
									
								<!------End Tab pane 3 ---------->
								

								<!------Tab Reviews  ---------->
								

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
<div class="wrapper">
<!--
<input type="button" onclick="location.href='/openemr/interface/patient_file/encounter/view_form.php?formname=progress_note&id=<?php echo $formid?>';" value="Back to Progress Note" style="width: 367px" />
-->
</div>

	
</body>
</html>
