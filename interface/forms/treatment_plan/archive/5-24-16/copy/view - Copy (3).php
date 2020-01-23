<?php
/**
 *
 * Copyright (C) 2012-2013 Naina Mohamed <naina@capminds.com> CapMinds Technologies
 *
 * LICENSE: This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 3
 * of the License, or (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://opensource.org/licenses/gpl-license.php>;.
 *
 * @package OpenEMR
 * @author  Naina Mohamed <naina@capminds.com>
 * @link    http://www.open-emr.org
 */
 
//SANITIZE ALL ESCAPES
 $sanitize_all_escapes=true;

 //STOP FAKE REGISTER GLOBALS
 $fake_register_globals=false;
 
include_once("../../globals.php");
include_once("$srcdir/api.inc");
require_once("$srcdir/patient.inc");
require_once("$srcdir/options.inc.php");
formHeader("Form:Treatment Planning");
$returnurl = $GLOBALS['concurrent_layout'] ? 'encounter_top.php' : 'patient_encounter.php';
$formid = 0 + (isset($_GET['id']) ? $_GET['id'] : '');
$obj = $formid ? formFetch("form_treatment_plan", $formid) : array();



// $query = "SELECT description FROM form_treatment_plan_sub_behavioral_definition WHERE form_id='$id' and pid = '{$GLOBALS['pid']}' " ;
// $result = mysql_query($query) or die(mysql_error());
// $row = mysql_fetch_array($result);
// //while($row = mysql_fetch_assoc($result)) {
//  $description = $row['description'];
//  
//}

//echo $description;
//echo ($obj{"description"});



// Get the providers list.
 $ures = sqlStatement("SELECT id, username, fname, lname FROM users WHERE " .
  "authorized != 0 AND active = 1 ORDER BY lname, fname");
?>
<html><head>
<?php html_header_show();?>
<script type="text/javascript" src="dialog.js"></script>
<!-- pop up calendar -->
<style type="text/css">@import url(<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.css);</style>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.js"></script>
<?php include_once("{$GLOBALS['srcdir']}/dynarch_calendar_en.inc.php"); ?>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar_setup.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/textformat.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dialog.js"></script>

<!--<script src="<?php echo "$web_root";?>/library/textimporter/jquery-1.11.3.min.js"></script>
        <script src="<?php echo "$web_root";?>/library/textimporter/underscore.js"></script>
        <script src="<?php echo "$web_root";?>/library/textimporter/jquery-tmpl.js"></script>
        <script src="<?php echo "$web_root";?>/library/textimporter/knockout-3.3.0.debug.js"></script>
        <script src="<?php echo "$web_root";?>/library/textimporter/koExternalTemplateEngine_all.js"></script>
        <script src="<?php echo "$web_root";?>/library/textimporter/textimporter.js"></script>
        <link href="<?php echo "$web_root";?>/library/textimporter/textimporter.css" rel="stylesheet"></link>
-->

<!-- Changed FancyBox to 1.3.2 dnunez 1/11/16-->
<link rel="stylesheet" href="/openemr/interface/themes/style_metal.css" type="text/css">
<link rel="stylesheet" type="text/css" href="/openemr/library/js/fancybox-1.3.4/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dialog.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery.1.3.2.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/common.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/fancybox-1.3.4/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/signaturepad/SigWebTablet.js"></script>
<script type="text/javascript">
$(document).ready(function(){

    // resized fancybox 1/11/16
	$(".medium_modal").fancybox( {
		openEffect: 'elastic',
	    closeEffect: 'elastic',
	    fitToView: false,
	    width: "90%",
	    maxWidth: 1080,
	    height: "95%",
	    type: 'iframe'
	});

});
</script>


<div>
    
    <div class="tabContainer" style="width:550px;">
        <div>
<table cellpadding="1" cellspacing="0" class="showborder">
	<tr class="showborder_head" height="22">
		    </tr>
         <tr height="22">
       <td valign="top" class="text"><b><a href="<?php echo "$web_root";?>/interface/forms/treatment_plan/tabs3.php?dev=1&formid=<?php echo "$formid";?>" class="iframe medium_modal"><span>Click Here to edit Treatment Plan</span></a></b>&nbsp;</td>
       <tr height="22">
       <td valign="top" class="text"><b><a href="<?php echo "$web_root";?>/interface/forms/treatment_plan/signature.php?dev=1&formid=<?php echo "$formid";?>" class="iframe medium_modal"><span>X</span></a></b>&nbsp;</td>
       
       <tr height="22">
       <td valign="top" class="text"><b><a href="<?php echo "$web_root";?>/interface/forms/treatment_plan/treatment_plan.php?dev=1&formid=<?php echo "$formid";?>" class="iframe medium_modal"><span>Click Here to Preview the entire Treatment Plan</span></a></b>&nbsp;</td>
       

       <td>&nbsp;</td>
      

    </tr>
    
    </table>
        </div>
    </div>
