const selectorPath = window.location.origin + "/openemr/library/textimporter/textimporterdata.php";
const savePath = "save.php";

let form_id = "";
let diagnosisHeading;
let arrDiagnosisOptions;

let behaviorHeading;
let arrBehaviorOptions;

let goalHeading;
let arrGoalOptions;

let objectiveHeading;
let arrObjectiveOptions;

let InterventionHeading;
let arrInterventionOptions;

let maxObjectiveNumber = 0;

let modalityProblemId = -1;
let modalityId = -1;

let modalityNoteId = -1;

$(function() {
   
   form_id = $('#form-id').val();
   loadDiagnosisHeading();
   loadBehaviorHeading();
   loadGoalHeading();
   loadObjectiveHeading();
   loadInterventionHeading();

   /*
   loadHeading();
   loadProblem();
*/
});

//-----------------------------------Diagnosis------------------------------------------------------
function loadDiagnosisHeading() {

   const params = {api:'getControl', page:'treatment_plan/edit.php', textboxid:'diagnosis_Description'};

   $.post(selectorPath, params, function(resData){
       diagnosisHeading = resData.data.controls;
       loadDiagnosisOptions();
   })
}

function loadDiagnosisOptions() {
   //const   params = {id1: form_id, api: 'getSelectorData', controlid: diagnosisHeading.selectors[0].id};
   //const   params = {id1: form_id, id2: groupID, id3: problemNumber, api: 'getSelectorData', controlid: diagnosisHeading.selectors[0].id};
   const   params = {id1: groupID, api: 'getSelectorData', controlid: diagnosisHeading.selectors[0].id, id2: form_id, id4: problemNumber };

   $.ajax({
       url: selectorPath,
       type: 'POST',
       data: params,
       success: function(resData){
           arrDiagnosisOptions = resData.data.list;
       }
   });
}

function createNewDiagnosis(problemId) {
   if (!arrDiagnosisOptions) {
      alert('There is no option');
      return;
  }
  $('#modal-title').html('New Diagnosis');
  initDiagnosisDialog(problemId);
}

function editDiagnosis(problemId, selectedDiagnosisId) {
   if (!arrDiagnosisOptions || selectedDiagnosisId < 0) {
       alert('There is no option');
       return;
   }
   $('#modal-title').html('Edit Diagnosis');
   initDiagnosisDialog(problemId, selectedDiagnosisId);
}

function saveDiagnosis(problemId, selectedDiagnosisId = -1) {
    
   if ($('#modal-first-select').val() < 0) {
       alert("Please select Diagnosis");
       return;
   }
   
   let params = {
           api : 'savediagnosis',
           id : selectedDiagnosisId,
           form_id : form_id,
           tp_problem_number : $("#problem-number-" + problemId).val(),
           GroupID : $("#problem-group-" + problemId).val(),
           Description : $("#modal-first-select option:selected").html(),
           LegalCode : $("#modal-first-select option:selected").html().split(' ')[0],
           IsDeleted : 0, 
           problem_id: problemId
       };


   $.post(savePath, params, function(response){
      if (selectedDiagnosisId < 0) {
         const newDiagnosisId = response.data.id;
         const newElement = "<li id='diagnosis-" + newDiagnosisId + "'><span id='diagnosis-description-" + newDiagnosisId + "'>" + $("#modal-first-select option:selected").html() + "</span>" +
            "<button type='button' class='btn btn-primary btn-sm right-button' onclick='editDiagnosis(" + problemId + ", "  + newDiagnosisId + ")'>Edit</button>" +
            "<button type='button' class='btn btn-danger btn-sm right-button' onclick='deleteDiagnosis(" + problemId + ", "  + newDiagnosisId + ")'>Delete</button> </li>";
         $("#dianosis-content-" + problemId).append(newElement);
      } else {
         $("#diagnosis-description-" + selectedDiagnosisId).html($("#modal-first-select option:selected").html());
      }
       $('#add-modal').modal('hide');
   });
}

