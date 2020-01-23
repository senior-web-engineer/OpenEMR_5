<!-- Forms generated from formsWiz -->
<?php
include_once("../../globals.php");
?>
<html><head>
<?php html_header_show();?>
<link rel=stylesheet href="<?php echo $css_header;?>" type="text/css">
<link rel=stylesheet href="../../themes/style-form-print.css" type="text/css">
<style type="text/css">
.style1 {
	font-size: x-small;
}
</style>
</head>

<!-- supporting javascript code -->
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/textformat.js"></script>

<!-- pop up calendar -->
<style type="text/css">@import url(<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.css);</style>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.js"></script>
<?php include_once("{$GLOBALS['srcdir']}/dynarch_calendar_en.inc.php"); ?>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar_setup.js"></script>

<script language="JavaScript">
// required for textbox date verification
var mypcc = '<?php echo $GLOBALS['phone_country_code'] ?>';
$(function() {
    $('input:checkbox').attr('disabled', true);
});
</script>

<body <?php echo $top_bg_line;?> topmargin=0 rightmargin=0 leftmargin=2 bottommargin=0 marginwidth=2 marginheight=0>
<?php
include_once("$srcdir/api.inc");
$obj = formFetch("form_assessment_cmh", $_GET["id"]);
?>
<form method=post action="<?php echo $rootdir?>/forms/assessment_cmh/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="my_form">

<?php $res = sqlStatement("SELECT fname,mname,lname,ss,street,city,state,postal_code,phone_home,DOB,sex FROM patient_data WHERE pid = $pid");
$result = SqlFetchArray($res); 
$dos = sqlQuery("select date from form_encounter where encounter=$encounter");
?>

<!-- Info Header -->
<div class="header">
	<h1>Assessment</h1>
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
			<span>Admission Date:</span><?php echo stripslashes($obj{"admit_date"});?>
			<span>Therapist:</span><?php echo $_SESSION['date'] ?><?php echo stripslashes($obj{"provider"});?><br>
			<span>Time Started:</span><?php echo stripslashes($obj{"timestart"});?>
			<span>End Time:</span><?php echo stripslashes($obj{"timeend"});?><br>
		</div>
		<br class="clr">
	</div>
	<br class="clr">
</div>
<!-- Notes -->
	<div class="notes">

<!--

<b>Name:</b>&nbsp; <?php echo $result['fname'] . '&nbsp' . $result['mname'] . '&nbsp;' . $result['lname'];?> 
<img src="../../../images/space.gif" width="572" height="1">
-->

<!-- 
<b>Date:</b>&nbsp; <?php print date('m/d/y'); ?><br><br>
--><br><br>
<!--
<b>SSN:</b>&nbsp;<?php echo $result['ss'];?><img src="../../../images/space.gif" width="172" height="1">
<!--
<b>DCN:</b>&nbsp;<input type="entry" name="dcn" value="<?php echo stripslashes($obj{"dcn"});?>"><img src="../../../images/space.gif" width="125" height="1">
-->
<label><b>Location:</b>&nbsp;<?php echo stripslashes($obj{"location"});?>
<!--<b>Address:</b>&nbsp; <?php echo $result['street'] . ',&nbsp' . $result['city']  . ',&nbsp' . $result['state'] . '&nbsp;' . $result['postal_code'];?><br><br>
<b>Telephone Number:</b>&nbsp; <?php echo $result['phone_home'];?><img src="../../../images/space.gif" width="400" height="1"> 
<b>Date of Birth:</b>&nbsp;<?php echo $result['DOB'];?><br><br>
<label><b>Time In:</b>&nbsp;<input type="entry" name="timestart" value="<?php echo stripslashes($obj{"timestart"});?>"></label><img src="../../../images/space.gif" width="65" height="1">
<label><b>Time Out:</b>&nbsp;<input type="entry" name="timeend" value="<?php echo stripslashes($obj{"timeend"});?>"></label><img src="../../../images/space.gif" width="65" height="1">

-->

