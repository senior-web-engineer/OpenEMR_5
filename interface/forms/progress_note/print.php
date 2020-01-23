<?php

//SANITIZE ALL ESCAPES
 $sanitize_all_escapes=true;

 //STOP FAKE REGISTER GLOBALS
 $fake_register_globals=false;
 
include_once("../../globals.php");
include_once("$srcdir/api.inc");
require_once("$srcdir/patient.inc");
require_once("$srcdir/options.inc.php");
formHeader("Form:Progress Note");
$returnurl = $GLOBALS['concurrent_layout'] ? 'encounter_top.php' : 'patient_encounter.php';
$formid = 0 + (isset($_GET['id']) ? $_GET['id'] : '');
$obj = $formid ? formFetch("form_progress_note", $formid) : array();
$form_name = stripslashes($obj{"note_type"});
$ures = sqlStatement("SELECT id, username, fname, lname FROM users WHERE " . "authorized != 0 AND active = 1 ORDER BY lname, fname");
$res = sqlStatement("SELECT fname,mname,lname,ss,sex,DOB,pid FROM patient_data WHERE pid = $pid");
$result = SqlFetchArray($res); 
$provider_results = sqlQuery("select fname, mname, lname from users where username='" . $_SESSION{"authUser"} . "'");
// $rendering_provider = sqlQuery("SELECT u.fname, u.mname, u.lname FROM (SELECT provider_id FROM form_encounter where encounter='$encounter') AS e LEFT JOIN (SELECT fname, mname, lname, id FROM  users) AS u ON e.provider_id = u.id");
$dos = sqlQuery("select date from form_encounter where encounter=$encounter");

?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php html_header_show();?>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>SOAP Progress Note</title>
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

<!-- Additional -->
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/signaturepad/SigWebTablet.js"></script>

		<!--Columnizer formatting-->
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

</head>

<body>

<div class="page_template">  
<!--ORIGINAL HEADER	<div class='header'>This is a header<hr></div>   -->
	<div class='header'>
	<!-- Info Header -->
		<h3>Progress Note - <?php echo $form_name; ?></h3>
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
				<span>Sex:</span><?php echo $result['sex'];?><br>
				<span>SS#:</span><?php echo $result['ss'];?>
				<span>Date of Service:</span><?php echo substr($dos["date"], 0, 10); ?><br>
				<span>Clinician:</span><?php echo stripslashes($obj{"provider_print_name"});?><br>
				<span>Time Started:</span><?php echo stripslashes($obj{"time_start"});?>
				<span>Time Ended :</span><?php echo stripslashes($obj{"time_end"});?><br>

				
			</div>
			<br class="clr">
		</div>
	<hr></div>  
	<div class='content'></div>  
	<div class='footer'><hr><span>Page: </span><?php echo $facility['name']?><br></div>  
</div> 
<div id="newsletterContent">

<!--main-->
<div>
	<div class="form-group group">
		<h3>Diagnosis:</h3>
		<div><span><?php echo stripslashes($obj{"diagnosis1"});?></span></div>
		<div><span><?php echo stripslashes($obj{"diagnosis2"});?></span></div>
		<div><span><?php echo stripslashes($obj{"diagnosis3"});?></span></div>
		<div><span><?php echo stripslashes($obj{"diagnosis4"});?></span></div>

		<ul>
			<?php 
		

