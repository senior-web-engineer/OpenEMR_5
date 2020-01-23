<?php
include_once("../../globals.php");
include_once("$srcdir/api.inc");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>Medication Management - Print Form</title>
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
		<script type="text/javascript" src="SigWebTablet.js"></script>
		<!-- SQL/PHP queries -->
		<?php $res = sqlStatement("SELECT fname,mname,lname,ss,sex,DOB,pid FROM patient_data WHERE pid = $pid");
		$result = SqlFetchArray($res); 
		$provider_results = sqlQuery("select fname, mname, lname from users where username='" . $_SESSION{"authUser"} . "'");
		$rendering_provider = sqlQuery("SELECT u.fname, u.mname, u.lname FROM (SELECT provider_id FROM form_encounter where encounter='$encounter') AS e LEFT JOIN (SELECT fname, mname, lname, id FROM  users) AS u ON e.provider_id = u.id");
		$dos = sqlQuery("select date from form_encounter where encounter=$encounter");
		$obj = formFetch("form_med_management", $_GET["id"]);
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
		
	</head>

<body>
<form method=post action="<?php echo $rootdir?>/forms/med_management/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="my_form">

<div class="page_template">  
<!--ORIGINAL HEADER	<div class='header'>This is a header<hr></div>   -->
	<div class='header'>
	<!-- Info Header -->
		<h1>Medication Management</h1>
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
				<span>Date of Service:</span><?php echo substr($dos["date"], 0, 10); ?><br>
				<span>Admission Date:</span><?php echo stripslashes($result{"admit_date"});?>
				<!--<span>Psychiatrist:</span><?php echo $rendering_provider["fname"].' '.$rendering_provider["mname"].' '.$rendering_provider["lname"]; ?><br>-->
				<span>Psychiatrist:</span><?php echo stripslashes($obj{"physician"}); ?><br>
				<span>Sex:</span><?php echo $result['sex'];?>
				<span>Referral Source:</span><?php echo $obj['referral_source'];?><br>				
			</div>
			<br class="clr">
		</div>
	<hr></div>  
	<div class='content'></div>  
	<div class='footer'><hr><span>Page: </span>Parent's Information &amp; Resource Center</div>  
</div> 
<div id="newsletterContent">

<!-- Notes -->
	<div class="form-group">
		<div class="form-group"><b>Service Code:</b> <?php echo stripslashes($obj{"servicecode"});?></div>
		<div class="form-group">
			<b>Patient has the following complaints(If no complaints, type none):</b>
			<span class="pre"><?php echo stripslashes($obj{"complaint"});?></span>
		</div>
		<div class="form-group"><b>ETOH Abuse:</b> <?php echo stripslashes($obj{"etoh"});?></div>
		<div class="form-group"><b>Drug Abuse:</b> <?php echo stripslashes($obj{"drug_abuse"});?></div>
		<div class="form-group"><b>Abnormal Movements:</b> <?php echo stripslashes($obj{"ab_movements"});?></div>
		<div class="form-group"><b>Memory:</b> <?php echo stripslashes($obj{"memory"});?></div>
		<div class="form-group"><b>A/V Hallucinations:</b> <?php echo stripslashes($obj{"hallucinations"});?></div>
		<div class="form-group"><b>S/H Ideation:</b> <?php echo stripslashes($obj{"sh_ideation"});?></div>
		<div class="form-group"><b>Paranoid Ideation:</b> <?php echo stripslashes($obj{"paranoid"});?></div>
		<div class="form-group">
			<b>Mood:</b> 
			<span class="pre"><?php echo stripslashes($obj{"mood"});?></span>
		</div>
		<div class="form-group">
			<b>Affect:</b> 
			<span class="pre"><?php echo stripslashes($obj{"affect"});?></span>
		</div>
		<div class="form-group">
			<h3>DSM Diagnoses</h3>
			<span><b>Axis I:</b> </span>
			<span class="pre"><?php echo stripslashes($obj{"axis1"});?></span>
		</div>
		<div class="form-group">
			<h3>Plan:</h3>
			<div class="form-group">
				<b>Psychotropic Medication:</b> 
				<span class="pre"><?php echo stripslashes($obj{"psychotropic_med"});?></span>
			</div>
			<div class="form-group"><b>Side Effects Explained(when applicable):</b> <?php echo stripslashes($obj{"side_effect_explained"});?></div>
			<div class="form-group">
				<b>Labs ordered/Results(if applicable):</b> 
				<span class="pre"><?php echo stripslashes($obj{"labs_ordered"});?></span>
			</div>
			<div class="form-group">
				<b>Return to clinic in:</b> 
				<span><?php echo stripslashes($obj{"return_to_clinic"});?><?php echo stripslashes($obj{"time_frame"});?></span>
			</div>
			<div class="form-group"><b>Other:</b> 
				<span class="pre"><?php echo stripslashes($obj{"other"});?></span>
			</div>
		</div>
	</div>

	<!-- Signature -->
	<div class="sig">
		<div class="col1">
			<span class="u"><?php echo stripslashes($obj{"signature"});?>, <?php echo stripslashes($obj{"credentials"});?></span>
			Provider Print Name<br><br>
			<!--
			<span class="u"><?php echo stripslashes($obj{"sup_signature"});?>, <?php echo stripslashes($obj{"sup_credentials"});?> </span>
			Supervisor Print Name
			-->
		</div>
		<div class="col1">
			<span class="u"><?php echo stripslashes($obj{"signature"});?>, <?php echo stripslashes($obj{"credentials"});?></span><span>Electronically Signed By</span>
			<br><br>
			<!--
			<span class="u"><?php echo stripslashes($obj{"sup_signature"});?>, <?php echo stripslashes($obj{"sup_credentials"});?></span><span>Electronically Signed By</span>
			-->
		</div>
		
		<div class="col3">	
			<span class="u"><?php echo stripslashes($obj{"sig_date"});?></span>
			Date<br><br>
			<!---
			<span class="u"><?php echo stripslashes($obj{"sup_sig_date"});?></span>
			Date
			-->
		</div>
		
	</div>
</div>
</form>
</body>
</html>
