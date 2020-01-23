<?php
include_once("../../globals.php");
include_once("$srcdir/api.inc");
require_once("$srcdir/patient.inc");
require_once("$srcdir/options.inc.php");
require_once("$srcdir/cpt_diag.php");//openremr/library/cpt_diag.php
?>
<html>
<head>
<?php html_header_show();?>
<!--
<link rel=stylesheet href="<?php echo $css_header;?>" type="text/css">
<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/interface/themes/style-form.css" type="text/css">
-->

<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-3.3.7/css/bootstrap.min.css" type="text/css">
<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/interface/themes/theme.css" type="text/css">

<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/library/js/toast/jquery.toast.min.css" type="text/css">
<!-- supporting javascript code -->
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/textformat.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-2.0.2.min.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-sidebar.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/fancybox-2.1.5/jquery.fancybox.pack.js"></script>
<link rel="stylesheet" type="text/css" href="/openemr/library/js/fancybox-2.1.5/jquery.fancybox.css" media="screen" />

<script type="text/javascript" src="au.js"></script>
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
// work on fixing the scrolling of the nav bar
var element = document.getElementById("home Complt DSM Plan Sign");

element.scrollIntoView({behavior: "smooth", inline: "nearest"});

</script>
    
<!-- AUTO SAVE -->
<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<script>
	var AUTOSAVE = true;
	var INTERVAL = '<?php echo $auto_save_timer; ?>';
	var FORM_SELECTOR = 'form';
</script>
<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/library/js/toast/jquery.toast.min.css" type="text/css">
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/toast/jquery.toast.min.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/auto-save.js"></script>
<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

</head>

<body <?php echo $top_bg_line;?> topmargin=0 rightmargin=0 leftmargin=2 bottommargin=0 marginwidth=2 marginheight=0>
<?php
//include_once("$srcdir/api.inc");
//$obj = formFetch("form_med_management", $_GET["id"]);
$formid = 0 + (isset($_GET['id']) ? $_GET['id'] : '');
$obj = $formid ? formFetch("form_med_management", $formid) : array();
?>
    
<div class="topnav">
  <a href="#home">Med Management</a>
  <a href="#Complt">Complaints</a>
  <a href="#DSM">DSM Diagnosis</a>
  <a href="#Plan">Plan</a>
  <a href="#Sign">Signature</a>
  <a href="javascript:top.restoreSession();document.my_form.submit();" class="link_submit">Save</a>
  <a href="<?php echo $GLOBALS['form_exit_url']; ?>"    
     class="link" onclick="top.restoreSession()">Don't Save</a>
  <a href="<?php echo "$web_root";?>/interface/forms/med_management/print.php?id=<?php echo "$formid";?>" target="_blank">Print</a>
</div>
    
<form method=post action="<?php echo $rootdir?>/forms/med_management/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="my_form">
 
<!--<h>Med Management</h>
    <br><br>
<div class = "button">
    <button class="btn btn-success" type='submit'><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Save</button>
    <a class="btn btn-primary" role='button' href="<?php echo "$web_root";?>/interface/forms/med_management/print.php<?php echo "$formid";?>" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</a>
    <input type="button" class="dontsave btn btn-danger" value="<?php xl('Don\'t Save Change','e'); ?>"> &nbsp; 
</div>
 -->
    
    <br><br>
<?php $res = sqlStatement("SELECT fname,mname,lname,ss,street,city,state,postal_code,phone_home,DOB FROM patient_data WHERE pid = $pid");
$result = SqlFetchArray($res); 
$provider_results = sqlQuery("select fname, mname, lname from users where username='" . $_SESSION{"authUser"} . "'");
$dos = sqlQuery("select date from form_encounter where encounter=$encounter");
$dos_pol = substr($dos["date"], 0, 10);
$client_insurance = getInsurancePnDataByDate($pid, $dos_pol, "primary", "provider", "subscriber_country", policy_number);
$insurance_type = sqlQuery("SELECT id, name, billing_code_type FROM insurance_companies WHERE id = '$client_insurance[provider]'");

?>


    
<!--
<center>
	<a href="javascript:top.restoreSession();document.my_form.submit();" class="link_submit">[Save]</a>
	<img src="../../../images/space.gif" width="5" height="1">
	<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" onclick="top.restoreSession()">[Don't Save]</a>
