

$(function () {
    //currently selected values
    var tp_problem_number = 0;
    var GroupID = 0;
    var ProblemNumber = 0;
    var ObjectiveNumber = 0;

    //load form
    var loadProblemSelector = function () {
        var options = "<option value='-1'>Please choose...</option>";
        if (!_.isUndefined(oProblems)) {
            _.each(oProblems, function (item) {
                options += "<option value='" + item.id + "'>" + item.tp_problem_number + "</option>";
            });
        };
        $("#availableProblems").html(options);
        
        var probs = ""; 
        if (!_.isUndefined(oProblems)) {
            _.each(oProblems, function (item) {
                probs += "<li class='active'><a data-toggle='tab' problemId='" + item.id + "'>";
                probs += getProblemListName(item);
                probs += "</a></li>";
            });
        };
        $("#problems_menu").html(probs);
        $("#problems_menu li a").on('click', function () {
            var problemId = $(this).attr("problemId");
            problemChange(problemId);
        });
                
        tp_problem_number = 0;
    };
    
    $(".sortable").sortable({
        handle: '.handle',
        stop: function(event, ui) {
            $(".sortable li a").each(function(i, el){
                var problemId = $(el).attr("problemId");
                var problem = _.findWhere(oProblems, { id: problemId });
                setProblemPrimary(problemId, i + 1); //save primary problem to db
                problem.IsPrimary = i + 1;
                if (i === 0){
                    problemChange(problemId);
                } 
                _.extend(_.findWhere(oProblems, {id: problemId}), problem); //replace problem
                $(el).html(getProblemListName(problem));
            });
            //loadProblemSelector();
        }
    });
    $(".sortable").disableSelection();
    
    var setProblemPrimary = function(problemId, IsPrimary){
        postProblemPrimary(problemId, IsPrimary, function(){
            //done
        });        
    }

    var getProblemListName = function(item){
        var probs = "";
        probs += "<span class='handle'>|||</span> &nbsp; ";
        probs += getProblemLevelHeading(item) + "<br>";
        var desc = item.Description;
        desc = desc.length > 28 ? desc.substring(0,28) + "..." : desc;
        probs += desc;
        return probs;
    }

    var getProblemLevelHeading = function(item){
        var desc = "";
        if (item.IsPrimary === "1" || item.IsPrimary === 1){
            desc = "Primary Problem:";
        } else {
            desc = "Secondary Prob. :";
        }        
        return desc;
    }

    var loadList = function (listID, editorType, objectList, filterObject, afterComplete) {
        var list = "";
        $("#" + listID).html(list);
        if (!_.isUndefined(objectList)) {
            var oList = [];
            if (!_.isUndefined(filterObject)) {
                oList = _.where(objectList, filterObject);
            } else {
                oList = objectList;
            }
            _.each(oList, function (item) {
                if (!_.isUndefined(item)) {
                    list += "<li class='itemList' >";
                    list += "<button class='btn btn-primary editbtn' editortype='" + editorType + "' recid='" + item.id + "'>Edit</button>";
                    //these show before the description
                    switch (editorType) {
                    	case "objective_item":

                    	break;
                    	case "problem_item":

                    	break;
                    	case "goal_item":

                    	
                    	break;
                    	case "modality_item"://NOW
                    	break;
                    	case "modalitynote_item":
                            list += "<br>&nbsp;<span>" + item.Notes + "</span>"
	                   	break;
	                   	
	                   	case "dischargecriteria_item":
							list += "<br>&nbsp;<span>" + item.Criteria + "</span>"
	                   	break;

	                   	
	                   	case "diagnosis_item":

	                   	break;
	                   	case "diagnosis2_item":

	                   	break;
                    };
                    //description (if it's available)
                    if (!_.isUndefined(item.Description)) { list += "<br>&nbsp;<span>" + item.Description + "</span>"; }
                    //these show after the description
                    switch (editorType) {
                    	case "objective_item":
                    		list += "<br>";
                    		list += "&nbsp;<br><b>Target Date: </b><span>" + item.target_date + "</span>";
							list += "&nbsp;<b>Sessions: </b><span>" + item.sessions + "</span>";
                    	break;
                    	case "problem_item":
                    		//nothing happens
                    	break;
                    	
                    	case "goal_item":
                    		list += "<br>";
                    		list += "&nbsp;<b>Status: </b><span>" + item.goal_status + "</span>";
                    	    list += "&nbsp;<b>Goal Action: </b><span>" + item.goal_action + "</span>";
                    	    list += "<br>";
                    	    list += "&nbsp;<b>Status Description: </b><span>" + item.review_status + "</span>";
                    	    
	                   	break;

                    	case "modality_item":
                    		list += "&nbsp;<b>Starting: </b><span>" + item.start_date + "</span>";
                    	    list += "&nbsp;<b>Ending: </b><span>" + item.end_date+ "</span>";
                    	    list += "<br>";
                    	    list += "&nbsp;<b>Modality: </b><span>" + item.modality + "</span>";
                    	    //list += "&nbsp;<b>Code: </b><span>" + item.hcpt + "</span>";
							list += "&nbsp;<b>Interval: </b><span>" + item.intervals + "</span>";
							list += "&nbsp;<b>Frequency: </b><span>" + item.frequency + "</span>";
							list += "&nbsp;<b>Hour(s): </b><span>" + item.duration_hour + "</span>";
							list += "&nbsp;<b>Minute(s): </b><span>" + item.duration_minute + "</span>";
							list += "<br>";
							list += "&nbsp;<b>Responsible Provider: </b><span>" + item.provider + "</span>";
	                   	break;
                    	case "diagnosis5_item":
                    		list += "<br>";
                    	    list += "&nbsp;<br><b>Current: </b><span>" + item.cgaf_score + "</span>";
							list += "&nbsp;<b>Prior: </b><span>" + item.pgaf_score + "</span>";
							list += "&nbsp;<b>Stress Severity Rating: </b><span>" + item.stress_rating + "</span>";
	                   	break;
                    };
                    list += "</li>";
                }
            });
            //errors(editorType + " => " + JSON.stringify(oList) + "<br/><br/>");
        };
        $("#" + listID).append(list);
        $("#" + listID + " > .itemList").on("click", itemListClickHandler);
        $("#" + listID + " > .itemList > .editbtn").on("click", itemEditClickHandler);
        if (!_.isUndefined(afterComplete)) {
            afterComplete();
        }
    };

    var loadEditor = function (id, editorType) {
        //alert("id= " + id + " type=" + editorType);
        id = parseInt(id);
        var form_id = $("#form_id").val();
        switch (editorType) {
            case "problem_item":
                var obj = _.findWhere(oProblems, { id: id });
                if (_.isUndefined(obj)) { obj = _.findWhere(oProblems, { id: id + "" }); }
                if (!_.isUndefined(obj)) {
                    fillProblems(obj);
                    var tiVM = ko.contextFor($("#problems_Description").get(0)).$data;
                    tiVM.updateControl({
                        id: 'problems_Description',
                        page: 'treatment_plan/edit.php',
                        storeid: ['problems_GroupID', 'problems_ProblemNumber'],
                        appendvalue: false,
                        params: { id1: GroupID, id4: ProblemNumber }
                    });
                }
                break;
            case "bd_item":
                var obj = _.findWhere(oBDs, { id: id });
                if (_.isUndefined(obj)) { obj = _.findWhere(oBDs, { id: id + "" }); }
                if (!_.isUndefined(obj)) {
                    if (parseInt(obj.GroupID) <= 0) { obj.GroupID = GroupID; }
                    if (parseInt(obj.ProblemNumber) <= 0) { obj.ProblemNumber = ProblemNumber; }
                    fillBDs(obj);
                    //disableTextBox("definitions_Description",obj.DefinitionNumber);
                    var tiVM = ko.contextFor($("#definitions_Description").get(0)).$data;
                    tiVM.updateControl({
                        id: 'definitions_Description',
                        page: 'treatment_plan/edit.php',
                        storeid: ['definitions_DefinitionNumber'],
                        appendvalue: false,
                        params: { id1: GroupID, id4: ProblemNumber }
                    });
                }
                break;
            case "goal_item":
                var obj = _.findWhere(oGoals, { id: id });
                if (_.isUndefined(obj)) { obj = _.findWhere(oGoals, { id: id + "" }); }
                if (!_.isUndefined(obj)) {
                    if (parseInt(obj.GroupID) <= 0) { obj.GroupID = GroupID; }
                    if (parseInt(obj.ProblemNumber) <= 0) { obj.ProblemNumber = ProblemNumber; }
                    fillGoals(obj);
                    //disableTextBox("goals_Description",obj.GoalNumber);
                    var tiVM = ko.contextFor($("#goals_Description").get(0)).$data;
                    tiVM.updateControl({
                        id: 'goals_Description',
                        page: 'treatment_plan/edit.php',
                        storeid: ['goals_GoalNumber'],
                        appendvalue: false,
                        params: { id1: GroupID, id4: ProblemNumber }
                    });
                }
                break;
            case "objective_item":
                var obj = _.findWhere(oObjectives, { id: id });
                if (_.isUndefined(obj)) { obj = _.findWhere(oObjectives, { id: id + "" }); }
                if (!_.isUndefined(obj)) {
                    if (parseInt(obj.GroupID) <= 0) { obj.GroupID = GroupID; }
                    if (parseInt(obj.ProblemNumber) <= 0) { obj.ProblemNumber = ProblemNumber; }
                    fillObjectives(obj);
                    //disableTextBox("objectives_Description",obj.ObjectiveNumber);
                    var tiVM = ko.contextFor($("#objectives_Description").get(0)).$data;
                    tiVM.updateControl({
                        id: 'objectives_Description',
                        page: 'treatment_plan/edit.php',
                        storeid: ['objectives_ObjectiveNumber'],
                        appendvalue: false,
                        params: { id1: GroupID, id4: ProblemNumber }
                    });
                }
                break;
            case "intervention_item":
                var obj = _.findWhere(oInterventions, { id: id });
                if (_.isUndefined(obj)) { obj = _.findWhere(oInterventions, { id: id + "" }); }
                if (!_.isUndefined(obj)) {
                    if (parseInt(obj.GroupID) <= 0) { obj.GroupID = GroupID; }
                    if (parseInt(obj.ProblemNumber) <= 0) { obj.ProblemNumber = ProblemNumber; }
                    fillInterventions(obj);
                    disableTextBox("interventions_Description",obj.InterventionNumber);
                    var tiVM = ko.contextFor($("#interventions_Description").get(0)).$data;
                    tiVM.updateControl({
                        id: 'interventions_Description',
                        page: 'treatment_plan/edit.php',
                        storeid: ['interventions_InterventionNumber'],
                        appendvalue: false,
                        params: { id1: GroupID, id4: ProblemNumber, id5: ObjectiveNumber }
                    });
                }
                break;
            //Yves 04-29-2017
            //case "modality_item":
            //    var obj = _.findWhere(oModalities, { id: id });
            //    if (_.isUndefined(obj)) { obj = _.findWhere(oModalities, { id: id + "" }); }
            //    if (!_.isUndefined(obj)) {
            //        if (parseInt(obj.GroupID) <= 0) { obj.GroupID = GroupID; }
            //        //if (parseInt(obj.ProblemNumber) <= 0) { obj.ProblemNumber = ProblemNumber; }
            //        fillModalities(obj);
            //       //no tiVM
           //   }

            
            case "modality_item":
                var obj = _.findWhere(oModalities, { id: id });
                if (_.isUndefined(obj)) { obj = _.findWhere(oModalities, { id: id + "" }); }
                if (!_.isUndefined(obj)) {
                     fillModalities(obj);
                 }
				break;          
            case "modalitynote_item":
                var obj = _.findWhere(oModalityNotes, { id: id });
                if (_.isUndefined(obj)) { obj = _.findWhere(oModalityNotes, { id: id + "" }); }
                if (!_.isUndefined(obj)) {
                    fillModalityNotes(obj);
                }
				break;
			case "dischargecriteria_item":
                var obj = _.findWhere(oDischargeCriteria, { id: id });
                if (_.isUndefined(obj)) { obj = _.findWhere(oDischargeCriteria, { id: id + "" }); }
                if (!_.isUndefined(obj)) {
                    fillDischargeCriteria(obj);
                }
				break;
			case "strength_item":
                var obj = _.findWhere(oStrength, { id: id });
                if (_.isUndefined(obj)) { obj = _.findWhere(oStrength, { id: id + "" }); }
                if (!_.isUndefined(obj)) {
                    fillStrength(obj);
                }
				break;
			case "weakness_item":
                var obj = _.findWhere(oWeakness, { id: id });
                if (_.isUndefined(obj)) { obj = _.findWhere(oWeakness, { id: id + "" }); }
                if (!_.isUndefined(obj)) {
                    fillWeakness(obj);
                }
				break;
			case "summary_item":
                var obj = _.findWhere(oSummary, { id: id });
                if (_.isUndefined(obj)) { obj = _.findWhere(oSummary, { id: id + "" }); }
                if (!_.isUndefined(obj)) {
                    fillSummary(obj);
                }
				break;
            case "diagnosis_item":
                var obj = _.findWhere(oDiagnosis, { id: id });
                if (_.isUndefined(obj)) { obj = _.findWhere(oDiagnosis, { id: id + "" }); }
                if (!_.isUndefined(obj)) {
                    if (parseInt(obj.GroupID) <= 0) { obj.GroupID = obj.GroupID; }// Changed obj.GroupID = GroupID To obj.GroupID = '400' for testing
                    fillDiagnosis(obj);
		      disableTextBox("diagnosis_Description",obj.DiagnosisNumber);
                    var tiVM = ko.contextFor($("#diagnosis_Description").get(0)).$data;
                    tiVM.updateControl({
                        id: 'diagnosis_Description',
                        page: 'treatment_plan/edit.php',
                        storeid: ['diagnosis_LegalCode'],
                        appendvalue: false,
                        params: { id1: form_id }
			   
                    });
                }
                break;
            case "diagnosis2_item":
                var obj = _.findWhere(oDiagnosis2, { id: id });
                if (_.isUndefined(obj)) { obj = _.findWhere(oDiagnosis2, { id: id + "" }); }
                if (!_.isUndefined(obj)) {
                    if (parseInt(obj.GroupID) <= 0) { obj.GroupID = obj.GroupID; }// Changed obj.GroupID = GroupID To obj.GroupID = '400' for testing
                    fillDiagnosis2(obj);
                    disableTextBox("diagnosis2_Description",obj.DiagnosisNumber);
                    var tiVM = ko.contextFor($("#diagnosis2_Description").get(0)).$data;
                    tiVM.updateControl({
                        id: 'diagnosis2_Description',
                        page: 'treatment_plan/edit.php',
                        storeid: ['diagnosis2_LegalCode'],
                        appendvalue: false,
                        params: { id1: form_id }
                    });
                }          
                break;
            case "diagnosis3_item":
                var obj = _.findWhere(oDiagnosis3, { id: id });
                if (_.isUndefined(obj)) { obj = _.findWhere(oDiagnosis3, { id: id + "" }); }
                if (!_.isUndefined(obj)) {
                    fillDiagnosis3(obj);
                }
				break;
            case "diagnosis4_item":
                var obj = _.findWhere(oDiagnosis4, { id: id });
                if (_.isUndefined(obj)) { obj = _.findWhere(oDiagnosis4, { id: id + "" }); }
                if (!_.isUndefined(obj)) {
                    if (parseInt(obj.GroupID) <= 0) { obj.GroupID = obj.GroupID; }// Changed obj.GroupID = GroupID To obj.GroupID = '400' for testing
                    fillDiagnosis4(obj);
                    disableTextBox("diagnosis4_Description",obj.DiagnosisNumber);
                    var tiVM = ko.contextFor($("#diagnosis4_Description").get(0)).$data;
                    tiVM.updateControl({
                        id: 'diagnosis4_Description',
                        page: 'treatment_plan/edit.php',
                        storeid: ['diagnosis4_LegalCode'],
                        appendvalue: false,
                        params: { id1: form_id }
                    });
                }          
                break;
            case "diagnosis5_item":
                var obj = _.findWhere(oDiagnosis5, { id: id });
                if (_.isUndefined(obj)) { obj = _.findWhere(oDiagnosis5, { id: id + "" }); }
                if (!_.isUndefined(obj)) {
                    fillDiagnosis5(obj);
                }
				break;                            
            default:
                alert("id= " + id + " type=" + editorType);
                break;
        };
    };

    var errors = function (msg) {
        $("#errors").append(msg + "<br/>");
    };

    var closeEditors = function () {
        $(".editor").each(function () {
            if ($(this).is(":visible")) {
                $(this).toggleClass('hidden');
            }
        });
    };

    //UI actions / events
    $(".close, .cancel").click(function () {
        $(this).closest(".editor").toggleClass('hidden');
        //TODO!
        //- purge any -1 items on the list
        //- clear editor
    });

    var itemEditClickHandler = function () {
        var editor = $(this).closest(".section").children(".editor");
        $(editor).toggleClass('hidden');
        if ($(editor).is(":visible")) {
            $(editor).css("width", $(this).closest(".itemList").width()).positionOn($(this).closest(".itemList")); //move the editor over current element
            var id = $(this).attr("recid");
            var editorType = $(this).attr("editortype");
            clearEditors(editorType);
            loadEditor(id, editorType);
        }
    };

    var itemListClickHandler = function () {
        //load child nodes
        var id = $(this).children(".editbtn").attr("recid");
        var editorType = $(this).children(".editbtn").attr("editortype");
        var form_id = $("#form_id").val();
        var tp_problem_number = $("#tp_problem_number").val();
        switch (editorType) {
            case "objective_item":
                var obj = _.findWhere(oObjectives, { id: id + "" });
                if (!_.isUndefined(obj)) { ObjectiveNumber = obj.ObjectiveNumber; }
                clearLists('interventions_list');
                var params = { api: "getinterventions", form_id: form_id, problem_id: problem_id, ObjectiveID: id };
                getCollection(params, "oInterventions", function () {
                    loadList("interventions_list", "intervention_item", oInterventions, { tp_problem_number: tp_problem_number });
                });
                $('#interventions_ObjectiveID').val(id);
                $("#interventionsection").removeClass('hidden');
                break;
            case "xyz_item":
                //do something else
                break;
        };
    };

    var itemAddEditor = function (editorType, addBtn) {
        clearEditors(editorType);
        var editor = $(addBtn).closest(".section").children(".editor");
        $(editor).toggleClass('hidden');
        if ($(editor).is(":visible")) {
            $(editor).positionOn($(addBtn)); //move the editor over current element
            loadEditor(-1, editorType);
        }
    };

    var clearLists = function (listType) {
        if (_.isUndefined(listType) || listType === "bd_list") {
            oBDs = [];
            loadList("bd_list", "bd_item", oBDs);
        }
         if (listType === "strength_list") {
            oStrength = [];
            loadList("strength_list", "strength_item", oStrength);
        }
        if (listType === "weakness_list") {
            oWeakness = [];
            loadList("weakness_list", "weakness_item", oWeakness);
        }
        if (listType === "summary_list") {
            oSummary = [];
            loadList("summary_list", "summary_item", oSummary);
        }

        if (_.isUndefined(listType) || listType === "goals_list") {
            oGoals = [];
            loadList("goals_list", "goal_item", oGoals);
        }
        if (_.isUndefined(listType) || listType === "objectives_list") {
            oObjectives = [];
            loadList("objectives_list", "objective_item", oObjectives);
        }
        if (_.isUndefined(listType) || listType === "interventions_list") {
            $("#interventionsection").addClass('hidden');
            oInterventions = [];
            loadList("interventions_list", "intervention_item", oInterventions);
        }
      // Yves 04-29-2017
      //  if (_.isUndefined(listType) || listType === "modalities_list") {
      //      oModalities = [];
      //      loadList("modalities_list", "modality_item", oModalities);
      //  }
        if (listType === "modalities_list") {
            oModalities = [];
            loadList("modalities_list", "modality_item", oModalities);
        }

        if (listType === "modalitynotes_list") {
            oModalityNotes = [];
            loadList("modalitynotes_list", "modalitynote_item", oModalityNotes);
        }
		if (listType === "dischargecriteria_list") {
            oDischargeCriteria = [];
            loadList("dischargecriteria_list", "dischargecriteria_item", oDischargeCriteria);
        }
        if (listType === "diagnosis_list") {
            oDiagnosis = [];
            loadList("diagnosis_list", "diagnosis_item", oDiagnosis);
        }
        if (listType === "diagnosis2_list") {
            oDiagnosis2 = [];
            loadList("diagnosis2_list", "diagnosis2_item", oDiagnosis2);
        }
        if (listType === "diagnosis3_list") {
            oDiagnosis3 = [];
            loadList("diagnosis3_list", "diagnosis3_item", oDiagnosis3);
        }
        if (listType === "diagnosis4_list") {
            oDiagnosis4 = [];
            loadList("diagnosis4_list", "diagnosis4_item", oDiagnosis4);
        }
        if (listType === "diagnosis5_list") {
            oDiagnosis5 = [];
            loadList("diagnosis5_list", "diagnosis5_item", oDiagnosis5);
        }
    };

    var clearEditors = function (editorType) {
        if (_.isUndefined(editorType) || editorType === "problem_item") {
            fillProblems({});
        }
        if (_.isUndefined(editorType) || editorType === "bd_item") {
            fillBDs({});
        }
         if (_.isUndefined(editorType) || editorType === "strength_item") {
            fillStrength({});
        }
         if (_.isUndefined(editorType) || editorType === "weakness_item") {
            fillWeakness({});
        }
         if (_.isUndefined(editorType) || editorType === "summary_item") {
            fillSummary({});
        }
        if (_.isUndefined(editorType) || editorType === "goal_item") {
            fillGoals({});
        }
        if (_.isUndefined(editorType) || editorType === "objective_item") {
            fillObjectives({});
        }
        if (_.isUndefined(editorType) || editorType === "intervention_item") {
            fillInterventions({});
        }
        if (_.isUndefined(editorType) || editorType === "modality_item") {
            fillModalities({});
        }
        if (_.isUndefined(editorType) || editorType === "modalitynote_item") {
            fillModalityNotes({});
        }
		if (_.isUndefined(editorType) || editorType === "dischargecriteria_item") {
            fillDischargeCriteria({});
        }
        if (_.isUndefined(editorType) || editorType === "diagnosis_item") {
            fillDiagnosis({});
        }
        if (_.isUndefined(editorType) || editorType === "diagnosis2_item") {
            fillDiagnosis2({});
        }
        if (_.isUndefined(editorType) || editorType === "diagnosis3_item") {
            fillDiagnosis3({});
        }
        if (_.isUndefined(editorType) || editorType === "diagnosis4_item") {
            fillDiagnosis4({});
        }
        if (_.isUndefined(editorType) || editorType === "diagnosis5_item") {
            fillDiagnosis5({});
        }
    };

    var problemCheck = function () {
        var ret = true;
        if (tp_problem_number <= 0) {
            ret = false;
            alert("Please select or create a Problem to work on first!");
        }
        return ret;
    };

    var disableTextBox = function(textareaid, selectedid){
        selectedid = _.isUndefined(selectedid) ? 0 : selectedid;
        var selectbutton = $('#' + textareaid).closest(".section").find(".opentibutton");
        $(selectbutton).disable(false);
        $('#' + textareaid).disable(false);
        if (selectedid <= 0){ // if not using librry 
            if ($('#' + textareaid).val().length>0){
                $(selectbutton).disable(true);
            }
        } else {
            $('#' + textareaid).disable(true);
        }        
    };

    //Problems
    $("#availableProblems").on('change', function () {
        problemChange(this.value);
    });
    
    var problemChange = function(problemid) {
        closeEditors(); //clear
        clearLists(); //clear all lists
        var form_id = $("#form_id").val();
        var problem = _.findWhere(oProblems, { id: problemid });
        var problemDesc = "";
        if (!_.isUndefined(problem)) {
            tp_problem_number = problem.tp_problem_number;
            GroupID = problem.GroupID;
            ProblemNumber = problem.ProblemNumber;
            problem_id = problemid;
            problemDesc = problem.Description;
            problemDesc = getProblemLevelHeading(problem) + " : " + problemDesc;
        } else {
            alert("Error loading problem");
            tp_problem_number = 0;
            GroupID = 0;
            ProblemNumber = 0;
            problem_id = 0;
        }
        //$("#problemheader").html("Problem " + tp_problem_number);
        $("#problemheader").html(problemDesc);
        $("#tp_problem_number").val(tp_problem_number || 0);
        //reload top level sections
        //-problem
        //loadList("problems_list", "problem_item", oProblems, { tp_problem_number: tp_problem_number });
        loadList("problems_list", "problem_item", oProblems, { id: problemid });
        //-beh definitions
        var params = { api: "getbds", form_id: form_id, problem_id: problem_id };
        getCollection(params, "oBDs", function () {
            loadList("bd_list", "bd_item", oBDs, { tp_problem_number: tp_problem_number });
        });
        //-goals
        var params = { api: "getgoals", form_id: form_id, problem_id: problem_id };
        getCollection(params, "oGoals", function () {
            loadList("goals_list", "goal_item", oGoals, { tp_problem_number: tp_problem_number });
        });
        //-objectives
        params = { api: "getobjectives", form_id: form_id, problem_id: problem_id };
        getCollection(params, "oObjectives", function () {
            loadList("objectives_list", "objective_item", oObjectives, { tp_problem_number: tp_problem_number });
        });
        //-modalities Yves 4-29-2017
        //var params = { api: "getmodalities", form_id: form_id, problem_id: problem_id };
        //getCollection(params, "oModalities", function () {
        //    loadList("modalities_list", "modality_item", oModalities, { tp_problem_number: tp_problem_number });
        //});
        //-modalities Yves 4-29-2017
        //NOW
        //var params = { api: "getmodalities", form_id: form_id };
        //	getCollection(params, "oModalities", function () {
        //    loadList("modalities_list", "modality_item", oModalities);
        //});

    };
    $("#addProblem").click(function () {
        //create & reload or set everything to blank ID's
        var maxProblemNumber = $("#availableProblems").children().length;
        if ($("#problems_menu li").length >= 4){
            alert("You have reached the maximum number of Problems allowed per Treatment Plan.");
            return;   
        }
        oProblems.push({ id: -1, tp_problem_number: maxProblemNumber, IsPrimary: maxProblemNumber });
        $("#tp_problem_number").val(maxProblemNumber);
        tp_problem_number = maxProblemNumber;
        itemAddEditor("problem_item", this);
    });
    $(".postproblem").click(function () {
        //top.restoreSession(); //figure out how to get this to work
        var action = $(this).attr("action");
        if (action === "delete"){
            if (!confirm("Are you sure you want to delete this Problem?")){ return; }
            problems_IsDeleted = 1; //set the delete flag for scrape
            //we are not deleting child nodes because they won't be accessible once this node is hidden
        }
        $(this).closest(".editor").toggleClass('hidden');
        postProblem(function () {
            //reload problem collection and selector
            loadList("problems_list", "problem_item", []);
            clearLists();
            var probParams = { form_id: $('#form_id').val(), api: "getproblems" };
            getCollection(probParams, "oProblems", loadProblemSelector);
            alert("Reloading Treatment Plan Problems.  Please select a Problem on left column to continue"); 
        });
    });

    //BD
    $("#addBD").click(function () {
        if (problemCheck()) {
            //create & reload or set everything to blank ID's
            var obj = { id: -1, tp_problem_number: tp_problem_number,
                GroupID: GroupID, ProblemNumber: ProblemNumber,
                problem_id: problem_id
            };
            oBDs.push(obj);
            itemAddEditor("bd_item", this);
        }
    });
    $(".postdefinition").click(function () {
        //top.restoreSession(); //figure out how to get this to work
        var action = $(this).attr("action");
        if (action === "delete"){
            if (!confirm("Are you sure you want to delete this Behavioral Definition?")){ return; }
            definitions_IsDeleted = 1; //set the delete flag for scrape
        }
        $(this).closest(".editor").toggleClass('hidden');
        postDefinition(function () {
            var obj = scrapeBD();//scrape into collection
            var objIdx = -1;
            _.each(oBDs, function (element, index, list) {
                if (parseInt(element.id) === parseInt(obj.id) || parseInt(element.id) === -1) { objIdx = index; }
            });
            if (objIdx >= 0){
                if (action === "delete"){
                    oBDs.splice(objIdx,1);
                } else { 
                    oBDs[objIdx] = obj; //replace the node
                } 
            }
            //update list
            loadList("bd_list", "bd_item", oBDs, { tp_problem_number: tp_problem_number });
        });
    });

    //Goals
    $("#addGoal").click(function () {
        if (problemCheck()) {
            //create & reload or set everything to blank ID's
            var obj = { id: -1, tp_problem_number: tp_problem_number,
                GroupID: GroupID, ProblemNumber: ProblemNumber, 
                problem_id: problem_id
            };
            oGoals.push(obj);
            itemAddEditor("goal_item", this);
        }
    });
    $(".postgoal").click(function () {
        //top.restoreSession(); //figure out how to get this to work
        var action = $(this).attr("action");
        if (action === "delete"){
            if (!confirm("Are you sure you want to delete this Goal?")){ return; }
            goals_IsDeleted = 1; //set the delete flag for scrape
        }
        $(this).closest(".editor").toggleClass('hidden');
        postGoal(function () {
            //scrape into collection
            var obj = scrapeGoals();
            var objIdx = -1;
            _.each(oGoals, function (element, index, list) {
                if (parseInt(element.id) === parseInt(obj.id) || parseInt(element.id) === -1) { objIdx = index; }
            });
            if (objIdx >= 0){
                if (action === "delete"){
                    oGoals.splice(objIdx,1);
                } else { 
                    oGoals[objIdx] = obj; //replace the node
                } 
            }
            //update list
            loadList("goals_list", "goal_item", oGoals, { tp_problem_number: tp_problem_number });
        });
    });

    //Objectives
    $("#addObjective").click(function () {
        if (problemCheck()) {
            //create & reload or set everything to blank ID's
            var obj = { id: -1, tp_problem_number: tp_problem_number,
                GroupID: GroupID, ProblemNumber: ProblemNumber, 
                problem_id: problem_id
            };
            oObjectives.push(obj);
            itemAddEditor("objective_item", this);
        }
    });
    $(".postobjective").click(function () {
        //top.restoreSession(); //figure out how to get this to work
        var action = $(this).attr("action");
        if (action === "delete"){
            if (!confirm("Are you sure you want to delete this Objective?")){ return; }
            objectives_IsDeleted = 1; //set the delete flag for scrape
        }
        $(this).closest(".editor").toggleClass('hidden');
        postObjective(function () {
            //scrape into collection
            clearLists('interventions_list');
            var obj = scrapeObjectives();
            //errors("scraped objective => " + JSON.stringify(obj) + "<br/><br/>");
            var objIdx = -1;
            _.each(oObjectives, function (element, index, list) {
                if (parseInt(element.id) === parseInt(obj.id) || parseInt(element.id) === -1) { objIdx = index; }
            });
            if (objIdx >= 0){
                if (action === "delete"){
                    oObjectives.splice(objIdx,1);
                } else { 
                    oObjectives[objIdx] = obj; //replace the node
                } 
            }
            //errors("updated objectives => " + JSON.stringify(oObjectives) + "<br/><br/>");
            //update list
            loadList("objectives_list", "objective_item", oObjectives, { tp_problem_number: tp_problem_number });
        });
    });

    //Interventions
    $("#addIntervention").click(function () {
        if (problemCheck()) {
            //create & reload or set everything to blank ID's
            var obj = { id: -1, tp_problem_number: tp_problem_number,
                GroupID: GroupID, ProblemNumber: ProblemNumber, 
                problem_id: problem_id
            };
            oInterventions.push(obj);
            itemAddEditor("intervention_item", this);
        }
    });
    $(".postintervention").click(function () {
        //top.restoreSession(); //figure out how to get this to work
        var action = $(this).attr("action");
        if (action === "delete"){
            if (!confirm("Are you sure you want to delete this Intervention?")){ return; }
            interventions_IsDeleted = 1; //set the delete flag for scrape
        }
        $(this).closest(".editor").toggleClass('hidden');
        postIntervention(function () {
            //scrape into collection
            var obj = scrapeInterventions();
            var objIdx = -1;
            _.each(oInterventions, function (element, index, list) {
                if (parseInt(element.id) === parseInt(obj.id) || parseInt(element.id) === -1) { objIdx = index; }
            });
            if (objIdx >= 0){
                if (action === "delete"){
                    oInterventions.splice(objIdx,1);
                } else { 
                    oInterventions[objIdx] = obj; //replace the node
                } 
            }
            //update list
            loadList("interventions_list", "intervention_item", oInterventions, { tp_problem_number: tp_problem_number });
        });
    });

    //Modalities
//    $("#addModality").click(function () {
//        //if (problemCheck()) {
//            //create & reload or set everything to blank ID's
//            var obj = { id: -1, tp_problem_number: tp_problem_number,
//                GroupID: GroupID, ProblemNumber: ProblemNumber, 
//                problem_id: problem_id
//            };
//            oModalities.push(obj);
//            itemAddEditor("modality_item", this);
        //}
//    });
//    $(".postmodality").click(function () {
//        //top.restoreSession(); //figure out how to get this to work
//        var action = $(this).attr("action");
//        if (action === "delete"){
//            if (!confirm("Are you sure you want to delete this Modality?")){ return; }
//          modalities_IsDeleted = 1; //set the delete flag for scrape
//        }
//        $(this).closest(".editor").toggleClass('hidden');
//        postModality(function () {
//            //scrape into collection
//            var obj = scrapeModalities();
//            var objIdx = -1;
//            _.each(oModalities, function (element, index, list) {
//                if (parseInt(element.id) === parseInt(obj.id) || parseInt(element.id) === -1) { objIdx = index; }
//            });
//            if (objIdx >= 0){
//                if (action === "delete"){
//                    oModalities.splice(objIdx,1);
//                } else { 
//                   oModalities[objIdx] = obj; //replace the node
//                } 
//            }
//            //update list
//            loadList("modalities_list", "modality_item", oModalities, { tp_problem_number: tp_problem_number });
//        });
//    });

//Modalities - Yves 04-29-2017
    $("#addModality").click(function () {
        if (problemCheck()) {
            //create & reload or set everything to blank ID's
            var obj = { id: -1 };
            oModalities.push(obj);
            itemAddEditor("modality_item", this);
        }
    });
    $(".postmodality").click(function () {
        //top.restoreSession(); //figure out how to get this to work
        var action = $(this).attr("action");
        if (action === "delete"){
            if (!confirm("Are you sure you want to delete this Modality?")){ return; }
            modalities_IsDeleted = 1; //set the delete flag for scrape
        }
        $(this).closest(".editor").toggleClass('hidden');
        postModality(function () {
            //scrape into collection
            var obj = scrapeModalities();
            var objIdx = -1;
            _.each(oModalities, function (element, index, list) {
                if (parseInt(element.id) === parseInt(obj.id) || parseInt(element.id) === -1) { objIdx = index; }
            });
            if (objIdx >= 0){
                if (action === "delete"){
                    oModalities.splice(objIdx,1);
                } else { 
                    oModalities[objIdx] = obj; //replace the node
                } 
            }
            //update list
            loadList("modalities_list", "modality_item", oModalities);
        });
    });

    //Modality Notes
    $("#addModalityNote").click(function () {
        //create & reload or set everything to blank ID's
        var obj = { id: -1 };
        oModalityNotes.push(obj);
        itemAddEditor("modalitynote_item", this);
    });
    $(".postmodalitynote").click(function () {
        //top.restoreSession(); //figure out how to get this to work
        var action = $(this).attr("action");
        if (action === "delete"){
            if (!confirm("Are you sure you want to delete this Modality Note?")){ return; }
            modalitynotes_IsDeleted = 1; //set the delete flag for scrape
        }
        $(this).closest(".editor").toggleClass('hidden');
        postModalityNote(function () {
            //scrape into collection
            var obj = scrapeModalityNotes();
            var objIdx = -1;
            _.each(oModalityNotes, function (element, index, list) {
                if (parseInt(element.id) === parseInt(obj.id) || parseInt(element.id) === -1) { objIdx = index; }
            });
            if (objIdx >= 0){
                if (action === "delete"){
                    oModalityNotes.splice(objIdx,1);
                } else { 
                    oModalityNotes[objIdx] = obj; //replace the node
                } 
            }
            hideAddButton("addModalityNote",oModalityNotes);
            //update list
            loadList("modalitynotes_list", "modalitynote_item", oModalityNotes);
        });
    });

    //Discharge Criteria
    $("#addDischargeCriteria").click(function () {
        //create & reload or set everything to blank ID's
        var obj = { id: -1 };
        oDischargeCriteria.push(obj);
        itemAddEditor("dischargecriteria_item", this);
    });
    $(".postdischargecriteria").click(function () {
        //top.restoreSession(); //figure out how to get this to work
        var action = $(this).attr("action");
        if (action === "delete"){
            if (!confirm("Are you sure you want to delete this Criteria?")){ return; }
            dischargecriteria_IsDeleted = 1; //set the delete flag for scrape
        }
        $(this).closest(".editor").toggleClass('hidden');
        postDischargeCriteria(function () {
            //scrape into collection
            var obj = scrapeDischargeCriteria();
            var objIdx = -1;
            _.each(oDischargeCriteria, function (element, index, list) {
                if (parseInt(element.id) === parseInt(obj.id) || parseInt(element.id) === -1) { objIdx = index; }
            });
            if (objIdx >= 0){
                if (action === "delete"){
                    oDischargeCriteria.splice(objIdx,1);
                } else { 
                    oDischargeCriteria[objIdx] = obj; //replace the node
                } 
            }
            //hideAddButton("addDischargeCriteria",oDischargeCriteria);
            //update list
            loadList("dischargecriteria_list", "dischargecriteria_item", oDischargeCriteria);
        });
    });
    //Strength
    $("#addStrength").click(function () {
        //create & reload or set everything to blank ID's
        var obj = { id: -1 };
        oStrength.push(obj);
        itemAddEditor("strength_item", this);
    });
    $(".poststrength").click(function () {
        //top.restoreSession(); //figure out how to get this to work
        var action = $(this).attr("action");
        if (action === "delete"){
            if (!confirm("Are you sure you want to delete this Strength?")){ return; }
            strength_IsDeleted = 1; //set the delete flag for scrape
        }
        $(this).closest(".editor").toggleClass('hidden');
        postStrength(scrapeStrength, "strength_id", function () {
            //scrape into collection
            var obj = scrapeStrength();
            var objIdx = -1;
            _.each(oStrength, function (element, index, list) {
                if (parseInt(element.id) === parseInt(obj.id) || parseInt(element.id) === -1) { objIdx = index; }
            });
            if (objIdx >= 0){
                if (action === "delete"){
                    oStrength.splice(objIdx,1);
                } else { 
                    oStrength[objIdx] = obj; //replace the node
                } 
            }
            //update list
            loadList("strength_list", "strength_item", oStrength);
        });
    });
	//Weakness
    $("#addWeakness").click(function () {
        //create & reload or set everything to blank ID's
        var obj = { id: -1 };
        oWeakness.push(obj);
        itemAddEditor("weakness_item", this);
    });
    $(".postweakness").click(function () {
        //top.restoreSession(); //figure out how to get this to work
        var action = $(this).attr("action");
        if (action === "delete"){
            if (!confirm("Are you sure you want to delete this Weakness?")){ return; }
            strength_IsDeleted = 1; //set the delete flag for scrape
        }
        $(this).closest(".editor").toggleClass('hidden');
        postWeakness(scrapeWeakness, "strength_id", function () {
            //scrape into collection
            var obj = scrapeWeakness();
            var objIdx = -1;
            _.each(oWeakness, function (element, index, list) {
                if (parseInt(element.id) === parseInt(obj.id) || parseInt(element.id) === -1) { objIdx = index; }
            });
            if (objIdx >= 0){
                if (action === "delete"){
                    oWeakness.splice(objIdx,1);
                } else { 
                    oWeakness[objIdx] = obj; //replace the node
                } 
            }
            //update list
            loadList("weakness_list", "weakness_item", oWeakness);
        });
    });
    
	//Summary
    $("#addSummary").click(function () {
        //create & reload or set everything to blank ID's
        var obj = { id: -1 };
        oSummary.push(obj);
        itemAddEditor("summary_item", this);
    });
    $(".postsummary").click(function () {
        //top.restoreSession(); //figure out how to get this to work
        var action = $(this).attr("action");
        if (action === "delete"){
            if (!confirm("Are you sure you want to delete this Summary?")){ return; }
            summary_IsDeleted = 1; //set the delete flag for scrape
        }
        $(this).closest(".editor").toggleClass('hidden');
        postSummary(scrapeSummary, "summary_id", function () {
            //scrape into collection
            var obj = scrapeSummary();
            var objIdx = -1;
            _.each(oSummary, function (element, index, list) {
                if (parseInt(element.id) === parseInt(obj.id) || parseInt(element.id) === -1) { objIdx = index; }
            });
            if (objIdx >= 0){
                if (action === "delete"){
                    oSummary.splice(objIdx,1);
                } else { 
                    oSummary[objIdx] = obj; //replace the node
                } 
            }
            //hideAddButton("addSummary",oSummary);

            //update list
            loadList("summary_list", "summary_item", oSummary);
        });
    });

    //Diagnosis
    $("#addDiagnosis").click(function () {
        //create & reload or set everything to blank ID's
        var obj = { id: -1 };
        oDiagnosis.push(obj);
        itemAddEditor("diagnosis_item", this);
    });
    $(".postdiagnosis").click(function () {
        //top.restoreSession(); //figure out how to get this to work
        var action = $(this).attr("action");
        if (action === "delete"){
            if (!confirm("Are you sure you want to delete this Diagnosis?")){ return; }
            diagnosis_IsDeleted = 1; //set the delete flag for scrape
        }
        $(this).closest(".editor").toggleClass('hidden');
        postDiagnosis(scrapeDiagnosis, "diagnosis_id", function () {
            //scrape into collection
            var obj = scrapeDiagnosis();
            var objIdx = -1;
            _.each(oDiagnosis, function (element, index, list) {
                if (parseInt(element.id) === parseInt(obj.id) || parseInt(element.id) === -1) { objIdx = index; }
            });
            if (objIdx >= 0){
                if (action === "delete"){
                    oDiagnosis.splice(objIdx,1);
                } else { 
                    oDiagnosis[objIdx] = obj; //replace the node
                } 
            }
            //update list
            loadList("diagnosis_list", "diagnosis_item", oDiagnosis);
        });
    });
    //Diagnosis2
    $("#addDiagnosis2").click(function () {
        //create & reload or set everything to blank ID's
        var obj = { id: -1 };
        oDiagnosis2.push(obj);
        itemAddEditor("diagnosis2_item", this);
    });
    $(".postdiagnosis2").click(function () {
        //top.restoreSession(); //figure out how to get this to work
        var action = $(this).attr("action");
        if (action === "delete"){
            if (!confirm("Are you sure you want to delete this Diagnosis?")){ return; }
            diagnosis2_IsDeleted = 1; //set the delete flag for scrape
        }
        $(this).closest(".editor").toggleClass('hidden');
        postDiagnosis2(scrapeDiagnosis2, "diagnosis2_id", function () {
            //scrape into collection
            var obj = scrapeDiagnosis2();
            var objIdx = -1;
            _.each(oDiagnosis2, function (element, index, list) {
                if (parseInt(element.id) === parseInt(obj.id) || parseInt(element.id) === -1) { objIdx = index; }
            });
            if (objIdx >= 0){
                if (action === "delete"){
                    oDiagnosis2.splice(objIdx,1);
                } else { 
                    oDiagnosis2[objIdx] = obj; //replace the node
                } 
            }
            //update list
            loadList("diagnosis_2list", "diagnosis2_item", oDiagnosis2);
        });
    });    

    //Diagnosis2
    $("#addDiagnosis2").click(function () {
        //create & reload or set everything to blank ID's
        var obj = { id: -1 };
        oDiagnosis2.push(obj);
        itemAddEditor("diagnosis2_item", this);
    });
    $(".postdiagnosis2").click(function () {
        //top.restoreSession(); //figure out how to get this to work
        var action = $(this).attr("action");
        if (action === "delete"){
            if (!confirm("Are you sure you want to delete this Diagnosis?")){ return; }
            diagnosis2_IsDeleted = 1; //set the delete flag for scrape
        }
        $(this).closest(".editor").toggleClass('hidden');
        postDiagnosis(scrapeDiagnosis2, "diagnosis2_id", function () {
            //scrape into collection
            var obj = scrapeDiagnosis2();
            var objIdx = -1;
            _.each(oDiagnosis2, function (element, index, list) {
                if (parseInt(element.id) === parseInt(obj.id) || parseInt(element.id) === -1) { objIdx = index; }
            });
            if (objIdx >= 0){
                if (action === "delete"){
                    oDiagnosis2.splice(objIdx,1);
                } else { 
                    oDiagnosis2[objIdx] = obj; //replace the node
                } 
            }
            //update list
            loadList("diagnosis2_list", "diagnosis2_item", oDiagnosis2);
        });
    });
    
    //Diagnosis3
    $("#addDiagnosis3").click(function () {
        //create & reload or set everything to blank ID's
        var obj = { id: -1 };
        oDiagnosis3.push(obj);
        itemAddEditor("diagnosis3_item", this);
    });
    $(".postdiagnosis3").click(function () {
        //top.restoreSession(); //figure out how to get this to work
        var action = $(this).attr("action");
        if (action === "delete"){
            if (!confirm("Are you sure you want to delete this Diagnosis?")){ return; }
            diagnosis3_IsDeleted = 1; //set the delete flag for scrape
        }
        $(this).closest(".editor").toggleClass('hidden');
        postDiagnosis(scrapeDiagnosis3, "diagnosis3_id", function () {
            //scrape into collection
            var obj = scrapeDiagnosis3();
            var objIdx = -1;
            _.each(oDiagnosis3, function (element, index, list) {
                if (parseInt(element.id) === parseInt(obj.id) || parseInt(element.id) === -1) { objIdx = index; }
            });
            if (objIdx >= 0){
                if (action === "delete"){
                    oDiagnosis3.splice(objIdx,1);
                } else { 
                    oDiagnosis3[objIdx] = obj; //replace the node
                } 
            }
            //update list
            loadList("diagnosis3_list", "diagnosis3_item", oDiagnosis3);
        });
    });
    
    //Diagnosis4
    $("#addDiagnosis4").click(function () {
        //create & reload or set everything to blank ID's
        var obj = { id: -1 };
        oDiagnosis4.push(obj);
        itemAddEditor("diagnosis4_item", this);
    });
    $(".postdiagnosis4").click(function () {
        //top.restoreSession(); //figure out how to get this to work
        var action = $(this).attr("action");
        if (action === "delete"){
            if (!confirm("Are you sure you want to delete this Diagnosis?")){ return; }
            diagnosis4_IsDeleted = 1; //set the delete flag for scrape
        }
        $(this).closest(".editor").toggleClass('hidden');
        postDiagnosis(scrapeDiagnosis4, "diagnosis4_id", function () {
            //scrape into collection
            var obj = scrapeDiagnosis4();
            var objIdx = -1;
            _.each(oDiagnosis4, function (element, index, list) {
                if (parseInt(element.id) === parseInt(obj.id) || parseInt(element.id) === -1) { objIdx = index; }
            });
            if (objIdx >= 0){
                if (action === "delete"){
                    oDiagnosis4.splice(objIdx,1);
                } else { 
                    oDiagnosis4[objIdx] = obj; //replace the node
                } 
            }
            //update list
            loadList("diagnosis4_list", "diagnosis4_item", oDiagnosis4);
        });
    });
    
    //Diagnosis5
    $("#addDiagnosis5").click(function () {
        //create & reload or set everything to blank ID's
        var obj = { id: -1 };
        oDiagnosis5.push(obj);
        itemAddEditor("diagnosis5_item", this);
    });
    $(".postdiagnosis5").click(function () {
        //top.restoreSession(); //figure out how to get this to work
        var action = $(this).attr("action");
        if (action === "delete"){
            if (!confirm("Are you sure you want to delete this Diagnosis?")){ return; }
            diagnosis5_IsDeleted = 1; //set the delete flag for scrape
        }
        $(this).closest(".editor").toggleClass('hidden');
        postDiagnosis(scrapeDiagnosis5, "diagnosis5_id", function () {
            //scrape into collection
            var obj = scrapeDiagnosis5();
            var objIdx = -1;
            _.each(oDiagnosis5, function (element, index, list) {
                if (parseInt(element.id) === parseInt(obj.id) || parseInt(element.id) === -1) { objIdx = index; }
            });
            if (objIdx >= 0){
                if (action === "delete"){
                    oDiagnosis5.splice(objIdx,1);
                } else { 
                    oDiagnosis5[objIdx] = obj; //replace the node
                } 
            }
            //update list
            loadList("diagnosis5_list", "diagnosis5_item", oDiagnosis5);
        });
    });            

    /* ---------- */
    /*  YC notes  */
    /* ---------- */
    //$("#form_id").focusout(function () { formChange(); });
    //anytime we need to redraw the form
    var formChange = function () {
        $("#availableProblems").html("");
        oProblems = [];
        tp_problem_number = 0;
        $('#tp_problem_number').val(tp_problem_number);
        var probParams = { form_id: $('#form_id').val(), api: "getproblems" };
        getCollection(probParams, "oProblems", loadProblemSelector);
	
	//-modalitie Yves 04-29-2017(Try it deleted)
        var form_id = $("#form_id").val();
        var params = { api: "getmodalities", form_id: form_id };
        clearLists("modalities_list");
        getCollection(params, "oModalities", function () {
            hideAddButton("addModalities",oModalities);
            loadList("modalities_list", "modality_item", oModalities);
        });

        //-modality notes
        var form_id = $("#form_id").val();
        var params = { api: "getmodalitynotes", form_id: form_id };
        clearLists("modalitynotes_list");
        getCollection(params, "oModalityNotes", function () {
            hideAddButton("addModalityNote",oModalityNotes);
            loadList("modalitynotes_list", "modalitynote_item", oModalityNotes);
        });

	//-discharge criteria
        var form_id = $("#form_id").val();
        var params = { api: "getdischargecriteria", form_id: form_id };
        clearLists("dischargecriteria_list");
        getCollection(params, "oDischargeCriteria", function () {
              loadList("dischargecriteria_list", "dischargecriteria_item", oDischargeCriteria);
        });
        
        //-diagnosis
        params = { api: "getdiagnosis", form_id: form_id, axis: 1 };
        clearLists("diagnosis_list");
        getCollection(params, "oDiagnosis", function () {
            loadList("diagnosis_list", "diagnosis_item", oDiagnosis); //, { tp_problem_number: tp_problem_number }
        });
        
        //-diagnosis2
        params = { api: "getdiagnosis", form_id: form_id, axis: 2 };
        clearLists("diagnosis2_list");
        getCollection(params, "oDiagnosis2", function () {
            loadList("diagnosis2_list", "diagnosis2_item", oDiagnosis2); //, { tp_problem_number: tp_problem_number }
        });

        //-diagnosis3
        params = { api: "getdiagnosis", form_id: form_id, axis: 3 };
        clearLists("diagnosis3_list");
        getCollection(params, "oDiagnosis3", function () {
            hideAddButton("addDiagnosis3",oDiagnosis3);
            loadList("diagnosis3_list", "diagnosis3_item", oDiagnosis3); //, { tp_problem_number: tp_problem_number }
        });
        
        //-diagnosis4
        params = { api: "getdiagnosis", form_id: form_id, axis: 4 };
        clearLists("diagnosis4_list");
        getCollection(params, "oDiagnosis4", function () {
            loadList("diagnosis4_list", "diagnosis4_item", oDiagnosis4); //, { tp_problem_number: tp_problem_number }
        });
        
        //-diagnosis5
        params = { api: "getdiagnosis", form_id: form_id, axis: 5 };
        clearLists("diagnosis5_list");
        getCollection(params, "oDiagnosis5", function () {
            hideAddButton("addDiagnosis5",oDiagnosis5);
            loadList("diagnosis5_list", "diagnosis5_item", oDiagnosis5); //, { tp_problem_number: tp_problem_number }
        });  
         //-strength
        var form_id = $("#form_id").val();
        var params = { api: "getstrength", form_id: form_id };
        clearLists("strength_list");
        getCollection(params, "oStrength", function () {
            //hideAddButton("addStrength",oStrength);
            loadList("strength_list", "strength_item", oStrength);
        });

         //-weakness
        var form_id = $("#form_id").val();
        var params = { api: "getweakness", form_id: form_id };
        clearLists("Weakness_list");
        getCollection(params, "oWeakness", function () {
            //hideAddButton("addWeakness",oWeakness);
            loadList("weakness_list", "weakness_item", oWeakness);
        });
		//-summary
        var form_id = $("#form_id").val();
        var params = { api: "getsummary", form_id: form_id };
        clearLists("Summary_list");
        getCollection(params, "oSummary", function () {
            hideAddButton("addSummary",oSummary);
            loadList("summary_list", "summary_item", oSummary);
        });
              
    };

    var hideAddButton = function(addButtonID,object){
        if(object.length > 0){
            if (object[0].id > 0){
                $("#"+addButtonID).addClass("hidden");
            }
        } else {
            $("#"+addButtonID).removeClass("hidden");
        };
    };
        
    var hideDevInputs = function () {
        if (dev === 1) {
            $(".dev").addClass("hidden");
        }
    };

    //INIT form
    //-----------
    //$('#form_id').val(1)
    formChange();
    hideDevInputs();
});

//http://snippets.aktagon.com/snippets/310-positioning-an-element-over-another-element-with-jquery
$.fn.positionOn = function(element, align) {
  return this.each(function() {
    var target   = $(this);
    var position = element.position();

    var x      = position.left; 
    var y      = position.top;

    if(align === 'right') {
      x -= (target.outerWidth() - element.outerWidth());
    } else if(align === 'center') {
      x -= target.outerWidth() / 2 - element.outerWidth() / 2;
    }

    target.css({
      position: 'absolute',
      zIndex:   5000,
      top:      y, 
      left:     x
    });
  });
};


// Extended jQuery to now have a disable function
jQuery.fn.extend({
    disable: function(state) {
        return this.each(function() {
            var $this = $(this);
            if($this.is('input, button, textarea'))
              this.disabled = state;
            else
              $this.toggleClass('disabled', state);
        });
    }
});