function deleteDiagnosis(problemId, selectedDiagnosisId) {
   if (selectedDiagnosisId < 0 || !confirm("Are you sure you want to delete this Diagnosis?")) {
      return;
   }

   let params = {
      api : 'savediagnosis',
      id : selectedDiagnosisId,
      form_id : form_id,
      tp_problem_number : $("#problem-number-" + problemId).val(),
      GroupID : $("#problem-group-" + problemId).val(),
      Description : $("#diagnosis-description-" + selectedDiagnosisId).html(),
      LegalCode : $("#diagnosis-description-" + selectedDiagnosisId).html().split(' ')[0],
      IsDeleted : 1, 
      problem_id: problemId
   };
   $.post(savePath, params, function(){
   //    $('#add-modal').modal('hide');
      $("#diagnosis-" + selectedDiagnosisId).remove();
   });
}

function initDiagnosisDialog(problemId, selectedDiagnosisId) {

   $('#add-modal').modal('show');

   $('#modal-first-label').html(diagnosisHeading.selectors[0].heading);
   
   $('#modal-first-select').empty().append("<option value='-1'>Please select diagnosis</option>");
   
   arrDiagnosisOptions.forEach(function(element) {
       $('#modal-first-select').append("<option value='" + element.value + "'>" + element.desc + "</option>");
   });

   $('#btn-save').off('click');

   $('#btn-save').on('click', function() {
       saveDiagnosis(problemId, selectedDiagnosisId);
   });

}


//-----------------------------------Behavioral Definitions------------------------------------------------------
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
}

function loadBehaviorOptions(problemId) {
   const problemNumber = $("#problem-number-" + problemId).val();
   const groupID = $("#problem-group-" + problemId).val();
   const   params = {id1: groupID, api: 'getSelectorData', controlid: behaviorHeading.selectors[0].id, id2:groupID, id4: problemNumber};
   $.ajax({
       url: selectorPath,
       type: 'POST',
       data: params,
       success: function(resData){
           arrBehaviorOptions = resData.data.list;
           $('#modal-first-select').empty().append("<option value='-1'>Please select behavior</option>");
   
           arrBehaviorOptions.forEach(function(element) {
               $('#modal-first-select').append("<option value='" + element.value + "'>" + element.desc + "</option>");
           });
       }
   }); 
}

function saveBehavior(problemId, selectedBehaviorId = -1) {
   if ($('#modal-first-select').val() < 0) {
       alert("Please select behavior");
       return;
   }
   if (problemId < 0) {
       return;
   }
   
   const problemNumber = $("#problem-number-" + problemId).val();
   const groupID = $("#problem-group-" + problemId).val();

   let params = {
      api : 'savebehavioraldefinitions',
      id : selectedBehaviorId,
      form_id : form_id,
      tp_problem_number : problemNumber,
      GroupID : groupID,
      ProblemNumber : problemNumber,
      Description : $("#modal-first-select option:selected").html(),
      IsCustom : 0,
      IsDeleted : 0, 
      problem_id: problemId
  };

   $.post(savePath, params, function(response){
      if (selectedBehaviorId < 0) {
         const newBehaviorId = response.data.id;
         const newElement = "<li style='list-style: none;' id='behavior-" + newBehaviorId + "'><span id='behavior-description-" + newBehaviorId + "'>" + $("#modal-first-select option:selected").html() + "</span>" +
            "<button type='button' class='btn btn-primary btn-sm right-button' onclick='editBehavior(" + problemId + ", "  + newBehaviorId + ")'>Edit</button>" +
            "<button type='button' class='btn btn-danger btn-sm right-button' onclick='deleteBehavior(" + problemId + ", "  + newBehaviorId + ")'>Delete</button> </li>";
         $("#behavior-content-" + problemId).append(newElement);
      } else {
         $("#behavior-description-" + selectedBehaviorId).html($("#modal-first-select option:selected").html());
      }
      $('#add-modal').modal('hide');
   });
}

