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
	<link rel="stylesheet" href="tabs3.css" >
	<script src="tabs3api.js" type="text/javascript" ></script>
	<script src="tabs3scrape.js" type="text/javascript" ></script>
	<script src="tabs3.js" type="text/javascript" ></script>

</head>
<body>
								<div id="diagnosis" class="tab-pane col-md-9">
									<div class="section">
										<h3>Diagnosis</h3>
										<button id="addDiagnosis" class="btn" >Add Diagnosis</button><br/>
										<ul class="list-unstyled" id="diagnosis_list" >
											<li class="itemList" editortype="diagnosis_item" recid="1" ></li>
										</ul>
										
										<div class="section hidden editor" >
											<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											<textarea class="textarea-sm"  id="diagnosis_Description"  disabled></textarea><br/>
											<div data-bind="tiControl: {
																id: 'diagnosis_Description',
																page: 'treatment_plan/edit.php',
																storeid: ['diagnosis_GroupID'] ,
																appendvalue: false,
																params: {id1: 0}
																}, tiVM: $data"></div>
											<span  class="dev" >
												id <input type='text' id='diagnosis_id' />
												GroupID <input type='text' id='diagnosis_GroupID' />
												Description <input type='text' id='diagnosis_Description' />
																							</span>
											<div class="clear text-right">
												<button class="btn postdiagnosis" action="delete">Delete</button>
												<button class="btn cancel">Cancel</button>
												<button class="btn postdiagnosis" action="save">Save Diagnosis</button>
											</div>
										</div>
									</div>
								</div>

                





</body>
</html>
