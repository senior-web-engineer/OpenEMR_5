const selectorPath = window.location.origin + "/openemr/library/textimporter/textimporterdata.php";
const savePath = "save.php";
const loadPath = "get.php";

let   arrProblem = [];
let   problemHeading = null;
let   arrLibrary = null;
let   maxProblem = 1;
let   form_id = 0;
let   selectedProblemId = -1;
let   currTab = 0;
let   totalLoadCnt = 0;
let   isChangingProblem = false;

let   libraryId = -1;

$(function() {
    
    form_id = $('#form-id').val();
    
    loadHeading();
    loadBehaviorHeading();
    loadGoalHeading();
    loadObjectiveHeading();
    loadInterventionHeading();
    loadDiagnosisHeading();
    loadProblem();

});

function loadHeading() {

    const paramsHeading = {api:'getControl', page:'treatment_plan/edit.php', textboxid:'problems_Description'};

    $.post(selectorPath, paramsHeading, function(resData){
        problemHeading = resData.data.controls;
        loadLibrary();
    })
}

function loadLibrary() {

    let   paramsLibrary = {id1: form_id, api: 'getSelectorData', controlid: problemHeading.selectors[0].id};

    $.post(selectorPath, paramsLibrary, function(resData){
        arrLibrary = resData.data;
        $('#btn-new-problem').prop('disabled', false);
    })
}

function loadLibraryProblem() {

    const paramsProblem = {id1: form_id, api: 'getSelectorData', controlid: problemHeading.selectors[1].id, id0: libraryId, id2: libraryId};
        
    $.post(selectorPath, paramsProblem, function(resData){

        $('#modal-first-select').empty().append("<option value='-1'>Please select problem</option>");

        if (resData.data.list) {
            resData.data.list.forEach(function(element) {

                $('#modal-first-select').append("<option value='" + element.value + "'>" + element.desc + "</option>");
    
            });
        }

        if (selectedProblemId > -1) {

            const selectedProblem = findProblemById(selectedProblemId);

            $("#modal-first-select option").filter(function() {
            
                return $(this).text() == selectedProblem.Description;
    
              }).prop('selected', true);
    
        }
    });

}

function loadProblem() {
    
    const params = {form_id : form_id, api: 'getproblems'};
    
    $.post(loadPath, params, function(resData){
    
        maxProblem = 1;
        arrProblem = resData.data.list;
        let problemTab = "";
        selectedProblemId = -1;

        if (arrProblem) {

            arrProblem.forEach(function(element) {
                const id = element.id;
                problemTab += "<a class='list-group-item list-group-item-action' id='problem_" + id + "' href='#' onclick='changeProblem(" + id + ")'>" + element.Description + "</a>";
                maxProblem = Math.max(maxProblem, (Number(element.IsPrimary) + 1));

            });

        }

        $('#problem-tab').html(problemTab);

        if (arrProblem) {
            selectedProblemId = arrProblem[0].id;
            libraryId = arrProblem[0].GroupID;
        }

        changeProblem(selectedProblemId);
    })

}

// events
function createNewProblem() {
    
    if (libraryId < 0) {
        showSelectLibrary();
    } else {
        showCreateProblemDlg();
    }
}


function editProblem() {

    if (!problemHeading || !arrLibrary || selectedProblemId < 0) {
        return;
    }

    $('#add-modal-title').html('Edit Problem');
    
    initDialog();

}

function deleteProblem() {

    if (selectedProblemId < 0 || !confirm("Are you sure you want to delete this Problem?")) {
        return;
    }
    
    let params = findProblemById(selectedProblemId);
    params.IsDeleted = 1;
    params.api = "saveproblems"

    $.post(savePath, params, function(){
        loadProblem();
        $('#add-modal').modal('hide');
    });

}

function updateProblemTab() {
    const indx = findProblemById(selectedProblemId, true);
    if (indx < 0) {
        return;
    }

    arrProblem[indx].tabIndx = currTab;

    const params = {
        api : 'saveproblemstab',
        tabIndx : currTab,
        id : selectedProblemId
    }
    
    $.post(savePath, params, function(){
    });
}

