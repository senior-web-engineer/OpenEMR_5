	//scrape form 
	var scrapeTP = function(){
		var obj = {
			api : 'savetreatmentplan',	
			id : $('#form_id').val(),
			modality_note : $('#treatmentplan_modality_note').val(),
			approach_note : $('#treatmentplan_approach_note').val(),
			date_created : $('#treatmentplan_date_created').val()
		};
		return obj;
	};
	
	var scrapeProblems = function(){
		var obj = {
			api : 'saveproblems',
			id : $('#problems_id').val(),
			form_id : $('#form_id').val(),
			tp_problem_number : $('#tp_problem_number').val(),
			GroupID : $('#problems_GroupID').val(),
			ProblemNumber : $('#problems_ProblemNumber').val(),
			Description : $('#problems_Description_2').val(),
			approach_note : $('#problems_approach_note').val(),
			IsCustom : $('#problems_IsCustom').val(),
			IsDeleted : problems_IsDeleted, 
			IsPrimary : $('#problems_IsPrimary').val()
		};
		return obj;
	};
	
	var scrapeBD = function(){
		var obj = {
			api : 'savebehavioraldefinitions',
			id : $('#definitions_id').val(),
			form_id : $('#form_id').val(),
			tp_problem_number : $('#tp_problem_number').val(),
			GroupID : $('#definitions_GroupID').val(),
			ProblemNumber : $('#definitions_ProblemNumber').val(),
			DefinitionNumber : $('#definitions_DefinitionNumber').val(),
			Description : $('#definitions_Description').val(),
			IsCustom : $('#definitions_IsCustom').val(),
			IsDeleted : definitions_IsDeleted,
			problem_id : problem_id
		};
		return obj;
	};

	var scrapeGoals = function(){
		var obj = {
			api : 'savegoals',
			id : $('#goals_id').val(),
			form_id : $('#form_id').val(),
			tp_problem_number : $('#tp_problem_number').val(),
			GroupID : $('#goals_GroupID').val(),
			ProblemNumber : $('#goals_ProblemNumber').val(),
			GoalNumber : $('#goals_GoalNumber').val(),
			Description : $('#goals_Description_2').val(),
			IsCustom : $('#goals_IsCustom').val(),
			goal_status : $('#goals_goal_status').val(),
			goal_action : $('#goals_goal_action').val(),
			review_status : $('#goals_review_status').val(),
			IsDeleted : goals_IsDeleted,
			problem_id : problem_id
		};
		return obj;
	};
	
	var scrapeObjectives = function() {
		var obj = {
			api : 'saveobjectives',
			id : $('#objectives_id').val(),
			form_id : $('#form_id').val(),
			tp_problem_number : $('#tp_problem_number').val(),
			target_date : $('#objectives_target_date').val(),
			sessions : $('#objectives_sessions').val(),
			IsCritical : $('#objectives_IsCritical').val(),
			GroupID : $('#objectives_GroupID').val(),
			ProblemNumber : $('#objectives_ProblemNumber').val(),
			ObjectiveNumber : $('#objectives_ObjectiveNumber').val(),
			Description : $('#objectives_Description_2').val(),
			IsCustom : $('#objectives_IsCustom').val(),
			IsEvidenceBased : $('#objectives_IsEvidenceBased').val(),
			IsDeleted : objectives_IsDeleted,
			problem_id : problem_id			
		};
		return obj;
	};
	
	var scrapeInterventions = function() {
		var obj = {
			api : 'saveinterventions',
			id : $('#interventions_id').val(),
			form_id : $('#form_id').val(),
			//tp_problem_number : $('#tp_problem_number').val(),
			//sessions : $('#interventions_sessions').val(),
			//user : $('#interventions_user').val(),
			GroupID : $('#interventions_GroupID').val(),
			//ProblemNumber : $('#interventions_ProblemNumber').val(),
			//InterventionNumber : $('#interventions_InterventionNumber').val(),
			Description : $('#interventions_Description_2').val(),
			ShortDescription : $('#interventions_ShortDescription').val(),
			IsCustom : $('#interventions_IsCustom').val(),
			IsEvidenceBased : $('#interventions_IsEvidenceBased').val(),
            		//ObjectiveID : $('#interventions_ObjectiveID').val(),
			IsDeleted : interventions_IsDeleted,
			//problem_id : problem_id
		};
		return obj;
	};
	
	var scrapeModalities = function(){
		var obj = {
			api : 'savemodalities',
			id : $('#modalities_id').val(),
			form_id : $('#form_id').val(),
			tp_problem_number : $('#tp_problem_number').val(),
			user : $('#modalities_user').val(),
			//modality : $('#modalities_modality').val(),
			//start_date : $('#modalities_start_date').val(),
			//end_date : $('#modalities_end_date').val(),
			//hcpt : $('#modalities_hcpt').val(),
			//intervals : $('#modalities_intervals').val(),
			//frequency : $('#modalities_frequency').val(),
			//duration_hour : $('#duration_hour').val(),
			//duration_minute : $('#duration_minute').val(),
			Description : $('#modalities_Description').val(),
			//provider : $('#modalities_provider').val(),
			IsDeleted : modalities_IsDeleted,
			problem_id : problem_id
		};
		return obj;
	};

	var scrapeModalityNotes = function(){
		var obj = {
			api : 'savemodalitynotes',
			id : $('#modalitynotes_id').val(),
			form_id : $('#form_id').val(),
			Notes : $('#modalitynotes_Notes').val(),
			IsDeleted : modalitynotes_IsDeleted
		};
		return obj;
	};
	
	var scrapeDischargeCriteria = function(){
		var obj = {
			api : 'savedischargecriteria',
			id : $('#dischargecriteria_id').val(),
			form_id : $('#form_id').val(),
			Criteria : $('#dischargecriteria_Criteria').val(),
			IsDeleted : dischargecriteria_IsDeleted
		};
		return obj;
	};

	var scrapeDiagnosis = function(){
		var obj = {
			api : 'savediagnosis',
			id : $('#diagnosis_id').val(),
			form_id : $('#form_id').val(),
			GroupID : $('#diagnosis_GroupID').val(),
			Description : $('#diagnosis_Description').val(),
			LegalCode : $('#diagnosis_LegalCode').val(),
			Axis : $("#diagnosis_Axis").val(),
			IsDeleted : diagnosis_IsDeleted
		};
		return obj;
	};

	var scrapeDiagnosis2 = function(){
		var obj = {
			api : 'savediagnosis',
			id : $('#diagnosis2_id').val(),
			form_id : $('#form_id').val(),
			GroupID : $('#diagnosis2_GroupID').val(),
			Description : $('#diagnosis2_Description').val(),
			LegalCode : $('#diagnosis2_LegalCode').val(),
			Axis : $("#diagnosis2_Axis").val(),
			IsDeleted : diagnosis2_IsDeleted
		};
		return obj;
	};
	
	var scrapeDiagnosis3 = function(){
		var obj = {
			api : 'savediagnosis',
			id : $('#diagnosis3_id').val(),
			form_id : $('#form_id').val(),
			GroupID : $('#diagnosis3_GroupID').val(),
			Description : $('#diagnosis3_Description').val(),
			//LegalCode : $('#diagnosis3_LegalCode').val(),
			Axis : $("#diagnosis3_Axis").val(),
			IsDeleted : diagnosis3_IsDeleted
		};
		return obj;
	};
	
	var scrapeDiagnosis4 = function(){
		var obj = {
			api : 'savediagnosis',
			id : $('#diagnosis4_id').val(),
			form_id : $('#form_id').val(),
			GroupID : $('#diagnosis4_GroupID').val(),
			Description : $('#diagnosis4_Description').val(),
			LegalCode : $('#diagnosis4_LegalCode').val(),
			Axis : $("#diagnosis4_Axis").val(),
			IsDeleted : diagnosis4_IsDeleted
		};
		return obj;
	};
	
	var scrapeDiagnosis5 = function(){
		var obj = {
			api : 'savediagnosis',
			id : $('#diagnosis5_id').val(),
			form_id : $('#form_id').val(),
			GroupID : $('#diagnosis5_GroupID').val(),
			cgaf_score : $('#diagnosis5_cgaf_score').val(),
			pgaf_score : $('#diagnosis5_pgaf_score').val(),
			stress_rating : $('#diagnosis5_stress_rating').val(),
			Axis : $("#diagnosis5_Axis").val(),
			IsDeleted : diagnosis5_IsDeleted
		};
		return obj;
	};
	
	var scrapeStrength = function(){
		var obj = {
			api : 'savestrength',
			id : $('#strength_id').val(),
			form_id : $('#form_id').val(),
			//GroupID : $('#strength_GroupID').val(),
			Description : $('#strength_Description').val(),
			IsDeleted : strength_IsDeleted
		};
		return obj;
	};
	//Remember that Weakness looks at the Strength Data
	var scrapeWeakness = function(){
		var obj = {
			api : 'saveweakness',
			id : $('#weakness_id').val(),
			form_id : $('#form_id').val(),
			//GroupID : $('#weakness_GroupID').val(),
			Description : $('#weakness_Description').val(),
			IsDeleted : strength_IsDeleted
		};
		return obj;
	};	
	var scrapeSummary = function(){
		var obj = {
			api : 'savesummary',
			id : $('#summary_id').val(),
			form_id : $('#form_id').val(),
			//GroupID : $('#weakness_GroupID').val(),
			Description : $('#summary_Description').val(),
			IsDeleted : summary_IsDeleted
		};
		return obj;

	};
		
	
	var fillProblems = function(obj){
		$("#problems_Description").val(obj.Description || "");
		$("#problems_ProblemNumber").val(obj.ProblemNumber || 0);
		$("#problems_GroupID").val(obj.GroupID || 0);
		$("#problems_id").val(obj.id);
		$("#problems_IsCustom").val(obj.IsCustom || 0);
		problems_IsDeleted = 0;
		$("#problems_IsPrimary").val(obj.IsPrimary || 0);
	};
	
	var fillBDs = function(obj) {
		$("#definitions_Description").val(obj.Description || "");
		$("#definitions_ProblemNumber").val(obj.ProblemNumber || 0);
		$("#definitions_DefinitionNumber").val(obj.DefinitionNumber || 0);
		$("#definitions_GroupID").val(obj.GroupID || 0);
		$("#definitions_id").val(obj.id);
		$("#definitions_IsCustom").val(obj.IsCustom || 0);
		definitions_IsDeleted = 0;
	};
	
	var fillGoals = function(obj) {
		$("#goals_Description_2").val(obj.Description || "");
		$("#goals_ProblemNumber").val(obj.ProblemNumber || 0);
		$("#goals_GoalNumber").val(obj.GoalNumber || 0);
		$("#goals_GroupID").val(obj.GroupID || 0);
		$("#goals_id").val(obj.id);
		$("#goals_IsCustom").val(obj.IsCustom || 0);
		$("#goals_goal_status").val(obj.goal_status || "");
		$("#goals_goal_action").val(obj.goal_action || "");
		$("#goals_review_status").val(obj.review_status || "");
		goals_IsDeleted = 0;
	};
	
	var fillObjectives = function(obj) {
		$("#objectives_Description_2").val(obj.Description || "");
		$("#objectives_ProblemNumber").val(obj.ProblemNumber || 0);
		$("#objectives_ObjectiveNumber").val(obj.ObjectiveNumber || 0);
		$("#objectives_GroupID").val(obj.GroupID || 0);
		$("#objectives_id").val(obj.id);
		$("#objectives_IsCustom").val(obj.IsCustom || 0);
		$("#objectives_target_date").val(obj.target_date || '');
		$("#objectives_sessions").val(obj.sessions || 0);
		//$("#objectives_target_date").val(obj.target_date || '');
		$("#objectives_IsCritical").val(obj.IsCritical || 0);
		$("#objectives_IsEvidenceBased").val(obj.IsEvidenceBased || 0);
		objectives_IsDeleted = 0;
	};

	var fillInterventions = function (obj) {
	    $("#interventions_Description_2").val(obj.Description || "");
	    //$("#interventions_ProblemNumber").val(obj.ProblemNumber || 0);
	    $("#interventions_InterventionNumber").val(obj.InterventionNumber || 0);
	    $("#interventions_GroupID").val(obj.GroupID || 0);
	    $("#interventions_id").val(obj.id);
	    $("#interventions_IsCustom").val(obj.IsCustom || 0);
	    //$("#interventions_sessions").val(obj.sessions || 0);
	    $("#interventions_user").val(obj.user || '');
	    $("#interventions_ShortDescription").val(obj.ShortDescription || 0);
	    $("#interventions_IsEvidenceBased").val(obj.IsEvidenceBased || 0);
		interventions_IsDeleted = 0;
	};
	
	var fillModalities = function(obj) {
		$("#modalities_Description").val(obj.Description || "");
		$("#modalities_user").val(obj.user || "");
		//$("#modalities_start_date").val(obj.start_date || '');
		//$("#modalities_end_date").val(obj.end_date || '');
		//$("#modalities_modality").val(obj.modality || 0);
		//$("#modalities_hcpt").val(obj.hcpt || 0);
		//$("#modalities_intervals").val(obj.intervals || 0);
		//$("#modalities_id").val(obj.id);
		//$("#modalities_frequency").val(obj.frequency || 0);
		//$("#modalities_duration_hour").val(obj.duration_hour || 0);
		//$("#modalities_duration_minute").val(obj.duration_minute || 0);
		//$("#modalities_provider").val(obj.provider);
		modalities_IsDeleted = 0;
	};

	var fillModalityNotes = function(obj) {
		$("#modalitynotes_Notes").val(obj.Notes || "");
		$("#modalitynotes_id").val(obj.id);
		modalitynotes_IsDeleted = 0;
	};
	
	var fillDischargeCriteria = function(obj) {
		$("#dischargecriteria_Criteria").val(obj.Criteria || "");
		$("#dischargecriteria_id").val(obj.id);
		dischargecriteria_IsDeleted = 0;
	};
	
	var fillDiagnosis = function(obj) {
		$("#diagnosis_Description").val(obj.Description || "");
		$("#diagnosis_LegalCode").val(obj.LegalCode || "");
		$("#diagnosis_GroupID").val(obj.GroupID || 0);
		$("#diagnosis_id").val(obj.id);
		diagnosis_IsDeleted = 0;
	};

	var fillDiagnosis2 = function(obj) {
		$("#diagnosis2_Description").val(obj.Description || "");
		$("#diagnosis2_LegalCode").val(obj.LegalCode || "");
		$("#diagnosis2_GroupID").val(obj.GroupID || 0);
		$("#diagnosis2_id").val(obj.id);
		diagnosis2_IsDeleted = 0;
	};
	
	var fillDiagnosis3 = function(obj) {
		$("#diagnosis3_Description").val(obj.Description || "");
		//$("#diagnosis3_LegalCode").val(obj.LegalCode || "");
		$("#diagnosis3_GroupID").val(obj.GroupID || 0);
		$("#diagnosis3_id").val(obj.id);
		diagnosis3_IsDeleted = 0;
	};
	
	var fillDiagnosis4 = function(obj) {
		$("#diagnosis4_Description").val(obj.Description || "");
		$("#diagnosis4_LegalCode").val(obj.LegalCode || "");
		$("#diagnosis4_GroupID").val(obj.GroupID || 0);
		$("#diagnosis4_id").val(obj.id);
		diagnosis4_IsDeleted = 0;
	};
	
	var fillDiagnosis5 = function(obj) {
		$("#diagnosis5_cgaf_score").val(obj.cgaf_score || "");
		$("#diagnosis5_pgaf_score").val(obj.pgaf_score || "");
		$("#diagnosis5_stress_rating").val(obj.stress_rating || "");
		$("#diagnosis5_GroupID").val(obj.GroupID || 0);
		$("#diagnosis5_id").val(obj.id);
		diagnosis5_IsDeleted = 0;
	};		
	
	var fillStrength = function(obj) {
		$("#strength_Description").val(obj.Description || "");
		$("#strength_id").val(obj.id);
		strength_IsDeleted = 0;
	};
	var fillWeakness = function(obj) {
		$("#weakness_Description").val(obj.Description || "");
		$("#weakness_id").val(obj.id);
		strength_IsDeleted = 0;
	};
	var fillSummary = function(obj) {
		$("#summary_Description").val(obj.Description || "");
		$("#summary_id").val(obj.id);
		summary_IsDeleted = 0;
	};


