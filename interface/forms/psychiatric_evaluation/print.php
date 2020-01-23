<?php
include_once("../../globals.php");
include_once("$srcdir/api.inc");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>Psychiatric Evaluation - Print Form</title>
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
		$obj = formFetch("form_psychiatric_evaluation", $_GET["id"]);
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
		
<script language="javascript">
//Update Choice			
$(document).ready(function() {
if( $("#update_yes").prop("checked")) {
  $(".form-group").hide();
  $(".full-info").hide();
  $(".update-info").removeClass('hidden').show();
  $("#GroupH .update-info").insertAfter("#GroupG");
  $(".dev-update").insertAfter("#GroupH");
  $("#GroupP").insertBefore("#GroupG");
  $("#GroupESub1").insertBefore("#GroupG");
  $(".med-changes").insertBefore(".med-allergies");
  $(".update-info#GroupJSub4").insertBefore(".med-changes");
  $("textarea[name=med_medication_current]").insertAfter(".update-info#GroupJSub4");
  $(".update-info#GroupISub1").insertAfter(".med-allergies");
  $(".lab-changes").insertBefore(".update-info#GroupISub1");
  $("textarea[name=accidents_falls_hospitalization]").insertAfter(".update-info#GroupISub1");
  $(".update-info#GroupJSub2").insertAfter("#GroupO");
  $(".update-info.med-use").insertAfter(".update-info#GroupJSub2");
  $("textarea[name=med_use_profile]").insertAfter(".update-info#GroupJSub2");
  $('#update_yes').attr('checked', true);
  }
});
</script>
		
	</head>

<body>
<form method=post action="<?php echo $rootdir?>/forms/psychiatric_evaluation/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="my_form">

