<!-- Forms generated from formsWiz -->
<?php
include_once("../../globals.php");
?>
<html><head>
<?php html_header_show();?>
<!--<link rel=stylesheet href="<?php echo $css_header;?>" type="text/css">-->
<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-3.3.7/css/bootstrap.min.css" type="text/css">
<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/interface/themes/theme.css" type="text/css">
<!-- supporting javascript code -->
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/textformat.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-2.0.2.min.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-sidebar.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-datepicker.min.js"></script>
<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/library/js/toast/jquery.toast.min.css" type="text/css">
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/fancybox/3.5.7/jquery.fancybox.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $GLOBALS['webroot'] ?>/library/js/fancybox/3.5.7/jquery.fancybox.min.css" media="screen" />

<!-- <script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/fancybox-2.1.5/jquery.fancybox.pack.js"></script>
<link rel="stylesheet" type="text/css" href="/openemr/library/js/fancybox-2.1.5/jquery.fancybox.css" media="screen" /> -->
<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/library/js/toast/jquery.toast.min.css" type="text/css">

<!-- pop up calendar -->
<!--<style type="text/css">@import url(<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.css);</style>-->
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.js"></script>
<?php include_once("{$GLOBALS['srcdir']}/dynarch_calendar_en.inc.php"); ?>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar_setup.js"></script>

</head>


<script language="JavaScript">
// required for textbox date verification
var mypcc = '<?php echo $GLOBALS['phone_country_code'] ?>';

function PrintForm() {
    newwin = window.open("<?php echo $rootdir."/forms/assessment_cmh/print.php?id=".$_GET["id"]; ?>","mywin");
}

</script>

<!-- AUTO SAVE -->
<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

<script>
    var AUTOSAVE = true;
    var INTERVAL = '<?php echo $auto_save_timer; ?>';
    var FORM_SELECTOR = 'form';
</script>

<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/toast/jquery.toast.min.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/auto-save.js"></script>
<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

<body <?php echo $top_bg_line;?> topmargin=0 rightmargin=0 leftmargin=2 bottommargin=0 marginwidth=2 marginheight=0>
<?php
include_once("$srcdir/api.inc");


$obj = formFetch("form_assessment_cmh", $_GET["id"]);
$provider_results = sqlQuery("select fname, mname, lname, supervisor from users where username='" . $_SESSION{"authUser"} . "'");
$dos = sqlQuery("select date from form_encounter where encounter=$encounter");
?>
<?php //echo "global". $GLOBALS['form_lock_override'];?>
<!--<form method=post action="<?php echo $rootdir?>/forms/assessment_cmh/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="my_form">-->
 <div class="topnav">
  <a href="#assessment">Assessment</a>
  <a href="#AOF">Areas of Functioning</a>
  <a href="#DSM">DSM Diagnosis</a>
  <a href="#Risk">Risk Factor</a>
  <a href="#Treatment">Treatment Recommendations</a>
  <a href="#Ref">Referrals</a>
  <a href="javascript:top.restoreSession();document.SigForm.submit();" class="link_submit">Save</a>
  <a href="<?php echo $GLOBALS['form_exit_url']; ?>"    
     class="link" onclick="top.restoreSession()">Don't Save</a>
  <a href="<?php echo "$web_root";?>/interface/forms/assessment_cmh/print.php?id=<?php echo $_GET["id"];?>" target="_blank">Print</a>
</div>
<form method=post action="<?php echo $rootdir?>/forms/assessment_cmh/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="SigForm" id="SigForm">

<script type="text/javascript" src="SigWebTablet.js"></script>


<?php 
	$res = sqlStatement("SELECT fname,mname,lname,ss,street,city,state,postal_code,phone_home,DOB FROM patient_data WHERE pid = $pid");
	$result = SqlFetchArray($res); 
?>

 
<br>
<br>
<fieldset id="assessment">
<b>Name:</b> <?php echo $result['fname'] . '&nbsp' . $result['lname'];?> 
<img src="../../../images/space.gif" width="572" height="1">
<!-- 
<b>Date:</b>&nbsp; <?php print date('m/d/y'); ?><br><br>
--><br><br>

<b>SSN:</b>&nbsp;<?php echo $result['ss'];?><img src="../../../images/space.gif" width="172" height="1">
<!--
<b>DCN:</b>&nbsp;<input type="entry" name="dcn" value="<?php echo stripslashes($obj{"dcn"});?>"><img src="../../../images/space.gif" width="125" height="1">
-->
<label>
    <b>Location:</b>&nbsp;
    <input class="input-css" type="entry" name="location" value=" 
    <?php echo stripslashes($obj{"location"});?>">
</label>
    <br><br>
    <b>Address:</b>&nbsp; 
    <?php echo $result['street'] . ',&nbsp' . $result['city']  . ',&nbsp' . $result['state'] . '&nbsp;' . $result['postal_code'];?>
    <br><br>
    <b>Telephone Number:</b>&nbsp;
    <?php echo $result['phone_home'];?><img src="../../../images/space.gif" width="400" height="1"> 
    <b>Date of Birth:</b>&nbsp;
    <?php echo $result['DOB'];?>
    <br><br>
