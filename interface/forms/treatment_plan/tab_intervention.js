let interventionHeading;
let arrinterventionOptions = [];
let selectedInterventionId = -1;
let maxintervention = 1;
let arrintervention = [];
let selectedInterventionObjectiveId = -1;

function loadInterventionHeading() {

    const params = {api:'getControl', page:'treatment_plan/edit.php', textboxid:'interventions_Description'};

    $.post(selectorPath, params, function(resData){
        interventionHeading = resData.data.controls;
    })
}

function clearIntervention() {

    maxintervention = 1;
    selectedInterventionId = -1;
    arrinterventionOptions = [];
    arrintervention = [];
    $('#btn-add-intervention').prop('disabled', true);

}

function loadObjectiveList() {
    // Initialize Objective list
    $('#objective-tab').html('');

    let objectiveTab = '';

    arrObjective.forEach(function(objective) {
        const id = objective.id;

        objectiveTab += `
            <a class='list-group-item list-group-item-action' 
                id='objective_${id}' 
                href='#' 
                onclick='changeObjective(${id})'
            >
                ${objective.Description}
            </a>`;
    });
    $('#objective-tab').html(objectiveTab);
}

function changeObjective(objectiveId) {
    if (objectiveId > -1) {
        const selectedObjective = findObjectiveById(objectiveId);
        const { ProblemNumber, GroupID, ObjectiveNumber } = selectedObjective;

        loadInterventionOptions(ProblemNumber, GroupID, ObjectiveNumber, objectiveId);
        loadIntervention(objectiveId);
    } else {
        $("#btn-add-intervention").attr('disabled', true);
    }
    selectedInterventionObjectiveId = objectiveId;
}

function loadInterventionOptions(problemNumber, groupID, objectiveNumber, objectiveId) {

    if (!interventionHeading) {
        // alert('There is no data for this');
        return;
    }

    //const   params = {id1: groupID, api: 'getSelectorData', controlid: interventionHeading.selectors[0].id, id2:groupID, id4: problemNumber, id5: objectiveNumber};
    const   params = {id1: groupID, api: 'getSelectorData', controlid: interventionHeading.selectors[0].id,id4: problemNumber, id5: objectiveNumber, id0: libraryId};
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

            arrObjective[objectiveIndex].arrinterventionOptions = resData.data.list;
            if (arrObjective[objectiveIndex].arrinterventionOptions) {
                $('#btn-add-intervention').prop('disabled', false);
            } else {
                $('#btn-add-intervention').prop('disabled', true);
            }
        }
    })
}


function loadIntervention(id) {
    
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
            arrObjective[objectiveIndex].maxintervention = 1;
            arrObjective[objectiveIndex].arrintervention = resData.data.list;

            let interventionContents = "";
            
            selectedInterventionId = -1;

            if (arrObjective[objectiveIndex].arrintervention) {

                arrObjective[objectiveIndex].arrintervention.forEach(function(element) {

                    interventionContents += '<li class="list-group-item d-flex justify-content-between align-items-center">';
                    interventionContents += element.Description;
                    interventionContents += '<button class="btn btn-primary btn-sm" onclick="editintervention(' + id + ',' + element.id + ')">Edit</button>';
                    interventionContents += '<button class="btn btn-danger btn-sm"  onclick="deleteintervention(' + id + ',' + element.id + ')">Delete</button>';
                    interventionContents += '</li>';
                    
                    arrObjective[objectiveIndex].maxintervention = Math.max(arrObjective[objectiveIndex].maxintervention, (Number(element.InterventionNumber) + 1));

                });

            }

            $('#intervention-contents').html(interventionContents);
            loadStep();
        }
    })

}

function saveIntervention() {
    
    if ($('#modal-first-select').val() < 0) {
        alert("Please select intervention");
        return;
    }

    if (selectedProblemId < 0 || selectedInterventionObjectiveId < 0) {
        return;
    }
    const selectedProblem = findProblemById(selectedProblemId);
    const objectiveId = findObjectiveById(selectedInterventionObjectiveId, true);
    let params;

    if (selectedInterventionId < 0 ) {

        params = {
            api : 'saveinterventions',
            id : -1,
            form_id : form_id,
            tp_problem_number : selectedProblem.tp_problem_number,
            GroupID : selectedProblem.GroupID,
            ProblemNumber : selectedProblem.ProblemNumber,
            InterventionNumber : arrObjective[objectiveId].maxintervention,
            Description : $("#modal-first-select option:selected").html(),
            IsCustom : 0,
            IsDeleted : 0, 
            IsEvidenceBased : 0,
            ObjectiveID : selectedInterventionObjectiveId,
            problem_id: selectedProblem.id
        };

    } else {

        params = findInterventionById(selectedInterventionObjectiveId, selectedInterventionId);
        params.api = "saveinterventions"
        params.Description = $("#modal-first-select option:selected").html();
        params.problem_id = selectedProblem.id;
        params.ObjectiveID = selectedInterventionObjectiveId;
    }

    $.post(savePath, params, function(){
        loadIntervention(selectedInterventionObjectiveId);
        $('#add-modal').modal('hide');
    });
}



function createNewIntervention() {

    selectedInterventionId = -1;

    if (!arrinterventionOptions) {
        return;
    }

    $('#modal-title').html('New Intervention');
    initinterventionDialog();

}

function editintervention(objectiveId, id) {

    if ( id < 0) {
        return;
    }

    selectedInterventionId = id;
    selectedInterventionObjectiveId = objectiveId;

    $('#modal-title').html('Edit Intervention');
    initinterventionDialog();
    
}

function deleteintervention(objectiveId, id) {
    
    if (id < 0 || !confirm("Are you sure you want to delete this Intervention?")) {
        return;
    }

    let params = findInterventionById(objectiveId, id);
    params.IsDeleted = 1;
    params.api = "saveinterventions"

    $.post(savePath, params, function(){
        loadIntervention(objectiveId);
        $('#add-modal').modal('hide');
    });

}

function findInterventionById(objectiveId, interventionId) {
    const objectiveIndex = findObjectiveById(objectiveId, true);
    if(!arrObjective[objectiveIndex]) {
        return;
    }

    if (!arrObjective[objectiveIndex].arrintervention || interventionId < 0) {
        return null;
    }

    let i = 0;
    for (i = 0 ; i < arrObjective[objectiveIndex].arrintervention.length ; i ++ ) {

        if (arrObjective[objectiveIndex].arrintervention[i].id == interventionId) {
            return arrObjective[objectiveIndex].arrintervention[i];
        }

    }

    return null;

}


function initinterventionDialog() {
    const objectiveIndex = findObjectiveById(selectedInterventionObjectiveId, true);

    if(!arrObjective[objectiveIndex].arrinterventionOptions) {
        return;
    }

    $('#add-modal').modal('show');

    $('#modal-primary').hide();
    $('#modal-second').hide();

    $('#modal-first-label').html(interventionHeading.selectors[0].heading);
    
    $('#modal-first-select').empty().append("<option value='-1'>Please select intervention</option>");
    
    arrObjective[objectiveIndex].arrinterventionOptions.forEach(function(element) {
        $('#modal-first-select').append("<option value='" + element.value + "'>" + element.desc + "</option>");
    });

    if (selectedInterventionId > -1) {

        const selectedintervention = findInterventionById(selectedInterventionObjectiveId, selectedInterventionId);

        $("#modal-first-select option").filter(function() {
        
            return $(this).text() == selectedintervention.Description;

          }).prop('selected', true);

    }

    $('#btn-save').off('click');

    $('#btn-save').on('click', function() {
        saveIntervention();
    });

}