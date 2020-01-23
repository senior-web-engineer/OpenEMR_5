<!-- Forms generated from formsWiz -->
<?php
include_once("../../globals.php");
?>
<html><head>
<?php html_header_show();?>
<link rel=stylesheet href="<?echo $css_header;?>" type="text/css">
<link rel=stylesheet href="../../themes/style-form.css" type="text/css">
<style type="text/css">
.style1 {
	font-size: x-small;
}
.style3 {
	text-align: center;
	font-size: x-small;
}
</style>
</head>

<!-- supporting javascript code -->
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/textformat.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery.timeentry.package-1.4.9/jquery.timeentry.js"></script>

<!-- pop up calendar -->
<style type="text/css">@import url(<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.css);
.style4 {
	font-size: small;
}
.style5 {
	text-align: center;
}
</style>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.js"></script>
<?php include_once("{$GLOBALS['srcdir']}/dynarch_calendar_en.inc.php"); ?>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar_setup.js"></script>




<body <?echo $top_bg_line;?> topmargin=0 rightmargin=0 leftmargin=2 bottommargin=0 marginwidth=2 marginheight=0>
<?php
include_once("$srcdir/api.inc");

//$obj = formFetch("form_soap_pirc", $_GET["id"]);
//$obj = $formid ? formFetch("form_treatment_plan", $formid) : array();
$obj = $formid ? formFetch("form_treatment_plan", $formid) : array();
?>

	<div class="style5">
<span class="title"><strong>Treatment Plan</strong></span>
<span class="title"><strong>Signature Page</strong></span><br><br>

	</div>
<form method=post action="<?echo $rootdir?>/forms/treatment_plan/save.php?mode=update&id=<?echo $_GET["id"];?>" name="SigForm" id="SigForm">


<?php /* From New */ ?>

<?php $res = sqlStatement("SELECT fname,mname,lname,ss,street,city,state,postal_code,phone_home,DOB FROM patient_data WHERE pid = $pid");
$result = SqlFetchArray($res); 

echo $formid;

?>
Encounter#:<?php echo $encounter; ?><input type="hidden" name="encounter" id="encounter" value="<?php echo $encounter; ?>" readonly="readonly">(System use only)

<?echo "hello". $_GET["id"];?>

<INPUT NAME="signatureid" id="signatureid" value="<?php echo $formid;?>">






<script type="text/javascript" src="SigWebTablet.js"></script>

<SCRIPT language="Javascript">


// required for textbox date verification
var mypcc = '<?php echo $GLOBALS['phone_country_code'] ?>';


    var Index;
  	var tmr;	   
	var tmr1;
	var cursig=0;
	    

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
	   				
           	//  function onReturnSampleSigAll()
        	//		{
        	//		onReturnSampleSig3();
			//			setTimeout(function(){
			//		onReturnSampleSig4();		
			//			setTimeout(function(){
			//		onReturnSampleSig5();
			//				},1000);
			//			},1000);

        	//		}
        			            
       		  function onReturnSampleSigAll()
        			{
	        			onReturnSampleSig5();
						setTimeout(function(){
							onReturnSampleSig4();		
							setTimeout(function(){
								onReturnSampleSig3();
								setTimeout(function(){
									onReturnSampleSig2();
									setTimeout(function(){
										onReturnSampleSig1();
										
									},1000);
								},1000);
							},1000);
						},1000);
        			}

 							
			
			

		
			
	
		
				
		       

		    function Refresh() {
		                
                        document.getElementById('sigplus').refreshEvent();
                                               
		    }
		    
		    function Display() {
		                alert(document.getElementById('sigplus').sigString);		   
		                 }
		                 
		                 
		              

  
	
	

</script>


<table>

<tr>
		<td align="left" style="width: 166px"><strong>Client Name:</strong></td>
		<td style="width: 10%">

 <br><?php echo $result['fname'] . '&nbsp' . $result['mname'] . '&nbsp;' . $result['lname'];?> 
<img src="../../../images/space.gif" width="292" height="1"> <br><br>
</td>
	</tr>
<tr>
		<td align="left" style="width: 166px"><strong>Therapist:</strong></td>
		<td style="width: 10%">


<input type="text" name="provider" id="provider" value="<? echo stripslashes($obj{"provider"});?>" style="width: 185px" readonly="readonly" >

</td>
	</tr>





		
	</table>
	
<br>

<hr style="
width: 610px; height: -12px" class="auto-style1">	
<body onload="onReturnSampleSigAll()">
	<!--PATIENT SIGNATURE-->

<canvas id="sigplus1" width="400" height="80">

</canvas>

<br>

