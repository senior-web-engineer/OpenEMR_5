let modalityHeading;
let arrModalityOptions = [];
let selectedModalityId = -1;
let arrModality = [];

function clearModality() {

    selectedModalityId = -1;
    arrModalityOptions = [];
    arrModality = [];
    // $('#btn-add-modality').prop('disabled', true);

}

function loadModality() {

    // if (selectedProblemId < 0) {
    //     return;
    // }
    // $('#btn-add-modality').prop('disabled', false);

    // const params = {form_id : form_id, api: 'getmodalities', problem_id: selectedProblemId};
    const params = {form_id : form_id, api: 'getmodalities'};

    $.ajax({
        url: loadPath,
        type: 'POST',
        data: params,
        success: function(resData){

        // $.post(loadPath, params, function(resData){

            arrModality = resData.data.list;
            let modalityContents = "";
            selectedModalityId = -1;

            if (arrModality) {

                arrModality.forEach(function(element) {

                    modalityContents += '<a href="#" class="list-group-item list-group-item-action">';
                    modalityContents += '<div class="d-flex w-100 justify-content-between">';
                    modalityContents += '<small>';
                    modalityContents += '<button class="btn btn-primary btn-sm" onclick="editModality(' + element.id + ')">Edit</button>';
                    modalityContents += '<button class="btn btn-danger btn-sm"  onclick="deleteModality(' + element.id + ')">Delete</button>';
                    modalityContents += '</small>';
                    modalityContents += '</div>';
                    modalityContents += "<div class='mb-1 status'>";
                    modalityContents += '<div class="row">';
                    modalityContents += '<div class="col-md-4">Starting Date : </div>';
                    modalityContents += '<div class="col-md-6 text-success">' + element.start_date + '</div>';
                    modalityContents += '</div>';
                    modalityContents += '<div class="row">';
                    modalityContents += '<div class="col-md-4">Ending Date: </div>';
                    modalityContents += '<div class="col-md-6 text-success">' + element.end_date + '</div>';
                    modalityContents += '</div>';
                    modalityContents += '<div class="row">';
                    modalityContents += '<div class="col-md-4">Modality: </div>';
                    modalityContents += '<div class="col-md-6 text-success">' + element.modality + '</div>';
                    modalityContents += '</div>';
                    modalityContents += '<div class="row">';
                    modalityContents += '<div class="col-md-4">Interval: </div>';
                    modalityContents += '<div class="col-md-6 text-success">' + element.intervals + '</div>';
                    modalityContents += '</div>';
                    modalityContents += '<div class="row">';
                    modalityContents += '<div class="col-md-4">Frequency: </div>';
                    modalityContents += '<div class="col-md-6 text-success">' + element.frequency + '</div>';
                    modalityContents += '</div>';
                    modalityContents += '<div class="row">';
                    modalityContents += '<div class="col-md-4">Hour(s): </div>';
                    modalityContents += '<div class="col-md-6 text-success">' + element.duration_hour + '</div>';
                    modalityContents += '</div>';
                    modalityContents += '<div class="row">';
                    modalityContents += '<div class="col-md-4">Minute(s): </div>';
                    modalityContents += '<div class="col-md-6 text-success">' + element.duration_minute + '</div>';
                    modalityContents += '</div>';
                    modalityContents += '<div class="row">';
                    modalityContents += '<div class="col-md-4">Responsible Provider: </div>';
                    modalityContents += '<div class="col-md-6 text-success">' + element.provider + '</div>';
                    modalityContents += '</div>';
                    modalityContents += '</div>';
                    modalityContents += '</a>';

                });

            }

            $('#modality-contents').html(modalityContents);
            loadStep();
            // if (isChangingProblem) {
            //     checkAllLoaded();
            // }

        }
    })

}

function saveModality() {

    if (!$("#modalityStartDate").val()         || !$("#modalityEndDate").val() ||
        !$("#modality-service-select").val()   || !$("#modality-duration-hour-select").val() ||
        !$("#modality-interval-select").val()  || !$("#modality-duration-min-select").val() ||
        !$("#modality-frequency-select").val() || !$("#modalityProvider").val()) {

        alert("Please insert all values");
        return;

    }

    // if (selectedProblemId < 0) {
    //     return;
    // }
    // const selectedProblem = findProblemById(selectedProblemId);

    let params = {
        api : 'savemodalities',
        id : -1,
        form_id : form_id,
        modality : $("#modality-service-select option:selected").html(),
        start_date : $('#modalityStartDate').val(),
        end_date : $('#modalityEndDate').val(),
        intervals : $("#modality-interval-select option:selected").html(),
        frequency : $("#modality-frequency-select option:selected").html(),
        duration_hour : $("#modality-duration-hour-select option:selected").html(),
        duration_minute : $("#modality-duration-min-select option:selected").html(),
        provider : $('#modalityProvider').val(),
        IsDeleted: 0,
        // problem_id: selectedProblemId

    };

    if (selectedModalityId > -1 ) {
        params.id = selectedModalityId;
    }

    $.post(savePath, params, function(){
        loadModality();
        $('#modality-modal').modal('hide');
    });
}



function createNewModality() {

    selectedModalityId = -1;

    if (!arrModalityOptions) {

        alert('There is no option');
        return;

    }

    $('#modality-title').html('New Modality');
    initModalityDialog();

}

function editModality(id) {

    if (!arrModalityOptions || id < 0) {
        alert('There is no option');
        return;
    }

    selectedModalityId = id;

    $('#modality-title').html('Edit Modality');
    initModalityDialog();

}

function deleteModality(id) {

    if (id < 0 || !confirm("Are you sure you want to delete this Modality?")) {
        return;
    }

    let params = findModalityById(id);
    params.IsDeleted = 1;
    params.api = "savemodalities"

    $.post(savePath, params, function(){
        loadModality();
    });

}

function findModalityById(modalityId) {

    if (!arrModality || modalityId < 0) {
        return null;
    }

    let i = 0;
    for (i = 0 ; i < arrModality.length ; i ++ ) {

        if (arrModality[i].id == modalityId) {
            return arrModality[i];
        }

    }

    return null;

}


function initModalityDialog() {

    $('#modality-modal').modal('show');

    if (selectedModalityId > -1) {

        const selectedModality = findModalityById(selectedModalityId);

        $('#modalityStartDate').val(selectedModality.start_date);
        $('#modalityEndDate').val(selectedModality.end_date);
        $('#modalityProvider').val(selectedModality.provider);

        $("#modality-service-select option").filter(function() {

            return $(this).text() == selectedModality.modality;

        }).prop('selected', true);
        $("#modality-interval-select option").filter(function() {

            return $(this).text() == selectedModality.intervals;

        }).prop('selected', true);
        $("#modality-frequency-select option").filter(function() {

            return $(this).text() == selectedModality.frequency;

        }).prop('selected', true);
        $("#modality-duration-hour-select option").filter(function() {

            return $(this).text() == selectedModality.duration_hour;

        }).prop('selected', true);
        $("#modality-duration-min-select option").filter(function() {

            return $(this).text() == selectedModality.duration_minute;

        }).prop('selected', true);

    }

}
