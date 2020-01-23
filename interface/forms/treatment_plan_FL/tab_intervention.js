let inventionHeading;
let arrInventionOptions = [];
let selectedInventionId = -1;
let maxInvention = 1;
let arrInvention = [];

function loadInventionHeading() {

    const params = {api:'getControl', page:'treatment_plan/edit.php', textboxid:'interventions_Description'};

    $.post(selectorPath, params, function(resData){
        inventionHeading = resData.data.controls;
    })
}

function clearInvention() {

    maxInvention = 1;
    selectedInventionId = -1;
    arrInventionOptions = [];
    arrInvention = [];
    $('#btn-add-invention').prop('disabled', true);

}

function loadInventionOptions(problemNumber, groupID, objectiveNumber, objectiveId) {

    if (!inventionHeading) {
        // alert('There is no data for this');
        return;
    }

    //const   params = {id1: groupID, api: 'getSelectorData', controlid: inventionHeading.selectors[0].id, id2:groupID, id4: problemNumber, id5: objectiveNumber};
    const   params = {id1: groupID, api: 'getSelectorData', controlid: inventionHeading.selectors[0].id,id4: problemNumber, id5: objectiveNumber, id0: libraryId};
    $.ajax({
        url: selectorPath,
        type: 'POST',
        data: params,
        success: function(resData){

    // $.post(selectorPath, params, function(resData) {
            const objectiveIndex = findObjectiveById(objectiveId, true);
            if(!arrObjective[objectiveIndex]) {
                return;
            }

            arrObjective[objectiveIndex].arrInventionOptions = resData.data.list;
            if (arrObjective[objectiveIndex].arrInventionOptions) {

                $('#btn-add-invention-' + objectiveId).prop('disabled', false);

            }
        }
    })
}


function loadInvention(id) {
    
    if (selectedProblemId < 0) {
        return;
    }

    const params = {form_id : form_id, api: 'getinterventions', problem_id: selectedProblemId, ObjectiveID: id};
    
    // $.post(loadPath, params, function(resData){
    $.ajax({
        url: loadPath,
        type: 'POST',
        data: params,
        success: function(resData){
    
            const objectiveIndex = findObjectiveById(id, true);
            if(!arrObjective[objectiveIndex]) {
                return;
            }
            arrObjective[objectiveIndex].maxInvention = 1;
            arrObjective[objectiveIndex].arrInvention = resData.data.list;
            let inventionContents = "";
            selectedInventionId = -1;

            if (arrObjective[objectiveIndex].arrInvention) {

                arrObjective[objectiveIndex].arrInvention.forEach(function(element) {

                    inventionContents += '<li class="list-group-item d-flex justify-content-between align-items-center">';
                    inventionContents += element.Description;
                    inventionContents += '<button class="btn btn-primary btn-sm" onclick="editInvention(' + id + ',' + element.id + ')">Edit</button>';
                    inventionContents += '<button class="btn btn-danger btn-sm"  onclick="deleteInvention(' + id + ',' + element.id + ')">Delete</button>';
                    inventionContents += '</li>';
                    
                    arrObjective[objectiveIndex].maxInvention = Math.max(arrObjective[objectiveIndex].maxInvention, (Number(element.InterventionNumber) + 1));

                });

            }

            $('#objective-interventions-'+id).html(inventionContents);
            loadStep();
        }
    })

}

function saveInvention() {
    
    if ($('#modal-first-select').val() < 0) {
        alert("Please select intervention");
        return;
    }

    if (selectedProblemId < 0 || selectedObjectiveId < 0) {
        return;
    }
    const selectedProblem = findProblemById(selectedProblemId);
    const objectiveId = findObjectiveById(selectedObjectiveId, true);
    let params;

    if (selectedInventionId < 0 ) {

        params = {
            api : 'saveinterventions',
            id : -1,
            form_id : form_id,
            tp_problem_number : selectedProblem.tp_problem_number,
            GroupID : selectedProblem.GroupID,
            ProblemNumber : selectedProblem.ProblemNumber,
            InterventionNumber : arrObjective[objectiveId].maxInvention,
            Description : $("#modal-first-select option:selected").html(),
            IsCustom : 0,
            IsDeleted : 0, 
            IsEvidenceBased : 0,
            ObjectiveID : selectedObjectiveId,
            problem_id: selectedProblem.id
        };

    } else {

        params = findInventionById(selectedObjectiveId, selectedInventionId);
        params.api = "saveinterventions"
        params.Description = $("#modal-first-select option:selected").html();
        params.problem_id = selectedProblem.id;
        params.ObjectiveID = selectedObjectiveId;
    }

    $.post(savePath, params, function(){
        loadInvention(selectedObjectiveId);
        $('#add-modal').modal('hide');
    });
}



function createNewInvention(objectiveId) {

    selectedInventionId = -1;

    // if (!arrInventionOptions) {
        
    //     return;

    // }
    selectedObjectiveId = objectiveId;
    $('#modal-title').html('New Intervention');
    initInventionDialog();

}

function editInvention(objectiveId, id) {

    if ( id < 0) {
        return;
    }

    selectedInventionId = id;
    selectedObjectiveId = objectiveId;

    $('#modal-title').html('Edit Intervention');
    initInventionDialog();
    
}

function deleteInvention(objectiveId, id) {
    
    if (id < 0 || !confirm("Are you sure you want to delete this Intervention?")) {
        return;
    }

    let params = findInventionById(objectiveId, id);
    params.IsDeleted = 1;
    params.api = "saveinterventions"

    $.post(savePath, params, function(){
        loadInvention(objectiveId);
        $('#add-modal').modal('hide');
    });

}

function findInventionById(objectiveId, inventionId) {
    const objectiveIndex = findObjectiveById(objectiveId, true);
    if(!arrObjective[objectiveIndex]) {
        return;
    }

    if (!arrObjective[objectiveIndex].arrInvention || inventionId < 0) {
        return null;
    }

    let i = 0;
    for (i = 0 ; i < arrObjective[objectiveIndex].arrInvention.length ; i ++ ) {

        if (arrObjective[objectiveIndex].arrInvention[i].id == inventionId) {
            return arrObjective[objectiveIndex].arrInvention[i];
        }

    }

    return null;

}


function initInventionDialog() {
    const objectiveIndex = findObjectiveById(selectedObjectiveId, true);
    if(!arrObjective[objectiveIndex].arrInventionOptions) {
        return;
    }

    $('#add-modal').modal('show');

    $('#modal-primary').hide();
    $('#modal-second').hide();

    $('#modal-first-label').html(inventionHeading.selectors[0].heading);
    
    $('#modal-first-select').empty().append("<option value='-1'>Please select intervention</option>");
    
    arrObjective[objectiveIndex].arrInventionOptions.forEach(function(element) {
        $('#modal-first-select').append("<option value='" + element.value + "'>" + element.desc + "</option>");
    });

    if (selectedInventionId > -1) {

        const selectedInvention = findInventionById(selectedObjectiveId, selectedInventionId);

        $("#modal-first-select option").filter(function() {
        
            return $(this).text() == selectedInvention.Description;

          }).prop('selected', true);

    }

    $('#btn-save').off('click');

    $('#btn-save').on('click', function() {
        saveInvention();
    });

}