<?php

include_once("../../globals.php");
include_once("$srcdir/api.inc");
formHeader("Form: individualized_treatment_plan_cmh");
?>
<html><head>
<?php html_header_show();?>
<link rel=stylesheet href="<?php echo $css_header;?>" type="text/css">
<link rel=stylesheet href="../../themes/style-form.css" type="text/css">
<style type="text/css">
.style1 {
	text-align: center;
}
.style2 {
	font-size: large;
}
</style>

<!-- TEXTIMPORTER CONTROL INCLUDES -->
<script src="<?php echo "$web_root";?>/library/textimporter/jquery-1.11.3.min.js"></script>
<script src="<?php echo "$web_root";?>/library/textimporter/underscore.js"></script>
<script src="<?php echo "$web_root";?>/library/textimporter/jquery-tmpl.js"></script>
<script src="<?php echo "$web_root";?>/library/textimporter/knockout-3.3.0.debug.js"></script>
<script src="<?php echo "$web_root";?>/library/textimporter/koExternalTemplateEngine_all.js"></script>
<script src="<?php echo "$web_root";?>/library/textimporter/textimporter.js"></script>
<link href="<?php echo "$web_root";?>/library/textimporter/textimporter.css" rel="stylesheet"></link>
<!-- TEXTIMPORTER CONTROL INCLUDES -->

</head>
<body <?php echo $top_bg_line;?> topmargin=0 rightmargin=0 leftmargin=2 bottommargin=0 marginwidth=2 marginheight=0>
<form method=post action="<?php echo $rootdir;?>/forms/individualized_treatment_plan_cmh/save.php?mode=new" name="my_form">
	<div class="style1">
<br>
<span class="style2"><strong>Individualized Treatment Plan<br></strong></span><br><br>
	</div>
<center><a href="javascript:top.restoreSession();document.my_form.submit();" class="link_submit">[Save]</a>
<img src="../../../images/space.gif" width="5" height="1">
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link_submit" onclick="top.restoreSession()">[Don't Save]</a></center>
<br>

<?php $res = sqlStatement("SELECT fname,mname,lname,ss,street,city,state,postal_code,phone_home,DOB FROM patient_data WHERE pid = $pid");
$result = SqlFetchArray($res); ?>

<b>Admission Date:</b>&nbsp;<input type="text" name="admit_date"> 
<img src="../../../images/space.gif" width="260" height="1">
<br><br>

<img src="../../../images/space.gif" width="28" height="1">
<b>Client Name:</b>&nbsp; <?php echo $result['fname'] . '&nbsp' . $result['mname'] . '&nbsp;' . $result['lname'];?> 
<img src="../../../images/space.gif" width="292" height="1">&nbsp;
<img src="../../../images/space.gif" width="1" height="1">

<br>

<b>

	<br><u>Diagnoses:</u><br><br>
		Axis I:<br>
<textarea cols=100 wrap=virtual name="axis1" style="height: 28px" ></textarea><br><br>
	Axis II::<br>
<textarea cols=100 wrap=virtual name="axis2" style="height: 26px" ></textarea><br><br>
	Axis III::<br>
<textarea cols=100 wrap=virtual name="axis3" style="height: 25px" ></textarea><br><br>
	<u>Allergies/Adverse reactions to medications:</u>&nbsp;<input type="text" name="allergies"><br><br>
	Axis IV Psychosocial and environmental problems in the last year:<br>
<input type=checkbox name='ax4_prob_support_group'  >&nbsp;Problems with primary support group
<img src="../../../images/space.gif" width="35" height="1">
<input type=checkbox name='ax4_prob_soc_env'  >&nbsp;Problems related to the social environment<br>

