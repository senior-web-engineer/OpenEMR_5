let diagnosisHeading;
let arrDiagnosisOptions = [];
let selectedDiagnosisId = -1;
let arrDiagnosis = [];

function loadDiagnosisHeading() {

    const params = {api:'getControl', page:'treatment_plan/edit.php', textboxid:'diagnosis_Description'};

    $.post(selectorPath, params, function(resData){
        diagnosisHeading = resData.data.controls;
    })
}

function clearDiagnosis() {

    selectedDiagnosisId = -1;
    arrDiagnosisOptions = [];
    arrDiagnosis = [];
    $('#btn-add-diagnosis').prop('disabled', true);

}

function loadDiagnosisOptions() {

    if (!diagnosisHeading) {
        // alert('There is no data for this');
        if (isChangingProblem) {
            checkAllLoaded();
        }
        return;
    }

    const   params = {id1: form_id, api: 'getSelectorData', controlid: diagnosisHeading.selectors[0].id, id0: libraryId};
    $.ajax({
        url: selectorPath,
        type: 'POST',
        data: params,
        success: function(resData){

    // $.post(selectorPath, params, function(resData) {

            arrDiagnosisOptions = resData.data.list;
            if (arrDiagnosisOptions) {

                $('#btn-add-diagnosis').prop('disabled', false);

            }
            if (isChangingProblem) {
                checkAllLoaded();
            }
    
        }
    });
}


function loadDiagnosis() {
    
    if (selectedProblemId < 0) {
        return;
    }

    //const params = {form_id : form_id, api: 'getdiagnosis', problem_id: selectedProblemId};
    const params = {form_id : form_id, api: 'getdiagnosis'};
    $.ajax({
        url: loadPath,
        type: 'POST',
        data: params,
        success: function(resData){

    // $.post(loadPath, params, function(resData){
            arrDiagnosis = resData.data.list;
            let diagnosisContents = "";
            selectedDiagnosisId = -1;

            if (arrDiagnosis) {

                arrDiagnosis.forEach(function(element) {

                    diagnosisContents += '<li class="list-group-item d-flex justify-content-between align-items-center">';
                    diagnosisContents += element.Description;
                    diagnosisContents += '<button class="btn btn-primary btn-sm" onclick="editDiagnosis(' + element.id + ')">Edit</button>';
                    diagnosisContents += '<button class="btn btn-danger btn-sm"  onclick="deleteDiagnosis(' + element.id + ')">Delete</button>';
                    diagnosisContents += '</li>';

                });

            }

            $('#diagnosis-contents').html(diagnosisContents);
            loadStep();
            if (isChangingProblem) {
                checkAllLoaded();
            }
    
        }
    }); 

}

function saveDiagnosis() {
    
    if ($('#modal-first-select').val() < 0) {
        alert("Please select axis");
        return;
    }

    if (selectedProblemId < 0) {
        return;
    }
    const selectedProblem = findProblemById(selectedProblemId);
    
    let params;

    if (selectedDiagnosisId < 0 ) {

        params = {
            api : 'savediagnosis',
            id : -1,
            form_id : form_id,
            tp_problem_number : selectedProblem.tp_problem_number,
            GroupID : selectedProblem.GroupID,
            Description : $("#modal-first-select option:selected").html(),
            LegalCode : $("#modal-first-select option:selected").html().split(' ')[0],
            IsDeleted : 0
//            problem_id: selectedProblemId
        };

    } else {

        params = findDiagnosisById(selectedDiagnosisId);
        params.api = "savediagnosis"
        params.Description = $("#modal-first-select option:selected").html();
        params.LegalCode = $("#modal-first-select option:selected").html().split(' ')[0];
//        params.problem_id = selectedProblemId;

    }

    $.post(savePath, params, function(){
        loadDiagnosis();
        $('#add-modal').modal('hide');
    });
}



function createNewDiagnosis() {

    selectedDiagnosisId = -1;

    if (!arrDiagnosisOptions) {

        alert('There is no option');
        return;

    }

    $('#modal-title').html('New Diagnosis');
    initDiagnosisDialog();

}

function editDiagnosis(id) {

    if (!arrDiagnosisOptions || id < 0) {
        alert('There is no option');
        return;
    }

    selectedDiagnosisId = id;
    
    $('#modal-title').html('Edit Diagnosis');
    initDiagnosisDialog();
    
}

function deleteDiagnosis(id) {
    
    if (id < 0 || !confirm("Are you sure you want to delete this Diagnosis?")) {
        return;
    }

    let params = findDiagnosisById(id);
    params.IsDeleted = 1;
    params.api = "savediagnosis"

    $.post(savePath, params, function(){
        loadDiagnosis();
        $('#add-modal').modal('hide');
    });

}

function findDiagnosisById(diagnosisId) {

    if (!arrDiagnosis || diagnosisId < 0) {
        return null;
    }

    let i = 0;
    for (i = 0 ; i < arrDiagnosis.length ; i ++ ) {

        if (arrDiagnosis[i].id == diagnosisId) {
            return arrDiagnosis[i];
        }

    }

    return null;

}


function initDiagnosisDialog() {

    $('#add-modal').modal('show');

    $('#modal-primary').hide();
    $('#modal-second').hide();

    $('#modal-first-label').html(diagnosisHeading.selectors[0].heading);
    
    $('#modal-first-select').empty().append("<option value='-1'>Please select diagnosis</option>");
    
    arrDiagnosisOptions.forEach(function(element) {
        $('#modal-first-select').append("<option value='" + element.value + "'>" + element.desc + "</option>");
    });

    if (selectedDiagnosisId > -1) {

        const selectedDiagnosis = findDiagnosisById(selectedDiagnosisId);

        $("#modal-first-select option").filter(function() {
        
            return $(this).text() == selectedDiagnosis.Description;

          }).prop('selected', true);

    }

    $('#btn-save').off('click');

    $('#btn-save').on('click', function() {
        saveDiagnosis();
    });

}