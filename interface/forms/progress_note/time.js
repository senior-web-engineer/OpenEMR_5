//0 code, 1 minutes per unit, 2 max unit
var arCodes =[
			["H2019HR",15,4],
			["H2019HO",15,8],
			["H2019HM",15,8],
			["90806",  60,1],
			["90808",  60,1],
			["H2017", 15,32],
			["H2012",  60,8],
			["90853",  60,1]
			 ];

$(document).ready(function(){
	//documentation for the time picker controls http://keith-wood.name/timeEntry.html
	//the settings below apply to both time pickers
	var timesettings = {
	  //spinnerImage: '<?php echo $GLOBALS['webroot'] ?>/library/js/jquery.timeentry.package-1.4.9/spinnerUpDown.png', 
		spinnerImage: 'spinnerUpDown.png', 
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
