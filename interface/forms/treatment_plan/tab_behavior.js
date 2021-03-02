let behaviorHeading;
let arrBehaviorOptions = [];
let selectedBehaviorId = -1;
let maxBehavior = 1;
let arrBehavior = [];

function loadBehaviorHeading() {

    const params = {api:'getControl', page:'treatment_plan/edit.php', textboxid:'definitions_Description'};
    $.ajax({
        url: selectorPath,
        type: 'POST',
        data: params,
        success: function(resData){
            behaviorHeading = resData.data.controls;
        }
    }); 
    // $.post(selectorPath, params, function(resData){
    //     behaviorHeading = resData.data.controls;
    // })
}

function clearBehavior() {

    maxBehavior = 1;
    selectedBehaviorId = -1;
    arrBehaviorOptions = [];
    arrBehavior = [];
    $('#btn-add-behavior').prop('disabled', true);

}

function loadBehaviorOptions(problemNumber, groupID) {

    if (!behaviorHeading) {
        // alert('There is no data for this');
        if (isChangingProblem) {
            checkAllLoaded();
        }
        return;
    }

    //const   params = {id1: groupID, api: 'getSelectorData', controlid: behaviorHeading.selectors[0].id, id2:groupID, id4: problemNumber};
    const   params = {id1: groupID, api: 'getSelectorData', controlid: behaviorHeading.selectors[0].id, id4: problemNumber, id0: libraryId};

    $.ajax({
        url: selectorPath,
        type: 'POST',
        data: params,
        success: function(resData){
            arrBehaviorOptions = resData.data.list;
            if (arrBehaviorOptions) {
    
                $('#btn-add-behavior').prop('disabled', false);
    
            }
            if (isChangingProblem) {
                checkAllLoaded();
            }
        }
    }); 

    // $.post(selectorPath, params, function(resData) {

    //     arrBehaviorOptions = resData.data.list;
    //     if (arrBehaviorOptions) {

    //         $('#btn-add-behavior').prop('disabled', false);

    //     }
    // })
}


function loadBehavior() {
    
    if (selectedProblemId < 0) {
        return;
    }

    const params = {form_id : form_id, api: 'getbds', problem_id: selectedProblemId};
    
    $.post(loadPath, params, function(resData){
    
        maxBehavior = 1;
        arrBehavior = resData.data.list;
        let behaviorContents = "";
        selectedBehaviorId = -1;

        if (arrBehavior) {

            arrBehavior.forEach(function(element) {

                behaviorContents += '<li class="list-group-item d-flex justify-content-between align-items-center">';
                behaviorContents += '<div class="row">';
                behaviorContents += '<div class="col-sm-10">' + element.Description + "</div>";
                behaviorContents += '<div class="col-sm-2">';
                behaviorContents += '<button class="btn btn-primary btn-sm" onclick="editBehavior(' + element.id +')">Edit</button>';
                behaviorContents += '<button class="btn btn-danger btn-sm"  onclick="deleteBehavior(' + element.id +')">Delete</button>';
                behaviorContents += '</div></div>';
                behaviorContents += '</li>';

                maxBehavior = Math.max(maxBehavior, (Number(element.DefinitionNumber) + 1));

            });

        }

        $('#behavior-contents').html(behaviorContents);
        loadStep();
        if (isChangingProblem) {
            checkAllLoaded();
        }
    })

}

function saveBehavior() {
    
    if ($('#modal-first-select').val() < 0) {
        alert("Please select behavior");
        return;
    }

    if (selectedProblemId < 0) {
        return;
    }
    const selectedProblem = findProblemById(selectedProblemId);
    
    let params;
    if (selectedBehaviorId < 0 ) {

        params = {
            api : 'savebehavioraldefinitions',
            id : -1,
            form_id : form_id,
            tp_problem_number : selectedProblem.tp_problem_number,
            GroupID : selectedProblem.GroupID,
            ProblemNumber : selectedProblem.ProblemNumber,
            DefinitionNumber : maxBehavior,
            Description : $("#modal-first-select option:selected").html(),
            IsCustom : 0,
            IsDeleted : 0, 
            problem_id: selectedProblem.id
        };

    } else {

        params = findBehaviorById(selectedBehaviorId);
        params.api = "savebehavioraldefinitions";
        params.Description = $("#modal-first-select option:selected").html();
        params.problem_id = selectedProblem.id;
    }

    $.post(savePath, params, function(){
        loadBehavior();
        $('#add-modal').modal('hide');
    });
}



function createNewBehavior() {

    selectedBehaviorId = -1;

    if (!arrBehaviorOptions) {

        alert('There is no option');
        return;

    }

    $('#modal-title').html('New Behavioral Definition');
    initBehaviorDialog();

}

function editBehavior(id) {

    if (!arrBehaviorOptions || id < 0) {
        alert('There is no option');
        return;
    }

    selectedBehaviorId = id;
    
    $('#modal-title').html('Edit Behavioral Definition');
    initBehaviorDialog();
    
}

function deleteBehavior(id) {
    
    if (id < 0 || !confirm("Are you sure you want to delete this Behavior?")) {
        return;
    }

    let params = findBehaviorById(id);
    params.IsDeleted = 1;
    params.api = "savebehavioraldefinitions"

    $.post(savePath, params, function(){
        loadBehavior();
        $('#add-modal').modal('hide');
    });

}

function findBehaviorById(behaviorId) {

    if (!arrBehavior || behaviorId < 0) {
        return null;
    }

    let i = 0;
    for (i = 0 ; i < arrBehavior.length ; i ++ ) {

        if (arrBehavior[i].id == behaviorId) {
            return arrBehavior[i];
        }

    }

    return null;

}


function initBehaviorDialog() {

    $('#add-modal').modal('show');

    $('#modal-primary').hide();
    $('#modal-second').hide();

    $('#modal-first-label').html(behaviorHeading.selectors[0].heading);
    
    $('#modal-first-select').empty().append("<option value='-1'>Please select behavior</option>");
    
    arrBehaviorOptions.forEach(function(element) {
        $('#modal-first-select').append("<option value='" + element.value + "'>" + element.desc + "</option>");
    });

    if (selectedBehaviorId > -1) {

        const selectedBehavior = findBehaviorById(selectedBehaviorId);

        $("#modal-first-select option").filter(function() {
        
            return $(this).text() == selectedBehavior.Description;

          }).prop('selected', true);

    }

    $('#btn-save').off('click');

    $('#btn-save').on('click', function() {
        saveBehavior();
    });

}