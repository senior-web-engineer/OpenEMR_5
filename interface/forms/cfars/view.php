<?php
include_once("../../globals.php");
?>
<html>
<head>
<?php html_header_show();?>

<!-- <link rel=stylesheet href="<?php echo $css_header;?>" type="text/css"> -->

<!--
<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/interface/themes/style-form.css" type="text/css">
-->
<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/library/js/bootstrap-3.3.7/css/bootstrap.min.css" type="text/css">
    
<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/interface/themes/theme.css" type="text/css">
<!--    
<link rel="stylesheet" type="text/css" href=".../../forms/cfars/form_11709/css/view.css" media="all" />
<link rel="stylesheet" type="text/css" href="../../forms/cfars/themes/theme_23.css" media="all" />
-->
<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/library/js/toast/jquery.toast.min.css" type="text/css">
    

    
<!-- supporting javascript code -->
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/textformat.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-2.0.2.min.js"></script>

<script type="text/javascript" src="../../forms/cfars/jquery-ui/ui/jquery.effects.core.js"></script>
<script type="text/javascript" src="../../forms/cfars/view.js"></script>
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
    newwin = window.open("<?php echo $rootdir."/forms/cfars/print.php?id=".$_GET["id"]; ?>","mywin");
}
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
<body <?php echo $top_bg_line;?> topmargin=0 rightmargin=0 leftmargin=2 bottommargin=0 marginwidth=2 marginheight=0 id="main_body" class="no_guidelines"> 
<?php
include_once("$srcdir/api.inc");
$obj = formFetch("form_cfars", $_GET["id"]);
$formid = 0 + (isset($_GET['id']) ? $_GET['id'] : '');
?>
 <div class="topnav">
  <a href="#home"><?php echo $obj{"service_name"};?></a>
  <a href="javascript:top.restoreSession();document.my_form.submit();" class="link_submit">Save</a>
  <a href="<?php echo $GLOBALS['form_exit_url']; ?>"    
     class="link" onclick="top.restoreSession()">Don't Save</a>
     
     <!--/forms/fars/print.php?id=".$_GET["id"]; ?>","mywin");-->

  <a href="<?php echo "$web_root";?>/interface/forms/cfars/print.php?id=<?php echo "$formid";?>" target="_blank">Print</a>
</div>
<form method=post action="<?php echo $rootdir?>/forms/cfars/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="my_form">
<?php $res = sqlStatement("SELECT fname,mname,lname,ss,street,city,state,postal_code,phone_home,DOB FROM patient_data WHERE pid = $pid");
$result = SqlFetchArray($res); 
$provider_results = sqlQuery("select fname, mname, lname from users where username='" . $_SESSION{"authUser"} . "'");
$dos = sqlQuery("select date from form_encounter where encounter=$encounter");
?>
    <br>
    <br>
<span id ="home"></span>
<?php
	//$service_name = stripslashes($obj{"service_name"});
    //echo "service_code". $service_code;
    //echo "service_name". $service_name;
    //echo "note_type". $note_type;
    if (stripslashes($obj{"service_name"}) == "CFARS"){
        include_once("cfars.php");
    }
?>
<?php
    if (stripslashes($obj{"service_name"}) == "FARS"){
        include_once("fars.php");
    }
?>
		<br>
		<br>
              <span>Select the status of this document. It will not be billed until signed and the status is 'Ready for Billing'</span>
		<select class = "select-css" name="status" id="status" >
			<option selected=""><?php echo stripslashes($obj{"status"});?></option>
			<option value="Ready for Billing/Supervisor">Ready for Billing/Supervisor</option>
			<option value="Void/Delete Request">Void/Delete Request</option>
		</select>
		
		<br>
		<br>
              <span>Sign Your Name: &nbsp; <input class ="input-css" name="provider_print_name" type="text" value="<?php echo stripslashes($obj{"provider_print_name"});?>" style="width: 226px"/></span>

		<br>
		<div class = "button">
            <button class="btn btn-success" type='submit'><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Save</button>
	       <a class="btn btn-primary" role='button' href="<?php echo "$web_root";?>/interface/forms/cfars/print.php?id=<?php echo "$formid";?>" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</a>
            <input type="button" class="dontsave btn btn-danger" value="<?php xl('Don\'t Save Change','e'); ?>"> &nbsp; 
		</div>
            </ul>


<script language="javascript">
/* required for popup calendar */
//Calendar.setup({inputField:"sig_date", ifFormat:"%Y-%m-%d", button:"img_sig_date"});
//Calendar.setup({inputField:"sup_sig_date", ifFormat:"%Y-%m-%d", button:"img_sup_sig_date"});
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