<div class="page_template">  
<!--ORIGINAL HEADER	<div class='header'>This is a header<hr></div>   -->
	<div class='header'>
	<!-- Info Header -->
		<h1>Psychiatric Evaluation <span class="hidden update-info">Update</span></h1>
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
				<span>Provider:</span><?php echo stripslashes($obj{"physician"}); ?><br>
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

	<form>
		<!-- Full/Update Choice -->
		  <div class="hidden">
			<label class="radio-inline"><input type="radio" name="update_choice" id="update_no" value="no" <?php if($obj['update_choice'] !== 'yes'): ?> checked="checked"<?php endif; ?>/>Full</label>
			<label class="radio-inline"><input type="radio" name="update_choice" id="update_yes" value="yes" <?php if($obj['update_choice'] == 'yes'): ?> checked="checked"<?php endif; ?>/>Update</label>
		  </div>
		<!-- end Full/Update Choice -->
		<div id="GroupA" class="form-group group dontsplit">
			<div class="form-inline">
				<span class="h3">Information Source:</span>
				<span><?php echo stripslashes($obj{"info_source"});?></span>
			</div>
		</div>
		<div id="GroupB" class="form-group group dontsplit">
			<h3>Chief Complaint/ Behavioral Concerns</h3>
			<span><?php echo stripslashes($obj{"complaint_behavior"});?></span>
		</div>
		<div id="GroupC" class="form-group group dontsplit">
			<h3>History of Present Illness:</h3>
			<span><?php echo stripslashes($obj{"history_of_present_illness"});?></span>
		</div>
		<div id="GroupD" class="form-group group dontsplit">
			<h3>Client HX <small>(Background Information, including social history &amp; cultural, religious &amp; spiritual influence):</small></h3>
			<span><?php echo stripslashes($obj{"client_hx"});?></span>
		</div>
		<div id="GroupE" class="form-group group dontsplit">
			<div class="form-inline">
				<span class="h3">Past Psychiatric History:</span>
				<label class="radio-inline"><input type="radio" name="psych_history" id="psych_hx_no" value="no" <?php if($obj['psych_history'] !== 'yes'): ?> checked="checked"<?php endif; ?>/>NO
				</label>
				<label class="radio-inline"><input type="radio" name="psych_history" id="psych_hx_yes" value="yes" <?php if($obj['psych_history'] == 'yes'): ?> checked="checked"<?php endif; ?> />YES
				</label>
				<script>
					$(document).ready( function() {
						if ($('#psych_hx_yes').is(":checked")){
							$('#collapse_psych_hx').collapse('show');
						}
					});
					$('input[name="psych_history"]').change( function() {
						if ($('#psych_hx_yes').is(":checked")){
							$('#collapse_psych_hx').collapse('show');
						} else {
							$('#collapse_psych_hx').collapse('hide');
						}
						if ($('#psych_hx_no').is(":checked")){
							$('#collapse_psych_hx').collapse('hide');
						} 
				  	});						
				</script>
			</div>
			<div class="collapse" id="collapse_psych_hx">
				<div id="GroupESub1" class="subgroup update-info">
					<h4 class="full-info">Outpatient Treatment <small>(specify when, where, treatment outcomes):</small></h4>
					<h3 class="hidden update-info">Psychiatric Update <small>(suicide, homicidal attempts, violence, inpatient hospitalizations):</small></h3>
					<span><?php echo stripslashes($obj{"outpatient_treatment"});?></span>
				</div>
				<div id="GroupESub2" class="subgroup">
					<h4>Inpatient Treatment <small>(specify when, where, treatment outcomes):</small></h4>
					<span><?php echo stripslashes($obj{"inpatient_treatment"});?></span>
				</div>
			</div>
		</div>
		<div id="GroupF" class="form-group group">
			<h3>History of Substance Use &amp; Treatment</h3>
			<div id="GroupFSub1" class="form-group row subgroup">
				<div class="col-xs-12">
					<label class="control-label">DRUGS</label>
					<div class="">
						<label class="radio-inline"><input type="radio" name="substance_drugs" id="drugs_no" value="no" <?php if($obj['substance_drugs'] !== 'yes'): ?> checked="checked"<?php endif; ?>/>No</label>
						<label class="radio-inline"><input type="radio" name="substance_drugs" id="drugs_yes" value="yes" <?php if($obj['substance_drugs'] == 'yes'): ?> checked="checked"<?php endif; ?>/>YES</label>
						<script>
							$(document).ready( function() {
								if ($('#drugs_yes').is(":checked")){
									$('#collapse_drugs').collapse('show');
								}
							});
							$('input[name="substance_drugs"]').change( function() {
								if ($('#drugs_yes').is(":checked")){
									$('#collapse_drugs').collapse('show');
								} else {
									$('#collapse_drugs').collapse('hide');
								}
								if ($('#drugs_no').is(":checked")){
									$('#collapse_drugs').collapse('hide');
								} 
						  });						
						</script>
					</div>
				</div>
			</div>
			<div class="collapse" id="collapse_drugs">
				<div id="GroupFSub2" class="form-group row subgroup dontsplit">
					<div class="col-xs-5">
						<label class="control-label">ALCOHOL</label>
						<div class="">
							<label class="radio-inline"><input type="radio" name="substance_alcohol" value="no" <?php echo ($obj['substance_drugs'] == "no" ? 'checked="checked"': ''); ?> <?php echo ($obj['substance_alcohol'] == "no" ? 'checked="checked"': ''); ?>/>NO</label>
							<label class="radio-inline"><input type="radio" name="substance_alcohol" value="yes" <?php echo ($obj['substance_alcohol'] == "yes" ? 'checked="checked"': ''); ?>/>YES</label>
							<label class="radio-inline"><input type="radio" name="substance_alcohol" value="daily" <?php echo ($obj['substance_alcohol'] == "daily" ? 'checked="checked"': ''); ?>/>DAILY</label>
							<label class="radio-inline"><input type="radio" name="substance_alcohol" value="weekly" <?php echo ($obj['substance_alcohol'] == "weekly" ? 'checked="checked"': ''); ?>/>WEEKLY</label>
							<label class="radio-inline"><input type="radio" name="substance_alcohol" value="monthly" <?php echo ($obj['substance_alcohol'] == "monthly" ? 'checked="checked"': ''); ?>/>MONTHLY</label> 
						</div>
					</div>
					<div class="col-xs-3">
						<label>DATE STARTED USING</label>
						<div class="input-group date">
					  		<span><?php echo stripslashes($obj{"substance_alcohol_start_date"});?></span>
						</div>
					</div>
					<div class="col-xs-4">
						<label>IF NOT USING NOW LAST DAY USED</label>
						<div class="input-group date">
					  		<span><?php echo stripslashes($obj{"substance_alcohol_last_used"});?></span>
						</div>
					</div>		
				</div>
				<div id="GroupFSub3" class="form-group row subgroup dontsplit">
					<div class="col-xs-5">
						<label class="control-label">COCAINE</label>
						<div class="">
							<label class="radio-inline"><input type="radio" name="substance_cocaine" value="no" <?php echo ($obj['substance_drugs'] == "no" ? 'checked="checked"': ''); ?> <?php echo ($obj['substance_cocaine'] == "no" ? 'checked="checked"': ''); ?>/>NO</label>
							<label class="radio-inline"><input type="radio" name="substance_cocaine" value="yes" <?php echo ($obj['substance_cocaine'] == "yes" ? 'checked="checked"': ''); ?>/>YES</label>
							<label class="radio-inline"><input type="radio" name="substance_cocaine" value="daily" <?php echo ($obj['substance_cocaine'] == "daily" ? 'checked="checked"': ''); ?>/>DAILY</label>
							<label class="radio-inline"><input type="radio" name="substance_cocaine" value="weekly" <?php echo ($obj['substance_cocaine'] == "weekly" ? 'checked="checked"': ''); ?>/>WEEKLY</label>
							<label class="radio-inline"><input type="radio" name="substance_cocaine" value="monthly" <?php echo ($obj['substance_cocaine'] == "monthly" ? 'checked="checked"': ''); ?>/>MONTHLY</label> 
						</div>
					</div>
					<div class="col-xs-3">
						<label>DATE STARTED USING</label>
						<div class="input-group date">
					  		<span><?php echo stripslashes($obj{"substance_cocaine_start_date"});?></span>
						</div>
					</div>
					<div class="col-xs-4">
						<label>IF NOT USING NOW LAST DAY USED</label>
						<div class="input-group date">
					  		<span><?php echo stripslashes($obj{"substance_cocaine_last_used"});?></span>
						</div>
					</div>		
				</div>
				<div id="GroupFSub4" class="form-group row subgroup dontsplit">
					<div class="col-xs-5">
						<label class="control-label">CRACK</label>
						<div class="">
							<label class="radio-inline"><input type="radio" name="substance_crack" value="no" <?php echo ($obj['substance_drugs'] == "no" ? 'checked="checked"': ''); ?> <?php echo ($obj['substance_crack'] == "no" ? 'checked="checked"': ''); ?>/>NO</label>
							<label class="radio-inline"><input type="radio" name="substance_crack" value="yes" <?php echo ($obj['substance_crack'] == "yes" ? 'checked="checked"': ''); ?> />YES</label>
							<label class="radio-inline"><input type="radio" name="substance_crack" value="daily" <?php echo ($obj['substance_crack'] == "daily" ? 'checked="checked"': ''); ?> />DAILY</label>
							<label class="radio-inline"><input type="radio" name="substance_crack" value="weekly" <?php echo ($obj['substance_crack'] == "weekly" ? 'checked="checked"': ''); ?> />WEEKLY</label>
							<label class="radio-inline"><input type="radio" name="substance_crack" value="monthly" <?php echo ($obj['substance_crack'] == "monthly" ? 'checked="checked"': ''); ?> />MONTHLY</label> 
						</div>
					</div>
					<div class="col-xs-3">
						<label>DATE STARTED USING</label>
						<div class="input-group date">
					  		<span><?php echo stripslashes($obj{"substance_crack_start_date"});?></span>
						</div>
					</div>
					<div class="col-xs-4">
						<label>IF NOT USING NOW LAST DAY USED</label>
						<div class="input-group date">
					  		<span><?php echo stripslashes($obj{"substance_crack_last_used"});?></span>
						</div>
					</div>		
				</div>
				<div id="GroupFSub5" class="form-group row subgroup dontsplit">
					<div class="col-xs-5">
						<label class="control-label">MARIJUANA</label>
						<div class="">
							<label class="radio-inline"><input type="radio" name="substance_marijuana" value="no" <?php echo ($obj['substance_drugs'] == "no" ? 'checked="checked"': ''); ?> <?php echo ($obj['substance_marijuana'] == "no" ? 'checked="checked"': ''); ?>/>NO</label>
							<label class="radio-inline"><input type="radio" name="substance_marijuana" value="yes" <?php echo ($obj['substance_marijuana'] == "yes" ? 'checked="checked"': ''); ?> />YES</label>
							<label class="radio-inline"><input type="radio" name="substance_marijuana" value="daily" <?php echo ($obj['substance_marijuana'] == "daily" ? 'checked="checked"': ''); ?> />DAILY</label>
							<label class="radio-inline"><input type="radio" name="substance_marijuana" value="weekly" <?php echo ($obj['substance_marijuana'] == "weekly" ? 'checked="checked"': ''); ?> />WEEKLY</label>
							<label class="radio-inline"><input type="radio" name="substance_marijuana" value="monthly" <?php echo ($obj['substance_marijuana'] == "monthly" ? 'checked="checked"': ''); ?> />MONTHLY</label> 
						</div>
					</div>
					<div class="col-xs-3">
						<label>DATE STARTED USING</label>
						<div class="input-group date">
					  		<span><?php echo stripslashes($obj{"substance_marijuana_start_date"});?></span>
						</div>
					</div>
					<div class="col-xs-4">
						<label>IF NOT USING NOW LAST DAY USED</label>
						<div class="input-group date">
					  		<span><?php echo stripslashes($obj{"substance_marijuana_last_used"});?></span>
						</div>
					</div>		
				</div>
				<div id="GroupFSub6" class="form-group row subgroup dontsplit">
					<div class="col-xs-5">
						<label class="control-label">HEROIN</label>
						<div class="">
							<label class="radio-inline"><input type="radio" name="substance_heroin" value="no" <?php echo ($obj['substance_drugs'] == "no" ? 'checked="checked"': ''); ?> <?php echo ($obj['substance_heroin'] == "no" ? 'checked="checked"': ''); ?>/>NO</label>
							<label class="radio-inline"><input type="radio" name="substance_heroin" value="yes" <?php echo ($obj['substance_heroin'] == "yes" ? 'checked="checked"': ''); ?> />YES</label>
							<label class="radio-inline"><input type="radio" name="substance_heroin" value="daily" <?php echo ($obj['substance_heroin'] == "daily" ? 'checked="checked"': ''); ?> />DAILY</label>
							<label class="radio-inline"><input type="radio" name="substance_heroin" value="weekly" <?php echo ($obj['substance_heroin'] == "weekly" ? 'checked="checked"': ''); ?> />WEEKLY</label>
							<label class="radio-inline"><input type="radio" name="substance_heroin" value="monthly" <?php echo ($obj['substance_heroin'] == "monthly" ? 'checked="checked"': ''); ?> />MONTHLY</label> 
						</div>
					</div>
					<div class="col-xs-3">
						<label>DATE STARTED USING</label>
						<div class="input-group date">
					  		<span><?php echo stripslashes($obj{"substance_heroin_start_date"});?></span>
						</div>
					</div>
					<div class="col-xs-4">
						<label>IF NOT USING NOW LAST DAY USED</label>
						<div class="input-group date">
					  		<span><?php echo stripslashes($obj{"substance_heroin_last_used"});?></span>
						</div>
					</div>		
				</div>
				<div id="GroupFSub7" class="form-group row subgroup dontsplit">
					<div class="col-xs-5">
						<label class="control-label">LSD</label>
						<div class="">
							<label class="radio-inline"><input type="radio" name="substance_lsd" value="no" <?php echo ($obj['substance_drugs'] == "no" ? 'checked="checked"': ''); ?> <?php echo ($obj['substance_lsd'] == "no" ? 'checked="checked"': ''); ?>/>NO</label>
							<label class="radio-inline"><input type="radio" name="substance_lsd" value="yes" <?php echo ($obj['substance_lsd'] == "yes" ? 'checked="checked"': ''); ?> />YES</label>
							<label class="radio-inline"><input type="radio" name="substance_lsd" value="daily" <?php echo ($obj['substance_lsd'] == "daily" ? 'checked="checked"': ''); ?> />DAILY</label>
							<label class="radio-inline"><input type="radio" name="substance_lsd" value="weekly" <?php echo ($obj['substance_lsd'] == "weekly" ? 'checked="checked"': ''); ?> />WEEKLY</label> 
							<label class="radio-inline"><input type="radio" name="substance_lsd" value="monthly" <?php echo ($obj['substance_lsd'] == "monthly" ? 'checked="checked"': ''); ?> />MONTHLY</label> 
						</div>
					</div>
					<div class="col-xs-3">
						<label>DATE STARTED USING</label>
						<div class="input-group date">
					  		<span><?php echo stripslashes($obj{"substance_lsd_start_date"});?></span>
						</div>
					</div>
					<div class="col-xs-4">
						<label>IF NOT USING NOW LAST DAY USED</label>
						<div class="input-group date">
					  		<span><?php echo stripslashes($obj{"substance_lsd_last_used"});?></span>
						</div>
					</div>		
				</div>
				<div id="GroupFSub8" class="form-group row subgroup dontsplit">
					<div class="col-xs-5">
						<div class="form-inline">
							<label class="control-label">SMOKE</label> <span><?php echo stripslashes($obj{"substance_smoke_type"});?></span>
						</div>	
						<div class="">
							<label class="radio-inline"><input type="radio" name="substance_smoke" value="no" <?php echo ($obj['substance_drugs'] == "no" ? 'checked="checked"': ''); ?> <?php echo ($obj['substance_smoke'] == "no" ? 'checked="checked"': ''); ?>/>NO</label>
							<label class="radio-inline"><input type="radio" name="substance_smoke" value="yes" <?php echo ($obj['substance_smoke'] == "yes" ? 'checked="checked"': ''); ?> />YES</label>
							<label class="radio-inline"><input type="radio" name="substance_smoke" value="daily" <?php echo ($obj['substance_smoke'] == "daily" ? 'checked="checked"': ''); ?> />DAILY</label>
							<label class="radio-inline"><input type="radio" name="substance_smoke" value="weekly" <?php echo ($obj['substance_smoke'] == "weekly" ? 'checked="checked"': ''); ?> />WEEKLY</label>
							<label class="radio-inline"><input type="radio" name="substance_smoke" value="monthly" <?php echo ($obj['substance_smoke'] == "monthly" ? 'checked="checked"': ''); ?> />MONTHLY</label> 
						</div>
					</div>
					<div class="col-xs-3">
						<label>DATE STARTED USING</label>
						<div class="input-group date">
					  		<span><?php echo stripslashes($obj{"substance_smoke_start_date"});?></span>
						</div>
					</div>
					<div class="col-xs-4">
						<label>IF NOT USING NOW LAST DAY USED</label>
						<div class="input-group date">
					  		<span><?php echo stripslashes($obj{"substance_smoke_last_used"});?></span>
						</div>
					</div>		
				</div>
				<div id="GroupFSub9" class="form-group row subgroup dontsplit">
					<div class="col-xs-5">
						<div class="form-inline">
							<label class="control-label">OTHER</label> <span><?php echo stripslashes($obj{"substance_other_type"});?></span>
						</div>	
						<div class="">
							<label class="radio-inline"><input type="radio" name="substance_other" value="no" <?php echo ($obj['substance_drugs'] == "no" ? 'checked="checked"': ''); ?> <?php echo ($obj['substance_other'] == "no" ? 'checked="checked"': ''); ?>/>NO</label>
							<label class="radio-inline"><input type="radio" name="substance_other" value="yes" <?php echo ($obj['substance_other'] == "yes" ? 'checked="checked"': ''); ?> />YES</label>
							<label class="radio-inline"><input type="radio" name="substance_other" value="daily" <?php echo ($obj['substance_other'] == "daily" ? 'checked="checked"': ''); ?> />DAILY</label>
							<label class="radio-inline"><input type="radio" name="substance_other" value="weekly" <?php echo ($obj['substance_other'] == "weekly" ? 'checked="checked"': ''); ?> />WEEKLY</label>
							<label class="radio-inline"><input type="radio" name="substance_other" value="monthly" <?php echo ($obj['substance_other'] == "monthly" ? 'checked="checked"': ''); ?> />MONTHLY</label> 
						</div>
					</div>
					<div class="col-xs-3">
						<label>DATE STARTED USING</label>
						<div class="input-group date">
					  		<span><?php echo stripslashes($obj{"substance_other_last_used"});?></span>
						</div>
					</div>
					<div class="col-xs-4">
						<label>IF NOT USING NOW LAST DAY USED</label>
						<div class="input-group date">
					  		<span><?php echo stripslashes($obj{"substance_other_last_used"});?></span>
						</div>
					</div>		
				</div>
			</div>
		</div><!--/collapse-->
		<div id="GroupG" class="form-group group dontsplit update-info">
			<h3 class="full-info">Recovery/Treatment:</h3>
			<h3 class="hidden update-info">Substance Use/Abuse Update:</h3>
			<span><?php echo stripslashes($obj{"recovery_treatment"});?></span>
		</div>
		<div id="GroupH" class="form-group group dontsplit">
			<h3 class="full-info">Developmental/Behavioral History: <small>(Required for children, adolescents &amp; when relevant for adults)</small></h3>
			<h3 class="hidden update-info">Developmental Update:</h3>
			<h4 id="GroupHSub1" class="subgroup">Pregnancy, Labor, &amp; Delivery</h4>
			<div class="form-inline">
				<label><input name="pregnancy_normal" type="checkbox" <?php echo ($obj['pregnancy_normal'] == "on" ? 'checked="checked"': ''); ?>/> Normal</label>
				<label><input name="pregnancy_notknown" type="checkbox" <?php echo ($obj['pregnancy_notknown'] == "on" ? 'checked="checked"': ''); ?>/> Not known</label>
				<label><input name="pregnancy_complications" type="checkbox" <?php echo ($obj['pregnancy_complications'] == "on" ? 'checked="checked"': ''); ?>/> Complications, describe:</label> <span><?php echo stripslashes($obj{"pregnancy_complications_desc"});?></span> 
			</div>
			<h4 id="GroupHSub2" class="subgroup">Developmental Delays</h4>
			<div class="form-inline">
				<label><input name="dev_delay_none" type="checkbox" <?php echo ($obj['dev_delay_none'] == "on" ? 'checked="checked"': ''); ?>/> None</label>
				<label><input name="dev_delay_notknown" type="checkbox" <?php echo ($obj['dev_delay_notknown'] == "on" ? 'checked="checked"': ''); ?>/> Not known</label>
				<label><input name="dev_delay_yes" type="checkbox" <?php echo ($obj['dev_delay_yes'] == "on" ? 'checked="checked"': ''); ?>/> Yes, describe:</label> <span><?php echo stripslashes($obj{"dev_delay_desc"});?></span> 
			</div>
			<h4 id="GroupHSub3" class="subgroup">Behavioral Concerns <small>(Optional For Adults)</small></h4>
			<div class="form-inline">
				<label><input name="behavior_concerns_thumbsucking" type="checkbox" <?php echo ($obj['behavior_concerns_thumbsucking'] == "on" ? 'checked="checked"': ''); ?>/> Thumb Sucking</label>
				<label><input name="behavior_concerns_headbanging" type="checkbox" <?php echo ($obj['behavior_concerns_headbanging'] == "on" ? 'checked="checked"': ''); ?>/> Head Banging</label>
				<label><input name="behavior_concerns_cursing" type="checkbox" <?php echo ($obj['behavior_concerns_cursing'] == "on" ? 'checked="checked"': ''); ?>/> Cursing</label>
				<label><input name="behavior_concerns_clothessoiling" type="checkbox" <?php echo ($obj['behavior_concerns_clothessoiling'] == "on" ? 'checked="checked"': ''); ?>/> Clothes Soiling</label>
				<label><input name="behavior_concerns_rocking" type="checkbox" <?php echo ($obj['behavior_concerns_rocking'] == "on" ? 'checked="checked"': ''); ?>/> Rocking</label>
				<label><input name="behavior_concerns_cryingspells" type="checkbox" <?php echo ($obj['behavior_concerns_cryingspells'] == "on" ? 'checked="checked"': ''); ?>/> Crying Spells</label>
				<label><input name="behavior_concerns_bedwetting" type="checkbox" <?php echo ($obj['behavior_concerns_bedwetting'] == "on" ? 'checked="checked"': ''); ?>/> Bed Wetting</label>
				<label><input name="behavior_concerns_nailbiting" type="checkbox" <?php echo ($obj['behavior_concerns_nailbiting'] == "on" ? 'checked="checked"': ''); ?>/> Nail Biting</label>
				<label><input name="behavior_concerns_tempertantrums" type="checkbox" <?php echo ($obj['behavior_concerns_tempertantrums'] == "on" ? 'checked="checked"': ''); ?>/> Temper Tantrums</label>
				<label><input name="behavior_concerns_firesetting" type="checkbox" <?php echo ($obj['behavior_concerns_firesetting'] == "on" ? 'checked="checked"': ''); ?>/> Fire setting</label>
				<label><input name="behavior_concerns_fighting" type="checkbox" <?php echo ($obj['behavior_concerns_fighting'] == "on" ? 'checked="checked"': ''); ?>/> Fighting/Yelling</label>
				<label><input name="behavior_concerns_twitches" type="checkbox" <?php echo ($obj['behavior_concerns_twitches'] == "on" ? 'checked="checked"': ''); ?>/> Twitches</label>
				<label><input name="behavior_concerns_selfdestructive" type="checkbox" <?php echo ($obj['behavior_concerns_selfdestructive'] == "on" ? 'checked="checked"': ''); ?>/> Self-Destructive</label>
				<label><input name="behavior_concerns_lying" type="checkbox" <?php echo ($obj['behavior_concerns_lying'] == "on" ? 'checked="checked"': ''); ?>/> Lying</label>
				<label><input name="behavior_concerns_animalagression" type="checkbox" <?php echo ($obj['behavior_concerns_animalagression'] == "on" ? 'checked="checked"': ''); ?>/> Aggression towards Animals</label> Describe:  <span><?php echo stripslashes($obj{"behavior_concerns_animalagression_desc"});?></span>
				<label><input name="behavior_concerns_other" type="checkbox" <?php echo ($obj['behavior_concerns_other'] == "on" ? 'checked="checked"': ''); ?>/> Other:</label>  <span class="dev-update"><?php echo stripslashes($obj{"behavior_concerns_other_desc"});?></span>
				<label><input name="behavior_concerns_ADL" type="checkbox" <?php echo ($obj['behavior_concerns_ADL'] == "on" ? 'checked="checked"': ''); ?>/> Ability to perform ADLs:</label> <span><?php echo stripslashes($obj{"behavior_concerns_ADL_desc"});?></span>
			</div>
		</div>
		<div id="GroupI" class="form-group group update-info">
			<h3 class="full-info">Medical History</h3>
			<h3 class="hidden update-info">Medical Update:</h3>
			<span><?php echo stripslashes($obj{"medical_hx"});?></span>
			<h4 id="GroupISub1" class="subgroup full-info">Accident/Falls/Hospitalization</h4>
			<h3 id="GroupISub1" class="subgroup hidden update-info">Hospital/ER Room Visits <small>(date, length of stay and reason)</small>:</h3>
			<span><?php echo stripslashes($obj{"accidents_falls_hospitalization"});?></span>
			<div class="form-inline full-info">
				<span class="h4" id="GroupISub2" class="subgroup">Date of last physical:</span>
				<div class="input-group date">
			  		<span><?php echo stripslashes($obj{"date_last_physical"});?></span>
				</div>
			</div>
			<div class="form-inline full-info">
				<span class="h4" id="GroupISub3" class="subgroup">Where Performed:</span> <span><?php echo stripslashes($obj{"where_last_physical"});?></span>
			</div>
			<div class="form-inline">
				<span class="h4 full-info" id="GroupISub4" class="subgroup">Medication allergies:</span>
				<h3 class="hidden update-info" id="GroupISub4" class="subgroup">Medication Allergies:</h3>
				<label><input type="radio" name="med_allergies" value="no" <?php echo ($obj['med_allergies'] == "no" ? 'checked="checked"': ''); ?>/> No</label>
				<label><input type="radio" name="med_allergies" value="yes" <?php echo ($obj['med_allergies'] == "yes" ? 'checked="checked"': ''); ?>/> Yes</label> If yes, describe: <span><?php echo stripslashes($obj{"med_allergies_desc"});?></span>
			</div>
			<div class="form-inline full-info">
				<span class="h4" id="GroupISub5" class="subgroup">Pregnant:</span>
				<label><input type="radio" name="pregnant" value="no" <?php echo ($obj['pregnant'] == "no" ? 'checked="checked"': ''); ?>/> No</label>
				<label><input type="radio" name="pregnant" value="yes" <?php echo ($obj['pregnant'] == "yes" ? 'checked="checked"': ''); ?>/> Yes</label> If yes, describe: <span><?php echo stripslashes($obj{"pregnant_desc"});?></span>
			</div>
			<div class="form-inline full-info">
				<span class="h4" id="GroupISub6" class="subgroup">Last Menstrual Period (LMP)</span>
				<div class="input-group date">
			  		<span><?php echo stripslashes($obj{"LMP"});?></span>
				</div>
			</div>
		</div>
		<div id="GroupJ" class="form-group group">
			<h3>Medication</h3>
			<h4 id="GroupJSub1" class="subgroup">a. Current Psychotropic Medication:</h4>
			<label><input name="current_psych_meds" type="checkbox" <?php echo ($obj['current_psych_meds'] == "on" ? 'checked="checked"': ''); ?>/>None</label>
			<h4 id="GroupJSub2" class="subgroup full-info">Medication Use Profile <small>(including dosage, frequency, effectiveness, &amp; recommendations)</small></h4>
			<h3 id="GroupJSub2" class="subgroup hidden update-info">Recommendations:</h3>
			<span class="update-info med-use"><?php echo stripslashes($obj{"med_use_profile"});?></span>
			<h4 id="GroupJSub3" class="subgroup">b. Past Psychotropic Medications: <small>(including effectiveness, side effects, compliance)</small></h4>
			<span><?php echo stripslashes($obj{"past_psych_meds"});?></span>
			<h4 id="GroupJSub4" class="subgroup full-info">c. Medical Medication - Current <small>(including dosage, frequency, purpose)</small></h4>
			<h3 id="GroupJSub4" class="subgroup hidden update-info">Current Medication <small>(including dosage, frequency, purpose)</small>:</h3>
			<span class="update-info"><?php echo stripslashes($obj{"med_medication_current"});?></span>
			<h4 id="GroupJSub5" class="subgroup">d. Use of O.T.C. Medications, Herbal Remedies, Food Supplements</h4>
			<span><?php echo stripslashes($obj{"otc_meds_herbalremedies_supplements"});?></span>
		</div>
		<div id="GroupK" class="form-group group">
			<h3>History of Trauma</h3>
			<span><?php echo stripslashes($obj{"hx_trauma"});?></span>
			<h4 id="GroupKSub1" class="subgroup">Previous Suicide Attempts:</h4>
			<label><input type="radio" name="suicide_attempt" id="suicide_no" value="no" <?php echo ($obj['suicide_attempt'] !== "yes" ? 'checked="checked"': ''); ?>/> No</label>
			<label><input type="radio" name="suicide_attempt" id="suicide_yes" value="yes" <?php echo ($obj['suicide_attempt'] == "yes" ? 'checked="checked"': ''); ?>/> Yes</label> If yes, describe:
			<script>
				$(document).ready( function() {
					if ($('#suicide_attempt').is(":checked")){
						$('#collapse_suicide_attempts').collapse('show');
					}
				});
				$('input[name="suicide_attempt"]').change( function() {
					if ($('#suicide_yes').is(":checked")){
						$('#collapse_suicide_attempts').collapse('show');
					} else {
						$('#collapse_suicide_attempts').collapse('hide');
					}
					if ($('#suicide_no').is(":checked")){
						$('#collapse_suicide_attempts').collapse('hide');
					} 
			  });						
			</script>
			<span><?php echo stripslashes($obj{"suicide_attempt_desc"});?></span>
			<h4 id="GroupKSub2" class="subgroup">Previous Homicide Attempts:</h4>
			<label><input type="radio" name="homicide_attempt" id="homicide_no" value="no" <?php echo ($obj['homicide_attempt'] !== "yes" ? 'checked="checked"': ''); ?>/> No</label>
			<label><input type="radio" name="homicide_attempt" id="homicide_yes" value="yes" <?php echo ($obj['homicide_attempt'] == "yes" ? 'checked="checked"': ''); ?>/> Yes</label> If yes, describe:
			<script>
				$(document).ready( function() {
					if ($('#homicide_yes').is(":checked")){
						$('#collapse_homicide_attempts').collapse('show');
					}
				});
				$('input[name="homicide_attempt"]').change( function() {
					if ($('#homicide_yes').is(":checked")){
						$('#collapse_homicide_attempts').collapse('show');
					} else {
						$('#collapse_homicide_attempts').collapse('hide');
					}
					if ($('#homicide_no').is(":checked")){
						$('#collapse_homicide_attempts').collapse('hide');
					} 
			  });						
			</script>
			<span><?php echo stripslashes($obj{"homicide_attempt_desc"});?></span>
			<h4 id="GroupKSub3" class="subgroup">History of other violent behavior:</h4>
			<label><input type="radio" name="hx_violent_behavior" id="hx_violence_no" value="no" <?php echo ($obj['hx_violent_behavior'] !== "yes" ? 'checked="checked"': ''); ?>/> No</label>
			<label><input type="radio" name="hx_violent_behavior" id="hx_violence_yes" value="yes" <?php echo ($obj['hx_violent_behavior'] == "yes" ? 'checked="checked"': ''); ?>/> Yes</label> If yes, describe:
			<script>
				$(document).ready( function() {
					if ($('#hx_violence_yes').is(":checked")){
						$('#collapse_hx_violence').collapse('show');
					}
				});
				$('input[name="hx_violent_behavior"]').change( function() {
					if ($('#hx_violence_yes').is(":checked")){
						$('#collapse_hx_violence').collapse('show');
					} else {
						$('#collapse_hx_violence').collapse('hide');
					}
					if ($('#hx_violence_no').is(":checked")){
						$('#collapse_hx_violence').collapse('hide');
					} 
			  });						
			</script>
			<span><?php echo stripslashes($obj{"hx_violent_behavior_desc"});?></span>
			<h4 id="GroupKSub4" class="subgroup">History of abuse/neglect/abandonment:</h4>
			<label><input type="radio" name="hx_abuse" id="hx_abuse_no" value="no" <?php echo ($obj['hx_abuse'] !== "yes" ? 'checked="checked"': ''); ?>/> No</label>
			<label><input type="radio" name="hx_abuse" id="hx_abuse_yes" value="yes" <?php echo ($obj['hx_abuse'] == "yes" ? 'checked="checked"': ''); ?>/> Yes</label> If yes, describe: 
			<script>
				$(document).ready( function() {
					if ($('#hx_abuse_yes').is(":checked")){
						$('#collapse_hx_abuse').collapse('show');
					}
				});
				$('input[name="hx_abuse"]').change( function() {
					if ($('#hx_abuse_yes').is(":checked")){
						$('#collapse_hx_abuse').collapse('show');
					} else {
						$('#collapse_hx_abuse').collapse('hide');
					}
					if ($('#hx_abuse_no').is(":checked")){
						$('#collapse_hx_abuse').collapse('hide');
					} 
			  });						
			</script>
			<span><?php echo stripslashes($obj{"hx_abuse_desc"});?></span>
			<h4 id="GroupKSub5" class="subgroup">Victim or witness to domestic violence:</h4>
			<label><input type="radio" name="hx_domestic_violence" id="hx_domestic_violence_no" value="no" <?php echo ($obj['hx_domestic_violence'] !== "yes" ? 'checked="checked"': ''); ?>/> No</label>
			<label><input type="radio" name="hx_domestic_violence" id="hx_domestic_violence_yes" value="yes" <?php echo ($obj['hx_domestic_violence'] == "yes" ? 'checked="checked"': ''); ?>/> Yes</label> If yes, describe:
			<script>
				$(document).ready( function() {
					if ($('#hx_domestic_violence_yes').is(":checked")){
						$('#collapse_hx_domestic_violence').collapse('show');
					}
				});
				$('input[name="hx_domestic_violence"]').change( function() {
					if ($('#hx_domestic_violence_yes').is(":checked")){
						$('#collapse_hx_domestic_violence').collapse('show');
					} else {
						$('#collapse_hx_domestic_violence').collapse('hide');
					}
					if ($('#hx_domestic_violence_no').is(":checked")){
						$('#collapse_hx_domestic_violence').collapse('hide');
					} 
			  });						
			</script>
			<span><?php echo stripslashes($obj{"hx_domestic_violence_desc"});?></span>
		</div>
		<div id="GroupL" class="form-group group dontsplit">
			<h3>Personal Strengths and Assets <small>(including family &amp; community supports):</small></h3>
			<span><?php echo stripslashes($obj{"personal_strengths"});?></span>
		</div>
		<div id="GroupM" class="form-group group dontsplit">
			<h3>Family History <small>(including psychiatric, substance use, medical, &amp; suicidal)</small></h3> 
			<span><?php echo stripslashes($obj{"family_hx"});?></span>
		</div>
		<div id="GroupN" class="form-group group">
			<h3>Mental Status:</h3>
			<div class="dontsplit">
				<h4 id="GroupNSub1" class="subgroup">A.  Appearance:</h4>
				<label><input type="radio" name="mental_status_appearance" id="mental_status_appearance_appropriate" value="appropriate" <?php echo ($obj['mental_status_appearance'] == "appropriate" ? 'checked="checked"': ''); ?>/> Appropriate</label>
				<label><input type="radio" name="mental_status_appearance" id="mental_status_appearance_disheveled" value="disheveled" <?php echo ($obj['mental_status_appearance'] == "disheveled" ? 'checked="checked"': ''); ?>/> Disheveled</label>
				<label><input type="radio" name="mental_status_appearance" id="mental_status_appearance_bizarre" value="bizarre" <?php echo ($obj['mental_status_appearance'] == "bizarre" ? 'checked="checked"': ''); ?>/> Bizarre</label>
				<label><input type="radio" name="mental_status_appearance" id="mental_status_appearance_other" value="other" <?php echo ($obj['mental_status_appearance'] == "other" ? 'checked="checked"': ''); ?>/> Other</label>
				Dress/Grooming: <span><?php echo stripslashes($obj{"mental_status_appearance_desc"});?></span> 
			</div>
			<div class="dontsplit">
				<h4 id="GroupNSub2" class="subgroup">B.  General Attitude:</h4>
				<label><input type="checkbox" id="mental_status_attitude" name="mental_status_attitude_cooperative" <?php echo ($obj['mental_status_attitude_cooperative'] == "on" ? 'checked="checked"': ''); ?>/> Cooperative</label>
				<label><input type="checkbox" id="mental_status_attitude" name="mental_status_attitude_uncooperative" <?php echo ($obj['mental_status_attitude_uncooperative'] == "on" ? 'checked="checked"': ''); ?>/> Uncooperative</label>
				<label><input type="checkbox" id="mental_status_attitude" name="mental_status_attitude_fearful" <?php echo ($obj['mental_status_attitude_fearful'] == "on" ? 'checked="checked"': ''); ?>/> Fearful</label>
				<label><input type="checkbox" id="mental_status_attitude" name="mental_status_attitude_impulsive" <?php echo ($obj['mental_status_attitude_impulsive'] == "on" ? 'checked="checked"': ''); ?>/> Impulsive</label>
				<label><input type="checkbox" id="mental_status_attitude" name="mental_status_attitude_suspicious" <?php echo ($obj['mental_status_attitude_suspicious'] == "on" ? 'checked="checked"': ''); ?>/> Suspicious</label>
				<label><input type="checkbox" id="mental_status_attitude" name="mental_status_attitude_withdrawn" <?php echo ($obj['mental_status_attitude_withdrawn'] == "on" ? 'checked="checked"': ''); ?>/> Withdrawn</label>
				<label><input type="checkbox" id="mental_status_attitude" name="mental_status_attitude_hostile" <?php echo ($obj['mental_status_attitude_hostile'] == "on" ? 'checked="checked"': ''); ?>/> Hostile</label>
				<label><input type="checkbox" id="mental_status_attitude" name="mental_status_attitude_manipulative" <?php echo ($obj['mental_status_attitude_manipulative'] == "on" ? 'checked="checked"': ''); ?>/> Manipulative</label>
				<label><input type="checkbox" id="mental_status_attitude" name="mental_status_attitude_other" <?php echo ($obj['mental_status_attitude_other'] == "on" ? 'checked="checked"': ''); ?>/> Other:</label> <span><?php echo stripslashes($obj{"mental_status_attitude_desc"});?></span>
			</div>
			<div class="dontsplit">
				<h4 id="GroupNSub3" class="subgroup">C.  Speech:</h4>
				<label><input type="checkbox" id="mental_status_speech" name="mental_status_speech_unremarkable" <?php echo ($obj['mental_status_speech_unremarkable'] == "on" ? 'checked="checked"': ''); ?>/> Unremarkable</label>
				<label><input type="checkbox" id="mental_status_speech" name="mental_status_speech_incoherent" <?php echo ($obj['mental_status_speech_incoherent'] == "on" ? 'checked="checked"': ''); ?>/> Incoherent</label>
				<label><input type="checkbox" id="mental_status_speech" name="mental_status_speech_stuttering" <?php echo ($obj['mental_status_speech_stuttering'] == "on" ? 'checked="checked"': ''); ?>/> Stuttering</label>
				<label><input type="checkbox" id="mental_status_speech" name="mental_status_speech_slow" <?php echo ($obj['mental_status_speech_slow'] == "on" ? 'checked="checked"': ''); ?>/> Slow</label>
				<label><input type="checkbox" id="mental_status_speech" name="mental_status_speech_fast" <?php echo ($obj['mental_status_speech_fast'] == "on" ? 'checked="checked"': ''); ?>/> Fast</label>
				<label><input type="checkbox" id="mental_status_speech" name="mental_status_speech_slurred" <?php echo ($obj['mental_status_speech_slurred'] == "on" ? 'checked="checked"': ''); ?>/> Slurred</label>
				<label><input type="checkbox" id="mental_status_speech" name="mental_status_speech_other" <?php echo ($obj['mental_status_speech_other'] == "on" ? 'checked="checked"': ''); ?>/> Other:</label> <span><?php echo stripslashes($obj{"mental_status_speech_desc"});?></span>
			</div>
			<div class="dontsplit">
				<h4 id="GroupNSub4" class="subgroup">D. Psychomotor Behavior:</h4>
				<label><input type="checkbox" id="mental_status_behavior" name="mental_status_behavior_normal" <?php echo ($obj['mental_status_behavior_normal'] == "on" ? 'checked="checked"': ''); ?>/> Normal</label>
				<label><input type="checkbox" id="mental_status_behavior" name="mental_status_behavior_retarded" <?php echo ($obj['mental_status_behavior_retarded'] == "on" ? 'checked="checked"': ''); ?>/> Retarded</label>
				<label><input type="checkbox" id="mental_status_behavior" name="mental_status_behavior_agitated" <?php echo ($obj['mental_status_behavior_agitated'] == "on" ? 'checked="checked"': ''); ?>/> Agitated</label>
				<label><input type="checkbox" id="mental_status_behavior" name="mental_status_behavior_other" <?php echo ($obj['mental_status_behavior_other'] == "on" ? 'checked="checked"': ''); ?>/> Other:</label> <span><?php echo stripslashes($obj{"mental_status_behavior_desc"});?></span>
			</div>
			<div class="dontsplit">
				<h4 id="GroupNSub5" class="subgroup">E.  Affect:</h4>
				<label><input type="checkbox" id="mental_status_affect" name="mental_status_affect_appropriate" <?php echo ($obj['mental_status_affect_appropriate'] == "on" ? 'checked="checked"': ''); ?>/> Appropriate</label>
				<label><input type="checkbox" id="mental_status_affect" name="mental_status_affect_inappropriate" <?php echo ($obj['mental_status_affect_inappropriate'] == "on" ? 'checked="checked"': ''); ?>/> Inappropriate</label>
				<label><input type="checkbox" id="mental_status_affect" name="mental_status_affect_flat" <?php echo ($obj['mental_status_affect_flat'] == "on" ? 'checked="checked"': ''); ?>/> Flat</label>
				<label><input type="checkbox" id="mental_status_affect" name="mental_status_affect_blunt" <?php echo ($obj['mental_status_affect_blunt'] == "on" ? 'checked="checked"': ''); ?>/> Blunt</label>
				<label><input type="checkbox" id="mental_status_affect" name="mental_status_affect_sad" <?php echo ($obj['mental_status_affect_sad'] == "on" ? 'checked="checked"': ''); ?>/> Sad</label>
				<label><input type="checkbox" id="mental_status_affect" name="mental_status_affect_other" <?php echo ($obj['mental_status_affect_other'] == "on" ? 'checked="checked"': ''); ?>/> Other:</label> <span><?php echo stripslashes($obj{"mental_status_affect_desc"});?></span>
			</div>
			<div class="dontsplit">
				<h4 id="GroupNSub6" class="subgroup">F.  Mood:</h4>
				<label><input type="checkbox" id="mental_status_mood" name="mental_status_mood_unremarkable" <?php echo ($obj['mental_status_mood_unremarkable'] == "on" ? 'checked="checked"': ''); ?>/> Unremarkable</label>
				<label><input type="checkbox" id="mental_status_mood" name="mental_status_mood_depressed" <?php echo ($obj['mental_status_mood_depressed'] == "on" ? 'checked="checked"': ''); ?>/> Depressed</label>
				<label><input type="checkbox" id="mental_status_mood" name="mental_status_mood_elated" <?php echo ($obj['mental_status_mood_elated'] == "on" ? 'checked="checked"': ''); ?>/> Elated</label>
				<label><input type="checkbox" id="mental_status_mood" name="mental_status_mood_angry" <?php echo ($obj['mental_status_mood_angry'] == "on" ? 'checked="checked"': ''); ?>/> Angry</label>
				<label><input type="checkbox" id="mental_status_mood" name="mental_status_mood_anxious" <?php echo ($obj['mental_status_mood_anxious'] == "on" ? 'checked="checked"': ''); ?>/> Anxious</label>
				<label><input type="checkbox" id="mental_status_mood" name="mental_status_mood_other" <?php echo ($obj['mental_status_mood_other'] == "on" ? 'checked="checked"': ''); ?>/> Other:</label> <span><?php echo stripslashes($obj{"mental_status_mood_desc"});?></span> 
			</div>
			<div class="dontsplit">
				<h4 id="GroupNSub7" class="subgroup">G.  Thought Process:</h4>
				<label><input type="checkbox" id="mental_status_process" name="mental_status_process_unremarkable" <?php echo ($obj['mental_status_process_unremarkable'] == "on" ? 'checked="checked"': ''); ?>/> Unremarkable</label>
				<label><input type="checkbox" id="mental_status_process" name="mental_status_process_tangential" <?php echo ($obj['mental_status_process_tangential'] == "on" ? 'checked="checked"': ''); ?>/> Tangential</label>
				<label><input type="checkbox" id="mental_status_process" name="mental_status_process_looseassociations" <?php echo ($obj['mental_status_process_looseassociations'] == "on" ? 'checked="checked"': ''); ?>/> Loose Associations</label>
				<label><input type="checkbox" id="mental_status_process" name="mental_status_process_evasive" <?php echo ($obj['mental_status_process_evasive'] == "on" ? 'checked="checked"': ''); ?>/> Evasive</label>
				<label><input type="checkbox" id="mental_status_process" name="mental_status_process_circumstantial" <?php echo ($obj['mental_status_process_circumstantial'] == "on" ? 'checked="checked"': ''); ?>/> Circumstantial</label>
				<label><input type="checkbox" id="mental_status_process" name="mental_status_process_flightideas" <?php echo ($obj['mental_status_process_flightideas'] == "on" ? 'checked="checked"': ''); ?>/> Flight of Ideas</label>
				<label><input type="checkbox" id="mental_status_process" name="mental_status_process_blocking" <?php echo ($obj['mental_status_process_blocking'] == "on" ? 'checked="checked"': ''); ?>/> Blocking</label>
				<label><input type="checkbox" id="mental_status_process" name="mental_status_process_other" <?php echo ($obj['mental_status_process_other'] == "on" ? 'checked="checked"': ''); ?>/> Other:</label> <span><?php echo stripslashes($obj{"mental_status_process_desc"});?></span> 
			</div>
			<div class="dontsplit">
				<h4 id="GroupNSub8" class="subgroup">H.  Thought Content:</h4>
				<label><input type="checkbox" id="mental_status_content" name="mental_status_content_unremarkable" <?php echo ($obj['mental_status_content_unremarkable'] == "on" ? 'checked="checked"': ''); ?>/> Unremarkable</label>
				<label><input type="checkbox" id="mental_status_content" name="mental_status_content_obsessions" <?php echo ($obj['mental_status_content_obsessions'] == "on" ? 'checked="checked"': ''); ?>/> Obsessions</label>
				<label><input type="checkbox" id="mental_status_content" name="mental_status_content_compulsions" <?php echo ($obj['mental_status_content_compulsions'] == "on" ? 'checked="checked"': ''); ?>/> Compulsions</label>
				<label><input type="checkbox" id="mental_status_content" name="mental_status_content_phobias" <?php echo ($obj['mental_status_content_phobias'] == "on" ? 'checked="checked"': ''); ?>/> Phobias</label>
				<label><input type="checkbox" id="mental_status_content" name="mental_status_content_other" <?php echo ($obj['mental_status_content_other'] == "on" ? 'checked="checked"': ''); ?>/> Other:</label> <span><?php echo stripslashes($obj{"mental_status_content_desc"});?></span>
				<label><input type="checkbox" id="mental_status_content" name="mental_status_content_hallucinations" <?php echo ($obj['mental_status_content_hallucinations'] == "on" ? 'checked="checked"': ''); ?>/> Hallucinations</label>
				<label><input type="checkbox" id="mental_status_content" name="mental_status_content_hallucinations_auditory" <?php echo ($obj['mental_status_content_hallucinations_auditory'] == "on" ? 'checked="checked"': ''); ?>/>Auditory (Command?</label> <label><input type="radio" name="hallucination_auditory_cmd" id="hallucination_auditory_cmd_no" value="no" <?php echo ($obj['hallucination_auditory_cmd'] == "no" ? 'checked="checked"': ''); ?>/> No</label> <label><input type="radio" name="hallucination_auditory_cmd" id="hallucination_auditory_cmd_yes" value="yes" <?php echo ($obj['hallucination_auditory_cmd'] == "no" ? 'checked="checked"': ''); ?>/> Yes</label>)
				<label><input type="checkbox" id="mental_status_content" name="mental_status_content_hallucinations_visual" <?php echo ($obj['mental_status_content_hallucinations_visual'] == "on" ? 'checked="checked"': ''); ?>/> Visual</label>
				<label><input type="checkbox" id="mental_status_content" name="mental_status_content_hallucinations_other" <?php echo ($obj['mental_status_content_hallucinations_other'] == "on" ? 'checked="checked"': ''); ?>/> Other:</label> <span><?php echo stripslashes($obj{"mental_status_content_hallucinations_desc"});?></span>
				<label><input type="checkbox" id="mental_status_content" name="mental_status_content_delusions" <?php echo ($obj['mental_status_content_delusions'] == "on" ? 'checked="checked"': ''); ?>/> Delusions</label>
				<label><input type="checkbox" id="mental_status_content" name="mental_status_content_delusions_paranoid" <?php echo ($obj['mental_status_content_delusions_paranoid'] == "on" ? 'checked="checked"': ''); ?>/> Paranoid</label>
				<label><input type="checkbox" id="mental_status_content" name="mental_status_content_delusions_grandiose" <?php echo ($obj['mental_status_content_delusions_grandiose'] == "on" ? 'checked="checked"': ''); ?>/> Grandiose</label>
				<label><input type="checkbox" id="mental_status_content" name="mental_status_content_delusions_other" <?php echo ($obj['mental_status_content_delusions_other'] == "on" ? 'checked="checked"': ''); ?>/> Other:</label> <span><?php echo stripslashes($obj{"mental_status_content_delusions_desc"});?></span>
			</div>
			<div class="dontsplit">
				<h4 id="GroupNSub9" class="subgroup">I.  Suicidality:</h4>
				<label><input type="radio" name="mental_status_suicidality" id="ms_suicidality_no" value="no" <?php echo ($obj['mental_status_suicidality'] !== "yes" ? 'checked="checked"': ''); ?>/> No</label>
				<label><input type="radio" name="mental_status_suicidality" id="ms_suicidality_yes" value="yes" <?php echo ($obj['mental_status_suicidality'] == "yes" ? 'checked="checked"': ''); ?>/> Yes</label> If yes, explain:
				<script>
					$(document).ready( function() {
						if ($('#ms_suicidality_yes').is(":checked")){
							$('#collapse_ms_suicidality').collapse('show');
						}
					});
					$('input[name="mental_status_suicidality"]').change( function() {
						if ($('#ms_suicidality_yes').is(":checked")){
							$('#collapse_ms_suicidality').collapse('show');
						} else {
							$('#collapse_ms_suicidality').collapse('hide');
						}
						if ($('#ms_suicidality_no').is(":checked")){
							$('#collapse_ms_suicidality').collapse('hide');
						} 
				  });						
				</script>
			<span id="collapse_ms_suicidality"><?php echo stripslashes($obj{"mental_status_suicidality_desc"});?></span>
			</div>
			<div class="dontsplit">
				<h4 id="GroupNSub10" class="subgroup">J.  Homicidality:</h4>
				<label><input type="radio" name="mental_status_homicidality" id="ms_homicidality_no" value="no" <?php echo ($obj['mental_status_homicidality'] !== "yes" ? 'checked="checked"': ''); ?>/> No</label>
				<label><input type="radio" name="mental_status_homicidality" id="ms_homicidality_yes" value="yes" <?php echo ($obj['mental_status_homicidality'] == "yes" ? 'checked="checked"': ''); ?>/> Yes</label> If yes, explain:
				<script>
					$(document).ready( function() {
						if ($('#ms_homicidality_yes').is(":checked")){
							$('#collapse_ms_homicidality').collapse('show');
						}
					});				$('input[name="mental_status_homicidality"]').change( function() {
						if ($('#ms_homicidality_yes').is(":checked")){
							$('#collapse_ms_homicidality').collapse('show');
						} else {
							$('#collapse_ms_homicidality').collapse('hide');
						}
						if ($('#ms_homicidality_no').is(":checked")){
							$('#collapse_ms_homicidality').collapse('hide');
						} 
				  });						
				</script>
			<span id="collapse_ms_homicidality"><?php echo stripslashes($obj{"mental_status_homicidality_desc"});?></span>
			</div>
			<div class="dontsplit">
				<h4 id="GroupNSub11" class="subgroup">K.  Sensorium:</h4>
				<label><input type="checkbox" id="mental_status_sensorium" name="mental_status_sensorium_alert" <?php echo ($obj['mental_status_sensorium_alert'] == "on" ? 'checked="checked"': ''); ?>/> Alert</label>
				<label><input type="checkbox" id="mental_status_sensorium" name="mental_status_sensorium_somnolent" <?php echo ($obj['mental_status_sensorium_somnolent'] == "on" ? 'checked="checked"': ''); ?>/> Somnolent</label>
				<label><input type="checkbox" id="mental_status_sensorium" name="mental_status_sensorium_confused" <?php echo ($obj['mental_status_sensorium_confused'] == "on" ? 'checked="checked"': ''); ?>/> Confused</label>
				<label><input type="checkbox" id="mental_status_sensorium" name="mental_status_sensorium_toodisturbed" <?php echo ($obj['mental_status_sensorium_toodisturbed'] == "on" ? 'checked="checked"': ''); ?>/> Too Disturbed to Test</label>
				<label><input type="checkbox" id="mental_status_sensorium" name="mental_status_sensorium_other" <?php echo ($obj['mental_status_sensorium_other'] == "on" ? 'checked="checked"': ''); ?>/> Other:</label> <span><?php echo stripslashes($obj{"mental_status_sensorium_desc"});?></span>
			</div>
			<div class="dontsplit">
				<h4 id="GroupNSub12" class="subgroup">L.  Orientation:</h4>
				<label><input type="checkbox" id="mental_status_orientation" name="mental_status_orientation_time" <?php echo ($obj['mental_status_orientation_time'] == "on" ? 'checked="checked"': ''); ?>/> Time</label>
				<label><input type="checkbox" id="mental_status_orientation" name="mental_status_orientation_place" <?php echo ($obj['mental_status_orientation_place'] == "on" ? 'checked="checked"': ''); ?>/> Place</label>
				<label><input type="checkbox" id="mental_status_orientation" name="mental_status_orientation_person" <?php echo ($obj['mental_status_orientation_person'] == "on" ? 'checked="checked"': ''); ?>/> Person</label>
				<label><input type="checkbox" id="mental_status_orientation" name="mental_status_orientation_toodisturbed" <?php echo ($obj['mental_status_orientation_toodisturbed'] == "on" ? 'checked="checked"': ''); ?>/> Too Disturbed to Test</label>
			</div>
			<div class="dontsplit">
				<h4 id="GroupNSub13" class="subgroup">M.  Memory:</h4>
				<label><input type="checkbox" id="mental_status_memory" name="mental_status_memory_unremarkable" <?php echo ($obj['mental_status_memory_unremarkable'] == "on" ? 'checked="checked"': ''); ?>/> Unremarkable Immediate</label>
				<label><input type="checkbox" id="mental_status_memory" name="mental_status_memory_recent" <?php echo ($obj['mental_status_memory_recent'] == "on" ? 'checked="checked"': ''); ?>/> Recent</label>
				<label><input type="checkbox" id="mental_status_memory" name="mental_status_memory_remote" <?php echo ($obj['mental_status_memory_remote'] == "on" ? 'checked="checked"': ''); ?>/> Remote</label>
				<label><input type="checkbox" id="mental_status_memory" name="mental_status_memory_impaired" <?php echo ($obj['mental_status_memory_impaired'] == "on" ? 'checked="checked"': ''); ?>/> Impaired (describe):</label> <span><?php echo stripslashes($obj{"mental_status_memory_desc"});?></span>
			</div>
			<div class="dontsplit">
				<h4 id="GroupNSub14" class="subgroup">N. Concentration</h4>
				<label><input type="checkbox" id="mental_status_concentration" name="mental_status_concentration_poor" <?php echo ($obj['mental_status_concentration_poor'] == "on" ? 'checked="checked"': ''); ?>/> Poor</label>
				<label><input type="checkbox" id="mental_status_concentration" name="mental_status_concentration_adequate" <?php echo ($obj['mental_status_concentration_adequate'] == "on" ? 'checked="checked"': ''); ?>/> Adequate</label>
				<label><input type="checkbox" id="mental_status_concentration" name="mental_status_concentration_preoccupation" <?php echo ($obj['mental_status_concentration_preoccupation'] == "on" ? 'checked="checked"': ''); ?>/> Preoccupation</label>
				<label><input type="checkbox" id="mental_status_concentration" name="mental_status_concentration_other" <?php echo ($obj['mental_status_concentration_other'] == "on" ? 'checked="checked"': ''); ?>/> Other:</label> <span><?php echo stripslashes($obj{"mental_status_concentration_desc"});?></span>
			</div>
			<div class="dontsplit">
				<h4 id="GroupNSub15" class="subgroup">O. Calculation</h4>
				<label><input type="checkbox" id="mental_status_calculation" name="mental_status_calculation_3s7s" <?php echo ($obj['mental_status_calculation_3s7s'] == "on" ? 'checked="checked"': ''); ?>/> Serial 3's or 7's</label>
				<label><input type="checkbox" id="mental_status_calculation" name="mental_status_calculation_addition" <?php echo ($obj['mental_status_calculation_addition'] == "on" ? 'checked="checked"': ''); ?>/> Addition</label>
				<label><input type="checkbox" id="mental_status_calculation" name="mental_status_calculation_multiplication" <?php echo ($obj['mental_status_calculation_multiplication'] == "on" ? 'checked="checked"': ''); ?>/> Multiplication</label>
				<label><input type="checkbox" id="mental_status_calculation" name="mental_status_calculation_subtraction" <?php echo ($obj['mental_status_calculation_subtraction'] == "on" ? 'checked="checked"': ''); ?>/> Subtraction</label>
				<label><input type="checkbox" id="mental_status_calculation" name="mental_status_calculation_other" <?php echo ($obj['mental_status_calculation_other'] == "on" ? 'checked="checked"': ''); ?>/> Other:</label> <span><?php echo stripslashes($obj{"mental_status_calculation_desc"});?></span>
			</div>
			<div class="dontsplit">
				<h4 id="GroupNSub16" class="subgroup">P. Abstraction</h4>
				<label><input type="checkbox" id="mental_status_abstraction" name="mental_status_abstraction_concrete" <?php echo ($obj['mental_status_abstraction_concrete'] == "on" ? 'checked="checked"': ''); ?>/> Concrete Thinking</label>
				<label><input type="checkbox" id="mental_status_abstraction" name="mental_status_abstraction_abstract" <?php echo ($obj['mental_status_abstraction_abstract'] == "on" ? 'checked="checked"': ''); ?>/> Able to Think Abstractly</label>
				<label><input type="checkbox" id="mental_status_abstraction" name="mental_status_abstraction_other" <?php echo ($obj['mental_status_abstraction_other'] == "on" ? 'checked="checked"': ''); ?>/> Other:</label> <span><?php echo stripslashes($obj{"mental_status_abstraction_desc"});?></span>
			</div>
			<div class="dontsplit">
				<h4 id="GroupNSub17" class="subgroup">Q.  Insight:</h4>
				<label><input type="radio" name="mental_status_insight" id="mental_status_insight_poor" value="poor" <?php echo ($obj['mental_status_insight'] == "poor" ? 'checked="checked"': ''); ?>/> Poor</label>
				<label><input type="radio" name="mental_status_insight" id="mental_status_insight_limited" value="limited" <?php echo ($obj['mental_status_insight'] == "limited" ? 'checked="checked"': ''); ?>/> Limited</label>
				<label><input type="radio" name="mental_status_insight" id="mental_status_insight_fair" value="fair" <?php echo ($obj['mental_status_insight'] == "fair" ? 'checked="checked"': ''); ?>/> Fair</label>
				<label><input type="radio" name="mental_status_insight" id="mental_status_insight_good" value="good" <?php echo ($obj['mental_status_insight'] == "good" ? 'checked="checked"': ''); ?>/> Good</label>
			</div>
			<div class="dontsplit">
				<h4 id="GroupNSub18" class="subgroup">Judgment:</h4>
				<label><input type="radio" name="mental_status_judgment" id="mental_status_judgment_poor" value="poor" <?php echo ($obj['mental_status_judgment'] == "poor" ? 'checked="checked"': ''); ?>/> Poor</label>
				<label><input type="radio" name="mental_status_judgment" id="mental_status_judgment_limited" value="limited" <?php echo ($obj['mental_status_judgment'] == "limited" ? 'checked="checked"': ''); ?>/> Limited</label>
				<label><input type="radio" name="mental_status_judgment" id="mental_status_judgment_fair" value="fair" <?php echo ($obj['mental_status_judgment'] == "fair" ? 'checked="checked"': ''); ?>/> Fair</label>
				<label><input type="radio" name="mental_status_judgment" id="mental_status_judgment_good" value="good" <?php echo ($obj['mental_status_judgment'] == "good" ? 'checked="checked"': ''); ?>/> Good</label>
			</div>
			<div class="dontsplit">
				<h4 id="GroupNSub19" class="subgroup">Reliability:</h4>
				<label><input type="radio" name="mental_status_reliability" id="mental_status_reliability_poor" value="poor" <?php echo ($obj['mental_status_reliability'] == "poor" ? 'checked="checked"': ''); ?>/> Poor</label>
				<label><input type="radio" name="mental_status_reliability" id="mental_status_reliability_limited" value="limited" <?php echo ($obj['mental_status_reliability'] == "limited" ? 'checked="checked"': ''); ?>/> Limited</label>
				<label><input type="radio" name="mental_status_reliability" id="mental_status_reliability_fair" value="fair" <?php echo ($obj['mental_status_reliability'] == "fair" ? 'checked="checked"': ''); ?>/> Fair</label>
				<label><input type="radio" name="mental_status_reliability" id="mental_status_reliability_good" value="good" <?php echo ($obj['mental_status_reliability'] == "good" ? 'checked="checked"': ''); ?>/> Good</label>
			</div>
			<div class="dontsplit">
				<h4 id="GroupNSub20" class="subgroup">Impulse Control:</h4>
				<label><input type="radio" name="mental_status_impulsecontrol" id="mental_status_impulsecontrol_poor" value="poor" <?php echo ($obj['mental_status_impulsecontrol'] == "poor" ? 'checked="checked"': ''); ?>/> Poor</label>
				<label><input type="radio" name="mental_status_impulsecontrol" id="mental_status_impulsecontrol_limited" value="limited" <?php echo ($obj['mental_status_impulsecontrol'] == "limited" ? 'checked="checked"': ''); ?>/> Limited</label>
				<label><input type="radio" name="mental_status_impulsecontrol" id="mental_status_impulsecontrol_fair" value="fair" <?php echo ($obj['mental_status_impulsecontrol'] == "fair" ? 'checked="checked"': ''); ?>/> Fair</label>
				<label><input type="radio" name="mental_status_impulsecontrol" id="mental_status_impulsecontrol_good" value="good" <?php echo ($obj['mental_status_impulsecontrol'] == "good" ? 'checked="checked"': ''); ?>/> Good</label>
			</div>
			<div class="dontsplit">
				<h4 id="GroupNSub21" class="subgroup">R. Level of intelligence:</h4>
				<label><input type="radio" name="mental_status_intlevel" id="mental_status_intlevel_belowave" value="below_ave" <?php echo ($obj['mental_status_intlevel'] == "below_ave" ? 'checked="checked"': ''); ?>/> Below AVE</label>
				<label><input type="radio" name="mental_status_intlevel" id="mental_status_intlevel_ave" value="ave" <?php echo ($obj['mental_status_intlevel'] == "ave" ? 'checked="checked"': ''); ?>/> AVE</label>
				<label><input type="radio" name="mental_status_intlevel" id="mental_status_intlevel_aboveave" value="above_ave" <?php echo ($obj['mental_status_intlevel'] == "above_ave" ? 'checked="checked"': ''); ?>/> Above AVE</label>
			</div>
		</div>
		<div id="GroupO" class="form-group group dontsplit update-info">
			<h3 class="full-info">Clinical Summary and Prognoses of Findings:</h3>
			<h3 class="hidden update-info">Mental Status Exam/Clinical Summary and Prognoses of Findings:</h3>
			<span><?php echo stripslashes($obj{"clinical_summary_prognoses"});?></span>
		</div>
		<div id="GroupP" class="form-group group dontsplit update-info">
			<h3 class="full-info">Diagnostic Formulation</h3>
			<h3 class="hidden update-info">Changes in Diagnosis:</h3>
			<div class="form-group row update-info">
				<div class="col-xs-12">
					<label>CODE | DESCRIPTOR:</label> <span><?php echo stripslashes($obj{"diagnosis_code_1"});?></span>
				</div>