//echo "<td class='style4'>PID</td>       <td class='style4'>Last Name</td> <td class='style4'>First Name</td><td class='style4'>Provider</td>  <td class='style4'><B>Last Encounter</B></td><td class='style4'> Days Since Last Encounter</td> <td class='style4'><B>Last Treatment Plan</B></td> <td class='style4'>Days Since Last TP</td> <td class='style4'><B>Last Treatment Plan Review</B></td> <td class='style4'>Days Since Last TP/R</td><td class='style4'><B>Last C/FARS</B></td><td class='style4'>Days Since Last C/FARS</td><td class='style4'><B>Last Psych Eval</B></td><td class='style4'> Days Since Last Psych Eval</td></tr>";
			$mysqli = new mysqli($host, $login, $pass, $dbase); 
			  $query = "SELECT id, IsPrimary, description FROM form_progress_problems WHERE (form_id='$id' AND pid = '{$GLOBALS['pid']}') AND IsDeleted = 0 ORDER BY IsPrimary " ;
				$result = $mysqli -> query ($query);			 			while($row = mysqli_fetch_assoc($result)) {
			   			$problem_id 	  = $row['id'];
			   			echo "<li><h4>Problem: <i>".$row['description']."</i></h4></li>";
						//---- Goals---- ----- 
										echo "<ul><li><h5>Goal(s):<h5></li></ul>";
										 $query_2 = "SELECT id, problem_id, description AS goaldescription ".
													"FROM form_progress_notes_goals ".
													"WHERE (form_id='$id' AND problem_id = $problem_id) AND IsDeleted = 0 " ;
				 							$result_2 = $mysqli -> query ($query_2); 
				 								while($row_2 = mysqli_fetch_assoc($result_2)) {
			   										echo "<ul>";
			   										echo "<ul><li><i>".$row_2['goaldescription']."</i></li></ul>";
													echo "</ul>";
																 							 }
						
						//---- Objectives ----- 
						//				echo "<ul><li><h5>Objective(s):<h5></li></ul>";
						//				$query_3 = "SELECT oj.id AS ojid, oj.Description AS ojdescription, oj.ObjectiveNumber AS ojObjectiveNumber ".
						//							"FROM form_progress_notes_objectives AS oj ".
						//							"WHERE oj.form_id = $id AND oj.problem_id = $problem_id and (IsDeleted is Null or IsDeleted = 0) ".
						//							"ORDER BY oj.id";
						//					$result_3 = $mysqli -> query ($query_3); 
						//						while ($row_3 = mysql_fetch_array($result_3)) { 
						//							echo "<ul>";
						//							echo "<ul><li><i>".$row_3['ojdescription']."</i></li></ul>";
						//							echo "</ul>";
						//										}
						//***************************************************
																
																}
			?>
		</ul>
	</div>
<?php
			if ($form_name == "IND" || $form_name == "TBO"|| $form_name == "GRP")
			{
?>

	<div id="GroupA" class="form-group group">
		<h3>Treatment Goal:</h3>
		<span name="goal"><?php echo stripslashes($obj{"goal"});?></span>
	</div>

	<div id="GroupB" class="form-group group">
		<h3>Subjective:</h3>
		<span name="subjective"><?php echo stripslashes($obj{"subjective"});?></span>
	</div>
	<div id="GroupC" class="form-group group">
		<h3>Objective:</h3>
		<span name="objective"><?php echo stripslashes($obj{"objective"});?></span>
	</div>
	<div id="GroupD" class="form-group group">
		<h3>Assessment:</h3>
		<span name="assessment"><?php echo stripslashes($obj{"assessment"});?></span>
	</div>
	<div id="GroupE" class="form-group group">
		<h3>Plan:</h3>
		<span name="plan"><?php echo stripslashes($obj{"plan"});?></span>
	</div>
<?php
		}
?>
<?php
			if ($form_name == "PSR"|| $form_name == "DAY")
			{
?>

	<div id="GroupA" class="form-group group">
		<h3>Specific Treatment Plan Deficit/Problems/Behavior Addressed:</h3>
		<span name="deficit_problems_behavior_addressed"><?php echo stripslashes($obj{"deficit_problems_behavior_addressed"});?></span>
	</div>

	<div id="GroupB" class="form-group group">
		<h3>Intervention:</h3>
		<span name="interventions"><?php echo stripslashes($obj{"interventions"});?></span>
	</div>
	<div id="GroupC" class="form-group group">
		<h3>Response to Intervention:</h3>
		<span name="response_to_intervention"><?php echo stripslashes($obj{"response_to_intervention"});?></span>
	</div>
	
<?php
		}
?>

	

</div>
<?php
		include ("signature_print.php");
		?>
		

</div><!--/container-->

<script language="javascript">
$('.input-group.date').datepicker({
    format: 'yyyy-mm-dd',
    todayHighlight: true
});
</script>

<?php
formFooter();
?>