    var dataPath = "";
	//object collections
	var oProblems = [];
	var oBDs = [];
	var oGoals = [];
	var oObjectives = [];
	var oInterventions = [];
	var oModalities = [];
	var oModalityNotes = [];
	var oDischargeCriteria = [];
	var oStrength = [];
	var oWeakness = [];
	var oSummary = [];
	var oDiagnosis = [];
	var oDiagnosis2 = [];
	var oDiagnosis3 = [];
	var oDiagnosis4 = [];
	var oDiagnosis5 = [];

	var problems_IsDeleted = 0;
	var definitions_IsDeleted = 0;
	var goals_IsDeleted = 0;
	var objectives_IsDeleted = 0;
	var interventions_IsDeleted = 0;
	var modalities_IsDeleted = 0;
	var modalitynotes_IsDeleted = 0;
	var dischargecriteria_IsDeleted = 0;
    var strength_IsDeleted = 0;
    var weakness_IsDeleted = 0;
    var summary_IsDeleted = 0;
    var diagnosis_IsDeleted = 0;
    var diagnosis2_IsDeleted = 0;
    var diagnosis3_IsDeleted = 0;
    var diagnosis4_IsDeleted = 0;
    var diagnosis5_IsDeleted = 0;

    var problem_id = 0;
	
	//generic ajax function
    var pullData = function(params,page,afterLoad){
        $.post(dataPath + "" + page, params, function(retObj){
			var loggedOut = false;
			if (_.isUndefined(retObj.data) ){
				loggedOut = retObj.indexOf('login_frame.ph')>=0;
			}
			if(!loggedOut){
				//handle server errors
				if (retObj.error.length > 0){
					alert(retObj.error);
				} else {
					if (!_.isUndefined(afterLoad)) {
						afterLoad(retObj);
					}
				}
			} else {
                 alert('Please log in to OpenEMR.');
			}
        })
        .error(function(data, textStatus){
            if (afterLoad) {
                afterLoad(data);
            }
        });
    };

	//get data
	var getCollection = function(params, collectionName, afterComplete){ //optional parameter function
		pullData(params,"get.php",function(data){
			if (!_.isUndefined(data.data)){
				if(!_.isUndefined(data.data.list)){ 
					switch (collectionName){
						case "oProblems":  oProblems = data.data.list;  break;
						case "oBDs":  oBDs = data.data.list;  break;
						case "oGoals":  oGoals = data.data.list;  break;
						case "oObjectives":  oObjectives = data.data.list;  break;
						case "oInterventions":  oInterventions = data.data.list;  break;
						case "oModalities":  oModalities = data.data.list;  break;
						case "oModalityNotes":  oModalityNotes = data.data.list;  break;
					    case "oDischargeCriteria":  oDischargeCriteria = data.data.list;  break;
					    case "oStrength":  oStrength = data.data.list;  break;
					    case "oWeakness":  oWeakness = data.data.list;  break;
					    case "oSummary":  oSummary = data.data.list;  break;
					    case "oDiagnosis":  oDiagnosis = data.data.list;  break;
					    case "oDiagnosis2":  oDiagnosis2 = data.data.list;  break;
					    case "oDiagnosis3":  oDiagnosis3 = data.data.list;  break;
					    case "oDiagnosis4":  oDiagnosis4 = data.data.list;  break;
					    case "oDiagnosis5":  oDiagnosis5 = data.data.list;  break;
					}
					
				};			
				if(!_.isUndefined(afterComplete)){
					afterComplete();
				}
			} else { alert("Was not able to get data from server."); }
		});
	};	
	
	//post form
	var postTP = function(afterComplete){ //optional parameter function
		pullData(scrapeTP(),"save.php",function(data){
			if (!_.isUndefined(data.data)){
				if(!_.isUndefined(afterComplete)){
					afterComplete(data.data);
				}
			} else { alert("Treatment Plan not saved"); }
		});
	};
	
	var postProblem = function(afterComplete){
		//postTP first to ensure it exists
		postTP(function(data){
			var tpid = data.id;
			//alert("tpid = " + tpid);
			$('#form_id').val(tpid); //in case it wasn't set before
		
			//post problems
			pullData(scrapeProblems(),"save.php",function(data){
				if (!_.isUndefined(data.data)){
					var problemid = data.data.id;
					//alert("problemid = " + problemid);
					$('#problems_id').val(problemid); //incase it wasn't set before
					if(!_.isUndefined(afterComplete)){
						afterComplete();
					}
				} else { alert("Problem not saved"); }
			});
		});
	};
	
	var postProblemPrimary = function(problemId, IsPrimary, afterComplete){
		var obj = {
			api : 'saveproblemprimary',	
			id : problemId,
			form_id : $('#form_id').val(),
			IsPrimary : IsPrimary
		};
	
		//post problems
		pullData(obj,"save.php",function(data){
			if (!_.isUndefined(data.data)){
				//var problemid = data.data.id;
				//alert("problemid = " + problemid);
				if(!_.isUndefined(afterComplete)){
					afterComplete();
				}
			} else { alert("Problem Is Primary not saved"); }
		});
	};
	
	var postDefinition = function(afterComplete){
		//post Behavioral definition -it depends on problem
		pullData(scrapeBD(),"save.php",function(data){
			if (!_.isUndefined(data.data)){
				var defid = data.data.id;
				//alert("definition id = " + defid);
				$('#definitions_id').val(defid); //incase it wasn't set before
				if(!_.isUndefined(afterComplete)){
					afterComplete();
				}
			} else { alert("Behavioral Definition not saved"); }
		});
	};	
	
	var postGoal = function(afterComplete){
		pullData(scrapeGoals(),"save.php",function(data){
			if (!_.isUndefined(data.data)){
				var defid = data.data.id;
				$('#goals_id').val(defid); //incase it wasn't set before
				if(!_.isUndefined(afterComplete)){
					afterComplete();
				}
			} else { alert("Goal not saved"); }
		});
	};	
	
	var postObjective = function(afterComplete){
		pullData(scrapeObjectives(),"save.php",function(data){
			if (!_.isUndefined(data.data)){
				var defid = data.data.id;
				$('#objectives_id').val(defid); //incase it wasn't set before
				if(!_.isUndefined(afterComplete)){
					afterComplete();
				}
			} else { alert("Objective not saved"); }
		});
	};	

	var postIntervention = function(afterComplete){
		pullData(scrapeInterventions(),"save.php",function(data){
			if (!_.isUndefined(data.data)){
				var defid = data.data.id;
				$('#interventions_id').val(defid); //incase it wasn't set before
				if(!_.isUndefined(afterComplete)){
					afterComplete();
				}
			} else { alert("Intervention not saved"); }
		});
	};	
	
	var postModality = function(afterComplete){
		pullData(scrapeModalities(),"save.php",function(data){
			if (!_.isUndefined(data.data)){
				var defid = data.data.id;
				$('#modalities_id').val(defid); //incase it wasn't set before
				if(!_.isUndefined(afterComplete)){
					afterComplete();
				}
			} else { alert("Modality not saved"); }
		});
	};	

	var postModalityNote = function(afterComplete){
		pullData(scrapeModalityNotes(),"save.php",function(data){
			if (!_.isUndefined(data.data)){
				var defid = data.data.id;
				$('#modalitynotes_id').val(defid); //incase it wasn't set before
				if(!_.isUndefined(afterComplete)){
					afterComplete();
				}
			} else { alert("Modality Note not saved"); }
		});
	};
	
	var postDischargeCriteria = function(afterComplete){
		pullData(scrapeDischargeCriteria(),"save.php",function(data){
			if (!_.isUndefined(data.data)){
				var defid = data.data.id;
				$('#dischargecriteria_id').val(defid); //incase it wasn't set before
				if(!_.isUndefined(afterComplete)){
					afterComplete();
				}
			} else { alert("Discharge Criteria not saved"); }
		});
	};
	
	var postDiagnosis = function(scrapeFn, diagnosis_id, afterComplete){
		pullData(scrapeFn(),"save.php",function(data){
			if (!_.isUndefined(data.data)){
				var defid = data.data.id;
				$('#' + diagnosis_id).val(defid); //incase it wasn't set before
				if(!_.isUndefined(afterComplete)){
					afterComplete();
				}
			} else { alert("Diagnosis not saved"); }
		});
	};
	var postStrength = function(scrapeFn, strength_id, afterComplete){
		pullData(scrapeFn(),"save.php",function(data){
			if (!_.isUndefined(data.data)){
				var defid = data.data.id;
				$('#' + strength_id).val(defid); //incase it wasn't set before
				if(!_.isUndefined(afterComplete)){
					afterComplete();
				}
			} else { alert("Strength not saved"); }
		});
	};
	var postWeakness = function(scrapeFn, strength_id, afterComplete){
		pullData(scrapeFn(),"save.php",function(data){
			if (!_.isUndefined(data.data)){
				var defid = data.data.id;
				$('#' + strength_id).val(defid); //incase it wasn't set before
				if(!_.isUndefined(afterComplete)){
					afterComplete();
				}
			} else { alert("Weakness not saved"); }
		});
	};
	var postSummary = function(scrapeFn, summary_id, afterComplete){
		pullData(scrapeFn(),"save.php",function(data){
			if (!_.isUndefined(data.data)){
				var defid = data.data.id;
				$('#' + summary_id).val(defid); //incase it wasn't set before
				if(!_.isUndefined(afterComplete)){
					afterComplete();
				}
			} else { alert("Summary not saved"); }
		});
	};


