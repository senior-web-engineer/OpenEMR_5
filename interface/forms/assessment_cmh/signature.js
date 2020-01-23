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
								$.post("<?php echo $GLOBALS['webroot'] ?>/interface/forms/assessment_cmh/save_provider_signature.php?mode=update&id=<?php echo $_GET['id'];?>",
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
								$.post("<?php echo $GLOBALS['webroot'] ?>/interface/forms/assessment_cmh/save_provider_signature.php?mode=update&id=<?php echo $_GET['id'];?>",
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
								$.post("<?php echo $GLOBALS['webroot'] ?>/interface/forms/assessment_cmh/save_provider_signature.php?mode=update&id=<?php echo $_GET['id'];?>",
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
								$.post("<?php echo $GLOBALS['webroot'] ?>/interface/forms/assessment_cmh/save_supervisor_signature.php?mode=update&id=<?php echo $_GET['id'];?>",
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
								$.post("<?php echo $GLOBALS['webroot'] ?>/interface/forms/assessment_cmh/save_provider_signature.php?mode=update&id=<?php echo $_GET['id'];?>",
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
		


		    function Refresh() 
                        {
		                
                        document.getElementById('sigplus').refreshEvent();
                                               
                        }
		    
		    function Display() {
		                alert(document.getElementById('sigplus').sigString);		   
		                 }
		                 
		                 
		              

  
	
	function providersignature()
					{
				        $.post("<?php echo $GLOBALS['webroot'] ?>/interface/forms/assessment_cmh/get-signature.php",
								{
                                    provider_print_name: $("#provider_print_name").val() , PIN: $("#clinician_pin").val() 
                                },
								function(data) 
                                {
								  if($.trim(data).length > 0)
                                  {
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
								 } 
                                    else 
                                    {
								  	alert("Incorrect PIN or Clinician Name");
								  }
								}								
							);
						}

	
	function supervisorsignature()
					{
							$.post("<?php echo $GLOBALS['webroot'] ?>/interface/forms/assessment_cmh/get-signature.php",
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
  