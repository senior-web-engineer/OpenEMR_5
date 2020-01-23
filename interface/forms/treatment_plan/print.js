

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
        tp_problem_number = 0;
    };

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
                    //list += "<button class='btn btn-primary editbtn' editortype='" + editorType + "' recid='" + item.id + "'>Edit</button>";
                    //these show before the description
                    switch (editorType) {
                    	case "objective_item":

                    	break;
                    	case "problem_item":

                    	break;
                    	case "modality_item":

	                   	break;
                    	case "modalitynote_item":
                            list += "&nbsp;<span>" + item.Notes + "</span>"
	                   	break;
                    };
                    //description (if it's available)
                    if (!_.isUndefined(item.Description)) { list += "&nbsp;<span>" + item.Description + "</span>"; }
                    //these show after the description
                    switch (editorType) {
                    	case "objective_item":
		                    list += "&nbsp;<br><b>Target Date: </b><span>" + item.target_date + "</span>";
							list += "&nbsp;<b>Sessions: </b><span>" + item.sessions + "</span>";
                    	break;
                    	case "problem_item":
                    		//nothing happens
                    	break;
                    	case "modality_item":
                    	    list += "&nbsp;<br><b>Modality: </b><span>" + item.modality + "</span>";
							list += "&nbsp;<b>Code: </b><span>" + item.hcpt + "</span>";
							list += "&nbsp;<b>Interval: </b><span>" + item.interval + "</span>";
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
                var params = { api: "getinterventions", form_id: form_id, tp_problem_number: tp_problem_number, ObjectiveID: id };
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
        if (_.isUndefined(listType) || listType == "bd_list") {
            oBDs = [];
            loadList("bd_list", "bd_item", oBDs);
        }
        if (_.isUndefined(listType) || listType == "goals_list") {
            oGoals = [];
            loadList("goals_list", "goal_item", oGoals);
        }
        if (_.isUndefined(listType) || listType == "objectives_list") {
            oObjectives = [];
            loadList("objectives_list", "objective_item", oObjectives);
        }
        if (_.isUndefined(listType) || listType == "interventions_list") {
            $("#interventionsection").addClass('hidden');
            oInterventions = [];
            loadList("interventions_list", "intervention_item", oInterventions);
        }
         if (_.isUndefined(listType) || listType == "modalities_list") {
            oModalities = [];
            loadList("modalities_list", "modality_item", oModalities);
        }
         if (listType == "modalitynotes_list") {
            oModalityNotes = [];
            loadList("modalitynotes_list", "modalitynote_item", oModalityNotes);
        }
        if (listType == "strength_list") {
            oStrength = [];
            loadList("strength_list", "strength_item", oStrength);
        }

    };
    

    var clearEditors = function (editorType) {
        if (_.isUndefined(editorType) || editorType == "problem_item") {
            fillProblems({});
        }
        if (_.isUndefined(editorType) || editorType == "bd_item") {
            fillBDs({});
        }
        if (_.isUndefined(editorType) || editorType == "goal_item") {
            fillGoals({});
        }
        if (_.isUndefined(editorType) || editorType == "objective_item") {
            fillObjectives({});
        }
        if (_.isUndefined(editorType) || editorType == "intervention_item") {
            fillInterventions({});
        }
        if (_.isUndefined(editorType) || editorType == "modality_item") {
            fillModalities({});
        }
        if (_.isUndefined(editorType) || editorType == "modalitynote_item") {
            fillModalityNotes({});
        }
        if (_.isUndefined(editorType) || editorType == "strength_item") {
            fillStrength({});
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

    //Problems
    $("#availableProblems").on('change', function () {
        closeEditors(); //clear
        clearLists(); //clear all lists
        var problemid = this.value;
        var form_id = $("#form_id").val();
        var problem = _.findWhere(oProblems, { id: problemid });
        if (!_.isUndefined(problem)) {
            tp_problem_number = problem.tp_problem_number;
            GroupID = problem.GroupID;
            ProblemNumber = problem.ProblemNumber;
        } else {
            alert("Error loading problem");
            tp_problem_number = 0;
            GroupID = 0;
            ProblemNumber = 0;
        }
        $("#tp_problem_number").val(tp_problem_number || 0);
        //reload top level sections
        //-problem
        loadList("problems_list", "problem_item", oProblems, { tp_problem_number: tp_problem_number });
        //-beh definitions
        var params = { api: "getbds", form_id: form_id, tp_problem_number: tp_problem_number };
        getCollection(params, "oBDs", function () {
            loadList("bd_list", "bd_item", oBDs, { tp_problem_number: tp_problem_number });
        });
        //-goals
        var params = { api: "getgoals", form_id: form_id, tp_problem_number: tp_problem_number };
        getCollection(params, "oGoals", function () {
            loadList("goals_list", "goal_item", oGoals, { tp_problem_number: tp_problem_number });
        });
        //-objectives
        params = { api: "getobjectives", form_id: form_id, tp_problem_number: tp_problem_number };
        getCollection(params, "oObjectives", function () {
            loadList("objectives_list", "objective_item", oObjectives, { tp_problem_number: tp_problem_number });
        });
        //-modalities
        var params = { api: "getmodalities", form_id: form_id, tp_problem_number: tp_problem_number };
        getCollection(params, "oModalities", function () {
            loadList("modalities_list", "modality_item", oModalities, { tp_problem_number: tp_problem_number });
        });
    });
    $("#addProblem").click(function () {
        //create & reload or set everything to blank ID's
        oProblems.push({ id: -1, tp_problem_number: $("#availableProblems").children().length });
        $("#tp_problem_number").val($("#availableProblems").children().length);
        tp_problem_number = $("#availableProblems").children().length;
        itemAddEditor("problem_item", this);
    });
    $("#saveproblem").click(function () {
        //top.restoreSession(); //figure out how to get this to work
        $(this).closest(".editor").toggleClass('hidden');
        postProblem(function () {
            //reload problem collection and selector
            loadList("problems_list", "problem_item", []);
            clearLists();
            var probParams = { form_id: $('#form_id').val(), api: "getproblems" };
            getCollection(probParams, "oProblems", loadProblemSelector);
        });
    });

    //BD
    $("#addBD").click(function () {
        if (problemCheck()) {
            //create & reload or set everything to blank ID's
            var obj = { id: -1, tp_problem_number: tp_problem_number,
                GroupID: GroupID, ProblemNumber: ProblemNumber
            };
            oBDs.push(obj);
            itemAddEditor("bd_item", this);
        }
    });
    $("#savebd").click(function () {
        //top.restoreSession(); //figure out how to get this to work
        $(this).closest(".editor").toggleClass('hidden');
        postDefinition(function () {
            //scrape into collection
            var obj = scrapeBD();
            _.each(oBDs, function (element, index, list) {
                //replace the node
                if (parseInt(element.id) == parseInt(obj.id)) { oBDs[index] = obj; }
                if (parseInt(element.id) == -1) { oBDs[index] = obj; }
            });
            //update list
            loadList("bd_list", "bd_item", oBDs, { tp_problem_number: tp_problem_number });
        });
    });

    //Goals
    $("#addGoal").click(function () {
        if (problemCheck()) {
            //create & reload or set everything to blank ID's
            var obj = { id: -1, tp_problem_number: tp_problem_number,
                GroupID: GroupID, ProblemNumber: ProblemNumber
            };
            oGoals.push(obj);
            itemAddEditor("goal_item", this);
        }
    });
    $("#savegoal").click(function () {
        //top.restoreSession(); //figure out how to get this to work
        $(this).closest(".editor").toggleClass('hidden');
        postGoal(function () {
            //scrape into collection
            var obj = scrapeGoals();
            _.each(oGoals, function (element, index, list) {
                //replace the node
                if (parseInt(element.id) == parseInt(obj.id)) { oGoals[index] = obj; }
                if (parseInt(element.id) == -1) { oGoals[index] = obj; }
            });
            //update list
            loadList("goals_list", "goal_item", oGoals, { tp_problem_number: tp_problem_number });
        });
    });

    //Objectives
    $("#addObjective").click(function () {
        if (problemCheck()) {
            //create & reload or set everything to blank ID's
            var obj = { id: -1, tp_problem_number: tp_problem_number,
                GroupID: GroupID, ProblemNumber: ProblemNumber
            };
            oObjectives.push(obj);
            itemAddEditor("objective_item", this);
        }
    });
    $("#saveobjective").click(function () {
        //top.restoreSession(); //figure out how to get this to work
        $(this).closest(".editor").toggleClass('hidden');
        postObjective(function () {
            //scrape into collection
            clearLists('interventions_list');
            var obj = scrapeObjectives();
            //errors("scraped objective => " + JSON.stringify(obj) + "<br/><br/>");
            _.each(oObjectives, function (element, index, list) {
                //replace the node
                if (parseInt(element.id) == parseInt(obj.id)) { oObjectives[index] = obj; }
                if (parseInt(element.id) == -1) { oObjectives[index] = obj; }
            });
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
                GroupID: GroupID, ProblemNumber: ProblemNumber
            };
            oInterventions.push(obj);
            itemAddEditor("intervention_item", this);
        }
    });
    $("#saveintervention").click(function () {
        //top.restoreSession(); //figure out how to get this to work
        $(this).closest(".editor").toggleClass('hidden');
        postIntervention(function () {
            //scrape into collection
            var obj = scrapeInterventions();
            //errors("scraped intervention => " + JSON.stringify(obj) + "<br/><br/>");
            _.each(oInterventions, function (element, index, list) {
                //replace the node
                if (parseInt(element.id) == parseInt(obj.id)) { oInterventions[index] = obj; }
                if (parseInt(element.id) == -1) { oInterventions[index] = obj; }
            });
            //errors("updated interventions => " + JSON.stringify(oInterventions) + "<br/><br/>");
            //update list
            loadList("interventions_list", "intervention_item", oInterventions, { tp_problem_number: tp_problem_number });
        });
    });

    //Modalities
    $("#addModality").click(function () {
        //if (problemCheck()) {
            //create & reload or set everything to blank ID's
            var obj = { id: -1, tp_problem_number: tp_problem_number,
                GroupID: GroupID, ProblemNumber: ProblemNumber
            };
            oModalities.push(obj);
            itemAddEditor("modality_item", this);
        //}
    });
    $("#savemodality").click(function () {
        //top.restoreSession(); //figure out how to get this to work
        $(this).closest(".editor").toggleClass('hidden');
        postModality(function () {
            //scrape into collection
            var obj = scrapeModalities();
            _.each(oModalities, function (element, index, list) {
                //replace the node
                if (parseInt(element.id) == parseInt(obj.id)) { oModalities[index] = obj; }
                if (parseInt(element.id) == -1) { oModalities[index] = obj; }
            });
            //update list
            loadList("modalities_list", "modality_item", oModalities, { tp_problem_number: tp_problem_number });
        });
    });

    //Modality Notes
    $("#addModalityNote").click(function () {
        //create & reload or set everything to blank ID's
        var obj = { id: -1 };
        oModalityNotes.push(obj);
        itemAddEditor("modalitynote_item", this);
    });
    $("#savemodalitynote").click(function () {
        //top.restoreSession(); //figure out how to get this to work
        $(this).closest(".editor").toggleClass('hidden');
        postModalityNote(function () {
            //scrape into collection
            var obj = scrapeModalityNotes();
            _.each(oModalityNotes, function (element, index, list) {
                //replace the node
                if (parseInt(element.id) == parseInt(obj.id)) { oModalityNotes[index] = obj; }
                if (parseInt(element.id) == -1) { oModalityNotes[index] = obj; }
            });
            hideAddModalityNotes(); //if we have one already there
            //update list
            loadList("modalitynotes_list", "modalitynote_item", oModalityNotes);
        });
        
        //Strength
    $("#addStrength").click(function () {
        //create & reload or set everything to blank ID's
        var obj = { id: -1 };
        oStrength.push(obj);
        itemAddEditor("strength_item", this);
    });
    $("#savestrength").click(function () {
        //top.restoreSession(); //figure out how to get this to work
        $(this).closest(".editor").toggleClass('hidden');
        postStrength(function () {
            //scrape into collection
            var obj = scrapeStrength();
            _.each(oStrength, function (element, index, list) {
                //replace the node
                if (parseInt(element.id) == parseInt(obj.id)) { oStrength[index] = obj; }
                if (parseInt(element.id) == -1) { oStrength[index] = obj; }
            });
            hideAddStrength(); //if we have one already there
            //update list
            loadList("strength_list", "strength_item", oStrength);
        });

        
        
        
        
    });

    /* ---------- */
    /*  YC notes  */
    /* ---------- */
    //$("#form_id").focusout(function () { formChange(); });

    var formChange = function () {
        $("#availableProblems").html("");
        oProblems = [];
        tp_problem_number = 0;
        $('#tp_problem_number').val(tp_problem_number);
        var probParams = { form_id: $('#form_id').val(), api: "getproblems" };
        getCollection(probParams, "oProblems", loadProblemSelector);

        //-modality notes
        var form_id = $("#form_id").val();
        var params = { api: "getmodalitynotes", form_id: form_id };
        clearLists("modalitynotes_list");
        getCollection(params, "oModalityNotes", function () {
            hideAddModalityNotes();
            loadList("modalitynotes_list", "modalitynote_item", oModalityNotes);
        });
    };

    var hideAddModalityNotes = function(){
        if(oModalityNotes.length > 0){
            if (oModalityNotes[0].id > 0){
                $("#addModalityNote").addClass("hidden");
            }
        };
    };
    
    var hideDevInputs = function () {
        if (dev === 0) {
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

    if(align == 'right') {
      x -= (target.outerWidth() - element.outerWidth());
    } else if(align == 'center') {
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






