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
		$pid =  0 + (isset($_GET['pid']) ? $_GET['pid'] : 0);
		$encounter = 0 + (isset($_GET['encounter']) ? $_GET['encounter'] : 0);
		$tpformid = 0 + (isset($_GET['tpformid']) ? $_GET['tpformid'] : 0);
	?>
		var dev = <?php echo $dev ?>;
	</script>
	
<style type="text/css">
.auto-style1 {
	text-decoration: underline;
}
.auto-style2 {
	background-color: #FF0000;
}
</style>
	
<?php
 
include_once("../../globals.php");
include_once("$srcdir/api.inc");
$obj = $formid ? formFetch("form_soap", $formid) : array();

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
    var service_code = '<?echo ($obj{"service_code"});?>';
    if(service_code == "H0032"){
        $("#review").hide();
        $("#review2").hide();
    } else {
        $("#review").show();
        $("#review2").show();
    }
    
});
</script>



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
		<h2>Progress Note</h2>
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
							  <ul class="col-md-9 nav nav-pills">
								<li class="active"><a data-toggle="pill" href="#problem_definitions_1">Problems / Definitions</a></li>
								<!--<li id="review" style="display:none;"><a data-toggle="pill" href="#reviews">Reviews</a></li>-->
								<li><a data-toggle="pill" href="#goals_1">Goals</a></li>
								<!--<li><a data-toggle="pill" href="#objectives_1">Objectives / Interventions</a></li>
								<li><a data-toggle="pill" href="#modalities_1">Modality</a></li>
								<li><a data-toggle="pill" href="#modalitynotes_1">Modality Note</a></li>
								<!--<li id="review2" style="display:none;">-->
								<!--<li><a data-toggle="pill" href="#discharge_criteria">Discharge Criteria</a></li>
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
										<button id="addProblem" class="btn" >Add Problem<?php echo $pid; ?></button><br/>
										<ul class="list-unstyled" id="problems_list" >
											<li class="itemList" editortype="problem_item" recid="1" ></li>
										</ul>
										
										<div class="section hidden editor" >
											<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											<textarea class="textarea-sm"  id="problems_Description_2"  ></textarea><br/>
											<div data-bind="tiControl: {
																id: 'problems_Description_2',
																page: 'soap/edit.php',
																storeid: ['problems_GroupID','problems_ProblemNumber'] ,
																appendvalue: false,
																params: {pid: <?php echo $pid; ?>, encounter: <?php echo $encounter; ?>, tpformid: <?php echo $tpformid; ?>},
																version: 2
																}, tiVM: $data"></div>
											IsPrimary <input type='text' id='problems_IsPrimary'  />
											Copied Form Id <input type='text' id='65_form_id'>																
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
											<textarea class="textarea-sm" id="goals_Description" ></textarea><br/>
											<div data-bind="tiControl: {
																id: 'goals_Description',
																page: 'soap/edit.php',
																storeid: ['goals_GoalNumber'] ,
																appendvalue: false,
																params: {pid: <?php echo $pid; ?>, encounter: <?php echo $encounter; ?>, tpformid: <?php echo $tpformid; ?>},
																version: 1
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
								
								<!------Tab Reviews  ---------->
								<div id="reviews" class="tab-pane col-md-9">
									
									<div class="row">
							  <ul class="nav nav-tabs">
								<li class="active"><a data-toggle="pill" href="#strength">Strength and Assets</a></li>
								<li><a href="#weakness" data-toggle="pill">Weaknesses (Limitations) or Special Needs</a></li>
								<li><a href="#summary" data-toggle="pill">Summary of Patient's Progress</a></li>
							  </ul>
							</div>
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
