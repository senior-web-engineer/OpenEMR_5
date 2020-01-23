<?php
include_once("../../globals.php");
include_once("$srcdir/api.inc");
formHeader("Form: med_management");
?>
<html>
<head>
<?php html_header_show();?>
<link rel=stylesheet href="<?php echo $css_header;?>" type="text/css">
<!--<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/interface/themes/style-form.css" type="text/css">-->    
<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-3.3.7/css/bootstrap.min.css" type="text/css">
<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/interface/themes/theme.css" type="text/css">
<!-- supporting javascript code -->
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/textformat.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-2.0.2.min.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-sidebar.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/fancybox-2.1.5/jquery.fancybox.pack.js"></script>
<link rel="stylesheet" type="text/css" href="/openemr/library/js/fancybox-2.1.5/jquery.fancybox.css" media="screen" />
<!-- pop up calendar -->
<style type="text/css">@import url(<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.css);</style>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.js"></script>
<?php include_once("{$GLOBALS['srcdir']}/dynarch_calendar_en.inc.php"); ?>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar_setup.js"></script>

<script language="JavaScript">
// required for textbox date verification
var mypcc = '<?php echo $GLOBALS['phone_country_code'] ?>';

function PrintForm() {
    newwin = window.open("<?php echo $rootdir."/forms/med_management/print.php?id=".$_GET["id"]; ?>","mywin");
}

</script>
</head>

<body <?php echo $top_bg_line;?> topmargin=0 rightmargin=0 leftmargin=2 bottommargin=0 marginwidth=2 marginheight=0>

<div class="topnav">
  <a href="#home">Med Management</a>
  <a href="#Complt">Complaints</a>
  <a href="#DSM">DSM Diagnosis</a>
  <a href="#Plan">Plan</a>
  <a href="#Sign">Signature</a>
  <a href="javascript:top.restoreSession();document.my_form.submit();" class="link_submit">Save</a>
  <a href="<?php echo $GLOBALS['form_exit_url']; ?>"    
     class="link" onclick="top.restoreSession()">Don't Save</a>
  <a href="<?php echo "$web_root";?>/interface/forms/med_management/print.php<?php echo "$formid";?>" target="_blank">Print</a>
</div>

<form method=post action="<?php echo $rootdir;?>/forms/med_management/save.php?mode=new" name="my_form">

    <br>
    <br>
<center>
	<a href="javascript:top.restoreSession();document.my_form.submit();" class="link_submit">[Save]</a>
	<img src="../../../images/space.gif" width="5" height="1">
	<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" onclick="top.restoreSession()">[Don't Save]</a>
</center>
<br>

<?php $res = sqlStatement("SELECT fname,mname,lname,ss,street,city,state,postal_code,phone_home,DOB FROM patient_data WHERE pid = $pid");
$result = SqlFetchArray($res); 
$provider_results = sqlQuery("select fname, mname, lname from users where username='" . $_SESSION{"authUser"} . "'");
?>
    
<fieldset id="home">
<b>Name:</b>&nbsp; <?php echo $result['fname'] . '&nbsp' . $result['mname'] . '&nbsp;' . $result['lname'];?> 
<img src="../../../images/space.gif" width="572" height="1">
<!-- 
<b>Date:</b>&nbsp; <?php print date('m/d/y'); ?><br><br>
-->
&nbsp;<?php echo $result['ss'];?><img src="../../../images/space.gif" width="172" height="1"> 
<br>

<b>Address:</b>&nbsp; <?php echo $result['street'] . ',&nbsp' . $result['city']  . ',&nbsp' . $result['state'] . '&nbsp;' . $result['postal_code'];?><br><br>
<b>Telephone Number:</b>&nbsp; <?php echo $result['phone_home'];?><br><br>
<b>Date of Birth:</b>&nbsp;<?php echo $result['DOB'];?><br><br>
<label><b>Time In:</b>&nbsp;<input type="time" name="timestart" min= "0:00" max= "24:00" value="<?php echo stripslashes($obj{"timestart"});?>"></label><img src="../../../images/space.gif" width="65" height="1">
<label><b>Time Out:</b>&nbsp;<input type="time" name="timeend" min="0:00" max= "24:00" value="<?php echo stripslashes($obj{"timeend"});?>"></label><img src="../../../images/space.gif" width="65" height="1">

<br>
<br>
<tr>
		<td align="left" style="width: 166px"><strong>Editor/Transcriber:</strong></td><img src="../../../images/space.gif" width="27" height="1">
		<td style="width: 10%">