function createNewBehavior(problemId) {
   $('#modal-title').html('New Behavioral Definition');
   initBehaviorDialog(problemId);
}

function editBehavior(problemId, selectedBehaviorId) {
   if (selectedBehaviorId < 0) {
       alert('There is no option');
       return;
   }

   $('#modal-title').html('Edit Behavioral Definition');
   initBehaviorDialog(problemId, selectedBehaviorId);
}

function deleteBehavior(problemId, selectedBehaviorId) {
   
   if (selectedBehaviorId < 0 || !confirm("Are you sure you want to delete this Behavior?")) {
       return;
   }

   const problemNumber = $("#problem-number-" + problemId).val();
   const groupID = $("#problem-group-" + problemId).val();

   let params = {
      api : 'savebehavioraldefinitions',
      id : selectedBehaviorId,
      form_id : form_id,
      tp_problem_number : problemNumber,
      GroupID : groupID,
      ProblemNumber : problemNumber,
      Description : $("#behavior-description-" + selectedBehaviorId).html(),
      IsCustom : 0,
      IsDeleted : 1, 
      problem_id: problemId
  };

   $.post(savePath, params, function(){
      $("#behavior-" + selectedBehaviorId).remove();
   });

}

function initBehaviorDialog(problemId, selectedBehaviorId = -1) {
   $('#modal-first-label').html(behaviorHeading.selectors[0].heading);
   $('#modal-first-select').empty();
   loadBehaviorOptions(problemId);

   $('#btn-save').off('click');
   $('#btn-save').on('click', function() {
       saveBehavior(problemId, selectedBehaviorId);
   });
   $('#add-modal').modal('show');
}


//-----------------------------------Behavioral Definitions------------------------------------------------------

function loadGoalHeading() {
   const params = {api:'getControl', page:'treatment_plan/edit.php', textboxid:'goals_Description'};
   $.post(selectorPath, params, function(resData){
       goalHeading = resData.data.controls;
   })
}

function loadGoalOptions(problemId) {
   const problemNumber = $("#problem-number-" + problemId).val();
   const groupID = $("#problem-group-" + problemId).val();
   const   params = {id1: groupID, api: 'getSelectorData', controlid: goalHeading.selectors[0].id, id2:groupID, id4: problemNumber};
   $.ajax({
       url: selectorPath,
       type: 'POST',
       data: params,
       success: function(resData){
           arrGoalOptions = resData.data.list;
           $('#modal-first-select').empty().append("<option value='-1'>Please select goal</option>");
           arrGoalOptions.forEach(function(element) {
               $('#modal-first-select').append("<option value='" + element.value + "'>" + element.desc + "</option>");
           });
       }
   })
}

function saveGoal(problemId, selectedGoalId = -1) {
   if ($('#modal-first-select').val() < 0) {
       alert("Please select behavior");
       return;
   }
   if (problemId < 0) {
       return;
   }
   
   const problemNumber = $("#problem-number-" + problemId).val();
   const groupID = $("#problem-group-" + problemId).val();

   let params = {
      api : 'savegoals',
      id : selectedGoalId,
      form_id : form_id,
      tp_problem_number : problemNumber,
      GroupID : groupID,
      ProblemNumber : problemNumber,
      Description : $("#modal-first-select option:selected").html(),
      IsCustom : 0,
      IsDeleted : 0, 
      problem_id: problemId
  };

   $.post(savePath, params, function(response){
      if (selectedGoalId < 0) {
         const newGoalId = response.data.id;
         const newElement = "<li style='list-style: none;' id='goal-" + newGoalId + "'><span id='goal-description-" + newGoalId + "'>" + $("#modal-first-select option:selected").html() + "</span>" +
            "<div class='row'><div class='col-sm-6'><h4>Status: </h4> <h4>Goal Action: </h4> <h4>Status Description: </h4>" + "</div>" +
            "<div class='col-sm-6'> <button type='button' class='btn btn-primary btn-sm right-button' onclick='editGoal(" + problemId + ", "  + newGoalId + ")'>Edit</button>" +
            "<button type='button' class='btn btn-danger btn-sm right-button' onclick='deleteGoal(" + problemId + ", "  + newGoalId + ")'>Delete</button> </div></div> </li>";
         $("#goal-content-" + problemId).append(newElement);
      } else {
         $("#goal-description-" + selectedGoalId).html($("#modal-first-select option:selected").html());
      }
      $('#add-modal').modal('hide');
   });
}