<label>
    <b>Time In:</b>&nbsp;
    <input class="input-css" type="time" name="time_start" min= "0:00" max= "24:00" value="<?php echo stripslashes($obj{'time_start'});?>">
</label>
    <img src="../../../images/space.gif" width="65" height="1">
<label>
    <b>Time Out:</b>&nbsp;
    <input class="input-css" type="time" name="time_end" min="0:00" max= "24:00" value="<?php echo stripslashes($obj{'time_end'});?>">
</label>
    <img src="../../../images/space.gif" width="65" height="1">
<label>
    <b>Referral Source:</b>&nbsp;
    <input class="input-css" type="entry" name="referral_source" value="<?php echo stripslashes($obj{'referral_source'});?>">
</label>
    <br><br>
     <ul class="blank">
        <li class="section_break">
    <div>
<label>Purpose:</label>
    <span class="columns">  
        <label class="container" for="new_client_eval">New client evaluation
            <input type="checkbox" id="new_client_eval" name="new_client_eval"<?php if ($obj{"new_client_eval"} == "on") {echo "checked";};?>
               class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
    <span class="columns">  
        <label class="container" for="readmission">Readmission
            <input type="checkbox" id="readmission" name="readmission"<?php if ($obj{"readmission"} == "on") {echo "checked";};?>
               class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
    <span class="columns">  
        <label class="container" for="consultation">Consultation/Annual Update
            <input type="checkbox" id="consultation" name="consultation"<?php if ($obj{"consultation"} == "on") {echo "checked";};?>
               class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
    </div>
        </li>
    </ul>
<label>
    <b>Copy sent to:</b>&nbsp;
    <input class="input-css" type="entry" name="copy_sent_to" value="<?php echo stripslashes($obj{"copy_sent_to"});?>">
</label>
    <br>
    
    <br>

<?php //echo "<br>test". $form_lock_override;?>
<tr>
		<td>
            <label><strong>Therapist:</strong>
            <img src="../../../images/space.gif" width="24" height="1">
		
            <input class="input-css" type="text" name="provider" id="provider" value="<?php echo stripslashes($obj{"provider"});?>" readonly="readonly" >
            </label>
        </td>
</tr>

<br><br>
        <td>
            <label><strong>Service Code:</strong>

            <input class="input-css" type="text" name="service_code" value="<?php echo stripslashes($obj{"service_code"});?>" readonly="readonly">
            </label>
			<!--<select class="select-css" name="service_code" readonly="readonly" >
			<option selected=""><?php echo stripslashes($obj{"service_code"});?></option>
			<option value="H0031HO">H0031HO In-Depth Assessment(New Patient)</option>
			<option value="H0031TS">H0031TS In-Depth Assessment(Established Patient)</option>
			<option value="H0031HN">H0031HN Bio-Psychosocial</option>
			</select>-->
            
            <em>
                <span class="style3">(H0031HO, H0031TS or H0031HN)</span>
            </em>
        </td>
</fieldset>

<br>
<br>
    <b>Chief Complaint/Presenting Problem:</b>
<br>
    <textarea cols=100 rows=3 wrap=virtual name="complaint" ><?php echo stripslashes($obj{'complaint'});?></textarea>
<br>

    <b>Background History:</b>
<br>
    <textarea cols=100 rows=5 wrap=virtual name="background_history" ><?php echo stripslashes($obj{"background_history"});?></textarea>
<br>
<br>    
    <b>Inpatient/Outpatient Psychiatric History & Patient's Response to Treatment:</b>
<br>
    <textarea cols=100 rows=5 wrap=virtual name="mh_history" ><?php echo stripslashes($obj{"mh_history"});?></textarea>
<br>
<br>
    <b>Family Psyciatric History:</b>
<br>
    <textarea cols=100 rows=5 wrap=virtual name="fam_mh_history" ><?php echo stripslashes($obj{"fam_mh_history"});?></textarea>
<br>
<br>
    <b>Inpatien/Outpatient Substance Use History & Patient's Response to Treatment:</b>
<br>
    <textarea cols=100 rows=5 wrap=virtual name="sa_history" ><?php echo stripslashes($obj{"sa_history"});?></textarea>
<br>
<br>
    <b>Family Substance Abuse History:</b>
<br>
    <textarea cols=100 rows=5 wrap=virtual name="fam_sa_history" ><?php echo stripslashes($obj{"fam_sa_history"});?></textarea>
<br>
<br>
    <b>Physical Health History:</b>
<br>
    <textarea cols=100 rows=5 wrap=virtual name="phys_history" ><?php echo stripslashes($obj{"phys_history"});?></textarea>
<br>
<br>
    <b>Developmental/Behavioral History:</b>
<br>
    <textarea cols=100 rows=5 wrap=virtual name="dev_history" ><?php echo stripslashes($obj{"dev_history"});?></textarea>
<br>
<br>
    <b>History of Abuse, Neglect and/or Abandonment:</b>