<label><b>Referral Source:</b>&nbsp;<?php echo stripslashes($obj{"referral_source"});?><br><br>
<b>Purpose:</b>&nbsp; <input type=checkbox name='new_client_eval' <?php if ($obj{"new_client_eval"} == "on") {echo "checked";};?>  ><b>New client evaluation</b><img src="../../../images/space.gif" width="10" height="1">
<input type=checkbox name='readmission' <?php if ($obj{"readmission"} == "on") {echo "checked";};?>  ><b>Readmission</b><img src="../../../images/space.gif" width="35" height="1">
<input type=checkbox name='consultation' <?php if ($obj{"consultation"} == "on") {echo "checked";};?> ><b>Consultation/Annual 
		Update</b><br><br> 
<label><b>Copy sent to:</b>&nbsp;<?php echo stripslashes($obj{"copy_sent_to"});?><br><br>

<label><b>Therapist:</b>&nbsp;<?php echo stripslashes($obj{"provider"});?>

<br><br>
<label><b>Service Code:</b>&nbsp;<?php echo stripslashes($obj{"servicecode"});?>

<br>
<h2>Chief Complaint/Presenting Problem:</h2>
<p><?php echo stripslashes($obj{"complaint"});?></p>

<h2>Background History:</h2>

<p><?php echo stripslashes($obj{"background_history"});?></p>

<h2>Inpatient/Outpatient Psychiatric History & Patient's Response to Treatment:</h2><p>
<?php echo stripslashes($obj{"mh_history"});?></p>

<h2>Family Psychiatric History:</h2><p>
<?php echo stripslashes($obj{"fam_mh_history"});?></p>

<h2>Inpatient/Outpatient Substance Use History & Patient's Response to Treatment:</h2>
<p><?php echo stripslashes($obj{"sa_history"});?></p>

<h2>Family Substance Abuse History:</h2>
<p><?php echo stripslashes($obj{"fam_sa_history"});?></p>

<h2>Physical Health History:</h2>

<?php echo stripslashes($obj{"phys_history"});?>

<h2>Developmental/Behavioral History:</h2>
<?php echo stripslashes($obj{"dev_history"});?>

<h2>History of Abuse, Neglect and/or Abandonment:</h2>
<?php echo stripslashes($obj{"abuse_history"});?>

<h2>History of Domestic and /or Other Violent Behavior:</h2>
<?php echo stripslashes($obj{"violent_history"});?>

<h2>Education History:</h2>
<?php echo stripslashes($obj{"education_history"});?>

<h2>Employment/Military History:</h2>
<?php echo stripslashes($obj{"empl_history"});?>

<h2>Legal History:</h2>
<?php echo stripslashes($obj{"legal_history"});?>




<b><u></u>Areas of Functioning:</b><br><br>
<b>School/Work:</b><br>

<?php echo stripslashes($obj{"school_work"});?>

<b>Personal Relationships (Intimate):</b><br>

<?php echo stripslashes($obj{"personal_relationships"});?>
<b><h2>Family Relationships:</h2></b>&nbsp; &nbsp;
<h2><input type=checkbox name='fatherc' <?php if ($obj{"fatherc"} == "on") {echo "checked";};?>  >&nbsp;Father involved/present/absent (Describe relationship)</h2></b><br>
<?php echo stripslashes($obj{"father_involved"});?>
<h2><input type=checkbox name='motherc' <?php if ($obj{"motherc"} == "on") {echo "checked";};?>  >&nbsp;<b>Mother involved/present/absent (Describe relationship)</h2></b><br>
<?php echo stripslashes($obj{"mother_involved"});?>
<b>Number of children:</b>&nbsp;
<?php echo stripslashes($obj{"number_children"});?>
<br>
<b>Names, ages, quality of relationship(s):</b><br>

<?php echo stripslashes($obj{"siblings"});?>
<br>
<b>Other family relationships:</b><br>
<?php echo stripslashes($obj{"other_relationships"});?><br><br>
<b>Social Relationships (Peers/Friends):</b><br>
<?php echo stripslashes($obj{"social_relationships"});?><br><br>
<b>Psychological/Personal Functioning (Current symptoms):</b><br>
<?php echo stripslashes($obj{"current_symptoms"});?><br><br>
<b>Personal resources and strengths (including the availability and use of family and peers):</b><br>
<?php echo stripslashes($obj{"personal_strengths"});?><br><br>
<b>Spiritual:</b>&nbsp;<?php echo stripslashes($obj{"spiritual"});?>&nbsp;<img src="../../../images/space.gif" width="35" height="1">
<b>Legal:</b>&nbsp;<?php echo stripslashes($obj{"legal"});?><br><br>

