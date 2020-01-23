<?php
include_once("../../globals.php");
?>
<html>
<head>
<?php html_header_show();?>
<link rel=stylesheet href="<?php echo $css_header;?>" type="text/css">
<link rel=stylesheet href="<?php echo $GLOBALS['webroot'] ?>/interface/themes/style-form-print.css" type="text/css">

<link rel="stylesheet" type="text/css" href=".../../forms/cfars/form_11709/css/view.css" media="all" />
<link rel="stylesheet" type="text/css" href="../../forms/cfars/themes/theme_23.css" media="all" />

<script type="text/javascript" src="../../forms/cfars/jquery.min.js"></script>
<script type="text/javascript" src="../../forms/cfars/jquery-ui/ui/jquery.effects.core.js"></script>
<script type="text/javascript" src="../../forms/cfars/view.js"></script>

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
function PrintForm() {
    newwin = window.open("<?php echo $rootdir."/forms/cfars/print.php?id=".$_GET["id"]; ?>","mywin");
}
$(function() {
    $('input:checkbox').attr('disabled', true);
    $('input:text').attr('disabled', true);
    $('select').attr('disabled', true);
});
</script>
</head>

<body <?php echo $top_bg_line;?> topmargin=0 rightmargin=0 leftmargin=2 bottommargin=0 marginwidth=2 marginheight=0 id="main_body" class="no_guidelines">
<?php
include_once("$srcdir/api.inc");
$obj = formFetch("form_cfars", $_GET["id"]);
?>
<form method=post action="<?php echo $rootdir?>/forms/cfars/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="my_form">

<?php $res = sqlStatement("SELECT fname,mname,lname,ss,street,city,state,postal_code,phone_home,DOB FROM patient_data WHERE pid = $pid");
$result = SqlFetchArray($res); 
$provider_results = sqlQuery("select fname, mname, lname from users where username='" . $_SESSION{"authUser"} . "'");
$dos = sqlQuery("select date from form_encounter where encounter=$encounter");
?>
<?php 
    if (stripslashes($obj{"service_name"}) == "CFARS"){
        include_once("print_cfars.php");
    }
?>
<?php 
     if (stripslashes($obj{"service_name"}) == "FARS"){
        include_once("print_fars.php");
    }
?>


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