<input type=checkbox name='ax4_educational_prob'  >&nbsp;Educational problems
<img src="../../../images/space.gif" width="5" height="1">
<input type=checkbox name='ax4_occ_prob'  >&nbsp;Occupational problems
<img src="../../../images/space.gif" width="5" height="1">
<input type=checkbox name='ax4_housing'  >&nbsp;Housing problems
<img src="../../../images/space.gif" width="5" height="1">
<input type=checkbox name='ax4_economic'  >&nbsp;Economic problems<br>
<input type=checkbox name='ax4_access_hc'  >&nbsp;Problems with access to health care services
<img src="../../../images/space.gif" width="5" height="1">
<input type=checkbox name='ax4_legal'  >&nbsp;Problems related to interaction with the legal system/crime<br>
<input type=checkbox name='ax4_other_cb'  >&nbsp;Other (specify):<br>
<textarea cols=100 wrap=virtual name="ax4_other" style="height: 43px" ></textarea><br><br>
	Axis V Global Assessment of Functioning (GAF) Scale (100 down to 0): <img src="../../../images/space.gif" width="5" height="1"><br>
	Currently: <input type="text" name="ax5_current">
<img src="../../../images/space.gif" width="5" height="1">
Past Year: <input type="text" name="ax5_past"><br><br><br><br>
	
	
	<br><br>Problem #1:<br>
<textarea cols=85 rows=2 wrap=virtual name="problem_1" id="problem_1" ></textarea><br><br>
        <div data-bind="tiControl: {
                            id: 'problem_1',
                            page: 'itp_cmh/new.php',
                            params: {id1: 0}
                            }, tiVM: $data"></div>
<div id="errors" class="errors" ></div>

<b>Goal #1:</b><br>

<textarea cols=85 rows=2 wrap=virtual name="goal_1" id="goal_1" ></textarea><br><br>
        <div data-bind="tiControl: {
                            id: 'goal_1',
                            page: 'itp_cmh/new.php',
                            storeid: ['group1','problem1'] ,
                            appendvalue: true,
                            params: {id1: 0}
                            }, tiVM: $data"></div>
        <input type="text" id="group1" />
        <input type="text" id="problem1" />
	<br><br>

<b>Objectives, Intervention & Skills#1:</b><br>
<textarea cols=85 rows=3 wrap=virtual name="obj_int_skill_1" ></textarea><br><br>

<b>Modality #1:</b><br>
<input type="checkbox" name="mod_ind_1">&nbsp;<b>Individual and / or Family Therapy</b></input>
<img src="../../../images/space.gif" width="6" height="1">
<input type="checkbox" name="mod_sa_1">&nbsp;<b>Substance Abuse</b></input><br>

<input type="checkbox" name="mod_group_1">&nbsp;<b>Group Therapy - psychoeducational group</b></input>
<img src="../../../images/space.gif" width="6" height="1">
<input type="checkbox" name="mod_parenting_1">&nbsp;<b>Parenting</b></input><br><br>

<b>Service Frequency #1:</b><br>
<textarea cols=85 rows=3 wrap=virtual name="frequency_1" ></textarea><br><br>

<b>Discharge Plans #1:</b><br>
<textarea cols=85 rows=3 wrap=virtual name="discharge_plan_1" ></textarea><br><br>


<b>Responsible Staff:</b><br>
<input name="staff_1" style="width: 276px; height: 23px" ><br><br>

****************************************************************************************
<br>Problem #2:<br>
<textarea cols=85 rows=2 wrap=virtual name="problem_2" ></textarea><br><br>

<b>Goal #2:</b><br>
<textarea cols=85 rows=3 wrap=virtual name="goal_2" ></textarea><br><br>

<b>Objectives, Intervention & Skills#2:</b><br>
<textarea cols=85 rows=3 wrap=virtual name="obj_int_skill_2" ></textarea><br><br>

<b>Modality #2:<br>
<input type="checkbox" name="mod_ind_2">&nbsp;<b>Individual and / or Family Therapy</b></input>
<img src="../../../images/space.gif" width="6" height="1">
<input type="checkbox" name="mod_sa_2">&nbsp;<b>Substance Abuse</b></input><br>

<input type="checkbox" name="mod_group_2">&nbsp;<b>Group Therapy - psychoeducational group</b></input>
<img src="../../../images/space.gif" width="6" height="1">
<input type="checkbox" name="mod_parenting_2">&nbsp;<b>Parenting</b></input><br><br>

<b>Service Frequency #2:</b><br>
<textarea cols=85 rows=3 wrap=virtual name="frequency_2" ></textarea><br><br>

<b>Discharge Plans #2:</b><br>
<textarea cols=85 rows=3 wrap=virtual name="discharge_plan_2" ></textarea><br><br>


