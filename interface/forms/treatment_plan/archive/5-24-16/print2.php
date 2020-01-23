<!DOCTYPE html>
<html lang="en">
<head>
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
	<link href="<?php echo "$web_root";?>/openemr/library/textimporter/textimporter.css" rel="stylesheet"></link>

	<!-- bootstrap -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

	<!-- page querystring parameters -->
	<script type="text/javascript">
	<?php 
		$formid = 0 + (isset($_GET['formid']) ? $_GET['formid'] : 0); 
		$dev	= 0 + (isset($_GET['dev']) ? $_GET['dev'] : 0); 
	?>
		var dev = <?php echo $dev ?>;
	</script>
	<!-- resources for this page -->
	<link rel="stylesheet" href="print.css" >
	<script src="tabs3api.js" type="text/javascript" ></script>
	<script src="tabs3scrape.js" type="text/javascript" ></script>
	<script src="print.js" type="text/javascript" ></script>

</head>
<body>
						<div class="row">
								<div class="col-md-9">
									Select Problem &nbsp;
									<select id="availableProblems"></select> &nbsp;
									<span  class="dev" >saved form id </span><input id="form_id" class="dev" value="<?php echo $formid ?>" /> &nbsp;
									<span  class="dev" >tp_problem_number </span><input type='text' class="dev" id='tp_problem_number' />
								</div>
							</div>
						
						<!--
						  <div class="row">
								<div class="col-md-9">
									Select Problem &nbsp;
									<span>saved form id </span><input type="hidden" id="availableProblems" class="dev" value="1" /> &nbsp;
									<span  class="dev" >saved form id </span><input type="hidden" id="form_id" class="dev" value="12" /> &nbsp;
									<span  class="dev" >tp_problem_number </span><input type='text' class="dev" id='tp_problem_number' value="1" />
								</div>
							</div>
-->
							
									<h3>Problem</h3>
										<ul class="list-unstyled" id="problems_list" >
											<li class="itemList" editortype="problem_item" recid="1" ></li>
										</ul>
										
										
											
											
																			
									
										<h3>Behavioral Definitions</h3>
										
										<ul class="list-unstyled"  id="bd_list" >
											<li class="itemList" editortype="bd_item" recid="1" ></li>
										</ul>
										
										
								
								
<!--								<div id="goals_1" class="tab-pane col-md-9">  -->
									
										<h3>Goals for Problem</h3>
										
										<ul class="list-unstyled" id="goals_list" >
											<li class="itemList" editortype="goal_item" recid="1" ></li>
										</ul>
										
										
																	
									<h3>Objectives for Problem</h3>
										
										
										<ul class="list-unstyled" id="objectives_list" >
											<li class="itemList" editortype="objective_item" recid="1" ></li>
										</ul>
										
										
								
									
									
										<h3>Interventions for Objective</h3>
										
										
										<ul class="list-unstyled"  id="interventions_list" >
											<li class="itemList" editortype="intervention_item" recid="1" ></li>
										</ul>
										
										
									
					<!------NESTED1---------->
			
					<!------NESTED5---------->	
								
										<h3>Modalities</h3>
										<p>Modality &nbsp;&nbsp;HCPT Code  &nbsp;&nbsp;Interval  &nbsp;&nbsp;Frequency  &nbsp;&nbsp;Responsible Provider</p>
										
										
										<ul class="list-unstyled" id="modalities_list" >
											<li class="itemList" editortype="modality_item" recid="1" ></li>
										</ul>
													
										
										
								
					<!------NESTED6---------->
								<div id="modalitynotes_1" class="tab-pane col-md-9">
									<div class="section" id="modalitynotessection" >
										<h3>Modality Notes</h3>
										
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
												
											</div>
										</div>
									</div>
								</div>

               






</body>
</html>
