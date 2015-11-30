/*jshint loopfunc: true, quotmark: false */
/* global _, jQuery, akzo, native5, Backbone, app, moment, createCard, model */
(function ($) {
    "use strict";

    var loader = new native5.ui.Loader({style: "gif"});
    loader.render();
    var simulationData;
    var dealerModal = new native5.ui.modal({"top":50}); 
    dealerModal.render({"modalElm":"#n5-dealer-popup"});

    var SimulationTables = Backbone.Collection.extend({
    	addGroup: function(){
    		this.add({
    			name: "Group " + (this.length + 1),
    			number: this.length,
    			value: []
    		});
    	}
    });
    window.SimulationTablesInstance = new SimulationTables;

	var SimulateView = Backbone.View.extend({
		el: $('.simulation-content'),
		collection: SimulationTablesInstance,
		template:  _.template($('#simulation-template').html()),
		initialize: function(){
			_.bindAll(this, 'render');
			this.collection.bind('add', this.render);
			this.collection.bind('remove', this.render);
			this.collection.addGroup();
			this.render();
		},
		render: function(){

			var self = this;
			$(this.el).html(this.template({groups: this.collection.toJSON()}));
			$("#add_group").click(function(){
				self.collection.addGroup()
			});

			$('.simulation-select').multiSelect({
				selectableHeader: "<div class='custom-header'><span>Draft Schemes</span><span><span class = 'deselect-all multiselect-header-button tooltip noleft' tip-title = 'Deselect All'><i class = 'fa fa-times'></i></span><span class = 'select-all multiselect-header-button tooltip noleft' tip-title = 'Select All'><i class = 'fa fa-check'></i></span></span></div>",
				selectionHeader: "<div class='custom-header'>Schemes to simulate</div>",
				afterSelect: function(values){
					var container = this.$container.parent();
					var select = $('.simulation-select', $(container));
					SimulationTablesInstance.models[$(container).data("number")].set("value", $(select).val());
				},
				afterDeselect: function(values){
					var container = this.$container.parent();
					var select = $('.simulation-select', $(container));
					SimulationTablesInstance.models[$(container).data("number")].set("value", $(select).val());
				}
			});

			$('.select-all').click(function(){
				$('.simulation-select', $(this).parents().eq(4)).multiSelect('select_all');
				return false;
			});
			$('.deselect-all').click(function(){
				$('.simulation-select', $(this).parents().eq(4)).multiSelect('deselect_all');
				return false;
			});

			$('.remove-group').click(function(){
				self.remove(this);
			});
			
			$('#simulate').click(function(){
				self.simulate();
			});
		},
		remove: function(elm){
			var index = $(elm).parents().eq(1).data("number") ;
			this.collection.remove(this.collection.models[index]);
			this.collection.each(function(model, index) {
				model.set("name", "Group " + (index + 1));
				model.set("number", index);
			});
			this.render();
		},
		getStatus: function(text) {
			switch(text) {
			    case simStatus.ready:
			        return "Simulation Complete";
			        break;
			    case simStatus.partial:
			        return "Simulation Partially Complete";
			        break;
			    case simStatus.locked:
			        return "Simulation in progress, Please revisit this page to see the results";
			        break;
			    case simStatus.not_started:
			        return "Simulation Error";
			        break;
			    case simStatus.just_started:
			        return "Simulation in progress, Please revisit this page to see the results";
			        break;
			}
		},
		simulate: function(){
			window.complete = true;
			var actuals = false;
			var self = this;
			if ($('input#actual-data-checkbox').is(':checked')) {
				actuals = true;
			}
			var data = SimulationTablesInstance.toJSON();
			var simulateService = service.invoke({
				serviceURL: "simulation/simulate",
				invokeData: {groups: data, actuals: actuals},
				successHandler: function(data) {
					simulationData = data.message;
					SalesDataInstance.set({
						details: data.message.details,
						prevSales: data.message.prevSalesData,
						currSales: data.message.currSalesData,
						ovrSales: data.message.ovrSalesData,
						percentage: {
							total: 11,
							atrqtr: 2,
							club: 2,
							monthly: 7
						}
					});
					SalesDataInstance.calculate();
					SimulationResultInstance.reset();
					$.each( data.message.simulation, function( key, value ) {
						var cumulatedData = data.message.simulation[key].cumulatedData;
						if(data.message.simulation[key].status != simStatus.ready) {
					  		window.complete = false;
					  	}
						if (data.message.simulation[key].status != simStatus.not_started ) {
							// var cumulatedData = JSON.parse(jsonData);
							if (!cumulatedData) {
								SimulationResultInstance.add({
							  		dealers: _.size(data.message.simulation[key].dealers),
							  		status: self.getStatus(data.message.simulation[key].status),
							  		code: data.message.details[key].code,
							  		uid: data.message.details[key].uid,
							  		schemeName: data.message.details[key].name,
							  		id: data.message.details[key].code,
							  		actuals: actuals,

							  		startDate:data.message.details[key].start_date,
							  		endDate:data.message.details[key].end_date,
							  		createdOn:data.message.details[key].created_at,
							  		initiatedBy:data.message.details[key].initiator.name,
							  		updatedBy:data.message.details[key].initiator.name,
							  		reviewedBy:data.message.details[key].reviewer.name,
							  		approvedBy:data.message.details[key].approver.name
							  	});
							}
							else {
								SimulationResultInstance.add({
							  		dealers: _.size(data.message.simulation[key].dealers),
							  		status: self.getStatus(data.message.simulation[key].status),
							  		code: data.message.details[key].code,
							  		uid: data.message.details[key].uid,
							  		schemeName: data.message.details[key].name,
							  		inbill: cumulatedData.inBills,
							  		ppi: cumulatedData.ppiOutputs,
							  		pri: cumulatedData.priOutputs,
							  		slab: cumulatedData.slabOutputs,
							  		slabV2: cumulatedData.slabV2Outputs,
							  		id: data.message.details[key].code,
							  		actuals: actuals,

							  		startDate:data.message.details[key].start_date,
							  		endDate:data.message.details[key].end_date,
							  		createdOn:data.message.details[key].created_at,
							  		initiatedBy:data.message.details[key].initiator.name,
							  		updatedBy:data.message.details[key].initiator.name,
							  		reviewedBy:data.message.details[key].reviewer.name,
							  		approvedBy:data.message.details[key].approver.name
							  	});
							}
							  	
						}
						else {
							native5.Notifications.show("There were issues processing request! Please try again later.", {
	                            notificationType:"toast",
	                            title:"Error",
	                            position:"top",
	                            distance:"50px",
	                            persistent: false,
	                            messageType: "error"
	                        });
	                        window.complete = true;
						}
					});
					loader.hideLoadingMessage();
                    console.log(data.message);
                    if (window.complete == false) {
                    	setTimeout(function(){self.simulate();}, 10000);
                    	// setTimeout(function(){console.log("function called");}, 10000);
                    }
				},
				errorHandler: function(err) {
					loader.hideLoadingMessage();
                    console.log(err);
				}
			});
			loader.showLoadingMessage({blocking: true});
		}
	});
	var simulateview = new SimulateView;


	var SimulationResult = Backbone.Collection.extend({});
	window.SimulationResultInstance = new SimulationResult;

	var ResultView = Backbone.View.extend({
		el: $('.simulation-result'),
		collection: SimulationResultInstance,
		template:  _.template($('#result-template').html()),
		initialize: function(){
			_.bindAll(this, 'render');
			this.collection.bind('add', this.render);
			this.collection.bind('remove', this.render);
		},
		render: function(){

			var self = this;
			$(this.el).html(this.template({results: this.collection.toJSON()}));

			$(".dealer-search-input").each(function(index, elm){
				var self = this;
                $(this).autocomplete({
					maxHeight:200,
					width:$(this).width() + 4,
					zIndex: 9999,
					minChars:2,
					onSelect: function(value, data, i){ 
						$(self).val("");
						$(self).focus();
						// var i = _.indexOf(simulationData.simulation[index].dealers, ACoptions.lookup[value]); 
						var priElm = "", ppiElm = "", slabElm = "", inbillElm = "", slabV2Elm = "";
						var simData = JSON.parse(simulationData.simulation[index].newData[value]);
						$.each( simData.inBills, function( k, v ) {
							inbillElm += '<div class = "result-list-elm"><span class = "result-list-title">Inbill( '+k+' ): </span>'+v.WITHOUT_QC+'</div>';
						});
						$.each( simData.priOutputs, function( k, v ) {
							if(v.WITH_QC) {
								priElm += '<div class = "result-list-elm"><span class = "result-list-title">PRI with QC( '+k+' ): </span>'+v.WITH_QC+'</div>';	
							}
							if (v.WITHOUT_QC) {
								priElm += '<div class = "result-list-elm"><span class = "result-list-title">PRI( '+k+' ): </span>'+v.WITHOUT_QC+'</div>';	
							}
							
						});
						$.each( simData.ppiOutputs, function( k, v ) {
							if(v.WITH_QC) {
								ppiElm += '<div class = "result-list-elm"><span class = "result-list-title">PPI with QC( '+k+' ): </span>'+v.WITH_QC+'</div>';	
							}
							if (v.WITHOUT_QC) {
								ppiElm += '<div class = "result-list-elm"><span class = "result-list-title">PPI( '+k+' ): </span>'+v.WITHOUT_QC+'</div>';	
							}
							
						});
						$.each( simData.slabOutputs, function( k, v ) {
							if(v.WITH_QC) {
								slabElm += '<div class = "result-list-elm"><span class = "result-list-title">Slab with QC( '+k+' ): </span>'+v.WITH_QC+'</div>';	
							}
							if (v.WITHOUT_QC) {
								slabElm += '<div class = "result-list-elm"><span class = "result-list-title">Slab( '+k+' ): </span>'+v.WITHOUT_QC+'</div>';	
							}
						});

						$.each( simData.slabV2Outputs, function( k, v ) {
							if(v.WITH_QC) {
								slabV2Elm += '<div class = "result-list-elm"><span class = "result-list-title">Slab V2 with QC( '+k+' ): </span>'+v.WITH_QC+'</div>';	
							}
							if (v.WITHOUT_QC) {
								slabV2Elm += '<div class = "result-list-elm"><span class = "result-list-title">Slab V2( '+k+' ): </span>'+v.WITHOUT_QC+'</div>';	
							}
						});

						$(self).parent().parent().find(".dealer-result-container").append('<div class = "col-lg-3 col-md-4 col-sm-6 col-xs-12"><div class = "results-panel result-dealers"><div class = "result-list-header" data-dealer =\''+simulationData.simulation[index].dealers[value]+'\'>'+simulationData.simulation[index].dealers[value].credit_name_code+'</div>'+inbillElm+ppiElm+priElm+slabElm+slabV2Elm+'</div></div>');
						$(self).parent().parent().find(".result-list-header").click(function(){
							var dealerData = $(this).data("dealer");
							var dealerTemplate =  _.template($('#dealer-template').html());
							$("#dealer-description").html(dealerTemplate({dealer: dealerData}));
							dealerModal.showModal();
						});
					},
					// local autosugest options:
					lookup: simulationData.simulation[index].dealers
				});
            });
			
			// $(".dealer-data-btn").off("click");
			// $(".dealer-data-btn").on("click", function(){
			// 	var code = $(this).data("code");
			// 	var uid = $(this).data("uid");
			// 	var dataLoadService = service.invoke({
			// 		method: 'GET',
			// 		serviceURL: "simulation/simulationDump",
			// 		invokeData: {code: code, uid: uid},
			// 		successHandler: function(data) {
			// 			console.log(data);
			// 		},
			// 		errorHandler: function(err) {
			// 			loader.hideLoadingMessage();
	  //                   console.log(err);
			// 		}
			// 	});
			// })
			
		},
		endsWith: function endsWith(str, suffix) {
		    return str.indexOf(suffix, str.length - suffix.length) !== -1;
		}
	});
	var resultview = new ResultView;


	var SalesData = Backbone.Model.extend({
		calculate: function(){
			var self = this;
			var types = [];
			$.each(self.attributes.details, function(key, value){
				if(value.type == "Monthly"){
					types.monthly = true;
				}
				else if(value.type == "ATR" || value.type == "QTR" ){
					types.atrqtr = true;
				}
				else if(value.type == "Custom Scheme"){
					types.custom = true;
				}

			});
			this.set({
				types: types,
				typeLength: this.getSize(types),
				ytdPrevMonth: {
					val: parseFloat(self.attributes.prevSales.value/100000).toFixed(2),
					budgetpercentage: self.getBudgetPercentage(types),
					budgetavailable: self.getBudgetAvailable(self.attributes.prevSales, types)
				},
				ytdCurrMonth: {
					val: parseFloat(self.attributes.currSales.value/100000).toFixed(2),
					budgetpercentage: self.getBudgetPercentage(types),
					budgetavailable: self.getBudgetAvailable(self.attributes.currSales, types)
				},
				ytdOvr: {
					val: parseFloat(self.attributes.ovrSales.value/100000).toFixed(2),
					budgetpercentage: self.getBudgetPercentage(types),
					budgetavailable: self.getBudgetAvailable(self.attributes.ovrSales, types)
				}
			});
			salesdataview.render();
		},
		getBudgetAvailable: function(sales, types){
			var budget = [];
			budget.monthly = parseFloat(this.attributes.percentage.monthly * sales.value/10000000).toFixed(2);
			budget.atrqtr = parseFloat(this.attributes.percentage.atrqtr * sales.value/10000000).toFixed(2); 
			budget.custom = parseFloat(this.attributes.percentage.club * sales.value/10000000).toFixed(2);

			if(this.getSize(types) == 1) {
				if(types['monthly'] == true){
					budget.total = parseFloat(this.attributes.percentage.monthly * sales.value/10000000).toFixed(2);
				}
				else if(types['atrqtr'] == true ){
					budget.total = parseFloat(this.attributes.percentage.atrqtr * sales.value/10000000).toFixed(2);
				}
				else if(types['custom'] == true){
					budget.total = parseFloat(this.attributes.percentage.club * sales.value/10000000).toFixed(2);
				}
			}
			return budget;
		},
		getBudgetPercentage: function(types){
			var percentage = [];
			percentage.monthly = this.attributes.percentage.monthly;
			percentage.atrqtr = this.attributes.percentage.atrqtr;
			percentage.custom = this.attributes.percentage.club;

			if(this.getSize(types) == 1) {
				if(types['monthly'] == true){
					percentage.total = this.attributes.percentage.monthly;
				}
				else if(types['atrqtr'] == true ){
					percentage.total = this.attributes.percentage.atrqtr;
				}
				else if(types['custom'] == true){
					percentage.total = this.attributes.percentage.club;
				}
			}
			return percentage;
		},
		getSize: function(obj) {
		    var size = 0, key;
		    for (key in obj) {
		        if (obj.hasOwnProperty(key)) size++;
		    }
		    return size;
		}

	});
	window.SalesDataInstance = new SalesData;

	var SalesDataView = Backbone.View.extend({
		el: $('.sales-data'),
		model: SalesDataInstance,
		template:  _.template($('#salesdata-template').html()),
		initialize: function(){

		},
		render: function(){
			var self = this;
			$(this.el).html(this.template({salesdata: this.model.toJSON()}));
		}
	});
	var salesdataview = new SalesDataView;

}(jQuery));