<b>Integrated Clinical Summary / Justification for Diagnosis:</b><br>
<?php echo stripslashes($obj{"summary_justification"});?><br><br>
<?php
		if (($dos['date']) >= '2014-01-01'){
		?>
				<b><u>DSM Diagnoses</u></b><br><br>
				<b>DSM 5: </b><br>
				<?php echo stripslashes($obj{"axis1"});?><br>
				<?php echo stripslashes($obj{"axis2"});?><br>
				<?php echo stripslashes($obj{"axis3"});?><br>
		<?php
		}else{
		?>
				<b><u>DSM Diagnoses</u></b><br><br>
				<b>Axis I:</b><br>
				<?php echo stripslashes($obj{"axis1"});?><br><br>
				<b>Axis II:</b><br>
				<?php echo stripslashes($obj{"axis2"});?><br><br>
				<b>Axis III:</b><br>
				<?php echo stripslashes($obj{"axis3"});?><br><br>
				<b><u>Allergies/Adverse reactions to medications:</u></b>&nbsp;<?php echo stripslashes($obj{"allergies"});?><br><br>
				<b>Axis IV Psychosocial and environmental problems in the last year:</b><br>
				<input type=checkbox name='ax4_prob_support_group' <?php if ($obj{"ax4_prob_support_group"} == "on") {echo "checked";};?>  >&nbsp;<b>Problems with primary support group</b>
				<img src="../../../images/space.gif" width="35" height="1">
				<input type=checkbox name='ax4_prob_soc_env' <?php if ($obj{"ax4_prob_soc_env"} == "on") {echo "checked";};?>  >&nbsp;<b>Problems related to the social environment</b><br>
				
				<input type=checkbox name='ax4_educational_prob' <?php if ($obj{"ax4_educational_prob"} == "on") {echo "checked";};?>  >&nbsp;<b>Educational problems</b>
				<img src="../../../images/space.gif" width="5" height="1">
				<input type=checkbox name='ax4_occ_prob' <?php if ($obj{"ax4_occ_prob"} == "on") {echo "checked";};?>  >&nbsp;<b>Occupational problems</b>
				<img src="../../../images/space.gif" width="5" height="1">
				<input type=checkbox name='ax4_housing' <?php if ($obj{"ax4_housing"} == "on") {echo "checked";};?>  >&nbsp;<b>Housing problems</b>
				<img src="../../../images/space.gif" width="5" height="1">
				<input type=checkbox name='ax4_economic' <?php if ($obj{"ax4_economic"} == "on") {echo "checked";};?>  >&nbsp;<b>Economic problems</b><br>
				<input type=checkbox name='ax4_access_hc' <?php if ($obj{"ax4_access_hc"} == "on") {echo "checked";};?>  >&nbsp;<b>Problems with access to health care services</b>
				<img src="../../../images/space.gif" width="5" height="1">
				<input type=checkbox name='ax4_legal' <?php if ($obj{"ax4_legal"} == "on") {echo "checked";};?>  >&nbsp;<b>Problems related to interaction with the legal system/crime</b><br>
				<input type=checkbox name='ax4_other_cb' <?php if ($obj{"ax4_other_cb"} == "on") {echo "checked";};?>  >&nbsp;<b>Other (specify):</b><br>
				<?php echo stripslashes($obj{"ax4_other"});?><br><br>
				<b>Axis V Global Assessment of Functioning (GAF) Scale (100 down to 0):</b>
				<img src="../../../images/space.gif" width="5" height="1"><br>
				<b>Currently</b><input type="entry" name="ax5_current" value="<?php echo stripslashes($obj{"ax5_current"});?>">
				<img src="../../../images/space.gif" width="5" height="1">
				<b>Past Year</b><input type="entry" name="ax5_past" value="<?php echo stripslashes($obj{"ax5_current"});?>"><br><br>
		
		<?php
		}
		?>