</center>
-->
    
<?php //$res = sqlStatement("SELECT fname,mname,lname,ss,street,city,state,postal_code,phone_home,DOB FROM patient_data WHERE pid = $pid");
//$result = SqlFetchArray($res); 
//$provider_results = sqlQuery("select fname, mname, lname from users where username='" . $_SESSION{"authUser"} . "'");
?>
    
<fieldset id="home">
    
<b>Name:</b>&nbsp; <?php echo $result['fname'] . '&nbsp' . $result['mname'] . '&nbsp;' . $result['lname'];?>

<br>

<b>Address:</b>&nbsp; <?php echo $result['street'] . ',&nbsp' . $result['city']  . ',&nbsp' . $result['state'] . '&nbsp;' . $result['postal_code'];?><br><br>
<b>Telephone Number:</b>&nbsp; <?php echo $result['phone_home'];?><br><br>
<b>Date of Birth:</b>&nbsp;<?php echo $result['DOB'];?><br><br>
<label><b>Time In:</b>&nbsp;<input class="input-css" type="time" name="timestart" min= "0:00" max= "24:00" value="<?php echo stripslashes($obj{"timestart"});?>"></label><img src="../../../images/space.gif" width="65" height="1">
<label><b>Time Out:</b>&nbsp;<input class="input-css" type="time" name="timeend" min="0:00" max= "24:00" value="<?php echo stripslashes($obj{"timeend"});?>"></label><img src="../../../images/space.gif" width="65" height="1">

<br>
<br>
    
    <tr>
		<td align="left" style="width: 166px"><strong>Editor/Transcriber:</strong></td><img src="../../../images/space.gif" width="27" height="1">
		<td style="width: 10%">

<input class="input-css" type="text" name="provider" id="provider" value="<?php echo $provider_results["fname"].' '.$provider_results["mname"].' '.$provider_results["lname"]; ?>" style="width: 185px" readonly="readonly" >
</td><br><br>
<td align="left"><strong>Performing Physician/Nurse Practitioner::</strong></td>
		<td width="90%">
			<select class="select-css" name="physician" style = "width:200px">
			<option selected=""><?php echo stripslashes($obj{"physician"});?></option>
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
			<option selected=""><?php echo stripslashes($obj{"servicecode"});?></option>
			<option value="T1015">T1015 Med Management(FL Medicaid)</option>
			<option value="90862">90862 Med Management(FL Medicare)</option>
			</select><em><span class="style3">(T1015 or 90862)</span></em></td>
<br>
<p>
<?php
$mysqli = new mysqli($host,$login,$pass,$dbase);
		if ($insurance_type["billing_code_type"] == 'CPT')
				{
				$valid_diag = $cpt_diag;
				}else{
				$valid_diag = $hcpcs_diag;
				}
				$query = "SELECT pid, title, diagnosis, type, enddate FROM lists where pid = $pid AND diagnosis IN ($valid_diag);";
		$result = $mysqli -> query($query);
			$dropdown1 .= "<select id='diagnosis1' class = 'select-css' name='diagnosis1' required ><option selected=''>". stripslashes($obj{"diagnosis1"}). "</option>";
			$dropdown2 .= "<select name='diagnosis2' class = 'select-css'><option selected=''>". stripslashes($obj{"diagnosis2"}). "</option>";
			$dropdown3 .= "<select name='diagnosis3' class = 'select-css'><option selected=''>". stripslashes($obj{"diagnosis3"}). "</option>";
			$dropdown4 .= "<select name='diagnosis4' class = 'select-css'><option selected=''>". stripslashes($obj{"diagnosis4"}). "</option>";
		while($row = mysqli_fetch_array($result)) {
			$dropdown1 .= "\r\n<option value='{$row['diagnosis']}". "  "."{$row['title']}'>{$row['diagnosis']}". "  "."{$row['title']}</option>";
			$dropdown2 .= "\r\n<option value='{$row['diagnosis']}". "  "."{$row['title']}'>{$row['diagnosis']}". "  "."{$row['title']}</option>";
			$dropdown3 .= "\r\n<option value='{$row['diagnosis']}". "  "."{$row['title']}'>{$row['diagnosis']}". "  "."{$row['title']}</option>";
			$dropdown4 .= "\r\n<option value='{$row['diagnosis']}". "  "."{$row['title']}'>{$row['diagnosis']}". "  "."{$row['title']}</option>";
		}
			$dropdown1 .= "\r\n</select>";
			$dropdown2 .= "\r\n</select>";
			$dropdown3 .= "\r\n</select>";
			$dropdown4 .= "\r\n</select>";
			echo  "<dl class='dl-horizontal'><dt>Diagnosis 1:</dt><dd>",$dropdown1, "<b>*Choose at least one.</b></dd>" ;?>
								<p>
								<?php echo "<dt>Diagnosis 2:</dt><dd>", $dropdown2, " Can't duplicate Diagnosis 1</dd>" ;?>
								<p>
								<?php echo "<dt>Diagnosis 3:</dt><dd>", $dropdown3, "</dd>" ;?>
								<p>
								<?php echo "<dt>Diagnosis 4:</dt><dd>", $dropdown4, "</dd></dl></div>" ;?>
		
    </fieldset>
    <fieldset>
