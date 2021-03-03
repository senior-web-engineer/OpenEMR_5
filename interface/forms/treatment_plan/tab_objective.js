let objectiveHeading;
let arrObjectiveOptions = [];
let selectedObjectiveId = -1;
let maxObjective = 1;
let arrObjective = [];
let selectedObjectiveGoalId = -1;
let loadingObjective = false;

function loadObjectiveHeading() {

    const params = {api:'getControl', page:'treatment_plan/edit.php', textboxid:'objectives_Description'};

    $.post(selectorPath, params, function(resData){
        objectiveHeading = resData.data.controls;
    })
}

function clearObjective() {

    maxObjective = 1;
    selectedObjectiveId = -1;
    arrObjectiveOptions = [];
    arrObjective = [];
    $('#btn-add-objective').prop('disabled', true);

}

function loadGoalList() {
    // Initialize Goal list
    $('#goal-tab').html('');

    let goalTab = '';

    arrGoal.forEach(function(goal) {
        const id = goal.id;

        goalTab += `
            <a class='list-group-item list-group-item-action' 
                id='objective_${id}' 
                href='#' 
                onclick='changeGoal(${id})'
            >
                ${goal.Description}
            </a>`;
    });
    $('#goal-tab').html(goalTab);
    
}

function changeGoal(goalId) {
    if (goalId > -1) {
        const selectedGoal = findGoalById(goalId);
        const { ProblemNumber, GroupID } = selectedGoal;

        loadObjectiveOptions(ProblemNumber, GroupID);
        loadObjective(goalId);
    } else {
        $("#btn-add-objective").attr('disabled', true);
    }
    
    selectedObjectiveGoalId = goalId;
}

function loadObjectiveOptions(problemNumber, groupID) {

    if (!objectiveHeading) {
        // alert('There is no data for this');
        if (isChangingProblem) {
            checkAllLoaded();
        }
        return;
    }

    //const   params = {id1: groupID, api: 'getSelectorData', controlid: objectiveHeading.selectors[0].id, id2:groupID, id4: problemNumber};
    const   params = {id1: groupID, api: 'getSelectorData', controlid: objectiveHeading.selectors[0].id, id4: problemNumber, id0: libraryId};

    $.ajax({
        url: selectorPath,
        type: 'POST',
        data: params,
        success: function(resData){

    // $.post(selectorPath, params, function(resData) {

            arrObjectiveOptions = resData.data.list;
            if (arrObjectiveOptions) {
                $('#btn-add-objective').prop('disabled', false);
            } else {
                $('#btn-add-objective').prop('disabled', true);
            }

            if (isChangingProblem) {
                checkAllLoaded();
            }
    
        }
    })
}


function loadObjective(goalId) {
    loadingObjective = true;

    if (selectedProblemId < 0) {
        return;
    }

    const params = { form_id : form_id, api: 'getobjectives', problem_id: selectedProblemId, goals_id: goalId };
    $.ajax({
        url: loadPath,
        type: 'POST',
        data: params,
        success: function(resData){

        // $.post(loadPath, params, function(resData){
            maxObjective = 1;
            arrObjective = resData.data.list;
            let objectiveContents = "";
            selectedObjectiveId = -1;

            if (arrObjective) {

                arrObjective.forEach(function(element) {

                    objectiveContents += '<a href="#" class="list-group-item list-group-item-action" id="objective-content_' + element.id +'">';
//                   objectiveContents += '<a href="#" class="list-group-item list-group-item-action" id="objective-content_' + element.id +'" onclick="changeObjective(' + element.id + ',' + element.ObjectiveNumber + ')">';
                    objectiveContents += '<div class="d-flex w-100 justify-content-between">';
                    objectiveContents += '<h4 class="mb-1 text-primary">';
                    objectiveContents += element.Description;
                    objectiveContents += '</h4>';
                    objectiveContents += '<small>';
                    objectiveContents += '<button class="btn btn-primary btn-sm" onclick="editObjective(' + element.id + ')">Edit</button>';
                    objectiveContents += '<button class="btn btn-danger btn-sm"  onclick="deleteObjective(' + element.id + ')">Delete</button>';
                    objectiveContents += '</small>';
                    objectiveContents += '</div>';
                    objectiveContents += '<p class="mb-1 status">';
                    objectiveContents += '<div class="row">';
                    objectiveContents += '<div class="col-md-2">Target Date : </div>';
                    objectiveContents += '<div class="col-md-7 text-success">' + element.target_date + '</div>';
                    objectiveContents += '</div>';
                    objectiveContents += '<div class="row">';
                    objectiveContents += '<div class="col-md-2">Sessions : </div>';
                    objectiveContents += '<div class="col-md-7 text-success">' + element.sessions + '</div>';
                    objectiveContents += '</div>';
                    objectiveContents += '</p>';
                    objectiveContents += '</a>';

                    maxObjective = Math.max(maxObjective, (Number(element.ObjectiveNumber) + 1));

                });
                // $('#objective-contents').html(objectiveContents);
                // changeObjective(arrObjective[0].id, arrObjective[0].ObjectiveNumber);
            }
                // $('#objective-contents').html(objectiveContents);
                // changeObjective(-1, -1);
            
            $('#objective-contents').html(objectiveContents);
            
            if (arrObjective) {
                selectedInterventionObjectiveId = arrObjective[0].id;
                loadObjectiveList();
            } else {
                selectedInterventionObjectiveId = -1;
            }

            changeObjective(selectedInterventionObjectiveId);
            loadStep();
            
            if (isChangingProblem) {
                checkAllLoaded();
            }
            loadingObjective = false;
        },
        error: function(xhr, status, error){
            loadingObjective = false;
        }
    })

}