function createNewGoal(problemId) {
   $('#modal-title').html('New Goal');
   initGoalDialog(problemId);
}

function editGoal(problemId, selectedGoalId) {
   if ( selectedGoalId < 0) {
       alert('There is no option');
       return;
   }
   $('#modal-title').html('Edit Goal');
   initGoalDialog(problemId, selectedGoalId);
}

function deleteGoal(problemId, selectedGoalId) {
   
   if (selectedGoalId < 0 || !confirm("Are you sure you want to delete this Goal?")) {
       return;
   }

   const problemNumber = $("#problem-number-" + problemId).val();
   const groupID = $("#problem-group-" + problemId).val();
   let params = {
      api : 'savegoals',
      id : selectedGoalId,
      form_id : form_id,
      tp_problem_number : problemNumber,
      GroupID : groupID,
      ProblemNumber : problemNumber,
      Description : $("#goal-description-" + selectedGoalId).html(),
      IsCustom : 0,
      IsDeleted : 1, 
      problem_id: problemId
  };
   $.post(savePath, params, function(){
      $("#goal-" + selectedGoalId).remove();
   });
}

function initGoalDialog(problemId, selectedGoalId = -1) {
   $('#modal-first-label').html(goalHeading.selectors[0].heading);
   $('#modal-first-select').empty();
   loadGoalOptions(problemId);

   $('#btn-save').off('click');
   $('#btn-save').on('click', function() {
       saveGoal(problemId, selectedGoalId);
   });
   $('#add-modal').modal('show');
}

//-----------------------------------Objective------------------------------------------------------
function loadObjectiveHeading() {
   const params = {api:'getControl', page:'treatment_plan/edit.php', textboxid:'objectives_Description'};

   $.post(selectorPath, params, function(resData){
       objectiveHeading = resData.data.controls;
   })
}

function loadObjectiveOptions(problemId) {
   const problemNumber = $("#problem-number-" + problemId).val();
   const groupID = $("#problem-group-" + problemId).val();
   const   params = {id1: groupID, api: 'getSelectorData', controlid: objectiveHeading.selectors[0].id, id2:groupID, id4: problemNumber};

   $.ajax({
       url: selectorPath,
       type: 'POST',
       data: params,
       success: function(resData){

         arrObjectiveOptions = resData.data.list;
         $('#objective-select').empty().append("<option value='-1'>Please select objective</option>");
   
         arrObjectiveOptions.forEach(function(element) {
             $('#objective-select').append("<option value='" + element.value + "'>" + element.desc + "</option>");
         });
       }
   })
}