<b><u>Assessment of Currently Known Risk Factors:</u></b><br><br>
<b>Suicide:</b><br><input type=checkbox name='risk_suicide_na' <?php if ($obj{"risk_suicide_na"} == "on") {echo "checked";};?>  >&nbsp;
<b>Not Assessed</b><br>
	<img src="../../../images/space.gif" width="5" height="1">
	<b>Behaviors:</b><img src="../../../images/space.gif" width="5" height="1">
	<input type=checkbox name='risk_suicide_nk' <?php if ($obj{"risk_suicide_nk"} == "on") {echo "checked";};?>  >&nbsp;<b>Not Known</b>
	<img src="../../../images/space.gif" width="5" height="1">
	<input type=checkbox name='risk_suicide_io' <?php if ($obj{"risk_suicide_io"} == "on") {echo "checked";};?>  >&nbsp;<b>Ideation only</b>
	<img src="../../../images/space.gif" width="5" height="1">
	<input type=checkbox name='risk_suicide_plan' <?php if ($obj{"risk_suicide_plan"} == "on") {echo "checked";};?>  >&nbsp;<b>Plan</b><br>
	<img src="../../../images/space.gif" width="100" height="1">
	<input type=checkbox name='risk_suicide_iwom' <?php if ($obj{"risk_suicide_iwom"} == "on") {echo "checked";};?>  >&nbsp;<b>Intent without means</b>
	<img src="../../../images/space.gif" width="5" height="1">
	<input type=checkbox name='risk_suicide_iwm' <?php if ($obj{"risk_suicide_iwm"} == "on") {echo "checked";};?>  >&nbsp;<b>Intent with means</b>
	<img src="../../../images/space.gif" width="5" height="1">
	<input type=checkbox name='risk_suicide_none' <?php if ($obj{"risk_suicide_none"} == "on") {echo "checked";};?>  >&nbsp;<b>None</b><br>
<br>
<b>Homicide:</b><br><input type=checkbox name='risk_homocide_na' <?php if ($obj{"risk_homocide_na"} == "on") {echo "checked";};?>  >&nbsp;<b>Not Assessed</b>
	<img src="../../../images/space.gif" width="5" height="1">
	<b><br>&nbsp;&nbsp;&nbsp; Behaviors:</b>
	<img src="../../../images/space.gif" width="5" height="1">
	<input type=checkbox name='risk_homocide_nk' <?php if ($obj{"risk_homocide_nk"} == "on") {echo "checked";};?>  >&nbsp;<b>Not Known</b>
	<img src="../../../images/space.gif" width="5" height="1">
	<input type=checkbox name='risk_homocide_io' <?php if ($obj{"risk_homocide_io"} == "on") {echo "checked";};?>  >&nbsp;<b>Ideation only</b>
	<img src="../../../images/space.gif" width="5" height="1">
	<input type=checkbox name='risk_homocide_plan' <?php if ($obj{"risk_homocide_plan"} == "on") {echo "checked";};?>  >&nbsp;<b>Plan</b><br>
	<img src="../../../images/space.gif" width="100" height="1">
	<input type=checkbox name='risk_homocide_iwom' <?php if ($obj{"risk_homocide_iwom"} == "on") {echo "checked";};?>  >&nbsp;<b>Intent without means</b>
	<img src="../../../images/space.gif" width="5" height="1">
	<input type=checkbox name='risk_homocide_iwm' <?php if ($obj{"risk_homocide_iwm"} == "on") {echo "checked";};?>  >&nbsp;<b>Intent with means</b>
    <img src="../../../images/space.gif" width="5" height="1">

    <input type=checkbox name='risk_homocide_none' <?php if ($obj{"risk_homocide_none"} == "on") {echo "checked";};?>  >&nbsp;<b>None</b><br>
