let goalHeading;
let arrGoalOptions = [];
let selectedGoalId = -1;
let maxGoal = 1;
let arrGoal = [];

function loadGoalHeading() {

    const params = {api:'getControl', page:'treatment_plan/edit.php', textboxid:'goals_Description'};

    $.post(selectorPath, params, function(resData){
        goalHeading = resData.data.controls;
    })
}

function clearGoal() {

    maxGoal = 1;
    selectedGoalId = -1;
    arrGoalOptions = [];
    arrGoal = [];
    $('#btn-add-goal').prop('disabled', true);

}

function loadGoalOptions(problemNumber, groupID) {

    if (!goalHeading) {
        // alert('There is no data for this');
        if (isChangingProblem) {
            checkAllLoaded();
        }
        return;
    }

    //const   params = {id1: groupID, api: 'getSelectorData', controlid: goalHeading.selectors[0].id, id2:groupID, id4: problemNumber};
    const   params = {id1: groupID, api: 'getSelectorData', controlid: goalHeading.selectors[0].id, id4: problemNumber, id0: libraryId};
    $.ajax({
        url: selectorPath,
        type: 'POST',
        data: params,
        success: function(resData){
    // $.post(selectorPath, params, function(resData) {

            arrGoalOptions = resData.data.list;
            if (arrGoalOptions) {

                $('#btn-add-goal').prop('disabled', false);

            }
            if (isChangingProblem) {
                checkAllLoaded();
            }
        }
    })
}


function loadGoal() {

    if (selectedProblemId < 0) {
        return;
    }

    const params = {form_id : form_id, api: 'getgoals', problem_id: selectedProblemId};
    $.ajax({
        url: loadPath,
        type: 'POST',
        data: params,
        success: function(resData){

    // $.post(loadPath, params, function(resData){

            maxGoal = 1;
            arrGoal = resData.data.list;
            let goalContents = "";
            selectedGoalId = -1;

            if (arrGoal) {

                arrGoal.forEach(function(element) {

                    goalContents += '<a href="#" class="list-group-item list-group-item-action">';
                    goalContents += '<div class="d-flex w-100 justify-content-between">';
                    goalContents += '<h4 class="mb-1 text-primary">';
                    goalContents += element.Description;
                    goalContents += '</h4>';
                    goalContents += '<small>';
                    goalContents += '<button class="btn btn-primary btn-sm" onclick="editGoal(' + element.id +')">Edit</button>';
                    goalContents += '<button class="btn btn-danger btn-sm"  onclick="deleteGoal(' + element.id +')">Delete</button>';
                    goalContents += '</small>';
                    goalContents += '</div>';
                    goalContents += '<p class="mb-1 status">';
                    goalContents += '<div class="row">';
                    goalContents += '<div class="col-md-2">Status : </div>';
                    goalContents += '<div class="col-md-7 text-success">' + element.goal_status + '</div>';
                    goalContents += '</div>';
                    goalContents += '<div class="row">';
                    goalContents += '<div class="col-md-2">Goal Action : </div>';
                    goalContents += '<div class="col-md-7 text-success">' + element.goal_action + '</div>';
                    goalContents += '</div>';
                    goalContents += '<div class="row">';
                    goalContents += '<div class="col-md-2">Status Description : </div>';
                    goalContents += '<div class="col-md-7 text-success">' + element.review_status + '</div>';
                    goalContents += '</div>';
                    goalContents += '</p>';
                    goalContents += '</a>';
                    maxGoal = Math.max(maxGoal, (Number(element.GoalNumber) + 1));

                });

            }

            $('#goal-contents').html(goalContents);

            if (arrGoal) {
                loadGoalList();
                selectedObjectiveGoalId = arrGoal[0].id;
            } else {
                selectedObjectiveGoalId = -1;
            }

            changeGoal(selectedObjectiveGoalId);
            loadStep();

            if (isChangingProblem) {
                checkAllLoaded();
            }

        }
    })

}

function saveGoal() {

    if ($('#modal-first-select').val() < 0) {
        alert("Please select goal");
        return;
    }

    if (selectedProblemId < 0) {
        return;
    }
    const selectedProblem = findProblemById(selectedProblemId);

    let params;

    if (selectedGoalId < 0 ) {

        params = {
            api : 'savegoals',
            id : -1,
            form_id : form_id,
            tp_problem_number : selectedProblem.tp_problem_number,
            GroupID : selectedProblem.GroupID,
            ProblemNumber : selectedProblem.ProblemNumber,
            GoalNumber : maxGoal,
            Description : $("#modal-first-select option:selected").html(),
            IsCustom : 0,
            IsDeleted : 0,
            problem_id: selectedProblem.id
        };

    } else {

        params = findGoalById(selectedGoalId);
        params.api = "savegoals"
        params.Description = $("#modal-first-select option:selected").html();
        params.problem_id = selectedProblem.id;

    }

    $.post(savePath, params, function(){
        loadGoal();
        $('#add-modal').modal('hide');
    });
}



function createNewGoal() {

    selectedGoalId = -1;

    if (!arrGoalOptions) {

        alert('There is no option');
        return;

    }

    $('#modal-title').html('New Goal');
    initGoalDialog();

}

function editGoal(id) {

    if (!arrGoalOptions || id < 0) {
        alert('There is no option');
        return;
    }

    selectedGoalId = id;

    $('#modal-title').html('Edit Goal');
    initGoalDialog();

}

function deleteGoal(id) {

    if (id < 0 || !confirm("Are you sure you want to delete this Goal?")) {
        return;
    }

    let params = findGoalById(id);
    params.IsDeleted = 1;
    params.api = "savegoals"

    $.post(savePath, params, function(){
        loadGoal();
        $('#add-modal').modal('hide');
    });

}

function findGoalById(goalId) {

    if (!arrGoal || goalId < 0) {
        return null;
    }

    let i = 0;
    for (i = 0 ; i < arrGoal.length ; i ++ ) {

        if (arrGoal[i].id == goalId) {
            return arrGoal[i];
        }

    }

    return null;

}


function initGoalDialog() {

    $('#add-modal').modal('show');

    $('#modal-primary').hide();
    $('#modal-second').hide();

    $('#modal-first-label').html(goalHeading.selectors[0].heading);

    $('#modal-first-select').empty().append("<option value='-1'>Please select goal</option>");

    arrGoalOptions.forEach(function(element) {
        $('#modal-first-select').append("<option value='" + element.value + "'>" + element.desc + "</option>");
    });

    if (selectedGoalId > -1) {

        const selectedGoal = findGoalById(selectedGoalId);

        $("#modal-first-select option").filter(function() {

            return $(this).text() == selectedGoal.Description;

          }).prop('selected', true);

    }

    $('#btn-save').off('click');

    $('#btn-save').on('click', function() {
        saveGoal();
    });

}