function saveObjective(problemId, selectedObjectiveId = -1) {
    
   if ($("#objective-select").val() < 0 || !$('#objectiveTargetDate').val() || Number($('#objectiveNoSession')).val < 0) {
       alert("Please insert correct value");
       return;
   }

   if (problemId < 0) {
       return;
   }
   const problemNumber = $("#problem-number-" + problemId).val();
   const groupID = $("#problem-group-" + problemId).val();
   const description = $("#objective-select option:selected").html();
   const targetDate = $('#objectiveTargetDate').val();
   let objectiveNumber;
   if (selectedObjectiveId == -1) {
      maxObjectiveNumber++;
      objectiveNumber = maxObjectiveNumber;
   }
   else {
      objectiveNumber = $("#objective-number-" + problemId + "-" + selectedObjectiveId).val();
   }

   let params = {
      api : 'saveobjectives',
      id : selectedObjectiveId,
      ObjectiveNumber: objectiveNumber,
      form_id : form_id,
      tp_problem_number : problemNumber,
      target_date : targetDate,
      sessions : $('#objectiveNoSession').val(),
      IsCritical : 0,
      GroupID : groupID,
      ProblemNumber : problemNumber,
      Description : description,
      IsCustom : 0,
      IsEvidenceBased : 0,
      IsDeleted : 0, 
      problem_id: problemId
  };

   $.post(savePath, params, function(response ){
      
      if (selectedObjectiveId < 0) {
         const newObjectiveId = response.data.id;
         const newElement = "<div id='objective-" + problemId + "-" + newObjectiveId + "'>" + 
            "<input type='hidden' id='objective-number-" + problemId + "-" + newObjectiveId + "' value='" + objectiveNumber + "'>" +
            "<div class='form-group group dontsplit'><h4>Objective: </h4> <div class='row'> <div class='col-sm-9'> <span id='objective-description-" + newObjectiveId + "'>" + description + "<b>Target Date:</b>" + targetDate + "</span></div>" + 
            "<div class='col-sm-3'><button type='button' class='btn btn-primary btn-sm right-button' onclick='editObjective(" + problemId + ", "  + newObjectiveId + ")'>Edit</button>" +
            "<button type='button' class='btn btn-danger btn-sm right-button' onclick='deleteObjective(" + problemId + ", "  + newObjectiveId + ")'>Delete</button> </div> </div>" +
            "<h4>Interventions:</h4>" +
            '<button type="button" class="btn btn-primary btn-add-objective" onclick="createNewIntervention(' + problemId + ',' + newObjectiveId + ')">Add Intervention of Objective</button>';
         $("#objective-content-" + problemId).append(newElement);
      } else {
         $("#objective-description-" + selectedObjectiveId).html(description + "<b>Target Date:</b>" + targetDate);
      }
      $('#objective-modal').modal('hide');
   });
}


function createNewObjective(problemId) {
   $('#objective-title').html('New Objective');
   initObjectiveDialog(problemId);
}

function editObjective(problemId, selectedObjectiveId) {
   if (selectedObjectiveId < 0) {
       alert('There is no option');
       return;
   }
   $('#objective-title').html('Edit Objective');
   initObjectiveDialog(problemId, selectedObjectiveId);
}

function deleteObjective(problemId, selectedObjectiveId) {
   
   if (selectedObjectiveId < 0 || !confirm("Are you sure you want to delete this Objective?")) {
       return;
   }
   const problemNumber = $("#problem-number-" + problemId).val();
   const groupID = $("#problem-group-" + problemId).val();
   const objectiveNumber = $("#objective-number-" + problemId + "-" + selectedObjectiveId).val();
      
   let params = {
      api : 'saveobjectives',
      id : selectedObjectiveId,
      ObjectiveNumber: objectiveNumber,
      form_id : form_id,
      tp_problem_number : problemNumber,
      IsCritical : 0,
      GroupID : groupID,
      ProblemNumber : problemNumber,
      IsCustom : 0,
      IsEvidenceBased : 0,
      IsDeleted : 1, 
      problem_id: problemId
  };
   $.post(savePath, params, function(){
      $("#objective-" + problemId + "-" + selectedObjectiveId).remove();
   });
}