<br>
<br>	
<b>Compliance with treatment:</b><br><input type=checkbox name='risk_compliance_na' <?php if ($obj{"risk_compliance_na"} == "on") {echo "checked";};?>  >&nbsp;<b>Not Assessed</b>
	<img src="../../../images/space.gif" width="5" height="1">
	<input type=checkbox name='risk_compliance_fc' <?php if ($obj{"risk_compliance_fc"} == "on") {echo "checked";};?>  >&nbsp;<b>Full compliance</b>
	<img src="../../../images/space.gif" width="5" height="1">
	<input type=checkbox name='risk_compliance_mc' <?php if ($obj{"risk_compliance_mc"} == "on") {echo "checked";};?>  >&nbsp;<b>Minimal compliance</b>
	<img src="../../../images/space.gif" width="5" height="1">
	<input type=checkbox name='risk_compliance_moc' <?php if ($obj{"risk_compliance_moc"} == "on") {echo "checked";};?>  >&nbsp;<b>Moderate compliance</b><br>
	<img src="../../../images/space.gif" width="100" height="1">
	<input type=checkbox name='risk_compliance_var' <?php if ($obj{"risk_compliance_var"} == "on") {echo "checked";};?>  >&nbsp;<b>Variable</b>
	<img src="../../../images/space.gif" width="5" height="1">
	<input type=checkbox name='risk_compliance_no' <?php if ($obj{"risk_compliance_no"} == "on") {echo "checked";};?>  >&nbsp;<b>Little or no compliance</b><br>
<br>	
<b>Substance Abuse:</b><br><input type=checkbox name='risk_substance_na' <?php if ($obj{"risk_substance_na"} == "on") {echo "checked";};?>  >&nbsp;<b>Not Assessed</b>
	<img src="../../../images/space.gif" width="5" height="1">
	<input type=checkbox name='risk_substance_none' <?php if ($obj{"risk_substance_none"} == "on") {echo "checked";};?>  >&nbsp;<b>None/normal use:</b><br>
    <?php echo stripslashes($obj{"risk_normal_use"});?><br>
	<input type=checkbox name='risk_substance_ou' <?php if ($obj{"risk_substance_ou"} == "on") {echo "checked";};?>  >&nbsp;<b>Overuse</b>
	<img src="../../../images/space.gif" width="5" height="1">
	<input type=checkbox name='risk_substance_dp' <?php if ($obj{"risk_substance_dp"} == "on") {echo "checked";};?>  >&nbsp;<b>Dependence</b>
	<img src="../../../images/space.gif" width="5" height="1">
	<input type=checkbox name='risk_substance_ur' <?php if ($obj{"risk_substance_ur"} == "on") {echo "checked";};?>  >&nbsp;<b>Unstable remission of abuse</b>
	<img src="../../../images/space.gif" width="5" height="1">
	<input type=checkbox name='risk_substance_ab' <?php if ($obj{"risk_substance_ab"} == "on") {echo "checked";};?>  >&nbsp;<b>Abuse</b><br>
<br>	
<b>Current physical or sexual abuse:</b><br><input type=checkbox name='risk_sexual_na' <?php if ($obj{"risk_sexual_na"} == "on") {echo "checked";};?>  >&nbsp;<b>Not Assessed</b>
	<img src="../../../images/space.gif" width="5" height="1">
	<input type=checkbox name='risk_sexual_y' <?php if ($obj{"risk_sexual_y"} == "on") {echo "checked";};?>>&nbsp;<b>Yes</b>
	<img src="../../../images/space.gif" width="5" height="1">
	<input type=checkbox name='risk_sexual_n' <?php if ($obj{"risk_sexual_n"} == "on") {echo "checked";};?>>&nbsp;<b>No</b><br>
	<b>Legally reportable?</b>&nbsp;<input type=checkbox name='risk_sexual_ry' <?php if ($obj{"risk_sexual_ry"} == "on") {echo "checked";};?>>&nbsp;<b>Yes</b>
   	<img src="../../../images/space.gif" width="5" height="1">
	<input type=checkbox name='risk_sexual_rn' <?php if ($obj{"risk_sexual_rn"} == "on") {echo "checked";};?>>&nbsp;<b>No</b>
	<img src="../../../images/space.gif" width="5" height="1">
	<b>If yes, client is </b>&nbsp;<input type=checkbox name='risk_sexual_cv' <?php if ($obj{"risk_sexual_cv"} == "on") {echo "checked";};?>>&nbsp;<b>victim</b>
	&nbsp;<input type=checkbox name='risk_sexual_cp' <?php if ($obj{"risk_sexual_cp"} == "on") {echo "checked";};?>>&nbsp;<b>perpetrator</b><br>
	<input type=checkbox name='risk_sexual_b' <?php if ($obj{"risk_sexual_b"} == "on") {echo "checked";};?>>&nbsp;<b>Both</b>&nbsp;
	<img src="../../../images/space.gif" width="5" height="1">
	<input type=checkbox name='risk_sexual_nf' <?php if ($obj{"risk_sexual_nf"} == "on") {echo "checked";};?>>&nbsp;<b>neither, but abuse exists in family</b>&nbsp;<br>