<input type="text" name="provider" id="provider" value="<?php echo $provider_results["fname"].' '.$provider_results["mname"].' '.$provider_results["lname"]; ?>" style="width: 185px" readonly="readonly" >
</td><br><br>
<td align="left"><strong>Performing Physician/Nurse Practitioner:</strong></td>
		<td width="90%">
			<select class="select-css" name="physician" style="width:200px">
			<option selected=""></option>
			<option value="Fred Jean">Fred Jean</option>
			<option value="Jean-Rony Jean-Mary">Jean-Rony Jean-Mary</option>
			<option value="Serge Celestin">Serge Celestin</option>
			</select><em><span class="style3"></span></em></td>
<br>


	</tr>

<br>
<td align="left"><strong>Service Code:</strong></td>
		<td width="90%">
			<select class="select-css" name="servicecode">
			<option selected="">T1015</option>
			<option value="T1015">T1015 Med Management(FL Medicaid)</option>
			<option value="90862">90862 Med Management(FL Medicare)</option>
			</select><em><span class="style3">(T1015 or 90862)</span></em></td>
<br>
    </fieldset>
    <fieldset id="Complt">
<br><b>Patient has the following complaints(If no complaints, type none):<span id="wordCount"></span></b><br>
	<textarea id="toCount" cols="100" name="complaint" wrap="virtual" style="height: 124px"></textarea><br><br>

        <table>
            <tr>
            <td> 
            <label>ETOH Abuse:</label> 
                </td>
                <td>
                   <select class="select-css" name="etoh" >
                   <option selected="NULL"><?php echo stripslashes($obj{"etoh"});?></option>
                   <option>Present</option>
	               <option>Absent</option>
	               </select>
            </td>
            <td>
            <label>Drug Abuse:</label>
                </td>
                <td>
                   <select class="select-css" name="drug_abuse">
	               <option selected="NULL"><?php echo stripslashes($obj{"drug_abuse"});?></option>
	               <option>Present</option>
	               <option>Absent</option>
	               </select>
            </td>
            <td>
            <label>Abnormal Movements:</label>
            </td>
                <td>
                    <select class="select-css" name="ab_movements">
                    <option selected="NULL"><?php echo stripslashes($obj{"ab_movements"});?></option>
                    <option>Present</option>
                    <option>Absent</option>
                    </select> 
            </td>
            </tr>
            <tr>
            <td>
            <label> Memory:</label>
                </td>
                <td>
                <select class="select-css" name="memory">
                <option selected="NULL"><?php echo stripslashes($obj{"memory"});?></option>
                <option>Forgetful</option>
                <option>Intact</option>
                </select>
            </td>
            <td>
            <label>A/V Hallucinations:</label>
                </td>
                <td>
                <select class="select-css" name="hallucinations">
                <option selected="NULL"><?php echo stripslashes($obj{"hallucinations"});?></option>
                <option>Present</option>
                <option>Absent</option>
                </select>
            </td>
            <td>
            <label>S/H Ideation:</label>
                </td>
                <td>
                <select class="select-css" name="sh_ideation">
                <option selected="NULL"><?php echo stripslashes($obj{"sh_ideation"});?></option>
                <option>Present</option>
                <option>Absent</option>
                </select>
            </td>
            </tr>
            <tr>
            <td>
            <label>Paranoid Ideation:</label>
                </td>
                <td>
                <select class="select-css" name="paranoid">
                <option selected="NULL"><?php echo stripslashes($obj{"paranoid"});?></option>
                <option>Present</option>
                <option>Absent</option>
                </select>
            </td>
            </tr>    
        </table>
        <!--