<label class="description" for="patient_print_name"> </label>
			<div>
				Patient Print Name:<input id="patient_print_name" name="patient_print_name"  class="element text medium" type="text" value="<?php echo stripslashes($obj{"patient_print_name"});?>"   /><label> Signature Date:</label>
				<input type='text' size='10' name='patient_signature_date' id='patient_signature_date' value="<?echo stripslashes($obj{"patient_signature_date"});?>" title='<?php xl('yyyy-mm-dd','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc)' />&nbsp;
			</div>
			<br>
			<br>

<!--END OF PATIENT SIGNATURE-->
<!-- GUARDIAN SIGNATURE-->
<canvas id="sigplus2" width="400" height="80">

</canvas>

<br>
<label class="description" for="guardian_print_name"> </label>
			<div>
				Guardian Print Name:<input id="guardian_print_name" name="guardian_print_name"  class="element text medium" type="text" value="<?php echo stripslashes($obj{"guardian_print_name"});?>"   />
				<label>Signature Date:</label>
				<input type='text' size='10' name='guardian_signature_date' id='guardian_signature_date' value="<?echo stripslashes($obj{"guardian_signature_date"});?>" title='<?php xl('yyyy-mm-dd','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc)' />&nbsp;
			</div>
		
<!--END OF GUARDIAN SIGNATURE-->

	
	
	
	
  <tr>
    <td height="10" width="500">
<canvas id="sigplus3" width="400" height="80">

</canvas>
<br>




<label class="description" for="provider_print_name"> </label>


			<div>
				Clinician Print Name: <input id="provider_print_name" name="provider_print_name"  class="element text medium" type="text" value="<?php echo stripslashes($obj{"provider_print_name"});?>"   />
				Credentials: 
				<input id="provider_credentials" name="provider_credentials"  class="element text medium" type="text" value="<?php echo stripslashes($obj{"provider_credentials"});?>" style="width: 75px"   />
				<label>Signature Date:</label>
				<input type='text' size='10' name='provider_signature_date' id='provider_signature_date' value="<?echo stripslashes($obj{"provider_signature_date"});?>" title='<?php xl('yyyy-mm-dd','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc)' />&nbsp;
				<br>
	</div>
	
				
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

<!--
<textarea id="rawdata" ></textarea>
-->
<label class="description" for="supervisor_print_name"> </label>
			<div>
				Supervisor Print Name: <input id="supervisor_print_name" name="supervisor_print_name"  class="element text medium" type="text" value="<?php echo stripslashes($obj{"supervisor_print_name"});?>"   />
				Credentials: 
				<input id="supervisor_credentials" name="supervisor_credentials"  class="element text medium" type="text" value="<?echo stripslashes($obj{"supervisor_credentials"});?>" style="width: 75px" >
				<label>Signature Date:</label>
				<input type='text' size='10' name='supervisor_signature_date' id='supervisor_signature_date' value="<?echo stripslashes($obj{"supervisor_signature_date"});?>" title='<?php xl('yyyy-mm-dd','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc)' />&nbsp; 
				<br>
			</div>
				
			<div>
				
				<br>
				
<br>

<canvas id="sigplus5" width="400" height="80">

</canvas>
<br>


<label class="description" for="supervisor_print_name"> </label>
			<div>
				Physician Print Name: <input id="physician_print_name" name="physician_print_name"  class="element text medium" type="text" value="<?php echo stripslashes($obj{"physician_print_name"});?>"   />
				Credentials: 
				<input id="physician_credentials" name="physician_credentials"  class="element text medium" type="text" value="<?php echo stripslashes($obj{"physician_credentials"});?>" style="width: 79px"   />
				<label>Signature Date:</label>
				<input type='text' size='10' name='physician_signature_date' id='physician_signature_date' value="<?echo stripslashes($obj{"physician_signature_date"});?>" title='<?php xl('yyyy-mm-dd','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc)' />&nbsp; 
				<br>
			</div>
				
				
<br>
						
				
<hr style="width: 659px">	
						
				
				<br>
				
				<br>



		
	



<script language="javascript">
/* required for popup calendar */
Calendar.setup({inputField:"patient_signature_date", ifFormat:"%Y-%m-%d", button:"img_patient_signature_date"});
Calendar.setup({inputField:"guardian_signature_date", ifFormat:"%Y-%m-%d", button:"img_guardian_signature_date"});
Calendar.setup({inputField:"provider_signature_date", ifFormat:"%Y-%m-%d", button:"img_provider_signature_date"});
Calendar.setup({inputField:"supervisor_signature_date", ifFormat:"%Y-%m-%d", button:"img_supervisor_signature_date"});
Calendar.setup({inputField:"physician_signature_date", ifFormat:"%Y-%m-%d", button:"img_physician_signature_date"});
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