<br>
<b>Current child/elder abuse:</b><br><input type=checkbox name='risk_neglect_na' <?php if ($obj{"risk_neglect_na"} == "on") {echo "checked";};?>  >&nbsp;<b>Not Assessed</b>
	<img src="../../../images/space.gif" width="5" height="1">
	<input type=checkbox name='risk_neglect_y' <?php if ($obj{"risk_neglect_y"} == "on") {echo "checked";};?>>&nbsp;<b>Yes</b>
	<img src="../../../images/space.gif" width="5" height="1">
	<input type=checkbox name='risk_neglect_n' <?php if ($obj{"risk_neglect_n"} == "on") {echo "checked";};?>>&nbsp;<b>No</b><br>
	<b>Legally reportable?</b>&nbsp;<input type=checkbox name='risk_neglect_ry' <?php if ($obj{"risk_neglect_ry"} == "on") {echo "checked";};?>>&nbsp;<b>Yes</b>
   	<img src="../../../images/space.gif" width="5" height="1">
	<input type=checkbox name='risk_neglect_rn' <?php if ($obj{"risk_neglect_rn"} == "on") {echo "checked";};?>>&nbsp;<b>No</b>
	<img src="../../../images/space.gif" width="5" height="1">
	<b>If yes, client is </b>&nbsp;<input type=checkbox name='risk_neglect_cv' <?php if ($obj{"risk_neglect_cv"} == "on") {echo "checked";};?>>&nbsp;<b>victim</b>
	&nbsp;<input type=checkbox name='risk_neglect_cp' <?php if ($obj{"risk_neglect_cp"} == "on") {echo "checked";};?>>&nbsp;<b>perpetrator</b><br>
	<input type=checkbox name='risk_neglect_cb' <?php if ($obj{"risk_neglect_cb"} == "on") {echo "checked";};?>>&nbsp;<b>Both</b>&nbsp;
	<img src="../../../images/space.gif" width="5" height="1">
	<input type=checkbox name='risk_neglect_cn' <?php if ($obj{"risk_neglect_cn"} == "on") {echo "checked";};?>>&nbsp;<b>neither, but abuse exists in family</b>&nbsp;<br>
<br>

	<b>If risk exists:</b>&nbsp;client&nbsp;<input type=checkbox name='risk_exists_c' <?php if ($obj{"risk_exists_c"} == "on") {echo "checked";};?>><b>can</b>&nbsp;
	<img src="../../../images/space.gif" width="5" height="1">
	<input type=checkbox name='risk_exists_cn' <?php if ($obj{"risk_exists_cn"} == "on") {echo "checked";};?>>&nbsp;<b>cannot</b>&nbsp;
	<b>meaningfully agree to a contract not to harm</b><br>
	<input type=checkbox name='risk_exists_s' <?php if ($obj{"risk_exists_s"} == "on") {echo "checked";};?>>&nbsp;<b>self</b>
	<img src="../../../images/space.gif" width="5" height="1">
	<input type=checkbox name='risk_exists_o' <?php if ($obj{"risk_exists_o"} == "on") {echo "checked";};?>>&nbsp;<b>others</b>
	<img src="../../../images/space.gif" width="5" height="1">
	<input type=checkbox name='risk_exists_b' <?php if ($obj{"risk_exists_b"} == "on") {echo "checked";};?>>&nbsp;<b>both</b><br><br>
	
    <b>Risk to community (criminal):</b><br>
    <?php echo stripslashes($obj{"risk_community"});?><br>
	<b>Patient Desired Services and Goals:</b><br>