function initObjectiveDialog(problemId, selectedObjectiveId) {
   $('#objective-label').html(objectiveHeading.selectors[0].heading);
   $('#objectiveNoSession').val("1");
   loadObjectiveOptions(problemId);   
   $('#object-save').off('click');
   $('#object-save').on('click', function() {
       saveObjective(problemId, selectedObjectiveId);
   });
   $('#objective-modal').modal('show');
}
//-----------------------------------Intervention------------------------------------------------------
function loadInterventionHeading() {
   const params = {api:'getControl', page:'treatment_plan/edit.php', textboxid:'interventions_Description'};
   $.post(selectorPath, params, function(resData){
       InterventionHeading = resData.data.controls;
   })
}

function loadInterventionOptions(problemId, objectiveId) {

   if (!InterventionHeading) {
       return;
   }
   const objectiveNumber = $("#objective-number-" + problemId + "-" + objectiveId).val();
   const problemNumber = $("#problem-number-" + problemId).val();
   const groupID = $("#problem-group-" + problemId).val();
   const   params = {id1: groupID, api: 'getSelectorData', controlid: InterventionHeading.selectors[0].id, id2:groupID, id4: problemNumber, id5: objectiveNumber};
   $.ajax({
       url: selectorPath,
       type: 'POST',
       data: params,
       success: function(resData){
            arrInterventionOptions = resData.data.list;
            $('#modal-first-select').empty().append("<option value='-1'>Please select intervention</option>");
            arrInterventionOptions.forEach(function(element) {
               $('#modal-first-select').append("<option value='" + element.value + "'>" + element.desc + "</option>");
            });
       }
   })
}

function saveIntervention(problemId, objectiveId, interventionId = -1) {
    
   if ($('#modal-first-select').val() < 0) {
       alert("Please select intervention");
       return;
   }

   if (problemId < 0 || objectiveId < 0) {
       return;
   }

   const problemNumber = $("#problem-number-" + problemId).val();
   const groupID = $("#problem-group-" + problemId).val();
   let params = {
      api : 'saveinterventions',
      id : interventionId,
      form_id : form_id,
      tp_problem_number : problemNumber,
      GroupID : groupID,
      ProblemNumber : problemNumber,
      Description : $("#modal-first-select option:selected").html(),
      IsCustom : 0,
      IsDeleted : 0, 
      IsEvidenceBased : 0,
      ObjectiveID : objectiveId,
      problem_id: problemId
   };

   $.post(savePath, params, function(response){
      if (interventionId < 0) {
         const newInterventionId = response.data.id;
         const newElement = "<li style='list-style: none;' id='intervention-" + objectiveId + "-" + newInterventionId + "'><span id='intervention-description-" + objectiveId + "-" + newInterventionId + "'>" + $("#modal-first-select option:selected").html() + "</span>" +
         "<button type='button' class='btn btn-primary btn-sm right-button' onclick='editIntervention(" + problemId + "," + objectiveId + ", "  + newInterventionId + ")'>Edit</button>" +
         "<button type='button' class='btn btn-danger btn-sm right-button' onclick='deleteIntervention(" + problemId + "," + objectiveId + ", "  + newInterventionId + ")'>Delete</button> </li>";
         $("#intervention-content-" + problemId + "-" + objectiveId).append(newElement);
      } else {
         $("#intervention-description-" + objectiveId + "-" + interventionId).html($("#modal-first-select option:selected").html());
      }
      $('#add-modal').modal('hide');
   });
}

function createNewIntervention(problemId, objectiveId) {
   $('#modal-title').html('New Intervention');
   initInterventionDialog(problemId, objectiveId);
}

function editIntervention(problemId, objectiveId, interventionId) {
   if ( interventionId < 0) {
       return;
   }
   $('#modal-title').html('Edit Intervention');
   initInterventionDialog(problemId, objectiveId, interventionId);
}