<br>
    <textarea cols=100 rows=5 wrap=virtual name="abuse_history" ><?php echo stripslashes($obj{"abuse_history"});?></textarea>
<br>
<br>
    <b>History of Domestic and /or Other Violent Behavior:</b>
<br>
    <textarea cols=100 rows=5 wrap=virtual name="violent_history" ><?php echo stripslashes($obj{"violent_history"});?></textarea>
<br>
<br>
    <b>Education History:</b>
<br>
    <textarea cols=100 rows=5 wrap=virtual name="education_history" ><?php echo stripslashes($obj{"education_history"});?></textarea>
<br>
<br>
    <b>Employment/Military History:</b>
<br>
    <textarea cols=100 rows=5 wrap=virtual name="empl_history" ><?php echo stripslashes($obj{"empl_history"});?></textarea>
<br>
<br>
    <b>Legal History:</b>
<br>
    <textarea cols=100 rows=5 wrap=virtual name="legal_history" ><?php echo stripslashes($obj{"legal_history"});?></textarea>
<br>
<br>   
    <fieldset>
        <legend id="AOF">Areas of Functioning:</legend>

        <b>School/Work:</b>
<br>
        <textarea cols=100 rows=3 wrap=virtual name="school_work" ><?php echo stripslashes($obj{"school_work"});?></textarea>
<br>
<br>
        <b>Personal Relationships (Intimate):</b>
        <textarea cols=100 rows=4 wrap=virtual name="personal_relationships" ><?php echo stripslashes($obj{"personal_relationships"});?></textarea>