<?php echo stripslashes($obj{"desired_services"});?><br><br>

<b><u>Clinical Treatment Recommendations:</u></b><br><br>


<b>Outpatient Psychotherapy:</b><br>
	
	<img src="../../../images/space.gif" width="5" height="1">
	<input type=checkbox name='recommendations_psy_p'<?php if ($obj{"recommendations_psy_p"} == "on") {echo "checked";};?>>&nbsp;<b>Psychiatric/Medication Treatment</b><br>
	<img src="../../../images/space.gif" width="5" height="1">
	<input type=checkbox name='recommendations_psy_i' <?php if ($obj{"recommendations_psy_i"} == "on") {echo "checked";};?>>&nbsp;<b>Individual/Family Therapy</b><br>
	<img src="../../../images/space.gif" width="5" height="1">
	<input type=checkbox name='recommendations_psy_tboss'<?php if ($obj{"recommendations_psy_tboss"} == "on") {echo "checked";};?>>&nbsp;<b>Therapeutic Behavioral On-site Services(TBOSS)</b><br>
	<img src="../../../images/space.gif" width="5" height="1">
	<input type=checkbox name='recommendations_psy_d'<?php if ($obj{"recommendations_psy_d"} == "on") {echo "checked";};?>>&nbsp;<b>Intensive Outpatient Treatment (Day Treatment, PSR)</b><br>
	<img src="../../../images/space.gif" width="5" height="1">
	<input type=checkbox name='recommendations_psy_o'<?php if ($obj{"recommendations_psy_o"} == "on") {echo "checked";};?>>&nbsp;<b>Other</b><br>
    <?php echo stripslashes($obj{"recommendations_psy_notes"});?><br>

	
	<h2><b>Date report sent to referral source:</b></h2>
	
	<?php echo stripslashes($obj{"refer_date"});?>&nbsp;
	
	<h2><b>Date report sent to Parent/Guardian:</b></h2>
	
    <?php echo stripslashes($obj{"parent"});?>
	

	<br><br>
	
<b><u>Referrals for Continuing Services</u></b><br><br>

<b>Psychiatric Evaluation Psychotropic Medications:</b><br>
	<?php echo stripslashes($obj{"referrals_pepm"});?><br><br>

<b>Medical Care:</b><br>
	
	<?php echo stripslashes($obj{"referrals_mc"});?><br>
	
<b>Educational/vocational services:</b><br>
	<?php echo stripslashes($obj{"referrals_vt"});?><br>
	
<b>Other:</b><br>
	<?php echo stripslashes($obj{"referrals_o"});?><br>

<b>Current use of resources/services from other community agencies:</b><br>
	<?php echo stripslashes($obj{"referrals_cu"});?><br>
	
<b>Documents to be obtained (Release of Information Required):</b><br>
	<?php echo stripslashes($obj{"referrals_docs"});?><br>
	
<b>Other needed resources and services:</b><br>
	<?php echo stripslashes($obj{"referrals_or"});?><br>

<?php /* From New */ ?>



<?php /* From New */ ?>

<br>
<br>
<br>
<br>	

<!-- Signature -->
	<div class="sig">
		<div class="col1">
			<span class="u"><?php echo stripslashes($obj{"provider_print_name"});?>, <?php echo stripslashes($obj{"provider_credentials"});?></span>
			(Clinician/Technician)Electronically Signed By:<br><br>
			<span class="u"><?php echo stripslashes($obj{"supervisor_print_name"});?>, <?php echo stripslashes($obj{"supervisor_credentials"});?> </span>
			(Supervisor)Electronically Signed By:		</div>
		<!--
		<div class="col2">
			<span class="u"></span>
			Signature and Credentials<br><br>
			<span class="u"></span>
			Signature and Credentials
		</div>
		-->
		<div class="col3">
			<span class="u"><?php echo stripslashes($obj{"provider_signature_date"});?></span>
			Date<br><br>
			<span class="u"><?php echo stripslashes($obj{"supervisor_signature_date"});?></span>
			Date
		</div>
	</div>
	<br class="clr">
	


<?php
formFooter();
?>