function deleteIntervention(problemId, objectiveId, interventionId) {
   
   if (interventionId < 0 || !confirm("Are you sure you want to delete this Intervention?")) {
       return;
   }

   const problemNumber = $("#problem-number-" + problemId).val();
   const groupID = $("#problem-group-" + problemId).val();
   let params = {
      api : 'saveinterventions',
      id : interventionId,
      form_id : form_id,
      tp_problem_number : problemNumber,
      GroupID : groupID,
      ProblemNumber : problemNumber,
      Description : $("#intervention-description-" + objectiveId + "-" + interventionId).html(),
      IsCustom : 0,
      IsDeleted : 1, 
      IsEvidenceBased : 0,
      ObjectiveID : objectiveId,
      problem_id: problemId
   };

   $.post(savePath, params, function(){
      $("#intervention-" + objectiveId + "-" + interventionId).remove();
   });
}

function initInterventionDialog(problemId, objectiveId, interventionId) {
   $('#modal-first-label').html(InterventionHeading.selectors[0].heading);
   loadInterventionOptions(problemId, objectiveId);
   $('#btn-save').off('click');

   $('#btn-save').on('click', function() {
       saveIntervention(problemId, objectiveId, interventionId);
   });
   $('#add-modal').modal('show');
}

//-----------------------------------Modality-----------------------------------------------------------

function saveModality() {
    
   if (!$("#modalityStartDate").val()         || !$("#modalityEndDate").val() || 
       !$("#modality-service-select").val()   || !$("#modality-duration-hour-select").val() || 
       !$("#modality-interval-select").val()  || !$("#modality-duration-min-select").val() || 
       !$("#modality-frequency-select").val() || !$("#modalityProvider").val()) {
       
       alert("Please insert all values");
       return;

   }

   if (modalityProblemId < 0) {
       return;
   }
   
   let params = {
       api : 'savemodalities',
       id : modalityId,
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
       problem_id: modalityProblemId

   };
   
   $.post(savePath, params, function(response){
      const modalityDescription = "<b>Starting: </b>"+ $('#modalityStartDate').val() +
                                  "<b> Ending: </b>" + $('#modalityEndDate').val() +
                                  "<br><b> Service Description: </b>" + $("#modality-service-select option:selected").html() +
                                  "<b> CPT\HCPCS Code: </b>" + 
                                  "<b> Interval: </b>" + $("#modality-interval-select option:selected").html() +
                                  "<b> Frequency: </b>" + $("#modality-frequency-select option:selected").html() +
                                  "<br><b> Responsible Provider: </b>" + $('#modalityProvider').val() + "<br>";
      if (modalityId < 0) {
         const newModalityId = response.data.id;
         const newElement = "<li style='list-style: none; margin-top: 15px' id='modality-" + newModalityId + "'> <div class='row'> <div class='col-sm-9'>  <span id='modality-description-" + newModalityId + "'>" + modalityDescription + "</span> </div>" +
            "<div class='col-sm-3'> <button type='button' class='btn btn-primary btn-sm right-button' onclick='editModality(" + modalityProblemId + ", "  + newModalityId + ")'>Edit</button>" +
            "<button type='button' class='btn btn-danger btn-sm right-button' onclick='deleteModality(" + modalityProblemId + ", "  + newModalityId + ")'>Delete</button> </div> </div> </li>";
         $("#modality-content-" + modalityProblemId).append(newElement);
      } else {
         $("#modality-description-" + modalityId).html(modalityDescription);
      }
      $('#modality-modal').modal('hide');
   });
}

function createNewModality(problemId) {
   modalityProblemId = problemId;
   modalityId = -1;
   $('#modality-title').html('New Modality');
   $('#modality-modal').modal('show');
}

function editModality(problemId, selectedModalityId) {
   modalityProblemId = problemId;
   modalityId = selectedModalityId;

   $('#modality-title').html('Edit Modality');
   $('#modality-modal').modal('show');
}

function deleteModality(problemId, selectedModalityId) {
   if (!confirm("Are you sure you want to delete this Modality?")) {
       return;
   }

   let params = {
      api : 'savemodalities',
      id : selectedModalityId,
      form_id : form_id,
      IsDeleted: 1,
      problem_id: problemId

  };
   $.post(savePath, params, function(){
      $("#modality-" + selectedModalityId).remove();
   });
}
//-----------------------------------Modality Note------------------------------------------------------


