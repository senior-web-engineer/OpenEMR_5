<script language="javascript">



// required for textbox date verification
var mypcc = '<?php echo $GLOBALS['phone_country_code'] ?>';
function PrintForm() {
    newwin = window.open("<?php echo $rootdir."/forms/progress_note/print.php?id=".$_GET["id"]; ?>","mywin");
}

//0 code, 1 minutes per unit, 2 max unit
var arCodes =[
			["H2019HR",15,4],
			["H2019HO",15,8],
			["H2019HM",15,8],
			["H2019HQ",15,8],
			["90806",  60,1],
			["90808",  60,1],
			["H2017", 15,32],
			["H2012",  60,8],
			["90853",  60,1],
			["90832",  30,1],
			["90834",  45,1],
			["90837",  60,1],
			["90839",  60,1]
			["90846",  60,1],
			["90847",  60,1]
					
			 ];

$(document).ready(function(){
	//documentation for the time picker controls http://keith-wood.name/timeEntry.html
	//the settings below apply to both time pickers
	var timesettings = {
		spinnerImage: '<?php echo $GLOBALS['webroot'] ?>/library/js/jquery.timeentry.package-1.4.9/spinnerUpDown.png', 
		spinnerSize: [15, 16, 0], 
		spinnerBigSize: [30, 32, 0], 
		spinnerIncDecOnly: true,
		//show24Hours: true, 
		timeSteps: [1, 15, 0], 
		beforeShow: customRange
	};
	
	//initialize controls
	$('#time_start')
		.timeEntry(timesettings)
		.blur(function(){ calcunits();});
	$('#time_end')
		.timeEntry(timesettings)
		.blur(function(){ calcunits();});
	$("#service_code").change(function(){ calcunits();});
	$("#units").blur(function(){ calcunits();});
	
	//calculate the units
	function calcunits(){
		try{
			var code = "";
			var mpu =0;
			var maxunit = 0;
			var minutesdiff = 0;
			var time_start = "";
			var time_end = "";
			var start = new Date ();
			var end = new Date();
			var debug = "";
			var units = 0;
			
			//1) find out what code is selected
			code = $("#service_code").val();
			time_start = $("#time_start").val();
			time_end = $("#time_end").val();
			
			//check to see if we have a code and a start and end date
			if (code.length > 0 && time_start.length > 0 && time_end.length > 0) { 
				dbug = "code:" + code + " time_start:" + time_start + " time_end:" + time_end;
				
				//2) look up code in arCodes
				for (var i = 0; i < arCodes.length; i++) {
					if (arCodes[i][0] == code) {
						mpu = arCodes[i][1] ;
						maxunit = arCodes[i][2];
					}
				}
				dbug += " mpu:" + mpu + " maxunit:" + maxunit;

				//3) calculate how many minutes in the time range
				var ah = time_start.split(':');
				dbug += " h:" + ah[0] + " m:" + ah[1].replace("AM", "").replace("PM", "");
				start.setHours (ah[0], ah[1].replace("AM", "").replace("PM", ""));
				ah = time_end.split(':');
				end.setHours (ah[0], ah[1].replace("AM", "").replace("PM", ""));
				var nTotalDiff = end.getTime () - start.getTime ();
				minutesdiff =(nTotalDiff / 1000 / 60);				
				dbug += " minutesdiff:" + minutesdiff;
				
				//4) change the units based on the code
				if (minutesdiff > 0 && mpu > 0 && maxunit > 0){
					units = Math.floor(minutesdiff / mpu);
					if (units > maxunit) { units = maxunit; }
					$("#units").val( units);
				}
				//alert(dbug); //popup that shows numbers calculated
			} else { 
				//alert(' Please select code, start time, and end time.');
			}
		} catch(err) { alert('Error calcunits() : ' + err);}
	}
	
	//this is called by the time picker to make sure the hours dont cross
	function customRange(input) { 
    return {minTime: (input.id == 'time_end' ? 
        $('#time_start').timeEntry('getTime') : null),  
        maxTime: (input.id == 'time_start' ? 
        $('#time_end').timeEntry('getTime') : null)}; 
	}
});
////////////////////////////////////////////////////////////////
//Disable Select Ready for Billing
//
//////////////////////////////////////////////////
//  01-14-2017									//
//  Y. Charles									//
//  Need to fix sig_date						//
//  Future Improvement:                         //
//       Check 'Quality of content              //
//////////////////////////////////////////////////
//$(document).ready(function() {
//$(function() {
//    $("#status").attr('disabled', 'disabled');
//});
//$("#time_start, #time_end, #service_code, #units, #subjective, #objective, #assessment, #plan").keyup(function() {     
//      if ($("#time_start").val() != "" && 
//      	  $("##time_end").val() != "" &&
//      	  $("#units").val() != "" &&
//      	  $("#servicecode").val() != "" &&
//      	  $("#subjective").val() != "" &&
//		  $("#objective").val() != "" &&
//		  $("#assessment").val() != "" &&
//      	  $("#plan").val() != "" ) {
//		          $("#status").removeAttr('disabled');
//		           } else {
//		          $("#status").attr('disabled', 'disabled');
//		         }
//    });
//    });
    
//End of Disable Select// 
</script>
<script type="text/javascript">
$(document).ready(function() {
	
	$(".various").fancybox({
		maxWidth	: 800,
		maxHeight	: 600,
		fitToView	: false,
		width		: '70%',
		height		: '70%',
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none'
			   								
	});
	
	$(".provider_signature").fancybox({
		maxWidth	: 800,
		maxHeight	: 600,
		fitToView	: false,
		width		: '70%',
		height		: '70%',
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none',
		afterClose  : function onReturnSampleSigAll()
        			{
        		onReturnSampleSig3();
						setTimeout(function(){
        			onReturnSampleSig4();
						setTimeout(function(){
					onReturnSampleSig3();		
											},1000);
					},1000);

					onReturnSampleSig3();
        			}
								
	});

	$(".supervisor_signature").fancybox({
		maxWidth	: 800,
		maxHeight	: 600,
		fitToView	: false,
		width		: '70%',
		height		: '70%',
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none',
		afterClose  : onReturnSampleSig4()		   								
	});

	
	$(".medium_modal").fancybox( {
		openEffect: 'elastic',
	    closeEffect: 'elastic',
	    fitToView: false,
	    width: "90%",
	    maxWidth: 1080,
	    height: "95%",
	    type: 'iframe'
	    
	});

	$(".small_modal").fancybox( {
		openEffect: 'elastic',
	    closeEffect: 'elastic',
	    fitToView: false,
	    width: "40%",
	    maxWidth: 1080,
	    height: "70%",
	    type: 'iframe'
	    
	});

});
</script>

<script>

function Update()
							{
	                   				document.SigForm.bioSigData.value = GetSigString();
	                   				document.SigForm.sigStringData.value  = document.SigForm.bioSigData.value;
								$.post("<?php echo $GLOBALS['webroot'] ?>/interface/forms/progress_note/save_provider_signature.php?mode=update&id=<?php echo $_GET['id'];?>",
										{provider_print_name: $("#provider_print_name").val() ,provider_credentials: $("#provider_credentials").val() , provider_signature_date: $("#provider_signature_date").val(), provider_signature: $('#sigStringData').val()},
											function(data) 
												{
										  			alert("Provider Signature Saved");
												}								
										);		
									
						    }

</script>
