
$(function(){
    //var dataPath = ""; //allways postfix with / if not blank
    //var dataPath = "https://10.0.0.22/openemr/library/textimporter/";
    var dataPath = window.location.origin + "/openemr/library/textimporter/";

    var textimporterdata = "textimporterdata.php";
    
    //infuser.defaults.templateUrl = "https://10.0.0.22/openemr/library/textimporter";
    infuser.defaults.templateUrl = window.location.origin + "/openemr/library/textimporter";

    //infuser.defaults.templatePrefix = "SomePrefix"
    //infuser.defaults.templateSuffix = "SomeSuffix"

    var ddlItem = function(value, desc) {
        this.value = value || "";
        this.desc = desc || "";
        this.shortDesc = desc ? desc.substring(0,50) : "";
    };
    
    var pullData = function(params,page,afterLoad){
        $.post(dataPath + "" + page, params, function(retObj){
            if (afterLoad) {
                afterLoad(retObj);
            }
        })
        .error(function(data, textStatus){
            if (afterLoad) {
                afterLoad(data);
            }
        });
    };
    
    var resultsPreProcessing = function(results){
        if (!isJson(results)){
             if (results.indexOf('login_frame.ph')<0){
                 errors(results);
             }else{
                 errors('Please log in to OpenEMR.');
             }
             return null;
        } else {
            //var jres = JSON.parse(results);
            var jres = results;
            if (!_.isUndefined(jres.error) && !_.isFunction(jres.error)
                    && jres.error !== "") {
                errors(jres.error);
                return null;
            }
            if (!_.isUndefined(jres.responseText) && jres.responseText !== "") {
                errors(jres.responseText);
                return null;
            }
            if (!_.isUndefined(jres.message) && jres.message !== "") {
                errors(jres.message);
            }
        }
        return results.data;
    };    
    
    var isJson = function (str) {
        try {
            if (typeof str !== 'object') {
                JSON.parse(str);
            }
        } catch (e) {
            return false;
        }
        return true;
    }
    
    var errors = function(msg){
        $("#errors").append(msg + "<br/>");
    };

    var selector = function(selectedCallBack) {
        var self = this;
        this.select1id = 0;
        this.select1label = ko.observable('Label');
        this.control = '';
        this.rememberId = 0;
        this.getParentId = 0;
        this.select1list = ko.observableArray([new ddlItem()]);
        this.selected1 = ko.observable();
        this.selectParams = {};
        this.selected1val = '';
        this.showLoader = ko.observable(false);
        
        this.selected1.subscribe(function(value){
			if (!_.isUndefined(value)){
				self.selected1val = value.shortDesc;
				selectedCallBack(value, self);
			}
        });
        
        this.loadList = function(id0,id2) {
            var params = self.selectParams || {}; //start with whatever was in the html params
            params.api = 'getSelectorData'; //add necessary params
            params.controlid = self.select1id;
            params.id0 = id0 !== "" ? id0 : 0;
			params.id2 = _.isUndefined(id2) ? 0 : id2;
            var fillData = function(results) {
                var data = resultsPreProcessing(results);
                if (data != null) {
                    if (data.list != undefined) {
                        var list = [];
                        for (var i = 0; i<data.list.length; i++){
                            list.push(new ddlItem(data.list[i].value,data.list[i].desc));
                        }
                        self.select1list(list);
                    }
                }
	            self.showLoader(false);
            };
            self.showLoader(true);
            pullData(params,textimporterdata,fillData);
        };
    };
    
    var control = function(configs){
        var self = this;
		if (_.isUndefined(configs)) configs ={};
		if (_.isUndefined(configs.id)) configs.id = "";
		if (_.isUndefined(configs.page)) configs.page = "";
		if (_.isUndefined(configs.params)) configs.params = {};
		if (_.isUndefined(configs.storeid)) configs.storeid = "";
		if (_.isUndefined(configs.appendvalue)) configs.appendvalue = true;
		if (_.isUndefined(configs.controlSavedCallBack)) configs.controlSavedCallBack = function(x) { };

        this.textboxId = configs.id;
        this.page = configs.page;
        this.selectParams = configs.params;
        this.storeId = configs.storeid;
		this.appendValue = configs.appendvalue;
        this.informParentSave = configs.controlSavedCallBack;
        this.showTextImporter = ko.observable(false);
        this.heading = ko.observable("Heading");
        this.controlId = ko.observable(0);
        this.selectors = ko.observableArray([]);
        this.selected1 = ko.observable();
        this.selected1val = ko.observable(0);
        this.rememberedId = 0;

		this.constructMe = function(configs){
			if (_.isUndefined(configs)) configs ={};
			if (_.isUndefined(configs.id)) configs.id = "";
			if (_.isUndefined(configs.page)) configs.page = "";
			if (_.isUndefined(configs.params)) configs.params = {};
			if (_.isUndefined(configs.storeid)) configs.storeid = "";
			if (_.isUndefined(configs.appendvalue)) configs.appendvalue = true;
			if (_.isUndefined(configs.controlSavedCallBack)) configs.controlSavedCallBack = function(x) { };
			self.textboxId = configs.id;
			self.page = configs.page;
			self.selectParams = configs.params;
			self.storeId = configs.storeid;
			self.appendValue = configs.appendvalue;
			self.informParentSave = configs.controlSavedCallBack;
		};

        this.clickTIButton = function () {
            self.showTextImporter(true);
			self.loadFirstSelector();
        };
        
        this.clickSave = function () {
            var desc = self.selected1() ? self.selected1().desc : '';
			if (self.appendValue){
				//$("#" + self.textboxId).append(desc + " ");
				$("#" + self.textboxId).val($("#" + self.textboxId).val() + " " + desc);
			} else {
				//$("#" + self.textboxId).html(desc);
				$("#" + self.textboxId).val(desc);
			}
			_.each(self.selectors(),function(sel,idx){
				if (!_.isUndefined(sel.selected1()) && _.isArray(self.storeId)){
					var id = sel.selected1().value;
					if (!_.isUndefined(self.storeId[idx])){
						$("#" + self.storeId[idx]).val(id);
					}
				}
			});
			
            self.showTextImporter(false);
        };
        
        this.clickCancel = function () {
            self.showTextImporter(false);
        };
        
        this.selectAction = function(value, sel){
            self.selected1(value);
            self.selected1val(value.shortDesc);
			self.informParentSave(self);
			//rememeberdId
			if (!_.isUndefined(value)){
				if(sel.rememberId === 1){
					self.rememberedId = value.value;
				}
			}
			//next selector
            var idx = self.selectors().indexOf(sel) +1;
            if (self.selectors().length > idx && self.selectors()[idx].getParentId === 1) {
                self.selectors()[idx].loadList(value.value, self.rememberedId); 
            }
        }

		this.loadFirstSelector = function(){
			if ( self.selectors().length > 0) {
				_.each(self.selectors(),function(sel,idx){
					if (idx === 0 || self.selectors()[idx].getParentId === 0) {
						if (_.isEqual(sel.select1list()[0],new ddlItem()))
							self.selectors()[idx].loadList('', self.rememberedId);
					}
				});
			}
		};
		
        this.loadControl = function(congrolPage,textboxId){
            var params = {api:'getControl',page:congrolPage,textboxid:textboxId};
            var fillData = function(results) {
                var data = resultsPreProcessing(results);
                if (!_.isUndefined(data) && data !== null) {
                    if (!_.isUndefined(data.controls)) {
                        var control = data.controls;
                        self.controlId(control.id);
                        self.heading(control.heading);
                        if (control.selectors[0] !== null) {
							self.selectors([]);//clear the existing list of selectors
                            _.each(control.selectors,function(sel){
                                var nsel = new selector(self.selectAction);
                                nsel.select1label(sel.heading);
                                nsel.select1id = sel.id;
                                nsel.control = sel.control;
                                nsel.rememberId = parseInt(sel.rememberId,10);
                                nsel.getParentId = parseInt(sel.getParentId,10);
                                nsel.selectParams = self.selectParams;
                                self.selectors.push(nsel);
                            });
							//load the first one by default
							self.loadFirstSelector();
                        }
                    }
                }
            };
            pullData(params,textimporterdata,fillData);
        };
        
        //self.loadControl(self.page,self.textboxId);
    };
    
    var textImporterVM = function() {
        var self = this;
		this.rememberedId = ko.observable(0);
        this.controls = ko.observableArray([]);

		this.controlSavedCallBack = function(ctrl){
			var rid = ctrl.rememberedId;
			if(!_.isUndefined(rid) && rid !== 0) 
				self.rememberedId(rid);
		};

		self.rememberedId.subscribe(function(val){
			_.each(self.controls(),function(ctrl){
				ctrl.rememberedId = val;
			});
		});
		
        self.loadControl = function(configs) {
           //return new control(configs);
		   configs.controlSavedCallBack = self.controlSavedCallBack;
		   var newControl = new control(configs);
		   self.controls.push(newControl);
		   return newControl;
        };
		
		self.updateControl = function(configs) {
			//reload control with new configs
		   configs.controlSavedCallBack = self.controlSavedCallBack;
		   var foundControl;
		   _.each(self.controls(),function(control){
				if (control.textboxId === configs.id){
					control.constructMe(configs);//re-load it
					control.loadControl(control.page,control.textboxId);
					foundControl = control;//return it
				}
			});
		   return foundControl;
		};
    };

    ko.bindingHandlers.tiControl = {
        init: function(element, valueAccessor, allBindingsAccessor){
            var configs = valueAccessor();
            var tiVM = allBindingsAccessor.get('tiVM');
			if(!_.isUndefined(tiVM)){
				var thisVM = tiVM.loadControl(configs);
				//ko.renderTemplate("textimporter", thisVM, {}, element, 'replaceNode');
				ko.renderTemplate("textimporter", tiVM.controls()[tiVM.controls().length-1], {}, element, 'replaceNode');
				//args: templateName, bindingContext, rendering engine options,
				//    DOM element to use, and template rendering mode
			}
        },
        update: function(element, valueAccessor, allBindingsAccessor){
            var configs = valueAccessor();
            var tiVM = allBindingsAccessor.get('tiVM');
			if(!_.isUndefined(tiVM)){
				var thisVM = tiVM.updateControl(configs);
				//ko.renderTemplate("textimporter", thisVM, {}, element, 'replaceNode');
				ko.renderTemplate("textimporter", _.findWhere(tiVM.controls(),{textboxId: thisVM.textboxId}), {}, element, 'replaceNode');
				//args: templateName, bindingContext, rendering engine options,
				//    DOM element to use, and template rendering mode
			}
        }
	};
     
    $(document).ready(function(){

        //ko.applyBindings(new textImporterVM());
        ko.applyBindings(new textImporterVM());
    });
});

