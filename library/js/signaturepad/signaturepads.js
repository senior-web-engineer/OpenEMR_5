

    var Index;
  	var tmr;	   
	var tmr1;
	var cursig=0;
	    

		    function onClear() 
		    		{
		        		document.getElementById('sigplus').clearSignature();
		    		}

          					
			function onReturnSampleSig()
					{
					 	SetSigCompressionMode(1);

					 	SetTabletState(0, tmr);
					 	var ctx = document.getElementById('sigplus').getContext('2d'); 
					 	   SetDisplayXSize( 500 );
						   SetDisplayYSize( 100 );
						   SetJustifyMode(0);      
						   ClearTablet();
						   tmr = SetTabletState(1, ctx, 50) || tmr;
     var mySig = "<?php echo  stripslashes($obj{"provider_signature"});?>";
	   						SetSigString(mySig, ctx);

	   					
	   						
	   					    
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
					 	var mySig2 = "<?php echo  stripslashes($obj{"supervisor_signature"});?>";
	   						SetSigString(mySig2, ctx2);

	  
                     }
       
 		function onReturnSampleSig3()
					{
					 	SetSigCompressionMode(1);
					 	//SetTabletState(0, tmr);

					 	var ctx = document.getElementById('sigplus').getContext('2d'); 
					 	var ctx2 = document.getElementById('sigplus2').getContext('2d');
 
						   //ClearTablet();
						   //tmr = SetTabletState(1, ctx, 50) || tmr;
     					   //tmr2 = SetTabletState(1, ctx2, 50) || tmr2;
	   					var mySig = "<?php echo  stripslashes($obj{"provider_signature"});?>";
	   						SetSigString(mySig, ctx);
	   					var mySig2 = "<?php echo  stripslashes($obj{"supervisor_signature"});?>";
	   					//	SetSigString(mySig2, ctx2);
	
	   					    
					}

    

			function onSign() 
					{
				 		   disableSignButtons();
						   cursig = 1;
						   SetSigCompressionMode(1);
						   //saveSigs();
						   SetTabletState(0, tmr);
						   //document.SigForm.sigStringDataText.value = '';
						   //document.SigForm.sigImageDataText.value = '';
   						var ctx = document.getElementById('sigplus').getContext('2d');
						   SetDisplayXSize( 500 );
						   SetDisplayYSize( 100 );
						   SetJustifyMode(0);      
						   ClearTablet();
						   tmr = SetTabletState(1, ctx, 50) || tmr;

					    	//    document.getElementById('sigplus').tabletState = 1;
			             	//    document.getElementById('sigplus').captureMode = 1;
			             	//    document.getElementById('sigplus1').tabletState = 0;
			             	//    document.getElementById('sigplus1').captureMode = 0;
			            	//    Index = setInterval(Refresh, 50);
		    		}

			function onSign1() 
					{
				        disableSignButtons();
						   cursig = 2;
						   SetSigCompressionMode(1);
						   //saveSigs();
						   SetTabletState(0, tmr);
						   //document.SigForm.sigStringDataText.value = '';
						   //document.SigForm.sigImageDataText.value = '';
   						var ctx2 = document.getElementById('sigplus2').getContext('2d');
						   SetDisplayXSize( 500 );
						   SetDisplayYSize( 100 );
						   SetJustifyMode(0);      
						   ClearTablet();
						   tmr = SetTabletState(1, ctx2, 50) || tmr;
		    		}

		    function onClear() 
		    		{
		        		//document.getElementById('sigplus').clearSignature();
		        
		        	 var ctx = document.getElementById('sigplus').getContext('2d');
					   //var ctx2 = document.getElementById('cnv2').getContext('2d');
					   //var ctx3 = document.getElementById('cnv3').getContext('2d');

					   ClearTablet();
					   ctx.clearRect(0, 0, sigplus.width, sigplus.height);
					   //ctx2.clearRect(0, 0, cnv2.width, cnv2.height);
					   //ctx3.clearRect(0, 0, cnv3.width, cnv3.height);
				    }
				    
		    function onClear1() 
		    		{
		        		document.getElementById('sigplus1').clearSignature();
		   			}

              
    		function onDoneForm()
					{
		 				document.SigForm.submit();
          	        }


	

		
//function onDone()
//		{
                

//                   document.getElementById('sigplus').compressionMode = 1;
//                   document.SigForm.bioSigData.value = document.getElementById('sigplus').sigString;
//                   document.SigForm.sigStringData.value  = document.getElementById('sigplus').sigString;
					
				
//							$.post("<?php echo $GLOBALS['webroot'] ?>/interface/forms/soap_pirc/save_provider_signature.php?mode=update&id=<?echo $_GET['id'];?>",
//								{provider_print_name: $("#provider_print_name").val() ,credentials: $("#credentials").val() , sig_date: $("#sig_date").val(), provider_signature: $('#sigStringData').val()},
//								function(data) {
//								  	alert("Provider Signature Saved");
//								}								
//							);
				

	//	}
			
		
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
		
		
		
		
		
		
		
		
		
		
				function onDone()
					{
           				if(NumberOfTabletPoints() == 0)
   							{
      							//no signature, exit
     							 return;
   							}
     

                   		document.SigForm.bioSigData.value = GetSigString();
                   		document.SigForm.sigStringData.value  = document.SigForm.bioSigData.value;
							$.post("<?php echo $GLOBALS['webroot'] ?>/interface/forms/soap_pirc/save_provider_signature.php?mode=update&id=<?echo $_GET['id'];?>",
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
			
		
		
		
					function onDone1()
							{
                
								if(NumberOfTabletPoints() == 0)
   							{
      							//no signature, exit
     							 return;
   							}
     

                   				document.SigForm.bioSigData1.value = GetSigString();
                   				document.SigForm.sigStringData1.value  = document.SigForm.bioSigData1.value;
									$.post("<?php echo $GLOBALS['webroot'] ?>/interface/forms/soap_pirc/save_supervisor_signature.php?mode=update&id=<?echo $_GET['id'];?>",
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
							$.post("<?php echo $GLOBALS['webroot'] ?>/interface/forms/soap_pirc/get-signature.php",
								{provider_print_name: $("#provider_print_name").val() , PIN: $("#clinician_pin").val() },
								function(data) {
								  if($.trim(data).length > 0){
								  		var ctx = document.getElementById('sigplus').getContext('2d');         
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
							$.post("<?php echo $GLOBALS['webroot'] ?>/interface/forms/soap_pirc/get-signature.php",
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

				
	
	
	
//	  function supervisorsignature(){
//							$.post("<?php echo $GLOBALS['webroot'] ?>/interface/forms/soap_pirc/get-signature.php",
//								{provider_print_name: $("#supervisor_print_name").val() , PIN: $("#supervisor_pin").val() },
//								function(data) {
//								  if($.trim(data).length > 0){
//								  	document.getElementById('sigplus1').compressionMode = 2;
//								    document.getElementById('sigplus1').sigString =  data;
//								   // document.getElementById('supervisor_signature').sigString =  data;
//
//								 	//alert(data.length);
//								 	//alert(data);
//								 } else {
//								  	alert("Incorrect PIN or Supervisor Name");
//								  }
//								}								
//							);
//						}
  
	
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

