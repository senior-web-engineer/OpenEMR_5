let selectedDischargeId = -1;
let arrDischarge = [];

function clearDischarge() {

    selectedDischargeId = -1;
    arrDischarge = [];
    $('#btn-add-discharge').prop('disabled', true);

}

function loadDischarge() {

    // if (selectedProblemId < 0) {
    //     return;
    // }

    // const params = {form_id : form_id, api: 'getdischargecriteria', problem_id: selectedProblemId};
    const params = {form_id : form_id, api: 'getdischargecriteria'};

    $.ajax({
        url: loadPath,
        type: 'POST',
        data: params,
        success: function(resData){

    // $.post(loadPath, params, function(resData){

            arrDischarge = resData.data.list;
            let dischargeContents = "";
            selectedDischargeId = -1;

            if (arrDischarge) {

                arrDischarge.forEach(function(element) {

                    dischargeContents += '<li class="list-group-item d-flex justify-content-between align-items-center">';
                    dischargeContents += '<div class="row">';
                    dischargeContents += '<div class="col-sm-10">' + element.Criteria + "</div>";
                    dischargeContents += '<div class="col-sm-2">';
                    dischargeContents += '<button class="btn btn-primary btn-sm" onclick="editDischarge(' + element.id + ')">Edit</button>';
                    dischargeContents += '<button class="btn btn-danger btn-sm"  onclick="deleteDischarge(' + element.id + ')">Delete</button>';
                    dischargeContents += '</div></div>';
                    dischargeContents += '</li>';

                });

            }

            $('#discharge-contents').html(dischargeContents);
            loadStep();
            // if (isChangingProblem) {
            //     checkAllLoaded();
            // }

        }
    });

}

function saveDischarge() {
    if (!$("#discharge-criteria").val()) {
        alert("Please insert criteria");
        return;
    }

    let params = {
        api : 'savedischargecriteria',
        id : -1,
        form_id : form_id,
        Criteria : $("#discharge-criteria").val(),
        IsDeleted : 0,
        // problem_id: selectedProblemId

    };

    if (selectedDischargeId > -1 ) {
        params.id = selectedDischargeId;
    }

    $.post(savePath, params, function(){
        loadDischarge();
        $('#discharge-modal').modal('hide');
        // parent.$.fancybox.close();
    });
}



function createNewDischarge() {

    selectedDischargeId = -1;

    $('#discharge-title').html('New Discharge');
    initDischargeDialog();

}

function editDischarge(id) {

    if (id < 0) {
        return;
    }

    selectedDischargeId = id;

    $('#discharge-title').html('Edit Discharge');
    initDischargeDialog();

}

function deleteDischarge(id) {

    if (id < 0 || !confirm("Are you sure you want to delete this Discharge?")) {
        return;
    }

    let params = findDischargeById(id);
    params.IsDeleted = 1;
    params.api = "savedischargecriteria"

    $.post(savePath, params, function(){
        loadDischarge();
        $('#discharge-modal').modal('hide');
    });

}

function findDischargeById(dischargeId) {

    if (!arrDischarge || dischargeId < 0) {
        return null;
    }

    let i = 0;
    for (i = 0 ; i < arrDischarge.length ; i ++ ) {

        if (arrDischarge[i].id == dischargeId) {
            return arrDischarge[i];
        }

    }

    return null;

}


function initDischargeDialog() {

    $('#discharge-modal').modal('show');

    if (selectedDischargeId > -1) {
        const selectedDischarge = findDischargeById(selectedDischargeId);
        $('#discharge-criteria').val(selectedDischarge.Criteria);
    } else {
        $('#discharge-criteria').val('');
    }

}