<!--
				<div class="col-xs-8">
					<label>DESCRIPTOR</label> <span><?php echo stripslashes($obj{"diagnosis_desc_1"});?></span>
				</div>
-->				
			</div>
			<div class="form-group row update-info">
				<div class="col-xs-12">
					<label>CODE | DESCRIPTOR:</label> <span><?php echo stripslashes($obj{"diagnosis_code_2"});?></span>
				</div>
<!--
				<div class="col-xs-8">
					<label>DESCRIPTOR</label> <span><?php echo stripslashes($obj{"diagnosis_desc_2"});?></span>
				</div>
-->				
			</div>
			<div class="form-group row update-info">
				<div class="col-xs-12">
					<label>CODE | DESCRIPTOR:</label> <span><?php echo stripslashes($obj{"diagnosis_code_3"});?></span>
				</div>
<!--
				<div class="col-xs-8">
					<label>DESCRIPTOR</label> <span><?php echo stripslashes($obj{"diagnosis_desc_3"});?></span>
				</div>
-->				
			</div>
			<div class="form-group row update-info">
				<div class="col-xs-12">
					<label>CODE | DESCRIPTOR:</label> <span><?php echo stripslashes($obj{"diagnosis_code_4"});?></span>
				</div>
			</div>
			<span><?php echo stripslashes($obj{"diagnosis_formulation"});?></span>
		</div>
		<div id="GroupQ" class="form-group group">
			<h3>Recommendations for Treatment</h3>
			<p>The undersigned, having reviewed the relevant assessment information and having interviewed the client personally, asserts that the clinical findings above form the basis for the diagnosis formulation and recommendations for the Treatment Plan.</p>
			<label><input type="checkbox" id="tx_recommendations" name="tx_recommendations_bpseval" <?php echo ($obj['tx_recommendations_bpseval'] == "on" ? 'checked="checked"': ''); ?>/> Bio-Psycho Social Evaluation</label>
			<label><input type="checkbox" id="tx_recommendations" name="tx_recommendations_daytreatment" <?php echo ($obj['tx_recommendations_daytreatment'] == "on" ? 'checked="checked"': ''); ?>/> Day treatment or PHP</label>
			<label><input type="checkbox" id="tx_recommendations" name="tx_recommendations_tprnew" <?php echo ($obj['tx_recommendations_tprnew'] == "on" ? 'checked="checked"': ''); ?>/> Development of Individualized Treatment Plan (New Patient)</label>
			<label><input type="checkbox" id="tx_recommendations" name="tx_recommendations_tpr" <?php echo ($obj['tx_recommendations_tpr'] == "on" ? 'checked="checked"': ''); ?>/> Development of Individualized Treatment Plan (established Patient)</label>
			<label><input type="checkbox" id="tx_recommendations" name="tx_recommendations_medpsy" <?php echo ($obj['tx_recommendations_medpsy'] == "on" ? 'checked="checked"': ''); ?>/> Medical/Psychiatric Services</label>
			<label><input type="checkbox" id="tx_recommendations" name="tx_recommendations_outpatient" <?php echo ($obj['tx_recommendations_outpatient'] == "on" ? 'checked="checked"': ''); ?>/> Outpatient Treatment</label>
			<label><input type="checkbox" id="tx_recommendations" name="tx_recommendations_clinic" <?php echo ($obj['tx_recommendations_clinic'] == "on" ? 'checked="checked"': ''); ?>/> Clinic Visit</label>
			<label><input type="checkbox" id="tx_recommendations" name="tx_recommendations_tbos" <?php echo ($obj['tx_recommendations_tbos'] == "on" ? 'checked="checked"': ''); ?>/> Intensive Outpatient On-Site Services</label>
			<label><input type="checkbox" id="tx_recommendations" name="tx_recommendations_psychtestng" <?php echo ($obj['tx_recommendations_psychtestng'] == "on" ? 'checked="checked"': ''); ?>/> Psychological Testing</label>
			<label><input type="checkbox" id="tx_recommendations" name="tx_recommendations_casemgmt" <?php echo ($obj['tx_recommendations_casemgmt'] == "on" ? 'checked="checked"': ''); ?>/> Children's Case Management</label>
			<label><input type="checkbox" id="tx_recommendations" name="tx_recommendations_indtherapy" <?php echo ($obj['tx_recommendations_indtherapy'] == "on" ? 'checked="checked"': ''); ?>/> Individual therapy</label>
			<label><input type="checkbox" id="tx_recommendations" name="tx_recommendations_other" <?php echo ($obj['tx_recommendations_other'] == "on" ? 'checked="checked"': ''); ?>/> Other</label>
			<label>Explain if needed:</label> <span><?php echo stripslashes($obj{"tx_recommendations_desc"});?></span>
			<div class="med-changes update-info">
				<h4 class="full-info">Medication change required?</h4>
				<h3 class="hidden update-info">Changes in Medication:</h3>
				<label><input type="radio" name="rec_med_change" id="rec_med_change_no" value="no" <?php echo ($obj['rec_med_change'] !== "yes" ? 'checked="checked"': ''); ?>/> No</label>
				<label><input type="radio" name="rec_med_change" id="rec_med_change_yes" value="yes" <?php echo ($obj['rec_med_change'] == "yes" ? 'checked="checked"': ''); ?>/> Yes</label> Describe:
				<script>
					$(document).ready( function() {
						if ($('#rec_med_change_yes').is(":checked")){
							$('#collapse_rec_med_change').collapse('show');
						}
					});
					$('input[name="rec_med_change"]').change( function() {
						if ($('#rec_med_change_yes').is(":checked")){
							$('#collapse_rec_med_change').collapse('show');
						} else {
							$('#collapse_rec_med_change').collapse('hide');
						}
						if ($('#rec_med_change_no').is(":checked")){
							$('#collapse_rec_med_change').collapse('hide');
						} 
				  });						
				</script>
				<span><?php echo stripslashes($obj{"rec_med_change_desc"});?></span>
			</div>
			<div class="lab-changes update-info">
				<h4 class="full-info">Lab test medically necessary:</h4>
				<h3 class="hidden update-info">Laboratory Test:</h3>
				<label><input type="radio" name="rec_lab_necessary" id="rec_lab_necessary_no" value="no" <?php echo ($obj['rec_lab_necessary'] !== "yes" ? 'checked="checked"': ''); ?>/> No</label>
				<label><input type="radio" name="rec_lab_necessary" id="rec_lab_necessary_yes" value="yes" <?php echo ($obj['rec_lab_necessary'] == "yes" ? 'checked="checked"': ''); ?>/> Yes</label> If yes, explain:
				<script>
					$(document).ready( function() {
						if ($('#rec_lab_necessary_yes').is(":checked")){
							$('#collapse_rec_lab_necessary').collapse('show');
						}
					});
					$('input[name="rec_lab_necessary"]').change( function() {
						if ($('#rec_lab_necessary_yes').is(":checked")){
							$('#collapse_rec_lab_necessary').collapse('show');
						} else {
							$('#collapse_rec_lab_necessary').collapse('hide');
						}
						if ($('#rec_lab_necessary_no').is(":checked")){
							$('#collapse_rec_lab_necessary').collapse('hide');
						} 
				  });						
				</script>
				<span><?php echo stripslashes($obj{"rec_lab_necessary_desc"});?></span>
			</div>
		</div>
		<div id="GroupR" class="form-group group dontsplit">
			<h3>Medication Tx:</h3>
			<span><?php echo stripslashes($obj{"med_tx"});?></span>
		</div>
		<div id="GroupS" class="form-group group dontsplit">
			<h3>Follow Up:</h3>
			<span><?php echo stripslashes($obj{"follow_up"});?></span>
		</div>
		<div class="columnbreak"></div>
		<div id="GroupT" class="form-group group dontsplit update-info">
		<SCRIPT language="Javascript">