function saveProblem() {
    
    if ($("#modal-first-select").val() < 0 || libraryId < 0 || Number($('#IsPrimary').val()) < 1) {
        alert("Please insert correct value");
        return;
    }

    let params;

    if (selectedProblemId < 0 ) {

        params = {
            api : 'saveproblems',
            id : -1,
            form_id : form_id,
            tp_problem_number : $("#modal-first-select").val(),
            GroupID : libraryId,
            ProblemNumber : $("#modal-first-select").val(),
            Description : $("#modal-first-select option:selected").html(),
            approach_note : '',
            IsCustom : 0,
            IsDeleted : 0, 
            IsPrimary : maxProblem,
        };

    } else {

        params = findProblemById(selectedProblemId);
        params.api = "saveproblems"
        params.GroupID = libraryId;
        params.Description = $("#modal-first-select option:selected").html();

    }

    $.post(savePath, params, function(){
        loadProblem();
        $('#add-modal').modal('hide');
    });

}

function changeProblem(problemId) {

    $('#loading').modal('show');
    cleanSteps();

    $('#problem-tab .active').removeClass('active');

    if (problemId > -1) {

        $('#problem-tab #problem_' + problemId).addClass('active');
        $('#btn-edit-problem').prop('disabled', false);
        $('#btn-delete-problem').prop('disabled', false);

    } else {

        $('#btn-edit-problem').prop('disabled', true);
        $('#btn-delete-problem').prop('disabled', true);

    }

    selectedProblemId = problemId;
    totalLoadCnt = 0;
    isChangingProblem = true;

    const selectedProblem = findProblemById(problemId);

    if (!selectedProblem) {
        
        clearBehavior();
        clearObjective();
        clearInvention();
        clearModality();
        clearModalityNote();
        clearDischarge();
        $('#loading').modal('hide');
        return;
    }

    currTab = selectedProblem.tabIndx;

    loadBehaviorOptions(selectedProblem.ProblemNumber, selectedProblem.GroupID);
    loadBehavior();

    loadGoalOptions(selectedProblem.ProblemNumber, selectedProblem.GroupID);
    loadGoal();

    loadModality();
    loadModalityNotes();
    
    loadDischarge();

    loadDiagnosisOptions(selectedProblem.ProblemNumber, selectedProblem.GroupID);
    loadDiagnosis();

    
}

function checkAllLoaded() {
    if (totalLoadCnt >= 8) {
        gotoStep(currTab);
        isChangingProblem = false;
        $('#loading').modal('hide');
    } else {
        totalLoadCnt++;
    }
}

function findProblemById(problemId, isIndx = false) {

    if (!arrProblem || problemId < 0) {
        return null;
    }

    let i = 0;
    for (i = 0 ; i < arrProblem.length ; i ++ ) {

        if (arrProblem[i].id == problemId) {
            if (isIndx) {
                return i;
            }
            return arrProblem[i];
        }

    }

    return null;

}


function initDialog() {

    $('#add-modal').modal('show');

    $('#modal-primary').hide();
    $('#modal-first').show();
    $('#modal-second').hide();

    $('#IsPrimary').val(selectedProblemId > -1 ? findProblemById(selectedProblemId).IsPrimary : maxProblem);
    $('#modal-first-label').html(problemHeading.selectors[1].heading);
    
    $('#modal-first-select').empty().append("<option value='-1'>Please select problem</option>");
    
    $('#btn-save').off('click');

    $('#btn-save').on('click', function() {
        saveProblem();
    });
/*
    if (selectedProblemId >= 0) {
        
        const selectedProblem = findProblemById(selectedProblemId);

        $('#modal-first-select').val(selectedProblem.GroupID);

        loadLibraryProblem();
        
    }
*/
    loadLibraryProblem();

}

function showSelectLibrary() {
    if (!problemHeading || !arrLibrary) {
        return;
    }
    $('#modal-title').html('Select Library');
    $('#add-modal').modal('show');

    $('#modal-primary').hide();
    $('#modal-second').hide();
    $('#modal-first').show();

    $('#modal-first-label').html(problemHeading.selectors[0].heading);
    
    $('#modal-first-select').empty().append("<option value='-1'>Please select library</option>");
    
    arrLibrary.list.forEach(function(element) {
        $('#modal-first-select').append("<option value='" + element.value + "'>" + element.desc + "</option>");
    });

    $('#modal-first-select').off('change');
    $('#btn-save').off('click');

    $('#btn-save').on('click', function() {
        if ($('#modal-first-select').val() < 0) {
            alert("You have to select library before create problem!");
            return;
        }
        libraryId = $('#modal-first-select').val();
        showCreateProblemDlg();
    });
}

function showCreateProblemDlg() {
    if (!problemHeading) {
        return;
    }

    selectedProblemId = -1;
    // changeProblem(selectedProblemId);

    $('#modal-title').html('New Problem');

    initDialog();
}