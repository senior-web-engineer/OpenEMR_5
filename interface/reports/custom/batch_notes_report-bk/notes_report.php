<?php

include_once("../../globals.php");
//include_once("$srcdir/api.inc");
//formHeader("Form: psychosocial");
?>




<BODY>

<!-- supporting javascript code -->
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/textformat.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery.timeentry.package-1.4.9/jquery.timeentry.js"></script>



<script language="JavaScript">
function ActionDeterminator() {
  if(document.myform.reason[0].selected == true) {
    document.myform.action = 'form_soap_pirc_batch.php';
  }
  if(document.myform.reason[1].selected == true) {
    document.myform.action = 'form_soap_pirc_batch.php';
    //document.myform.method = 'get';
  }
  if(document.myform.reason[2].selected == true) {
    document.myform.action = 'form_group_pirc_batch.php';
    }
  if(document.myform.reason[3].selected == true) {
    document.myform.action = 'form_psychosocial_batch.php';

  }
  return true;
}
</script>

<FORM NAME="myform" ACTION="form_soap_pirc_batch.php" METHOD=POST TARGET="_blank">




<br><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </b><br>

<br>Enter DOS Start Date:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<INPUT TYPE=TEXT SIZE=117 NAME=start_date VALUE="2013-06-01" style="width: 84px">&nbsp;&nbsp; Enter DOS End Date:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<INPUT TYPE=TEXT SIZE=117 NAME=end_date VALUE="2013-06-25" style="width: 75px"> <br>
	Enter Patient ID:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<INPUT TYPE=TEXT SIZE=117 NAME=patientid style="width: 75px"> <br>

<br><br><br><br>
<select name="reason">
        <option value="lite">Select Form</option>
        <option value="form_soap_pirc_batch.php">SAOP Notes</option>
        <option value="form_group_pirc_batch.php">Group Notes</option>
        <option value="form_psychosocial_batch.php">PSR Notes</option>
        
       
    </select>



<!--<input id="SignBtn" name="SignBtn" type="submit" value="Submit"  ><br><br>-->


<input
   type="submit"
   value="Run Report"
   onClick="return ActionDeterminator();">

  
 
</FORM>