// required for textbox date verification
var mypcc = '<?php echo $GLOBALS['phone_country_code'] ?>';


   // var Index;
  	
  

    var Index;
  	var tmr;	   
	var tmr1;
	var cursig=0;
	    

		    function onClear() 
		    		{
		        		document.getElementById('sigplus').clearSignature();
		    		}

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
								onReturnSampleSig1();
									setTimeout(function(){
								onReturnSampleSig2();
									setTimeout(function(){		
								onReturnSampleSig3();
									setTimeout(function(){
								onReturnSampleSig4();		
									setTimeout(function(){
								onReturnSampleSig5();
										},1000);
									},1000);
								},1000);
							},1000);								
        			}
        			
        	 function onReturnPhySig()
        	 {
													
									setTimeout(function(){
								onReturnSampleSig5();
										
									
								
							},3500);								
        			}

        			            
       		//  function onReturnSampleSigAll()
        	//		{
	        //			onReturnSampleSig5();
			//			setTimeout(function(){
			//				onReturnSampleSig4();		
			//				setTimeout(function(){
			//					onReturnSampleSig3();
			//					setTimeout(function(){
			//						onReturnSampleSig2();
			//						setTimeout(function(){
			//							onReturnSampleSig1();
			//							
			//						},1000);
			//					},1000);
			//				},1000);
			//			},1000);
        	//		}

 							
			function onSign1() 
						{
				 		   disableSignButtons();
						   cursig = 1;
						   SetSigCompressionMode(1);
						   SetTabletState(0, tmr);
						  var ctx = document.getElementById('sigplus1').getContext('2d');
						   SetDisplayXSize( 500 );
						   SetDisplayYSize( 100 );
						   SetJustifyMode(0);      
						   ClearTablet();
						   tmr = SetTabletState(1, ctx, 50) || tmr;
		    			}
		    			
			function onSign2() 
						{
				 		   disableSignButtons();
						   cursig = 1;
						   SetSigCompressionMode(1);
						   SetTabletState(0, tmr);
						  var ctx = document.getElementById('sigplus2').getContext('2d');
						   SetDisplayXSize( 500 );
						   SetDisplayYSize( 100 );
						   SetJustifyMode(0);      
						   ClearTablet();
						   tmr = SetTabletState(1, ctx, 50) || tmr;
		    			}
		    			
			function onSign3() 
						{
				 		   disableSignButtons();
						   cursig = 1;
						   SetSigCompressionMode(1);
						   SetTabletState(0, tmr);
						  var ctx = document.getElementById('sigplus3').getContext('2d');
						   SetDisplayXSize( 500 );
						   SetDisplayYSize( 100 );
						   SetJustifyMode(0);      
						   ClearTablet();
						   tmr = SetTabletState(1, ctx, 50) || tmr;
		    			}
		    			
		    function onSign4() 
						{
				 		   disableSignButtons();
						   cursig = 1;
						   SetSigCompressionMode(1);
						   SetTabletState(0, tmr);
						  var ctx = document.getElementById('sigplus4').getContext('2d');
						   SetDisplayXSize( 500 );
						   SetDisplayYSize( 100 );
						   SetJustifyMode(0);      
						   ClearTablet();
						   tmr = SetTabletState(1, ctx, 50) || tmr;
					    }
					    
		 function onSign5() 
						{
				 		   disableSignButtons();
						   cursig = 1;
						   SetSigCompressionMode(1);
						   SetTabletState(0, tmr);
						  var ctx = document.getElementById('sigplus5').getContext('2d');
						   SetDisplayXSize( 500 );
						   SetDisplayYSize( 100 );
						   SetJustifyMode(0);      
						   ClearTablet();
						   tmr = SetTabletState(1, ctx, 50) || tmr;
		    			}
		    			
		   
			function onClear1() 
		    		{
		        	 var ctx1 = document.getElementById('sigplus1').getContext('2d');
					 ctx1.clearRect(0, 0, sigplus1.width, sigplus1.height);
					}

		    function onClear2() 
		    		{
		        	 var ctx2 = document.getElementById('sigplus2').getContext('2d');
					 ctx2.clearRect(0, 0, sigplus2.width, sigplus2.height);
					}

		    function onClear3() 
		    		{
		        	 var ctx3 = document.getElementById('sigplus3').getContext('2d');
					 ctx3.clearRect(0, 0, sigplus3.width, sigplus3.height);
					}
		    function onClear4() 
		    		{
		        	 var ctx4 = document.getElementById('sigplus4').getContext('2d');
					 ctx4.clearRect(0, 0, sigplus4.width, sigplus4.height);
					 }
			function onClear5() 
		    		{
		        	 var ctx5 = document.getElementById('sigplus5').getContext('2d');
					 ctx5.clearRect(0, 0, sigplus5.width, sigplus5.height);
					 }
       
    		function onDoneForm()
					{
		 				document.SigForm.submit();
          	        }


		
			function saveSigs2()
					{
   						if(NumberOfTabletPoints() == 0)
   					{
      				//no signature, exit
      							return;
   					}

   if(cursig == 1)
   {
      document.FORM1.bioSigData.value = GetSigString(); //assign sigstring to hidden field
      document.FORM1.sigStringDataText.value = document.FORM1.bioSigData.value; //show current sigstring data in text area
   }
   if(cursig == 2)
   {
      document.FORM1.bioSigData2.value = GetSigString(); //assign sigstring to hidden field
      document.FORM1.sigStringDataText.value = document.FORM1.bioSigData2.value; //show current sigstring data in text area
   }
   if(cursig == 3)
   {
      document.FORM1.bioSigData3.value = GetSigString(); //assign sigstring to hidden field
      document.FORM1.sigStringDataText.value = document.FORM1.bioSigData3.value; //show current sigstring data in text area
   }

      SetImageXSize(500);
      SetImageYSize(100);
      SetImagePenWidth(1);
      GetSigImageB64(SigImageCallback);
}
		
		
		
		
		
		
		
				
		        function onDone1()
							{
	           					if(NumberOfTabletPoints() == 0)
	   							{
	      							//no signature, exit
	     							 return;
	   							}
	                   				document.SigForm.bioSigData1.value = GetSigString();
	                   				document.SigForm.sigStringData1.value  = document.SigForm.bioSigData1.value;
								$.post("<?php echo $GLOBALS['webroot'] ?>/interface/forms/psychiatric_evaluation/save_patient_signature.php?mode=update&id=<?php echo $_GET['id'];?>",
										{form_id: $("#signatureid").val() , patient_print_name: $("#patient_print_name").val() , patient_signature_date: $("#patient_signature_date").val(), patient_signature: $('#sigStringData1').val()},
											function(data) 
												{
													//alert (data);
										  			alert("Patient Signature Saved");
												}								
										);		
									SetImageXSize(500);
								    SetImageYSize(100);
								    SetImagePenWidth(1);
								    SetJustifyMode(0);
								    GetSigImageB64(SigImageCallback);
						    }

				function onDone2()
							{
	           					if(NumberOfTabletPoints() == 0)
	   							{
	      							//no signature, exit
	     							 return;
	   							}
	                   				document.SigForm.bioSigData2.value = GetSigString();
	                   				document.SigForm.sigStringData2.value  = document.SigForm.bioSigData2.value;
								$.post("<?php echo $GLOBALS['webroot'] ?>/interface/forms/psychiatric_evaluation/save_guardian_signature.php?mode=update&id=<?php echo $_GET['id'];?>",
										{form_id: $("#signatureid").val() , guardian_print_name: $("#guardian_print_name").val() , guardian_signature_date: $("#guardian_signature_date").val(), guardian_signature: $('#sigStringData2').val()},
											function(data) 
												{
										  			  //alert (data);
													  alert("Guardian Signature Saved");
												}								
										);		
									SetImageXSize(500);
								    SetImageYSize(100);
								    SetImagePenWidth(1);
								    SetJustifyMode(0);
								    GetSigImageB64(SigImageCallback);
						    }

				function onDone3()
							{
	           					if(NumberOfTabletPoints() == 0)
	   							{
	      							//no signature, exit
	     							 return;
	   							}
	                   				document.SigForm.bioSigData3.value = GetSigString();
	                   				document.SigForm.sigStringData3.value  = document.SigForm.bioSigData3.value;
								$.post("<?php echo $GLOBALS['webroot'] ?>/interface/forms/psychiatric_evaluation/save_provider_signature.php?mode=update&id=<?php echo $_GET['id'];?>",
										{form_id: $("#signatureid").val() , provider_print_name: $("#provider_print_name").val() ,provider_credentials: $("#provider_credentials").val() , provider_signature_date: $("#provider_signature_date").val(), provider_signature: $('#sigStringData3').val()},
											function(data) 
												{
										  			  //alert (data);
													  alert("Provider Signature Saved");
												}								
										);		
									SetImageXSize(500);
								    SetImageYSize(100);
								    SetImagePenWidth(1);
								    SetJustifyMode(0);
								    GetSigImageB64(SigImageCallback);
						    }
			
				
					function onDone4()
							{
	                			if(NumberOfTabletPoints() == 0)
	   							{
	      							//no signature, exit
	     							 return;
	   							}
	                   				document.SigForm.bioSigData4.value = GetSigString();
	                   				document.SigForm.sigStringData4.value  = document.SigForm.bioSigData4.value;
								$.post("<?php echo $GLOBALS['webroot'] ?>/interface/forms/psychiatric_evaluation/save_supervisor_signature.php?mode=update&id=<?php echo $_GET['id'];?>",
									{form_id: $("#signatureid").val() ,supervisor_print_name: $("#supervisor_print_name").val() ,supervisor_credentials: $("#supervisor_credentials").val() , supervisor_signature_date: $("#supervisor_signature_date").val(), supervisor_signature: $('#sigStringData4').val()},
										function(data) 
												{
										  			  //alert (data);
													  alert("Supervisor Signature Saved");
												}								
										);		
									SetImageXSize(500);
								    SetImageYSize(100);
								    SetImagePenWidth(1);
								    SetJustifyMode(0);
								    GetSigImageB64(SigImageCallback);
							}
							
					function onDone5()
							{
	           					if(NumberOfTabletPoints() == 0)
	   							{
	      							//no signature, exit
	     							 return;
	   							}
	                   				document.SigForm.bioSigData5.value = GetSigString();
	                   				document.SigForm.sigStringData5.value  = document.SigForm.bioSigData5.value;
								$.post("<?php echo $GLOBALS['webroot'] ?>/interface/forms/psychiatric_evaluation/save_physician_signature.php?mode=update&id=<?php echo $_GET['id'];?>",
										{form_id: $("#signatureid").val() , physician_print_name: $("#physician_print_name").val() ,physician_credentials: $("#physician_credentials").val() , physician_signature_date: $("#physician_signature_date").val(), physician_signature: $('#sigStringData5').val()},
											function(data) 
												{
													//alert (data);
										  			alert("Physician Signature Saved");
												}								
										);		
									SetImageXSize(500);
								    SetImageYSize(100);
								    SetImagePenWidth(1);
								    SetJustifyMode(0);
								    GetSigImageB64(SigImageCallback);
						    }
		


		    function Refresh() {
		                
                        document.getElementById('sigplus').refreshEvent();
                                               
		    }
		    
		    function Display() {
		                alert(document.getElementById('sigplus').sigString);		   
		                 }
		                 
		                 
		              

  
	
	function providersignature()
					{
							$.post("<?php echo $GLOBALS['webroot'] ?>/interface/forms/psychiatric_evaluation/get-signature.php",
								{provider_print_name: $("#provider_print_name").val() , PIN: $("#clinician_pin").val() },
								function(data) {
								  if($.trim(data).length > 0){
								  		var ctx3 = document.getElementById('sigplus3').getContext('2d');         
   											SetDisplayXSize( 500 );
   											SetDisplayYSize( 100 );
   											SetJustifyMode(0);
   											ClearTablet();
 										var  tmr = SetTabletState(1, ctx3, 50) || tmr;

								  	
								  //document.getElementById('sigplus2').sigString =  "<?php echo $signature_result; ?>";
                                    var mySig3 = data;
                                    SetSigString(mySig3, ctx3);
   									SetJustifyMode(0);

							 	//alert(data.length);
								 	//alert(data);
								 } else {
								  	alert("Incorrect PIN or Clinician Name");
								  }
								}								
							);
						}

	
	function supervisorsignature()
					{
							$.post("<?php echo $GLOBALS['webroot'] ?>/interface/forms/psychiatric_evaluation/get-signature.php",
								{provider_print_name: $("#supervisor_print_name").val() , PIN: $("#supervisor_pin").val() },
								function(data) {
								  if($.trim(data).length > 0){
								  		var ctx4 = document.getElementById('sigplus4').getContext('2d');         
   											SetDisplayXSize( 500 );
   											SetDisplayYSize( 100 );
   											SetJustifyMode(0);
   											ClearTablet();
 										var  tmr1 = SetTabletState(1, ctx4, 50) || tmr1;

								  	
								  //document.getElementById('sigplus2').sigString =  "<?php echo $signature_result; ?>";
                                    var mySig4 = data;
                                    SetSigString(mySig4, ctx4);
   									SetJustifyMode(0);

							 	//alert(data.length);
								 	//alert(data);								
								 	 } else {
								  	alert("Incorrect PIN or Supervisor Name");
								  }
								}								
							);
						}

	function physiciansignature(){
								$.post("<?php echo $GLOBALS['webroot'] ?>/interface/forms/psychiatric_evaluation/get-signature.php",
									{provider_print_name: $("#physician_print_name").val() , PIN: $("#physician_pin").val() },
									function(data) {
									 if($.trim(data).length > 0){
								  		var ctx5 = document.getElementById('sigplus5').getContext('2d');         
   											SetDisplayXSize( 500 );
   											SetDisplayYSize( 100 );
   											SetJustifyMode(0);
   											ClearTablet();
 										var  tmr = SetTabletState(1, ctx5, 50) || tmr;								  	
								  //document.getElementById('sigplus2').sigString =  "<?php echo $signature_result; ?>";
                                    var mySig5 = data;
                                    SetSigString(mySig5, ctx5);
   									SetJustifyMode(0);
							 	//alert(data.length);
								 	//alert(data);		
									} else {
										alert("Incorrect PIN or Physician Name");
									}
									}								
								);
							}
			
	
	
	
	
