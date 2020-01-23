<?php
include_once("../../globals.php");
include_once("$srcdir/api.inc");
require_once("$srcdir/patient.inc");
require_once("$srcdir/options.inc.php");
?>
<!--												SIGNATURE CODE                         -->
<!DOCTYPE html>
<html lang="en">
<head>

<style type="text/css">@import url(<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.css);</style>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.js"></script>
<?php include_once("{$GLOBALS['srcdir']}/dynarch_calendar_en.inc.php"); ?>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar_setup.js"></script>
<script language="JavaScript">
// required for textbox date verification
var mypcc = '<?php echo $GLOBALS['phone_country_code'] ?>';
//}
</script>

<head>
<style type="text/css">
.auto-style1 {
	text-align: center;
}
.auto-style2 {
	font-size: x-large;
}
.auto-style3 {
	text-align: left;
}
</style>
</head>

<script type="text/javascript" src="SigWebTablet.js"></script>
<SCRIPT language="Javascript">
	//test if sigweb is alive
										

    var Index;
  	var tmr;	   
	var tmr1;
	var cursig=0;
	
	
//			function drivertest()
//							{
//	           					if(NumberOfTabletPoints() == 0)
//	   							{
//	      							echo "00000000000000000000";
//	   							} else{
//	   										echo "11111111111111111";
//
//							}
	
  
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
		
	
				
		        function onDone1()
							{
	           					if(NumberOfTabletPoints() == 0)
	   							{
	      							//no signature, exit
	     							 return;
	   							}
	                   				document.SigForm.bioSigData.value = GetSigString();
	                   				document.SigForm.sigStringData.value  = document.SigForm.bioSigData.value;
								$.post("<?php echo $GLOBALS['webroot'] ?>/interface/forms/progress_note/save_provider_signature.php?mode=update&id=<?php echo $_GET['id'];?>",
										{provider_print_name: $("#provider_print_name").val() ,credentials: $("#credentials").val() , sig_date: $("#sig_date").val(), provider_signature: $('#sigStringData').val()},
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

				function onDone2()
							{
	           					if(NumberOfTabletPoints() == 0)
	   							{
	      							//no signature, exit
	     							 return;
	   							}
	                   				document.SigForm.bioSigData.value = GetSigString();
	                   				document.SigForm.sigStringData.value  = document.SigForm.bioSigData.value;
								$.post("<?php echo $GLOBALS['webroot'] ?>/interface/forms/progress_note/save_provider_signature.php?mode=update&id=<?php echo $_GET['id'];?>",
										{provider_print_name: $("#provider_print_name").val() ,credentials: $("#credentials").val() , sig_date: $("#sig_date").val(), provider_signature: $('#sigStringData').val()},
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

				function onDone3()
							{
	           					if(NumberOfTabletPoints() == 0)
	   							{
	      							//no signature, exit
	     							 return;
	   							}
	                   				document.SigForm.bioSigData.value = GetSigString();
	                   				document.SigForm.sigStringData.value  = document.SigForm.bioSigData.value;
								$.post("<?php echo $GLOBALS['webroot'] ?>/interface/forms/progress_note/save_provider_signature.php?mode=update&id=<?php echo $_GET['id'];?>",
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
								$.post("<?php echo $GLOBALS['webroot'] ?>/interface/forms/progress_note/save_supervisor_signature.php?mode=update&id=<?php echo $_GET['id'];?>",
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
							
					function onDone5()
							{
	           					if(NumberOfTabletPoints() == 0)
	   							{
	      							//no signature, exit
	     							 return;
	   							}
	                   				document.SigForm.bioSigData.value = GetSigString();
	                   				document.SigForm.sigStringData.value  = document.SigForm.bioSigData.value;
								$.post("<?php echo $GLOBALS['webroot'] ?>/interface/forms/progress_note/save_provider_signature.php?mode=update&id=<?php echo $_GET['id'];?>",
										{provider_print_name: $("#provider_print_name").val() ,credentials: $("#credentials").val() , sig_date: $("#sig_date").val(), provider_signature: $('#sigStringData').val()},
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
		


		    function Refresh() {
		                
                        document.getElementById('sigplus').refreshEvent();
                                               
		    }
		    
		    function Display() {
		                alert(document.getElementById('sigplus').sigString);		   
		                 }
		                 
	
	
			function providersignature()
							{
									$.post("<?php echo $GLOBALS['webroot'] ?>/interface/forms/progress_note/get-signature.php",
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
			function providersignatureNG()
			{
					$.post("<?php echo $GLOBALS['webroot'] ?>/interface/forms/progress_note/get-signature.php",
						{provider_print_name: $("#provider_print_name").val() , PIN: $("#clinician_pin").val() },
						function(data) {
						  if($.trim(data).length > 0){
							var signature = data;							  	
							$.post("<?php echo $GLOBALS['webroot'] ?>/interface/forms/progress_note/save_provider_signature.php?mode=update&id=<?php echo $_GET['id'];?>",
								{
								 provider_print_name: $("#provider_print_name").val() ,
								 provider_credentials: $("#provider_credentials").val(), 
								 provider_signature_date: $("#provider_signature_date").val(),
								 provider_signature: signature
								 },
								function(data) {
								 	//alert(data.length);
								 	//alert(data);
								 	alert("Signature Saved");
							 	}
						 	);
						 	//alert(data.length);
						 	//alert(data);
						 } else {
						  	alert("Incorrect PIN or Clinician Name");
						  }
						}								
					);
				}
			function supervisorsignatureNG()
			{
					$.post("<?php echo $GLOBALS['webroot'] ?>/interface/forms/progress_note/get-signature.php",
						{provider_print_name: $("#supervisor_print_name").val() , PIN: $("#supervisor_pin").val() },
						function(data) {
						  if($.trim(data).length > 0){
							var signature = data;							  	
							$.post("<?php echo $GLOBALS['webroot'] ?>/interface/forms/progress_note/save_supervisor_signature.php?mode=update&id=<?php echo $_GET['id'];?>",
								{
								 supervisor_print_name: $("#supervisor_print_name").val() ,
								 supervisor_credentials: $("#supervisor_credentials").val(), 
								 supervisor_signature_date: $("#supervisor_signature_date").val(),
								 supervisor_signature: signature
								 },
								function(data) {
								 	//alert(data.length);
								 	//alert(data);
								 	alert("Signature Saved");
							 	}
						 	);
						 	//alert(data.length);
						 	//alert(data);
						 } else {
						  	alert("Incorrect PIN or Supervisor Name");
						  }
						}								
					);
				}

	
			function supervisorsignature()
							{
									$.post("<?php echo $GLOBALS['webroot'] ?>/interface/forms/progress_note/get-signature.php",
										{provider_print_name: $("#supervisor_print_name").val() , PIN: $("#supervisor_pin").val() },
										function(data) {
										  if($.trim(data).length > 0){
										  		var ctx2 = document.getElementById('sigplus4').getContext('2d');         
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

<!--<body onload="drivertest()">-->

						<?php /* From New */ ?>
						<INPUT TYPE=HIDDEN NAME="bioSigData2">
						
						<div class="auto-style1">
							<div class="auto-style1">
							<strong><span class="auto-style2">Signature<br><br></span>
							</div>
							<div class="auto-style3">
							Please, read 
							carefully:</strong>
							
							</div>
							
							<li class="auto-style3">You have the option of signing, or loading previously 
							saved signature.</li>
							<li class="auto-style3">You must click on 'Save Signature' 
							after you sign.</li>
							<li class="auto-style3">You may only save one signature at a time.</li>
						      
							<strong><span class="auto-style2"><br></span>
						</div>
						 <!--     PROVIDER SIGNATURE-->	
	<div id="physician_signature" class="">
				<h3>Provider's Signature</h3>
				<td valign="top" class="text"><b>
				<a href="<?php echo "$web_root";?>/interface/forms/progress_note/provider_signature.php?dev=1&formid=<?php echo "$formid";?>" class="provider_signature" data-fancybox-type="iframe">
				<span>+Click Here for Provider's Signature Page</span></a></b>&nbsp;</td>
    </div>
    <!--END  PROVIDER SIGNATURE-->
  						
						<hr style="
						width: 610px; height: -12px" class="auto-style1" >
						<body onload="onReturnSampleSigAll()">
						  <canvas id="sigplus3" width="400" height="80">
						
						</canvas>
						<br>
						<label class="description" for="provider_print_name"> </label>
					
							<b>Clinician Print Name:</b> <input id="provider_print_name" name="provider_print_name"  class="element text medium" type="text" value="<?php echo stripslashes($obj{"provider_print_name"});?>"   required />
							<b>Credentials:</b> 
							<input id="provider_credentials" name="provider_credentials"  class="element text medium" type="text" value="<?php echo stripslashes($obj{"provider_credentials"});?>" style="width: 75px"   required />
							<label>Signature Date:</label>
							<input type='text' size='10' name='provider_signature_date' id='provider_signature_date' value="<?php echo stripslashes($obj{"provider_signature_date"});?>" title='<?php xl('yyyy-mm-dd','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc)' required />
							<img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_provider_signature_date' border='0' alt='[?]' style='cursor:pointer;cursor:hand' title='<?php xl('Click here to choose a date','e'); ?>'>
						<div id="topaz">	
						
						</div>
										<br>
										<span class="auto-style2"></span>
									<!--     SUPERVISOR SIGNATURE-->	
	<div id="supervisor_signature" class="">
				<h3>Supervisor's Signature</h3>
				<td valign="top" class="text"><b>
				<a href="<?php echo "$web_root";?>/interface/forms/progress_note/supervisor_signature.php?dev=1&formid=<?php echo "$formid";?>" class="supervisor_signature" data-fancybox-type="iframe">
				<span>+Click Here for Supervisor's Signature Page</span></a></b>&nbsp;</td>
    </div>
    <!--END  SUPERVISOR SIGNATURE-->

									<hr style="	width: 610px; height: -12px">	
									
									
									<tr>
						    <td height="10" width="500">
						<!--<object id="sigplus1"  type="application/sigplus" width="500" height="100">
						    <param name="onload" value="onReturnSampleSig1" />
						</object>
						-->
		<div id="supervisor_signature">
						<canvas id="sigplus4" width="400" height="80">
						
						</canvas>
						<div id="topazsup">
						<label class="description" for="supervisor_print_name"> </label>
									<div>
										<b>Supervisor Print Name: </b><input id="supervisor_print_name" name="supervisor_print_name"  class="element text medium" type="text" value="<?php echo stripslashes($obj{"supervisor_print_name"});?>"   />
										<b>Credentials:</b> 
										<input id="supervisor_credentials" name="supervisor_credentials"  class="element text medium" type="text" value="<?php echo stripslashes($obj{"supervisor_credentials"});?>" style="width: 75px" >
										<label>Signature Date:</label>
										<input type='text' size='10' name='supervisor_signature_date' id='supervisor_signature_date' value="<?php echo stripslashes($obj{"supervisor_signature_date"});?>" title='<?php xl('yyyy-mm-dd','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc)' />
										<img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_supervisor_signature_date' border='0' alt='[?]' style='cursor:pointer;cursor:hand' title='<?php xl('Click here to choose a date','e'); ?>'> 
										<br>
									</div>
									
									<br>
							&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<br>
						
	
									<div>
										
										
										&nbsp;
										<br>
										<!--
										<label class="description" for="supervisor_sig_lock">Lock Supervisor's Signature</label>
						<input id="supervisor_sig_lock" name="supervisor_sig_lock" <?php if ($obj{"supervisor_sig_lock"} == "on") {echo "checked";};?> class="element text medium" type="checkbox"     />
										-->
						<br>				
						<!--<b>(2)</b><input id="button1" name="StopBtn" type="button" value="Save Supervisor's Signature" onclick="javascript:onDone4()"/>-->
						<br>
						</div>
		</div>
										
										<br>
						
						<INPUT TYPE=HIDDEN NAME="bioSigData">
						<INPUT TYPE=HIDDEN NAME="bioSigData1">
						<INPUT TYPE=HIDDEN NAME="sigStringData" id="sigStringData" value="<?php echo  stripslashes($obj{"provider_signature"});?>">
						<INPUT TYPE=HIDDEN NAME="sigStringData1" id="sigStringData1" value="<?php echo  stripslashes($obj{"supervisor_signature"});?>">
						<INPUT TYPE=HIDDEN NAME="sigString">
						<INPUT TYPE=HIDDEN NAME="sigImageData">
						
						<br>
						<br>
<?php
if ($provider_results["supervisor"] != "1")
{
?>
<script language="javascript">
	//$("#supervisor_signature *").attr("disabled", "disabled").off('click');
	$("#supervisor_print_name").attr("readonly", true);
	$("#supervisor_credentials").attr("readonly", true);
	

</script>		
<?php
}
?>		

						
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
						
	//test if sigweb is alive
											function SigWebLifeCheck() {
												var xhr = SigWebcreateXHR();
												var prop = 'CompressionMode/1';
												if (xhr) {
													try {
														xhr.open("POST", baseUri + prop, false);
														xhr.send();
														if (xhr.readyState == 4 && xhr.status == 200) {
															//return xhr.responseText;
															return true;
														}
													} catch(err) {
														return false;
													}
												}
												return false;
											}
											


</script>
<!--												END OF SIGNATURE CODE                         -->