function saveObjective() {
    
    if ($("#objective-select").val() < 0 || !$('#objectiveTargetDate').val() || Number($('#objectiveNoSession')).val < 0) {
        alert("Please insert correct value");
        return;
    }

    if (selectedProblemId < 0) {
        return;
    }
    const selectedProblem = findProblemById(selectedProblemId);
    
    let params;

    if (selectedObjectiveId < 0 ) {

        params = {
            api : 'saveobjectives',
            id : -1,
            form_id : form_id,
            tp_problem_number : selectedProblem.tp_problem_number,
            target_date : $('#objectiveTargetDate').val(),
            sessions : $('#objectiveNoSession').val(),
            IsCritical : 0,
            GroupID : selectedProblem.GroupID,
            ProblemNumber : selectedProblem.ProblemNumber,
            ObjectiveNumber : maxObjective,
            Description : $("#objective-select option:selected").html(),
            IsCustom : 0,
            IsEvidenceBased : 0,
            IsDeleted : 0, 
            problem_id: selectedProblem.id,
            goals_id: selectedObjectiveGoalId
        };

    } else {

        params = findObjectiveById(selectedObjectiveId);
        params.api = "saveobjectives"
        params.Description = $("#objective-select option:selected").html();
        params.problem_id = selectedProblem.id;
        params.target_date = $('#objectiveTargetDate').val();
        params.sessions = $('#objectiveNoSession').val();

    }

    $.post(savePath, params, function(response){
        loadObjective(selectedObjectiveGoalId);
        $('#objective-modal').modal('hide');
    });
}



function createNewObjective() {

    selectedObjectiveId = -1;

    if (!arrObjectiveOptions) {
        
        alert('There is no option');
        return;

    }

    $('#objective-title').html('New Objective');
    initObjectiveDialog();

}

function editObjective(id) {

    if (!arrObjectiveOptions || id < 0) {
        alert('There is no option');
        return;
    }

    selectedObjectiveId = id;
    
    $('#objective-title').html('Edit Objective');
    initObjectiveDialog();
    
}

function deleteObjective(id) {
    
    if (id < 0 || !confirm("Are you sure you want to delete this Objective?")) {
        return;
    }

    let params = findObjectiveById(id);
    params.IsDeleted = 1;
    params.api = "saveobjectives"

    $.post(savePath, params, function(){
        loadObjective(selectedObjectiveGoalId);
        $('#objective-modal').modal('hide');
    });

}

function findObjectiveById(objectiveId, isParam = false) {

    if (!arrObjective || objectiveId < 0) {
        return null;
    }

    let i = 0;
    for (i = 0 ; i < arrObjective.length ; i ++ ) {

        if (arrObjective[i].id == objectiveId) {
            if (isParam) {
                return i;
            }
            return arrObjective[i];
        }

    }

    return null;

}


function initObjectiveDialog() {

    $('#objective-modal').modal('show');

    $('#objective-label').html(objectiveHeading.selectors[0].heading);
    $('#objectiveNoSession').val("1");
    $('#objective-select').empty().append("<option value='-1'>Please select objective</option>");
    
    arrObjectiveOptions.forEach(function(element) {
        $('#objective-select').append("<option value='" + element.value + "'>" + element.desc + "</option>");
    });
    
    if (selectedObjectiveId > -1) {

        const selectedObjective = findObjectiveById(selectedObjectiveId);

        $("#objective-select option").filter(function() {
        
            return $(this).text() == selectedObjective.Description;

          }).prop('selected', true);

        $('#objectiveTargetDate').val(selectedObjective.target_date);
        $('#objectiveNoSession').val(selectedObjective.sessions);

    }

}

// function changeObjective(id, objectiveNumber) {

//     $('#objective-contents .focus-active').removeClass('focus-active');
//     $('#objective-content_' + id).addClass('focus-active');

//     if (id < 0 || objectiveNumber < 0) {
//         $('#intervention-containter').hide();
//         return;
//     }

//     selectedObjectiveId = id;
//     $('#intervention-containter').show();

//     const selectedProblem = findProblemById(selectedProblemId);
//     loadInventionOptions(selectedProblem.ProblemNumber, selectedProblem.GroupID, objectiveNumber, id);
//     loadInvention(id);
// }