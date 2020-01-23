let currModalityNote = -1;
let arrModalityNote = [];
let modalityNoteId = -1;

function clearModalityNote() {
    currModalityNote = -1;
    $('#btn-delete-modality-note').prop('disabled', true);
    $('#btn-add-modality-note').html('Add');
    $('#modality-notes').val('');
    modalityNoteId = -1;
}


function loadModalityNotes() {
    
    if (selectedProblemId < 0) {
        return;
    }
    clearModalityNote();

    //const params = {form_id : form_id, api: 'getmodalitynotes', problem_id: selectedProblemId};
    const params = {form_id : form_id, api: 'getmodalitynotes'};
    
    $.ajax({
        url: loadPath,
        type: 'POST',
        data: params,
        success: function(resData){

        // $.post(loadPath, params, function(resData){
        
            arrModalityNote = resData.data.list;

            if (arrModalityNote) {

                arrModalityNote.forEach(function(element) {
                    $('#modality-notes').val(element.Notes);
                    modalityNoteId = element.id;
                    // modalityContents += '<li class="list-group-item d-flex justify-content-between align-items-center">';
                    // modalityContents += '<div class="row">';
                    // modalityContents += '<div class="col-sm-10">';
                    // modalityContents += '<input type="text" id="modality-notes-' + element.id + '" value="' + element.Notes + '" name="" class="form-control"/>';
                    // modalityContents += '</div>';
                    // modalityContents += '<div class="col-sm-2">';
                    // modalityContents += '<button class="btn btn-primary btn-sm" onclick="saveModalityNote(' + element.id +')">Save</button>';
                    // modalityContents += '<button class="btn btn-danger btn-sm"  onclick="deleteModalityNote(' + element.id +')">Delete</button>';
                    // modalityContents += '</div></div>';
                    // modalityContents += '</li>';
    
                });

                $('#btn-add-modality-note').html('Update');
                $('#btn-delete-modality-note').prop('disabled', false);
            
            }

            loadStep();
            if (isChangingProblem) {
                checkAllLoaded();
            }
    
        }
    })

}

function saveModalityNote() {

    if (selectedProblemId < 0) {
        alert("No Problem selected");
        return;
    }

    let newNotes = "";
    newNotes = $('#modality-notes').val();

    if (!newNotes) {
        alert("Please insert notes");
        return;
    }

    const selectedProblem = findProblemById(selectedProblemId);
    
    let params = {
        api : 'savemodalitynotes',
        id : modalityNoteId,
        form_id : form_id,
        Notes : newNotes,
        IsDeleted : 0
//        problem_id: selectedProblemId
    };

    $.post(savePath, params, function(resData){
        loadModalityNotes();
    });
}

function deleteModalityNote() {
    
    const selectedProblem = findProblemById(selectedProblemId);   
    let params = {
        api : 'savemodalitynotes',
        id : modalityNoteId,
        form_id : form_id,
        Notes : '',
        IsDeleted : 1
//        problem_id: selectedProblem.id
    };

    $.post(savePath, params, function(){
        loadModalityNotes();
    });
}