<b>Responsible Staff:</b><br>
<input name="staff_2" style="width: 276px; height: 23px" ><br><br>

****************************************************************************************
<br>Problem #3:<br>
<textarea cols=85 rows=2 wrap=virtual name="problem_3" ></textarea><br><br>

<b>Goal #3:</b><br>
<textarea cols=85 rows=3 wrap=virtual name="goal_3" ></textarea><br><br>

<b>Objectives, Intervention & Skills#3:</b><br>
<textarea cols=85 rows=3 wrap=virtual name="obj_int_skill_3" ></textarea><br><br>

<b>Modality #3:<br>
<input type="checkbox" name="mod_ind_3">&nbsp;<b>Individual and / or Family Therapy</b></input>
<img src="../../../images/space.gif" width="6" height="1">
<input type="checkbox" name="mod_sa_3">&nbsp;<b>Substance Abuse</b></input><br>

<input type="checkbox" name="mod_group_3">&nbsp;<b>Group Therapy - psychoeducational group</b></input>
<img src="../../../images/space.gif" width="6" height="1">
<input type="checkbox" name="mod_parenting_3">&nbsp;<b>Parenting</b></input><br><br>

<b>Service Frequency #3:</b><br>
<textarea cols=85 rows=3 wrap=virtual name="frequency_3" ></textarea><br><br>

<b>Discharge Plans #3:</b><br>
<textarea cols=85 rows=3 wrap=virtual name="discharge_plan_3" ></textarea><br><br>


<b>Responsible Staff:</b><br>
<input name="staff_3" style="width: 276px; height: 23px" ><br><br>
****************************************************************************************
<br>Problem #4:<br>
<textarea cols=85 rows=2 wrap=virtual name="problem_4" ></textarea><br><br>

<b>Goal #4:</b><br>
<textarea cols=85 rows=3 wrap=virtual name="goal_4" ></textarea><br><br>

<b>Objectives, Intervention & Skills#2:</b><br>
<textarea cols=85 rows=3 wrap=virtual name="obj_int_skill_4" ></textarea><br><br>

<b>Modality #4:<br>
<input type="checkbox" name="mod_ind_4">&nbsp;<b>Individual and / or Family Therapy</b></input>
<img src="../../../images/space.gif" width="6" height="1">
<input type="checkbox" name="mod_sa_4">&nbsp;<b>Substance Abuse</b></input><br>

<input type="checkbox" name="mod_group_4">&nbsp;<b>Group Therapy - psychoeducational group</b></input>
<img src="../../../images/space.gif" width="6" height="1">
<input type="checkbox" name="mod_parenting_4">&nbsp;<b>Parenting</b></input><br><br>

<b>Service Frequency #4:</b><br>
<textarea cols=85 rows=3 wrap=virtual name="frequency_4" ></textarea><br><br>

<b>Discharge Plans #4:</b><br>
<textarea cols=85 rows=3 wrap=virtual name="discharge_plan_4" ></textarea><br><br>


<b>Responsible Staff:</b><br>
<input name="staff_4" style="width: 276px; height: 23px" ><br><br>




	<br><br>

<br>________________________________________________________________________________________<br><br>

	<br><br><br>

	<u>Signature:</u>&nbsp;<input type="text" name="provider_print_name" style="width: 256px"><u>Credentials:</u>&nbsp;<input type="text" name="credentials" style="width: 152px">&nbsp; 
	Date of signature:
   <input type="text" name="sig_date">
<br>
<br>
<td align="left"></td>
		<td width="90%">
	<br>
<br>

		<strong>Status:</strong>
		
			<select name="status" id="status" >
			<option selected="In Progress">In Progress</option>
			<option value="Ready for Billing/Supervisor">Ready for Billing/Supervisor</option>
			
			
			
			</select><em><span class="style3">Select the status of this document. It will not be billed until signed and the status is 'Ready for Billing'</span></em></td>
	<br>





<br>


<br><br>
<center><a href="javascript:top.restoreSession();document.my_form.submit();" class="link_submit">[Save]</a>
<img src="../../../images/space.gif" width="5" height="1">
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link_submit" onclick="top.restoreSession()">[Don't Save]</a></center>
<br>
</form>
<?php
formFooter();
?>