<ul class="blank">
    <li class="section_break">
    <div>
        <span class="columns">
    <label>ETOH Abuse:</label> 
   <select class="select-css" name="etoh" >
	<option selected="NULL"><?php echo stripslashes($obj{"etoh"});?></option>
	<option>Present</option>
	<option>Absent</option>
	</select>
    </span>
        
        <span class="columns">
    <label>Drug Abuse:</label>
    <select class="select-css" name="drug_abuse">
	<option selected="NULL"><?php echo stripslashes($obj{"drug_abuse"});?></option>
	<option>Present</option>
	<option>Absent</option>
	</select>
    </span>
        <span class="columns">
    <label>Abnormal Movements:</label>
	<select class="select-css" name="ab_movements">
	<option selected="NULL"><?php echo stripslashes($obj{"ab_movements"});?></option>
	<option>Present</option>
	<option>Absent</option>
	</select>
    </span>
        <span class = "columns">
    <label> Memory:</label>
    <select class="select-css" name="memory">
	<option selected="NULL"><?php echo stripslashes($obj{"memory"});?></option>
	<option>Forgetful</option>
	<option>Intact</option>
	</select>
    </span>
        <span class="columns">
    <label>A/V Hallucinations:</label>
    <select class="select-css" name="hallucinations">
	<option selected="NULL"><?php echo stripslashes($obj{"hallucinations"});?></option>
	<option>Present</option>
	<option>Absent</option>
	</select>
    </span>
        <span class="columns">
    <label>S/H Ideation:</label>
    <select class="select-css" name="sh_ideation">
	<option selected="NULL"><?php echo stripslashes($obj{"sh_ideation"});?></option>
	<option>Present</option>
	<option>Absent</option>
	</select>
    </span>
        <span class="columns">
    <label>Paranoid Ideation:</label>
    <select class="select-css" name="paranoid">
	<option selected="NULL"><?php echo stripslashes($obj{"paranoid"});?></option>
	<option>Present</option>
	<option>Absent</option>
	</select>
        </span>
    </div>
    </li>
        </ul>

-->

<b>Mood:</b><br>
<textarea cols=100 rows=5 wrap=virtual name="mood" ></textarea><br><br>

<b>Affect:</b><br>
<textarea cols=100 rows=5 wrap=virtual name="affect" ></textarea><br><br>
    </fieldset>
<fieldset id="DSM">
        <legend>DSM Diagnoses</legend>
<b>Axis I:</b><br>
<textarea cols=100 rows=3 wrap=virtual name="axis1" ></textarea><br><br>
    </fieldset>
        <fieldset id="Plan">
            <legend>Plan:</legend>
            <br>Psychotropic Medication:<br>
<textarea cols=100 rows=5 wrap=virtual name="psychotropic_med" ></textarea><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
	Side Effects Explained(when applicable)<b>: <select class="select-css" name="side_effect_explained">
	<option selected="NULL"></option>
	<option>YES</option>
	<option>NO</option>
	</select><br></b><br> 	

<b><br><br><br>Labs ordered/Results(if applicable):</b><br>
<textarea cols=100 rows=5 wrap=virtual name="labs_ordered" ></textarea><br><br>
<fieldset>
<b>Return to clinic in:</b>
<input name="return_to_clinic" type="number" min = "0" style="width: 52px"><select class="select-css" name="time_frame">
	<option selected="NULL"></option>
    <option>Day(s)</option>
	<option>Week(s)</option>
	<option>Month(s)</option>
	</select><br><br>
    
<b>Other:</b><br>
<textarea cols=100 rows=5 wrap=virtual name="other" ></textarea>
    <br><br>
    </fieldset>
	</fieldset>
	<br>

<br>


<tr>
<td align="left" style="width: 166px"></td>
		<td width="90%">

	
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Signature:&nbsp<input id="Sign" type="text" name="signature" value="<?php echo stripslashes($obj{"signature"});?>" style="width: 162px">
Credentials:&nbsp;<input type="text" name="credentials"value="<?php echo stripslashes($obj{"credentials"});?>" style="width: 99px">
&nbsp; 
	   	
	
	
	Signature Date:
   <input type='text' size='10' name='sig_date' id='sig_date'
    value="<?php echo stripslashes($obj{"sig_date"});?>"
    title='<?php xl('yyyy-mm-dd','e'); ?>'
    onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc)' />
   <img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22'
    id='img_sig_date' border='0' alt='[?]' style='cursor:pointer;cursor:hand'
    title='<?php xl('Click here to choose a date','e'); ?>'>

<?php /* From New */ ?>

	

<tr>
<td align="left"></td>
		<td width="90%">
<br>
	
	
	</td>
	






<center><a href="javascript:top.restoreSession();document.my_form.submit();" class="link_submit">[Save]</a>
<img src="../../../images/space.gif" width="5" height="1">
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link"
 onclick="top.restoreSession()">[Don't Save]</a></center>
<br>
</form>

<script language="javascript">
/* required for popup calendar */
Calendar.setup({inputField:"sig_date", ifFormat:"%Y-%m-%d", button:"img_sig_date"});
// jQuery stuff to make the page a little easier to use
</script>





<?php
formFooter();
?>