</div>







<link rel="stylesheet" href="<?php echo $css_header;?>" type="text/css">
</head>
<body class="body_top">
<p><span class="forms-title"><?php echo xlt('Treatment Planning'); ?></span></p>

<?php
echo "<form method='post' name='my_form' " .
  "action='$rootdir/forms/treatment_plan/savetp.php?mode=update&id=" . attr($formid) ."'>\n";
?>
<form method=post action="<?echo $rootdir?>/forms/treatment_plan/savetp.php?mode=update&id=<?echo $_GET["id"];?>" name="SigForm" id="SigForm">


<SCRIPT language="Javascript">
    var mypcc = '<?php echo $GLOBALS['phone_country_code'] ?>';
 
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
     					var mySig1 = "<?php echo  stripslashes($obj{"provider_signature"});?>";
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
     					var mySig2 = "<?php echo  stripslashes($obj{"provider_signature"});?>";
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
     					var mySig5 = "<?php echo  stripslashes($obj{"provider_signature"});?>";
	   						SetSigString(mySig5, ctx5);
	   				}
	   				
           	  function onReturnSampleSigAll()
        			{
        			onReturnSampleSig3();
						setTimeout(function(){
					onReturnSampleSig4();		
						setTimeout(function(){
					onReturnSampleSig5();
							},1000);
						},1000);

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
		
		    
				function onDone3()
							{
	           					if(NumberOfTabletPoints() == 0)
	   							{
	      							//no signature, exit
	     							 return;
	   							}
	                   				document.SigForm.bioSigData.value = GetSigString();
	                   				document.SigForm.sigStringData.value  = document.SigForm.bioSigData.value;
								$.post("<?php echo $GLOBALS['webroot'] ?>/interface/forms/treatment_plan/save_provider_signature.php?mode=update&id=<?echo $_GET['id'];?>",
										{provider_print_name: $("#provider_print_name").val() ,provider_credentials: $("#provider_credentials").val() , provider_signature_date: $("#provider_signature_date").val(), provider_signature: $('#sigStringData').val()},
											function(data) 
												{
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
	                   				document.SigForm.bioSigData1.value = GetSigString();
	                   				document.SigForm.sigStringData1.value  = document.SigForm.bioSigData1.value;
								$.post("<?php echo $GLOBALS['webroot'] ?>/interface/forms/treatment_plan/save_supervisor_signature.php?mode=update&id=<?echo $_GET['id'];?>",
									{supervisor_print_name: $("#supervisor_print_name").val() ,supervisor_credentials: $("#supervisor_credentials").val() , supervisor_signature_date: $("#supervisor_signature_date").val(), supervisor_signature: $('#sigStringData1').val()},
										function(data) 
												{
										  			alert("Supervisor Signature Saved");
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
							$.post("<?php echo $GLOBALS['webroot'] ?>/interface/forms/treatment_plan/get-signature.php",
								{provider_print_name: $("#provider_print_name").val() , PIN: $("#clinician_pin").val() },
								function(data) {
								  if($.trim(data).length > 0){
								  		var ctx = document.getElementById('sigplus3').getContext('2d');         
   											SetDisplayXSize( 500 );
   											SetDisplayYSize( 100 );
   											SetJustifyMode(0);
   											ClearTablet();
 										var  tmr = SetTabletState(1, ctx, 50) || tmr;

								  	
								  //document.getElementById('sigplus2').sigString =  "<?php echo $signature_result; ?>";
                                    var mySig = data;
                                    SetSigString(mySig, ctx);
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
							$.post("<?php echo $GLOBALS['webroot'] ?>/interface/forms/treatment_plan/get-signature.php",
								{provider_print_name: $("#supervisor_print_name").val() , PIN: $("#supervisor_pin").val() },
								function(data) {
								  if($.trim(data).length > 0){
								  		var ctx2 = document.getElementById('sigplus2').getContext('2d');         
   											SetDisplayXSize( 500 );
   											SetDisplayYSize( 100 );
   											SetJustifyMode(0);
   											ClearTablet();
 										var  tmr1 = SetTabletState(1, ctx2, 50) || tmr1;

								  	
								  //document.getElementById('sigplus2').sigString =  "<?php echo $signature_result; ?>";
                                    var mySig2 = data;
                                    SetSigString(mySig2, ctx2);
   									SetJustifyMode(0);

							 	//alert(data.length);
								 	//alert(data);								
								 	 } else {
								  	alert("Incorrect PIN or Supervisor Name");
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







<!----><br><span><br><br>Select the status of this document.<br> 
			It will not be billed until signed and the status is 'Ready for Billing':</span><br>
		<select name="status" id="status" >
			<option selected=""><?echo stripslashes($obj{"status"});?></option>
			<option value="In Progress">In Progress</option>
			<option value="Ready for Billing/Supervisor">Ready for Billing/Supervisor</option>
			<option value="Void/Delete Request">Void/Delete Request</option>
		</select>
		Service Code:<?echo stripslashes($obj{"service_code"});?>
		<br>
		<br>
<!--
-->










<!-- -->
<table  border="0">

<tr>
<td align="left" class="forms" class="forms"><b><?php echo xlt('Client Name' ); ?>:</b></td>
		<td class="forms">
			<label class="forms-data"> <?php if (is_numeric($pid)) {
    
    $result = getPatientData($pid, "fname,lname,squad");
   echo text($result['fname'])." ".text($result['lname']);}
   $patient_name=($result['fname'])." ".($result['lname']);
   ?>
   </label>
   
   <!--<input type="hidden" name="client_name" value="<?php echo attr($patient_name);?>">-->
		</td>
		<td align="left"  class="forms"><b><?php echo xlt('DOB'); ?>:</b></td>
		<td class="forms">
		<label class="forms-data"> <?php if (is_numeric($pid)) {
        														$result = getPatientData($pid, "*");
   																echo text($result['DOB']);}
  											 $dob=($result['DOB']);
   ?>
   </label>
     <!--<input type="hidden" name="DOB" value="<?php echo attr($dob);?>">-->
		</td>
		</tr>
	<tr>
 	
	
	
		<td align="left"  class="forms"><b><?php echo xlt('Client Number'); ?>:</b></td>
		<td class="forms">
			<label class="forms-data" > <?php if (is_numeric($pid)) {
    
    $result = getPatientData($pid, "*");
   echo text($result['pid']);}
   $patient_id=$result['pid'];
   ?>
   </label>
    <!--<input type="hidden" name="client_number" value="<?php echo attr($patient_id);?>">-->
		</td>


		<!--<td align="left" class="forms"><?php echo xlt('Admit Date'); ?>:</td>-->
		
</html>



<!--

	
		<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Case</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>


-->
<body>


 

</body>
</html>

		
		
    <td><input type='submit'  value='<?php echo xlt('Save');?>' class="button-css">&nbsp;
	<input type='button'  value="Print" onclick="window.print()" class="button-css">&nbsp;
	<input type='button' class="button-css" value='<?php echo xlt('Cancel');?>'
 onclick="top.restoreSession();location='<?php echo "$rootdir/patient_file/encounter/$returnurl" ?>'" /></td>
	</tr>
</table>
</form>

<div id="errors" class="errors" ></div>

<?php
formFooter();
?>



<div id="signature">
<form action="#" name=FORM1>
<INPUT TYPE=HIDDEN NAME="bioSigData2">

		
	
<br>

<hr style="
width: 610px; height: -12px" class="auto-style1">	
<body onload="onReturnSampleSigAll()">
  <tr>
    <td height="10" width="500">
<canvas id="sigplus3" width="400" height="80">

</canvas>
<br>
<input id="SignBtn" name="SignBtn" type="button" value="Sign"  onclick="javascript:onSign3()"/>&nbsp;&nbsp;&nbsp;&nbsp;
<input id="clear" name="ClearBtn" type="button" value="Clear" onclick="javascript:onClear3()"/>&nbsp;&nbsp;&nbsp;&nbsp;
<input id="button" name="StopBtn" type="button" value="Done" onclick="javascript:onDone3()"/>&nbsp;&nbsp;&nbsp;&nbsp;




<label class="description" for="provider_print_name"> </label>


			<div>
				Clinician Print Name: <input id="provider_print_name" name="provider_print_name"  class="element text medium" type="text" value="<?php echo stripslashes($obj{"provider_print_name"});?>"   />
				Credentials: 
				<input id="credentials" name="credentials"  class="element text medium" type="text" value="<?php echo stripslashes($obj{"credentials"});?>" style="width: 75px"   />
				
				<label>Signature Date:</label>
				<input type='text' size='10' name='provider_signature_date' id='provider_signature_date' value="<?echo stripslashes($obj{"provider_signature_date"});?>" title='<?php xl('yyyy-mm-dd','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc)' />
				<img src='show_calendar.gif' align='absbottom' width='24' height='22' id='img_sig_date' border='0' alt='[?]' style='cursor:pointer;cursor:hand' title='<?php xl('Click here to choose a date','e'); ?>'>
	</div>
	
				PIN:<input id="clinician_pin" name="clinician_pin"  class="element text medium" type="password" value="" style="width: 35px"   />
				<input type="button" id="btnprovidersignature" value="Load Clinician's Signatures"  onclick="javascript:providersignature()" />
<br>
<label class="description" for="clinician_sig_lock">Lock Clinician's Signature</label>
			
				<input id="clinician_sig_lock" name="clinician_sig_lock" <?php if ($obj{"clinician_sig_lock"} == "on") {echo "checked";};?> class="element text medium" type="checkbox"     />
				<br>
			<hr style="
width: 610px; height: -12px">	
			
			
			<tr>
    <td height="10" width="500">
<!--<object id="sigplus1"  type="application/sigplus" width="500" height="100">
    <param name="onload" value="onReturnSampleSig1" />
</object>
-->
<canvas id="sigplus4" width="400" height="80">

</canvas>

<br>
<input id="SignBtn1" name="SignBtn" type="button" value="Sign"  onclick="javascript:onSign4()"/>&nbsp;&nbsp;&nbsp;&nbsp;
<input id="clear1" name="ClearBtn" type="button" value="Clear" onclick="javascript:onClear4()"/>&nbsp;&nbsp;&nbsp;&nbsp;
<input id="button1" name="StopBtn" type="button" value="Done" onclick="javascript:onDone4()"/>&nbsp;&nbsp;&nbsp;&nbsp;

<!--
<textarea id="rawdata" ></textarea>
-->
<label class="description" for="supervisor_print_name"> </label>
			<div>
				Supervisor Print Name: <input id="supervisor_print_name" name="supervisor_print_name"  class="element text medium" type="text" value="<?php echo stripslashes($obj{"supervisor_print_name"});?>"   />
				Credentials: 
				<input id="supervisor_credentials" name="supervisor_credentials"  class="element text medium" type="text" value="<?echo stripslashes($obj{"supervisor_credentials"});?>" style="width: 75px" >
				<label>Signature Date:</label>
				<input type='text' size='10' name='supervisor_signature_date' id='supervisor_signature_date' value="<?echo stripslashes($obj{"supervisor_signature_date"});?>" title='<?php xl('yyyy-mm-dd','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc)' />
				<img src='show_calendar.gif' align='absbottom' width='24' height='22' id='img_supervisor_signature_date' border='0' alt='[?]' style='cursor:pointer;cursor:hand' title='<?php xl('Click here to choose a date','e'); ?>'> 
				<br>
			</div>
				
			<div>
				
				<br>
				PIN:<input id="supervisor_pin" name="supervisor_pin"  class="element text medium" type="password" value="" style="width: 35px"   />
				<input type="button" id="btnsupervisorsignature" value="Load Supervisor's Signatures"  onclick="javascript:supervisorsignature()" />
				<br>
				<label class="description" for="supervisor_sig_lock">Lock Supervisor's Signature</label>
<input id="supervisor_sig_lock" name="supervisor_sig_lock" <?php if ($obj{"supervisor_sig_lock"} == "on") {echo "checked";};?> class="element text medium" type="checkbox"     />
<br>

				
				<br>

<INPUT TYPE=HIDDEN NAME="bioSigData">
<INPUT TYPE=HIDDEN NAME="bioSigData1">

<INPUT TYPE=HIDDEN NAME="sigStringData" id="sigStringData" value="">
<INPUT TYPE=HIDDEN NAME="sigStringData3" id="sigStringData1" value="<?php echo  stripslashes($obj{"supervisor_signature"});?>">
<INPUT TYPE=HIDDEN NAME="sigString">
<INPUT TYPE=HIDDEN NAME="sigImageData">
















</form>


</div>

