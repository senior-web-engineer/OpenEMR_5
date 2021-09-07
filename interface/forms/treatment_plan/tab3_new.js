var dataPath = window.location.origin + "/openemr/library/textimporter/";
var textimporterdata = dataPath + "textimporterdata.php";
var currStep = 0;
let bStepChange = true;

$(function() {
    console.log('tab3_new')
	$('#mainSplitter').jqxSplitter({
		width: 'calc(100% - 10px)',
		height: 'calc(100% - 10px)',
		panels: [
			{ size: 200, min: 100, max: 300 },
			{min: 200, size: 'calc(100% - 200px)'}
		],
		theme: theme
	});
    $('#subSplitter').jqxSplitter({ width: '100%', height: '100%',
        orientation: 'horizontal',
        panels: [{ size:210, min: 100,  },
        {size:120}]
    });

	// $('#jqxExpander').jqxExpander({
	// 	width: '100%',
	// 	height: '100%',
	// 	showArrow: false,
	// 	toggleMode: 'none',
	// 	theme: theme
	// });

	// Step show event
    $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
       //alert("You are on step "+stepNumber+" now");
       if(stepPosition === 'first'){
           $("#prev-btn").addClass('disabled');
       }else if(stepPosition === 'final'){
           $("#next-btn").addClass('disabled');
       }else{
           $("#prev-btn").removeClass('disabled');
           $("#next-btn").removeClass('disabled');
       }
    });

    // Smart Wizard
    $('#smartwizard').smartWizard({
            selected: 0,
            theme: 'arrows',
            transitionEffect:'fade',
            showStepURLhash: true,
            toolbarSettings: {
            	toolbarPosition: 'toolbarPosition',
                toolbarButtonPosition: 'end'
            },
            autoAdjustHeight: true,
    });

    $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition) {

        if (stepDirection === "backward") {
            return true;
        }

        let isValid = true;
        switch(stepNumber) {
            case 0:
                if (!arrDiagnosis || arrDiagnosis.length < 1)
                    isValid = false;
                break;
            case 1:
                if (!arrBehavior || arrBehavior.length < 1)
                    isValid = false;
                break;
            case 2:
                if (!arrGoal || arrGoal.length < 1)
                    isValid = false;
                break;
            case 3:
                if (!arrObjective || arrObjective.length < 1) {
                    isValid = false;
                    if (!loadingObjective) {
                        alert('There are no objectives for selected goal .');
                    }
                }
                break;
            case 5:
                if (!arrModality || arrModality.length < 1)
                    isValid = false;
                break;
            case 6:
                if (!arrModalityNote || arrModalityNote.length < 1)
                    isValid = false;
                break;
            // case 5:
            //     if (!arrDischarge || arrDischarge.length < 1)
            //         isValid = false;
            //     break;
        }

        return isValid;
    });

    $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
        currStep = stepNumber;
        if (bStepChange) {
            currTab = stepNumber;
            updateProblemTab();
        }
        bStepChange = true;
        loadStep();
    });


    $("#prev-btn").on("click", function() {
        // Navigate previous
        $('#smartwizard').smartWizard("prev");
        return true;
    });

    $("#next-btn").on("click", function() {
        // Navigate next
        $('#smartwizard').smartWizard("next");
        return true;
    });

    // Objective splitter and expander
    $('#objectiveSplitter').jqxSplitter({
		width: '100%',
		height: 700,
		panels: [
			{ size: 200, min: 100, max: 300 },
			{ min: 200, size: 'calc(100% - 200px)' }
		],
		theme: theme
	});

	$('#objectiveExpander').jqxExpander({
		width: '100%',
		height: '100%',
		showArrow: false,
		toggleMode: 'none',
		theme: theme
	});

    // Intervention splitter and expander
    $('#interventionSplitter').jqxSplitter({
		width: 'calc(100%)',
		height: 700,
		panels: [
			{ size: 200, min: 100, max: 300 },
			{ min: 200, size: 'calc(100% - 200px)' }
		],
		theme: theme
	});

	$('#interventionExpander').jqxExpander({
		width: '100%',
		height: '100%',
		showArrow: false,
		toggleMode: 'none',
		theme: theme
	});
});

function cleanSteps() {

    bStepChange = false;
    $('#smartwizard').smartWizard("reset");

}

function loadStep() {
    if(currStep > 5) return;
    //in the case of Objective/interventions and modality, not show any prev contents
    if ( currStep == 3 || currStep == 4 || currStep == 5 || currStep == 7 || currStep == 1) {
        return;
    }
    let i = 1;
    for ( i = 1 ; i < 6 ; i ++ ) {
        // for ( i = 1 ; i < 8 ; i ++ ) {
        $('#step-' + i + ' .step-prev-contents').html('');
    }
    $('.step-content-header').hide();


    if (currStep == 5) {
        $( '#step-4 .step-content-body').clone().appendTo( '#step-5 .step-prev-contents' );
    } else {
        for ( i = 2 ; i < currStep + 1 ; i ++ ) {
            $( '#step-' + i + ' .step-content-body').clone().appendTo( '#step-' + (currStep + 1) + ' .step-prev-contents' );
        }
    }

    $('#step-' + (currStep + 1) + ' .step-prev-contents .step-content-header').show();
    $('#step-' + (currStep + 1) + ' .step-prev-contents .btn').hide();
    $('.step-prev-contents  .create-intervention').hide();
    $('#step-' + (currStep + 1) + ' .step-prev-contents h3').addClass('prev-tab-h3');
}

function gotoStep(step) {
    if (!step) {
        return;
    }
    let i = 0;
    for (i = 0 ; i < step ; i ++) {
        bStepChange = false;
        setTimeout(()=>{
        $("#smartwizard").smartWizard("next");
        },1000)
        //  $("#smartwizard").smartWizard("next");
    }
}

// show modality & discharge
function displayModality(){
    document.getElementById('smartwizard').classList.add('hide');
    document.getElementById('step-6').classList.remove('hide');
    document.getElementById('step-7').classList.add('hide');
    document.getElementById('step-8').classList.add('hide');
}
function displayModalityNote(){
    document.getElementById('smartwizard').classList.add('hide');
    document.getElementById('step-6').classList.add('hide');
    document.getElementById('step-7').classList.remove('hide');
    document.getElementById('step-8').classList.add('hide');
}
function displayDischarge(){
    document.getElementById('smartwizard').classList.add('hide');
    document.getElementById('step-6').classList.add('hide');
    document.getElementById('step-7').classList.add('hide');
    document.getElementById('step-8').classList.remove('hide');
}