function saveModalityNote(problemId, modalityNoteId) {
   let newNotes = $('#modality-notes-' + problemId).val();
   if (!newNotes) {
       alert("Please insert notes");
       return;
   }
   let params = {
       api : 'savemodalitynotes',
       id : modalityNoteId,
       form_id : form_id,
       Notes : newNotes,
       IsDeleted : 0, 
       problem_id: problemId
   };
   $.post(savePath, params, function(response){
      if (modalityNoteId < 0) {
         $('#btn-modality-save-' + problemId).on('click', function() {
            saveModalityNote(problemId, response.data.id);
         });
         $('#btn-modality-delete-' + problemId).on('click', function() {
            deleteModalityNote(problemId, response.data.id);
         });
      }
   });
}

function deleteModalityNote(problemId, modalityNoteId) {
   if (modalityNoteId < 0)
      return;

   let params = {
       api : 'savemodalitynotes',
       id : modalityNoteId,
       form_id : form_id,
       Notes : '',
       IsDeleted : 1, 
       problem_id: problemId
   };
   $.post(savePath, params, function(){
      $('#modality-notes-' + problemId).val("");
   });
}


//-----------------------------------Discharge----------------------------------------------------------

function saveDischarge(problemId, selectedDischargeId) {
   if (!$("#discharge-criteria").val()) {
       alert("Please insert criteria");
       return;
   }

   let params = {
       api : 'savedischargecriteria',
       id : selectedDischargeId,
       form_id : form_id,
       Criteria : $("#discharge-criteria").val(),
       IsDeleted : 0, 
       problem_id: problemId

   };

   $.post(savePath, params, function(response){
      if (selectedDischargeId < 0) {
         const newDischargeId = response.data.id;
         const newElement = "<li style='list-style: none;' id='discharge-" + newDischargeId + "'><span id='discharge-description-" + newDischargeId + "'>" + $("#discharge-criteria").val() + "</span>" +
            "<button type='button' class='btn btn-primary btn-sm right-button' onclick='editDischarge(" + problemId + ", "  + newDischargeId + ")'>Edit</button>" +
            "<button type='button' class='btn btn-danger btn-sm right-button' onclick='deleteDischarge(" + problemId + ", "  + newDischargeId + ")'>Delete</button> </li>";
         $("#discharge-content-" + problemId).append(newElement);
      } else {
         $("#discharge-description-" + selectedDischargeId).html($("#discharge-criteria").val());
      }
      $('#discharge-modal').modal('hide');
   });
}

function createNewDischarge(problemId) {
   $('#discharge-title').html('New Discharge');
   initDischargeDialog(problemId);
}

function editDischarge(problemId, selectedDischargeId) {
   if (selectedDischargeId < 0) {
       return;
   }
   $('#discharge-title').html('Edit Discharge');
   initDischargeDialog(problemId, selectedDischargeId);
   
}

function deleteDischarge(problemId, selectedDischargeId) {
   
   if (selectedDischargeId < 0 || !confirm("Are you sure you want to delete this Discharge?")) {
       return;
   }

   let params = {
      api : 'savedischargecriteria',
      id : selectedDischargeId,
      form_id : form_id,
      Criteria : $("#discharge-description-" + selectedDischargeId).html(),
      IsDeleted : 1, 
      problem_id: problemId

   };

   $.post(savePath, params, function(){
      $("#discharge-" + selectedDischargeId).remove();
   });

}

function initDischargeDialog(problemId, selectedDischargeId = -1) {
   $('#btn-save-discharge').off('click');
   $('#btn-save-discharge').on('click', function() {
      saveDischarge(problemId, selectedDischargeId);
   });
   $('#discharge-modal').modal('show');
}