<br><b id="Complt">Patient has the following complaints(If no complaints, type none):</b><br>
	<textarea cols="100" name="complaint" wrap="virtual" style="height: 124px"><?php echo stripslashes($obj{"complaint"});?></textarea><br><br>
  
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
<textarea cols=100 rows=5 wrap=virtual name="mood" ><?php echo stripslashes($obj{"mood"});?></textarea><br><br>

<b>Affect:</b><br>
<textarea cols=100 rows=5 wrap=virtual name="affect" ><?php echo stripslashes($obj{"affect"});?></textarea><br><br>
    </fieldset>  
<fieldset>
    <legend><b id="DSM">DSM Diagnoses</b></legend>
<b>Axis I:</b><br>
<textarea cols=100 rows=5 wrap=virtual name="axis1" ><?php echo stripslashes($obj{"axis1"});?></textarea><br><br>
    </fieldset>



<fieldset>
    <legend><b id="Plan">Plan:</b></legend>
    <b><br><br>Psychotropic Medication:</b><br>
<textarea cols=100 rows=5 wrap=virtual name="psychotropic_med" ><?php echo stripslashes($obj{"psychotropic_med"});?></textarea><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
	Side Effects Explained(when applicable)<b>: <select class="select-css" name="side_effect_explained">
	<option selected=""><?php echo stripslashes($obj{"side_effect_explained"});?></option>
	<option>YES</option>
	<option>NO</option>
	</select><br></b><br> 	

<b><br><br><br>Labs ordered/Results(if applicable):</b><br>
<textarea cols=100 rows=5 wrap=virtual name="labs_ordered" ><?php echo stripslashes($obj{"labs_ordered"});?></textarea><br><br>
    </fieldset>
<fieldset>
    <label><b>Return to clinic in:</b></label>
<input class="input-css" "return_to_clinic" value = "<?php echo stripslashes($obj{"return_to_clinic"});?>" type="number" min = "0">
<select class="select-css" name="time_frame">
	<option selected=""><?php echo stripslashes($obj{"time_frame"});?></option>
    <option>Day(s)</option>
	<option>Week(s)</option>
	<option>Month(s)</option>
	</select><b></b><br>

<b>Other:</b><br>
<textarea cols=100 rows=5 wrap=virtual name="other" ><?php echo stripslashes($obj{"other"});?></textarea><br><br>
    
    </fieldset>
	<br>

<br>

    
<tr>
<td align="left" style="width: 166px"></td>
		<td width="90%">

	<br>
    </td>
            <label id="Sign"> Signature:</label><input class="input-css" type="text" name="signature" value="<?php echo stripslashes($obj{"signature"});?>">
            
            
            <label>Credentials:</label><input class="input-css" type="text" name="credentials"value="<?php echo stripslashes($obj{"credentials"});?>">
	   	
	
            <label>Signature Date:</label>
   <input class="input-css" type='text' size='10' name='sig_date' id='sig_date'
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

$(document).ready(function(){
   $(".save").click(function() { top.restoreSession(); document.my_form.submit(); });
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