function disableSignButtons()
{
document.getElementById("SignBtn").disabled = true; 
document.getElementById("SignBtn1").disabled = true; 
//document.getElementById("Sign3Btn").disabled = true; 
}

function enableSignButtons()
{
document.getElementById("SignBtn").disabled = false; 
document.getElementById("SignBtn1").disabled = false; 
//document.getElementById("Sign3Btn").disabled = false; 
}


function saveSigs()
{
   if(NumberOfTabletPoints() == 0)
   {
      //no signature, exit
      return;
   }

   if(cursig == 1)
   {
      document.FORM1.bioSigData.value = GetSigString(); //assign sigstring to hidden field
      document.FORM1.sigStringDataText.value = document.FORM1.bioSigData.value; //show current sigstring data in text area
   }
   if(cursig == 2)
   {
      document.FORM1.bioSigData2.value = GetSigString(); //assign sigstring to hidden field
      document.FORM1.sigStringDataText.value = document.FORM1.bioSigData2.value; //show current sigstring data in text area
   }
   if(cursig == 3)
   {
      document.FORM1.bioSigData3.value = GetSigString(); //assign sigstring to hidden field
      document.FORM1.sigStringDataText.value = document.FORM1.bioSigData3.value; //show current sigstring data in text area
   }

      SetImageXSize(500);
      SetImageYSize(100);
      SetImagePenWidth(5);
      GetSigImageB64(SigImageCallback);
}





</script>
		
		
		
		
		<body onload="onReturnPhySig()">
		<!--<body onload="onReturnSampleSig5()">-->
			<p>This is to certify that this intervention was a FACE-TO-FACE interview with the patient during which information was gathered and written to formulate a diagnosis and plan of care.</p>
			<div id="physician_signature" class="">
				<h3>Physician's Signature</h3>
				<canvas id="sigplus5" width="400" height="80" style="border:1px solid #000000;"></canvas>
				<br>
				<div class="form-inline">
					<label>Physician: </label><span><?php echo stripslashes($obj{"physician_print_name"});?></span>
					<label>Credentials: </label><span><?php echo stripslashes($obj{"physician_credentials"});?></span>
					<br>
					<label>Signature Date:</label>
					<div class="input-group date">
				  		<span><?php echo stripslashes($obj{'physician_signature_date'});?></span>
					</div><br>
				</div>
			</div><!--END  PHYSICIAN SIGNATURE-->			
		</div>
	</form>

</div>

</body>
</html>