<br>
<br>
        <b>Family Relationships:</b>
        <span class="columns">
            <label class="container" for="fatherc">
                Father involved/present/absent (Describe relationship)
                <input type="checkbox" id="fatherc" name="fatherc"<?php if ($obj{"fatherc"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
            </label>
        </span>
<br>
        <textarea cols=100 rows=3 wrap=virtual name="father_involved" >
            <?php echo stripslashes($obj{"father_involved"});?>
        </textarea>
<br>
        <span class="columns">  
            <label class="container" for="motherc">
                Mother involved/present/absent (Describe relationship)
                <input type="checkbox" id="motherc" name="motherc"<?php if ($obj{"motherc"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label>
        </span>
<br>
        <textarea cols=100 rows=3 wrap=virtual name="mother_involved" ><?php echo stripslashes($obj{"mother_involved"});?></textarea>
<br>
<br>
        <b>Number of children:</b>
        <input class="input-css" type="entry" name="number_children"value="<?php echo stripslashes($obj{"number_children"});?>">
<br>
        <b>Names, ages, quality of relationship(s):</b>
<br>
        <textarea cols=100 rows=3 wrap=virtual name="siblings" ><?php echo stripslashes($obj{"siblings"});?></textarea>
<br>
<br>
        <b>Other family relationships:</b>
<br>
        <textarea cols=100 rows=2 wrap=virtual name="other_relationships" ><?php echo stripslashes($obj{"other_relationships"});?></textarea>
<br>
<br>
        <b>Social Relationships (Peers/Friends):</b>
<br>
        <textarea cols=100 rows=3 wrap=virtual name="social_relationships" ><?php echo stripslashes($obj{"social_relationships"});?></textarea>
<br>
<br>
        <b>Psychological/Personal Functioning (Current symptons):</b>
<br>
        <textarea cols=100 rows=3 wrap=virtual name="current_symptoms" ><?php echo stripslashes($obj{"current_symptoms"});?></textarea>
<br>
<br>
        <b>Personal resources and strengths (including the availability & use of family and peers):</b>
<br>
        <textarea cols=100 rows=3 wrap=virtual name="personal_strengths" ><?php echo stripslashes($obj{"personal_strengths"});?></textarea>
<br>
<br>
        <b>Spiritual:</b>
        <input class = "input-css" type="entry" name="spiritual" value="<?php echo stripslashes($obj{"spiritual"});?>">
        <b>Legal:</b>&nbsp;<input class="input-css"type="entry" name="legal" value="<?php echo stripslashes($obj{"legal"});?>">
<br>
<br>

        <b>Integrated Clinical Summary / Justification for Diagnosis:</b>
<br>
        <textarea cols=100 wrap=virtual name="summary_justification" style="height: 116px" ><?php echo stripslashes($obj{"summary_justification"});?></textarea>
<br>
<br>
    </fieldset>
<?php 
    if ($service_code != 'H0031HN'){
?>
<?php 
    if (($dos['date']) >= '2014-01-01'){
?>
    
    <fieldset>
        <legend id="DSM">DSM Diagnoses:</legend>
				<b>DSM 5: (One per Line)</b><br>
				<input  class = "input-css" name="axis1" style="width:100%" value="<?php echo stripslashes($obj{"axis1"});?>"><br><br>
				<b>DSM 5:</b><br>
				<input  class = "input-css" name="axis2" style="width:100%" value="<?php echo stripslashes($obj{"axis2"});?>"><br><br>
				<b>DSM 5:</b><br>
				<input class = "input-css" name="axis3" style="width:100%" value="<?php echo stripslashes($obj{"axis3"});?>">
    </fieldset>
        <br><br>
		<?php
		}else{
		?>
        <fieldset>
				<legend><u>DSM Diagnoses</u></legend>
<br>
<br>
				<b>Axis I:</b>
<br>
				<textarea cols=100 rows=3 wrap=virtual name="axis1" ><?php echo stripslashes($obj{"axis1"});?></textarea>
<br>
<br>
				<b>Axis II:</b>
<br>
				<textarea cols=100 rows=3 wrap=virtual name="axis2" ><?php echo stripslashes($obj{"axis2"});?></textarea>
<br>
<br>
				<b>Axis III:</b>
<br>
				<textarea cols=100 rows=3 wrap=virtual name="axis3" ><?php echo stripslashes($obj{"axis3"});?></textarea>
<br>
<br>
				<b><u>Allergies/Adverse reactions to medications:</u></b>
                <input class="input-css"type="entry" name="allergies" value="<?php echo stripslashes($obj{"allergies"});?>">
<br>
<br>
        </fieldset>
        <fieldset>
				<legend>Axis IV Psychosocial and environmental problems in the last year:</legend>
<br>            
                <span class="columns">
                    <label class="container" for="ax4_prob_support_group">
                        Problems with primary support group
                        <input type="checkbox" id="ax4_prob_support_group" name="ax4_prob_support_group"<?php if ($obj{"ax4_prob_support_group"} == "on") {echo "checked";};?>
                        class ="choice">
                <span class="checkmark" ></span>
                      </label>
                </span>
                <span class="columns"> 
                    <label class="container" for="ax4_prob_soc_env">
                        Problems related to the social environment
                        <input type="checkbox" id="ax4_prob_soc_env" name="ax4_prob_soc_env"<?php if ($obj{"ax4_prob_soc_env"} == "on") {echo "checked";};?>
                        class ="choice">
                <span class="checkmark" ></span>
                      </label>
                </span>
				<span class="columns">
                    <label class="container" for="ax4_educational_prob">
                        Educational problems
                        <input type="checkbox" id="ax4_educational_prob" name="ax4_educational_prob"<?php if ($obj{"ax4_educational_prob"} == "on") {echo "checked";};?>
                        class ="choice">
                <span class="checkmark" ></span>
                      </label>
                </span>
				
				<span class="columns">  
                    <label class="container" for="ax4_occ_prob">
                        Occupational problems
                        <input type="checkbox" id="ax4_occ_prob" name="ax4_occ_prob"<?php if ($obj{"ax4_occ_prob"} == "on") {echo "checked";};?>
                        class ="choice">
                <span class="checkmark" ></span>
                      </label>
                </span>
				<span class="columns">
                    <label class="container" for="ax4_housing">
                        Housing problems
                        <input type="checkbox" id="ax4_housing" name="ax4_housing"<?php if ($obj{"ax4_housing"} == "on") {echo "checked";};?>
                        class ="choice">
                <span class="checkmark" ></span>
                      </label>
                </span>
                <span class="columns">
                    <label class="container" for="ax4_economic">
                        Economic problems
                        <input type="checkbox" id="ax4_economic" name="ax4_economic"<?php if ($obj{"ax4_economic"} == "on") {echo "checked";};?>
                        class ="choice">
                <span class="checkmark" ></span>
                      </label>
                </span>
				<span class="columns">
                    <label class="container" for="ax4_access_hc">
                        Problems with access to health care services
                        <input type="checkbox" id="ax4_access_hc" name="ax4_access_hc"<?php if ($obj{"ax4_access_hc"} == "on") {echo "checked";};?>
                        class ="choice">
                <span class="checkmark" ></span>
                      </label>
                </span>
                <span class="columns">
                    <label class="container" for="ax4_legal">
                        Problems related to interaction with the legal system/crime
                        <input type="checkbox" id="ax4_legal" name="ax4_legal"<?php if ($obj{"ax4_legal"} == "on") {echo "checked";};?>
                        class ="choice">
                <span class="checkmark" ></span>
                      </label>
                </span>
				<span class="columns">
                    <label class="container" for="ax4_other_cb">
                        Other (specify)
                        <input type="checkbox" id="ax4_other_cb" name="ax4_other_cb"<?php if ($obj{"ax4_other_cb"} == "on") {echo "checked";};?>
                        class ="choice">
                <span class="checkmark" ></span>
                      </label>
                </span>
				<textarea cols=100 rows=2 wrap=virtual name="ax4_other" ><?php echo stripslashes($obj{"ax4_other"});?></textarea>
<br>
<br>
				<b>Axis V Global Assessment of Functioning (GAF) Scale (100 down to 0):</b>
				<img src="../../../images/space.gif" width="5" height="1">
<br>
				<b>Currently</b>
                    <input class="input-css" type="entry" name="ax5_current" value="<?php echo stripslashes($obj{"ax5_current"});?>">
				    <img src="../../../images/space.gif" width="5" height="1">
				<b>Past Year</b>
                    <input class="input-css" type="entry" name="ax5_past" value="<?php echo stripslashes($obj{"ax5_current"});?>">
<br>
<br>
		
		<?php
		}
		?>
        
		<?php
		}
		?>
    </fieldset>
<br>
    <fieldset>
        <legend id="Risk">Assessment of Currently Known Risk Factors:</legend>
<br>
    <fieldset>
        <legend>Suicide:</legend>
    <span class="columns">
        <label class="container" for="risk_suicide_na">
            Not Assessed <!--<?php var_dump($obj)?>-->
            <input type="checkbox" id="risk_suicide_na" name="risk_suicide_na"<?php if ($obj{"risk_suicide_na"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
	   <b>Behaviors:</b>
    <span class="columns">  
        <label class="container" for="risk_suicide_nk">
            Not Known
            <input type="checkbox" id="risk_suicide_nk" name="risk_suicide_nk"<?php if ($obj{"risk_suicide_nk"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
    <span class="columns"> 
        <label class="container" for="risk_suicide_io">
            Ideation only
        <input type="checkbox" id="risk_suicide_io" name="risk_suicide_io"<?php if ($obj{"risk_suicide_io"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
	<span class="columns">  
        <label class="container" for="risk_suicide_plan">
            Plan
            <input type="checkbox" id="risk_suicide_plan" name="risk_suicide_plan"<?php if ($obj{"risk_suicide_plan"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
	<span class="columns">  
        <label class="container" for="risk_suicide_iwom">
            Intent without means
            <input type="checkbox" id="risk_suicide_iwom" name="risk_suicide_iwom"<?php if ($obj{"risk_suicide_iwom"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
	<span class="columns">  
        <label class="container" for="risk_suicide_iwm">
            Intent with means
            <input type="checkbox" id="risk_suicide_iwm" name="risk_suicide_iwm"<?php if ($obj{"risk_suicide_iwm"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
	<span class="columns">  
        <label class="container" for="risk_suicide_none">
            None
            <input type="checkbox" id="risk_suicide_none" name="risk_suicide_none"<?php if ($obj{"risk_suicide_none"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
    </fieldset>
<br>
    <fieldset>
        <legend>Homocide:</legend>
    <span class="columns">  
        <label class="container" for="risk_homocide_na">
            Not Assessed
            <input type="checkbox" id="risk_homocide_na" name="risk_homocide_na"<?php if ($obj{"risk_homocide_na"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
	   <b>Behaviors:</b>
    <span class="columns">  
        <label class="container" for="risk_homocide_nk">
            Not Known
            <input type="checkbox" id="risk_homocide_nk" name="risk_homocide_nk"<?php if ($obj{"risk_homocide_nk"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
	<span class="columns">  
        <label class="container" for="risk_homocide_io">
            Ideation only
            <input type="checkbox" id="risk_homocide_io" name="risk_homocide_io"<?php if ($obj{"risk_homocide_io"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
	<span class="columns">  
        <label class="container" for="risk_homocide_plan">
            Plan
            <input type="checkbox" id="risk_homocide_plan" name="risk_homocide_plan"<?php if ($obj{"risk_homocide_plan"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
	<span class="columns">  
        <label class="container" for="risk_homocide_iwom">
            Intent without means
            <input type="checkbox" id="risk_homocide_iwom" name="risk_homocide_iwom"<?php if ($obj{"risk_homocide_iwom"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
	<span class="columns">  
        <label class="container" for="risk_homocide_iwm">
            Intent with means
            <input type="checkbox" id="risk_homocide_iwm" name="risk_homocide_iwm"<?php if ($obj{"risk_homocide_iwm"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
	<span class="columns">  
        <label class="container" for="risk_homocide_none">
            None
            <input type="checkbox" id="risk_homocide_none" name="risk_homocide_none"<?php if ($obj{"risk_homocide_none"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
    </fieldset>
<br>
<br>	
    <fieldset>
        <legend>Compliance with treatment:</legend>
    <span class="columns">  
        <label class="container" for="risk_compliance_na">
            Not Assessed
            <input type="checkbox" id="risk_compliance_na" name="risk_compliance_na"<?php if ($obj{"risk_compliance_na"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
    <span class="columns">  
        <label class="container" for="risk_compliance_fc">
            Fully compliance
            <input type="checkbox" id="risk_compliance_fc" name="risk_compliance_fc"<?php if ($obj{"risk_compliance_fc"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
	<span class="columns">  
        <label class="container" for="risk_compliance_mc">
            Minimal compliance
            <input type="checkbox" id="risk_compliance_mc" name="risk_compliance_mc"<?php if ($obj{"risk_compliance_mc"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
	<span class="columns">  
        <label class="container" for="risk_compliance_moc">
            Moderate compliance
            <input type="checkbox" id="risk_compliance_moc" name="risk_compliance_moc"<?php if ($obj{"risk_compliance_moc"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
	<span class="columns">  
        <label class="container" for="risk_compliance_var">
            Variable
            <input type="checkbox" id="risk_compliance_var" name="risk_compliance_var"<?php if ($obj{"risk_compliance_var"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
	<span class="columns">  
        <label class="container" for="risk_compliance_no">
            Little to no compliance
            <input type="checkbox" id="risk_compliance_no" name="risk_compliance_no"<?php if ($obj{"risk_compliance_no"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
    </fieldset>
<br>	
    <fieldset>
        <legend>Substance Abuse:</legend>
    <span class="columns">  
        <label class="container" for="risk_substance_na">
            Not Assessed
            <input type="checkbox" id="risk_substance_na" name="risk_substance_na"<?php if ($obj{"risk_substance_na"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
    <span class="columns">  
        <label class="container" for="risk_substance_none">
            None/normal use:
            <input type="checkbox" id="risk_substance_none" name="risk_substance_none"<?php if ($obj{"risk_substance_none"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
    <textarea cols=100 rows=1 wrap=virtual name="risk_normal_use" >
        <?php echo stripslashes($obj{"risk_normal_use"});?>
    </textarea>
    <span class="columns">  
        <label class="container" for="risk_substance_ou">
            Overuse
            <input type="checkbox" id="risk_substance_ou" name="risk_substance_ou"<?php if ($obj{"risk_substance_ou"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
	<span class="columns">  
        <label class="container" for="risk_substance_dp">
            Dependence
            <input type="checkbox" id="risk_substance_dp" name="risk_substance_dp"<?php if ($obj{"risk_substance_dp"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
	<span class="columns">  
        <label class="container" for="risk_substance_ur">
            Unstable remission of abuse
            <input type="checkbox" id="risk_substance_ur" name="risk_substance_ur"<?php if ($obj{"risk_substance_ur"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
	<span class="columns">  
        <label class="container" for="risk_substance_ab">
            Abuse
            <input type="checkbox" id="risk_substance_ab" name="risk_substance_ab"<?php if ($obj{"risk_substance_ab"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
    </fieldset>
<br>	
    <fieldset>
        <legend>Current physical or sexual abuse:</legend>
    <span class="columns">  
        <label class="container" for="risk_sexual_na">
            Not Assessed
            <input type="checkbox" id="risk_sexual_na" name="risk_sexual_na"<?php if ($obj{"risk_sexual_na"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
    <span class="columns">  
        <label class="container" for="risk_sexual_y">
            Yes
            <input type="checkbox" id="risk_sexual_y" name="risk_sexual_y"<?php if ($obj{"risk_sexual_y"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
	<span class="columns">  
        <label class="container" for="risk_sexual_n">
            No
            <input type="checkbox" id="risk_sexual_n" name="risk_sexual_n"<?php if ($obj{"risk_sexual_n"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
	   <b>Legally reportable?</b>
    <span class="columns"> 
        <label class="container" for="risk_sexual_ry">
            Yes
            <input type="checkbox" id="risk_sexual_ry" name="risk_sexual_ry"<?php if ($obj{"risk_sexual_ry"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
    <span class="columns">  
        <label class="container" for="risk_sexual_rn">
            No
            <input type="checkbox" id="risk_sexual_rn" name="risk_sexual_rn"<?php if ($obj{"risk_sexual_rn"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
	   <b>If yes, client is </b>
    <span class="columns">  
        <label class="container" for="risk_sexual_cv">
            Victim
            <input type="checkbox" id="risk_sexual_cv" name="risk_sexual_cv"<?php if ($obj{"risk_sexual_cv"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
    <span class="columns">  
        <label class="container" for="risk_sexual_cp">
            Perpetrator
            <input type="checkbox" id="risk_sexual_cp" name="risk_sexual_cp"<?php if ($obj{"risk_sexual_cp"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
	<span class="columns">  
        <label class="container" for="risk_sexual_b">
            Both
            <input type="checkbox" id="risk_sexual_b" name="risk_sexual_b"<?php if ($obj{"risk_sexual_b"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
	<span class="columns">  
        <label class="container" for="risk_sexual_nf">
            Neither, but abuse exists in the family
            <input type="checkbox" id="risk_sexual_nf" name="risk_sexual_nf"<?php if ($obj{"risk_sexual_nf"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
    </fieldset>
<br>
    <fieldset>
        <legend>Current child/elder abuse:</legend>
    <span class="columns">  
        <label class="container" for="risk_neglect_na">
            Not Assessed
            <input type="checkbox" id="risk_neglect_na" name="risk_neglect_na"<?php if ($obj{"risk_neglect_na"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
     <span class="columns"> 
         <label class="container" for="risk_neglect_y">
             Yes
             <input type="checkbox" id="risk_neglect_y" name="risk_neglect_y"<?php if ($obj{"risk_neglect_y"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
	<span class="columns">  
        <label class="container" for="risk_neglect_n">
            No
            <input type="checkbox" id="risk_neglect_n" name="risk_neglect_n"<?php if ($obj{"risk_neglect_n"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
	   <b>Legally reportable?</b>
    <span class="columns">  
        <label class="container" for="risk_neglect_ry">
            Yes
            <input type="checkbox" id="risk_neglect_ry" name="risk_neglect_ry"<?php if ($obj{"risk_neglect_ry"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
    <span class="columns"> 
        <label class="container" for="risk_neglect_rn">
            No
            <input type="checkbox" id="risk_neglect_rn" name="risk_neglect_rn"<?php if ($obj{"risk_neglect_rn"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
	   <b>If yes, client is </b>
    <span class="columns">  
        <label class="container" for="risk_neglect_cv">
            Victim
            <input type="checkbox" id="risk_neglect_cv" name="risk_neglect_cv"<?php if ($obj{"risk_neglect_cv"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
    <span class="columns">  
        <label class="container" for="risk_neglect_cp">
            Perpetrator
            <input type="checkbox" id="risk_neglect_cp" name="risk_neglect_cp"<?php if ($obj{"risk_neglect_cp"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
	<span class="columns">  
        <label class="container" for="risk_neglect_cb">
            Both
            <input type="checkbox" id="risk_neglect_cb" name="risk_neglect_cb"<?php if ($obj{"risk_neglect_cb"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
	<span class="columns">  
        <label class="container" for="risk_neglect_cn">
            Neither, but abuse exists in family
            <input type="checkbox" id="risk_neglect_cn" name="risk_neglect_cn"<?php if ($obj{"risk_neglect_cn"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
    </fieldset>
<br>
    <fieldset>
        <legend>If risk exists:</legend>
        <b>client</b>
    <span class="columns">  
        <label class="container" for="risk_exists_c">
            can
            <input type="checkbox" id="risk_exists_c" name="risk_exists_c"<?php if ($obj{"risk_exists_c"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
    <span class="columns">  
        <label class="container" for="risk_exists_cn">
            cannot
            <input type="checkbox" id="risk_exists_cn" name="risk_exists_cn"<?php if ($obj{"risk_exists_cn"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
	   <b>meaningfully agree to a contract not to harm</b>
    <span class="columns">  
        <label class="container" for="risk_exists_s">
            self
            <input type="checkbox" id="risk_exists_s" name="risk_exists_s"<?php if ($obj{"risk_exists_s"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
	<span class="columns">  
        <label class="container" for="risk_exists_o">
            others
            <input type="checkbox" id="risk_exists_o" name="risk_exists_o"<?php if ($obj{"risk_exists_o"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
	<span class="columns"> 
        <label class="container" for="risk_exists_b">
            both
            <input type="checkbox" id="risk_exists_b" name="risk_exists_b"<?php if ($obj{"risk_exists_b"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
    </fieldset>
	
        <b>Risk to community (criminal):</b><br>
    <textarea cols=100 rows=3 wrap=virtual name="risk_community" ><?php echo stripslashes($obj{"risk_community"});?></textarea>
<br>
	   <b>Patient Desired Services and Goals:</b>
<br>
    <textarea cols=100 wrap=virtual name="desired_services" style="height: 118px" ><?php echo stripslashes($obj{"desired_services"});?></textarea>
<br>
<br>
    </fieldset>
    <fieldset>
        <legend id="Treatment">Clinical Treatment Recommendations:</legend>
        <b>Outpatient Psychotherapy:</b>
<br>
    <span class="columns">  
        <label class="container" for="recommendations_psy_p">
            Psychiatric/Medication Treatment
            <input type="checkbox" id="recommendations_psy_p" name="recommendations_psy_p"<?php if ($obj{"recommendations_psy_p"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
	<span class="columns"> 
        <label class="container" for="recommendations_psy_i">
            Individual/Family Therapy
            <input type="checkbox" id="recommendations_psy_i" name="recommendations_psy_i"<?php if ($obj{"recommendations_psy_i"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
	<span class="columns">  
        <label class="container" for="recommendations_psy_tboss">
            Therapeutic Behavioral On-site Services(TBOSS)
            <input type="checkbox" id="recommendations_psy_tboss" name="recommendations_psy_tboss"<?php if ($obj{"recommendations_psy_tboss"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
	<span class="columns">  
        <label class="container" for="recommendations_psy_d">
            Intensive Outpatient Treatmenr (Day Treatment, PSR)
            <input type="checkbox" id="recommendations_psy_d" name="recommendations_psy_d"<?php if ($obj{"recommendations_psy_d"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
	<span class="columns"> 
        <label class="container" for="recommendations_psy_o">
            Other
            <input type="checkbox" id="recommendations_psy_o" name="recommendations_psy_o"<?php if ($obj{"recommendations_psy_o"} == "on") {echo "checked";};?> class ="choice">
    <span class="checkmark" ></span>
        </label>
    </span>
    <textarea cols=100 rows=3 wrap=virtual name="recommendations_psy_notes" ><?php echo stripslashes($obj{"recommendations_psy_notes"});?></textarea>
<br>
	
	<b>Date report sent to referral source:</b>
        <input class="input-css" type='text' size='10' name='refer_date' id='refer_date'
        value="<?php echo stripslashes($obj{"refer_date"});?>"
        title='<?php xl('yyyy-mm-dd','e'); ?>'
        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc)' />
	<!--<input type="text" name='refer_date' value="<?php echo stripslashes($obj{"refer_date"});?>">-->
	<b>Parent/Guardian:</b>
        <input class="input-css" type='text' size='10' name='parent' id='parent'
        value="<?php echo stripslashes($obj{"parent"});?>"
        title='<?php xl('yyyy-mm-dd','e'); ?>'
        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc)' />
   <!-- <input type="text" name='parent' value="<?php echo stripslashes($obj{"parent"});?>">
	<span class="style1"><em>YYYY-MM-DD</em></span><br>-->

<br>
    </fieldset>
    <fieldset>
        <legend id="Ref">Referrals for Continuing Services</legend>
<br>
<br>
    <b>Psychiatric Evaluation Psychotropic Medications:</b>
<br>
	<textarea cols=100 rows=2 wrap=virtual name="referrals_pepm" >
        <?php echo stripslashes($obj{"referrals_pepm"});?>
    </textarea>
<br>
<br>

    <b>Medical Care:</b>
<br>
	<textarea cols=100 rows=2 wrap=virtual name="referrals_mc" ><?php echo stripslashes($obj{"referrals_mc"});?></textarea>
<br>
<br>
	
    <b>Educational/vocational services:</b>
<br>
	<textarea cols=100 rows=2 wrap=virtual name="referrals_vt" ><?php echo stripslashes($obj{"referrals_vt"});?></textarea>
<br>
<br>
	
    <b>Other:</b>
<br>
	<textarea cols=100 rows=2 wrap=virtual name="referrals_o" ><?php echo stripslashes($obj{"referrals_o"});?></textarea>
<br>
<br>

    <b>Current use of resources/services from other community agencies:</b>
<br>
	<textarea cols=100 rows=2 wrap=virtual name="referrals_cu" ><?php echo stripslashes($obj{"referrals_cu"});?></textarea>
<br>
<br>
	
    <b>Documents to be obtainded (Release of Information Required):</b>
<br>
	<textarea cols=100 rows=2 wrap=virtual name="referrals_docs" ><?php echo stripslashes($obj{"referrals_docs"});?></textarea>
<br>
<br>
	
    <b>Other needed resources and services:</b>
<br>
	<textarea cols=100 rows=2 wrap=virtual name="referrals_or" ><?php echo stripslashes($obj{"referrals_or"});?></textarea>
<br>
<br>
    </fieldset>
    
<?php /* From New */ ?>

<div id="signature">
	<?php
	include ("signature.php");
	?>
</div>


<?php /* From New */ ?>

	<strong>Status:</strong>
		
	<select class = "select-css" name="status" id="status" >
		<option selected=""><?php echo stripslashes($obj{"status"});?></option>
		<option value="Ready for Billing/Supervisor">Ready for Billing/Supervisor</option>
		<option value="Void/Delete Request">Void/Delete Request</option>
	</select>
        <em>
            <span class="style3">
                Select the status of this document. It will not be billed until signed and the status is 'Ready for Billing'
            </span>
        </em>
	
<br>
	
    <INPUT TYPE=HIDDEN NAME="bioSigData">
    <INPUT TYPE=HIDDEN NAME="bioSigData1">
    <INPUT TYPE=HIDDEN NAME="sigStringData" id="sigStringData" value="">
    <INPUT TYPE=HIDDEN NAME="sigStringData3" id="sigStringData1" value="<?php echo  stripslashes($obj{"supervisor_signature"});?>">
    <INPUT TYPE=HIDDEN NAME="sigString">
    <INPUT TYPE=HIDDEN NAME="sigImageData">

<br>
    <div class = "button">
    <button class="btn btn-success" type='submit'><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Save</button>
    <a class="btn btn-primary" role='button' href="<?php echo "$web_root";?>/interface/forms/assessment_cmh/print.php<?php echo "$formid";?>" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</a>
    <input class="dontsave btn btn-danger" type="button" value="<?php xl('Don\'t Save Change','e'); ?>"> &nbsp; 
</div>
</form>
<script language="javascript">
/* required for popup calendar */
Calendar.setup({inputField:"provider_signature_date", ifFormat:"%Y-%m-%d", button:"img_provider_signature_date"});
Calendar.setup({inputField:"supervisor_signature_date", ifFormat:"%Y-%m-%d", button:"img_supervisor_signature_date"});
// jQuery stuff to make the page a little easier to use
$(document).ready(function(){
   $(".save").click(function() { top.restoreSession(); document.SigForm.submit(); });
    $(".dontsave").click(function() { location.href='<?php echo $GLOBALS['form_exit_url']; ?>'; });
    $(".printform").click(function() { PrintForm(); });
// disable the Print ability if the form has changed
    // this forces the user to save their changes prior to printing
    $("#img_date_of_signature").click(function() { $(".printform").attr("disabled","disabled"); });
    $("input").keydown(function() { $(".printform").attr("disabled","disabled"); });
    $("select").change(function() { $(".printform").attr("disabled","disabled"); });
    $("textarea").keydown(function() { $(".printform").attr("disabled","disabled"); });
});
</script>

<?php
formFooter();
?>