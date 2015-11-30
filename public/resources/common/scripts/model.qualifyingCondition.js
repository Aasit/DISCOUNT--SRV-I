/*jshint loopfunc: true, quotmark: false */
/* global _, jQuery, akzo, native5, Backbone, app, moment, getParameterByName, console, confirm, createCard */
var model = (function (_, $, akzo, native5, Backbone, model) {
    "use strict";
    var i = 0;

    model.QualifyingConditionView = Backbone.View.extend({
        initialize: function(){
            this.collection.add(this.model);
            model.EventBus.on("validate:QCView",this.validate, this);
            this.uniqueID = this.model.attributes.qid;
            this.model.on("destroy", this.removeQCView, this);
        },
        events: {
            "click .n5-add-payout": "togglePayout",
            "click .n5-tempate-close-condition": "remove",
        },
        template:  _.template($('#n5-ui-template-qualCond-template').html()),
        render: function(){
            var that = this;
            if(typeof this.model.attributes.name !== "undefined") {
                $(this.el).append(this.template(this.model.toJSON()));
            }
            model.renderDropdown(this.$(".n5-qctype-select"),"", "qc-select-dropdown");
            model.renderDropdown(this.$(".n5-operator-select"),"", "qc-select-dropdown");
            this.dateRange = [];
            this.productSelect = [];   

            model.applyDaterangepicker(this.$(".n5-ui-qc-input-datepicker"));
            if(this.tabNum || this.inSlabQCElm) {
                model.addSegmentCheckBox(this.$(".n5-template-qc-segment-checkbox"), this.model.attributes.topLevelSegment);    
            }

            //manual event listening

            $("input", this.$(".n5-template-qc-segment-checkbox")).on("change", function() {
                that.setData();
            });
            this.$(".n5-qctype-select").on("change", function() {
                that.clearModel();
                that.updateTemplate();
                that.setData();
            });
            this.$(".n5-operator-select").on("change", function() {
                that.setData();
            });
            this.$(".n5-ui-qc-input-value").on("change", function() {
                that.setData();
            });
            this.$(".n5-ui-qc-input-datepicker").on("apply.daterangepicker", function() {
                that.setData();
            });
            model.generateProductSelectOnclick(this.$(".qc-product-select"));
            this.$(".qc-product-select").on("change", function() {
                that.setData();
            });
            this.$(".n5-ui-qc-input-payout").on("change", function() {
                that.setData();
            });
            this.updateTemplate();

            model.validateValue(this.$(".n5-ui-qc-input-value"));
            model.validateProductSelect(this.$(".input-product-select"));
            model.validatePayout(this.$(".n5-ui-qc-input-payout"));
        },
        clearModel: function(){
            this.unbind();
            this.model.clear();
        },

        updateTemplate: function(){
            var that = this;
            if(this.$(".n5-qctype-select").select2("val") == "Ratio Value" || this.$(".n5-qctype-select").select2("val") == "Ratio Volume") {
                for (i = 0; i < this.dateRange.length; i++) {
                    this.dateRange[i].remove();
                }
                this.dateRange = [];
                for (i = 0; i < this.productSelect.length; i++) {
                    this.productSelect[i].select2("destroy");
                }
                this.productSelect = [];
                this.$(".n5-input-datepicker-container").html('<span class="n5-template-qc-conditions-col"> <span class="add-on input-group-addon"> <i class="glyphicon glyphicon-calendar fa fa-calendar"> </i> </span> <input type="text" class="qc-template-box n5-ui-qc-previous-datepicker" placeholder = "Previous Period" readonly/></span><span class="n5-template-qc-conditions-col" tip-title="Cannot be Empty"> <span class="n5-qc-multi-check"> <button class = "qc-template-box input-previous-product-select qc-product-select">Update Previous Products</button> </span></span><span class="n5-template-qc-conditions-col"> <span class="add-on input-group-addon"> <i class="glyphicon glyphicon-calendar fa fa-calendar"> </i> </span> <input type="text" class="qc-template-box n5-ui-qc-current-datepicker" placeholder = "Current Period" readonly /></span><span class="n5-template-qc-conditions-col" tip-title="Cannot be Empty"> <span class="n5-qc-multi-check"> <button class = "qc-template-box input-current-product-select qc-product-select">Update Current Products</button> </span></span>');
                this.dateRange.previous = model.applyDaterangepicker(this.$(".n5-ui-qc-previous-datepicker"));
                this.dateRange.current = model.applyDaterangepicker(this.$(".n5-ui-qc-current-datepicker"));
                model.generateProductSelectOnclick(this.$(".qc-product-select"));
                this.$(".qc-product-select").on("change", function() {
                    that.setData();
                });

                if(this.model.toJSON().numPeriod) {
                    this.$('.n5-ui-qc-previous-datepicker').data('daterangepicker').setStartDate(moment(this.model.toJSON().numPeriod.startDate, "DD-MMM-YYYY"));
                    this.$('.n5-ui-qc-previous-datepicker').data('daterangepicker').setEndDate(moment(this.model.toJSON().numPeriod.endDate, "DD-MMM-YYYY"));
                    this.$('.n5-ui-qc-previous-datepicker').data('daterangepicker').clickApply();
                }
                if(this.model.toJSON().denPeriod) {
                    this.$('.n5-ui-qc-current-datepicker').data('daterangepicker').setStartDate(moment(this.model.toJSON().denPeriod.startDate, "DD-MMM-YYYY"));
                    this.$('.n5-ui-qc-current-datepicker').data('daterangepicker').setEndDate(moment(this.model.toJSON().denPeriod.endDate, "DD-MMM-YYYY"));
                    this.$('.n5-ui-qc-current-datepicker').data('daterangepicker').clickApply();
                }
                if(this.model.toJSON().numProducts)
                    this.$(".input-previous-product-select").data("products", this.model.toJSON().numProducts);
                if(this.model.toJSON().denProducts)
                    this.$(".input-current-product-select").data('products', this.model.toJSON().denProducts);
                // model.validateDatepicker(this.$(".n5-ui-qc-previous-datepicker"));
                // model.validateDatepicker(this.$(".n5-ui-qc-current-datepicker"));
                model.validateProductSelect(this.$(".input-previous-product-select"));
                model.validateProductSelect(this.$(".input-current-product-select"));
            }

            else if(this.$(".n5-qctype-select").select2("val") == "Growth Value" || this.$(".n5-qctype-select").select2("val") == "Growth Volume"){
                for (i = 0; i < this.dateRange.length; i++) {
                    this.dateRange[i].remove();
                }
                this.dateRange = [];
                for (i = 0; i < this.productSelect.length; i++) {
                    this.productSelect[i].select2("destroy");
                }
                this.productSelect = [];
                this.$(".n5-input-datepicker-container").html('<span class="n5-template-qc-conditions-col"> <span class="add-on input-group-addon"> <i class="glyphicon glyphicon-calendar fa fa-calendar"> </i> </span> <input type="text" class="qc-template-box n5-ui-qc-previous-datepicker" readonly placeholder = "Previous Period" /> </span> <span class="n5-template-qc-conditions-col"> <span class="add-on input-group-addon"> <i class="glyphicon glyphicon-calendar fa fa-calendar"> </i> </span> <input type="text" class="qc-template-box n5-ui-qc-current-datepicker" readonly placeholder = "Current Period" /> </span> <span class="n5-template-qc-conditions-col" tip-title="Cannot be Empty"> <span class="n5-qc-multi-check"> <button class = "qc-template-box input-product-select qc-product-select">Update Products</button> </span> </span>');
                this.dateRange.previous = model.applyDaterangepicker(this.$(".n5-ui-qc-previous-datepicker"));
                this.dateRange.current = model.applyDaterangepicker(this.$(".n5-ui-qc-current-datepicker"));
                model.generateProductSelectOnclick(this.$(".qc-product-select"));
                this.$(".qc-product-select").on("change", function() {
                    that.setData();
                });

                if(this.model.toJSON().previousPeriod) {
                    this.$('.n5-ui-qc-previous-datepicker').data('daterangepicker').setStartDate(moment(this.model.toJSON().previousPeriod.startDate, "DD-MMM-YYYY"));
                    this.$('.n5-ui-qc-previous-datepicker').data('daterangepicker').setEndDate(moment(this.model.toJSON().previousPeriod.endDate, "DD-MMM-YYYY"));
                    this.$('.n5-ui-qc-previous-datepicker').data('daterangepicker').clickApply();
                }
                if(this.model.toJSON().currentPeriod) {
                    this.$('.n5-ui-qc-current-datepicker').data('daterangepicker').setStartDate(moment(this.model.toJSON().currentPeriod.startDate, "DD-MMM-YYYY"));
                    this.$('.n5-ui-qc-current-datepicker').data('daterangepicker').setEndDate(moment(this.model.toJSON().currentPeriod.endDate, "DD-MMM-YYYY"));
                    this.$('.n5-ui-qc-current-datepicker').data('daterangepicker').clickApply();
                }
                if(this.model.toJSON().products)
                    this.$(".input-product-select").data('products', this.model.toJSON().products);

                // model.validateDatepicker(this.$(".n5-ui-qc-previous-datepicker"));
                // model.validateDatepicker(this.$(".n5-ui-qc-current-datepicker"));
                model.validateProductSelect(this.$(".input-product-select"));
            }

            else {
                for (i = 0; i < this.dateRange.length; i++) {
                    this.dateRange[i].remove();
                }
                this.dateRange = [];
                for (i = 0; i < this.productSelect.length; i++) {
                    this.productSelect[i].select2("destroy");
                }
                this.productSelect = [];
                this.$(".n5-input-datepicker-container").html('<span class="n5-template-qc-conditions-col"> <span class="add-on input-group-addon"> <i class="glyphicon glyphicon-calendar fa fa-calendar"></i> </span> <input type="text" name="sales-period" class="qc-template-box n5-ui-qc-input-datepicker" readonly placeholder = "Select Period" /> </span> <span class="n5-template-qc-conditions-col" tip-title="Cannot be Empty"> <span class="n5-qc-multi-check"> <button class = "qc-template-box input-product-select qc-product-select">Update Products</button> </span> </span>');
                this.dateRange[0] = model.applyDaterangepicker(this.$(".n5-ui-qc-input-datepicker"));
                model.generateProductSelectOnclick(this.$(".qc-product-select"));
                this.$(".qc-product-select").on("change", function() {
                    that.setData();
                });

                if(this.model.toJSON().period) {
                    this.$('.n5-ui-qc-input-datepicker').data('daterangepicker').setStartDate(moment(this.model.toJSON().period.startDate, "DD-MMM-YYYY"));
                    this.$('.n5-ui-qc-input-datepicker').data('daterangepicker').setEndDate(moment(this.model.toJSON().period.endDate, "DD-MMM-YYYY"));
                    this.$('.n5-ui-qc-input-datepicker').data('daterangepicker').clickApply();
                }
                if(this.model.toJSON().products)
                    this.$(".input-product-select").data('products', this.model.toJSON().products);

                // model.validateDatepicker(this.$(".n5-ui-qc-input-datepicker"));
                model.validateProductSelect(this.$(".input-product-select"));
            }
            this.delegateEvents();
            return this;
        },
        setData: function() {
            var self = this;
            var qdata;
            if(this.$(".n5-qctype-select").select2("val") == "Ratio Value" || this.$(".n5-qctype-select").select2("val") == "Ratio Volume") {
                qdata = {
                    name: ((this.$(".n5-qctype-select").select2("val")).split(" ")[0]).toUpperCase(),
                    type: ((this.$(".n5-qctype-select").select2("val")).split(" ")[1]).toUpperCase(),
                    op: this.$(".n5-operator-select").select2("val"),
                    val: this.$(".n5-ui-qc-input-value").val(),
                    numPeriod: {
                        startDate: model.getFormattedDate(new Date(this.$(".n5-ui-qc-previous-datepicker").data("daterangepicker").startDate)),
                        endDate: model.getFormattedDate(new Date(this.$(".n5-ui-qc-previous-datepicker").data("daterangepicker").endDate))
                    },
                    denPeriod: {
                        startDate: model.getFormattedDate(new Date(this.$(".n5-ui-qc-current-datepicker").data("daterangepicker").startDate)),
                        endDate: model.getFormattedDate(new Date(this.$(".n5-ui-qc-current-datepicker").data("daterangepicker").endDate))
                    },
                    numProducts: this.$(".input-previous-product-select").data("products"),
                    denProducts: this.$(".input-current-product-select").data("products"),
                    payoutCondition: this.$(".n5-ui-qc-input-payout").val(),
                    qid: this.uniqueID
                };
            }

            else if(this.$(".n5-qctype-select").select2("val") == "Growth Value" || this.$(".n5-qctype-select").select2("val") == "Growth Volume"){
                qdata = {
                    name: ((this.$(".n5-qctype-select").select2("val")).split(" ")[0]).toUpperCase(),
                    type: ((this.$(".n5-qctype-select").select2("val")).split(" ")[1]).toUpperCase(),
                    op: this.$(".n5-operator-select").select2("val"),
                    val: this.$(".n5-ui-qc-input-value").val(),
                    previousPeriod: {
                        startDate: model.getFormattedDate(new Date(this.$(".n5-ui-qc-previous-datepicker").data("daterangepicker").startDate)),
                        endDate: model.getFormattedDate(new Date(this.$(".n5-ui-qc-previous-datepicker").data("daterangepicker").endDate))
                    },
                    currentPeriod: {
                        startDate: model.getFormattedDate(new Date(this.$(".n5-ui-qc-current-datepicker").data("daterangepicker").startDate)),
                        endDate: model.getFormattedDate(new Date(this.$(".n5-ui-qc-current-datepicker").data("daterangepicker").endDate))
                    },
                    products: this.$(".input-product-select").data("products"),
                    payoutCondition: this.$(".n5-ui-qc-input-payout").val(),
                    qid: this.uniqueID
                };
            }
            else{
                qdata = {
                    name: ((this.$(".n5-qctype-select").select2("val")).split(" ")[0]).toUpperCase(),
                    type: ((this.$(".n5-qctype-select").select2("val")).split(" ")[1]).toUpperCase(),
                    op: this.$(".n5-operator-select").select2("val"),
                    val: this.$(".n5-ui-qc-input-value").val(),
                    period: {
                        startDate: model.getFormattedDate(new Date(this.$(".n5-ui-qc-input-datepicker").data("daterangepicker").startDate)),
                        endDate: model.getFormattedDate(new Date(this.$(".n5-ui-qc-input-datepicker").data("daterangepicker").endDate))
                    },
                    products: this.$(".input-product-select").data("products"),
                    payoutCondition: this.$(".n5-ui-qc-input-payout").val(),
                    qid: this.uniqueID
                };
            }
            if($("input", this.$(".n5-template-qc-segment-checkbox")).length) {
                if($("input", this.$(".n5-template-qc-segment-checkbox")).is(":checked")){
                    qdata.segment = $(".n5-segment-select",$("#scheme-details")).select2("val");
                }
                else {
                    var segmentArray = [];
                    if(self.tabNum) {
                        var segmentData = $(this.el).parents().eq(2).find("select.template-segment-values").select2("data");
                    }
                    else if(self.inSlabQCElm) {
                        var segmentData = $(self.inSlabQCElm).parents().eq(7).find("select.template-segment-values").select2("data");
                    }
                    $.each(segmentData, function(key,segment){
                        segmentArray.push(segment.text);
                    })
                    qdata.segment = segmentArray;
                }
                qdata.topLevelSegment = $("input", this.$(".n5-template-qc-segment-checkbox")).is(":checked");
            }
            else {
                qdata.segment = $(".n5-segment-select",$("#scheme-details")).select2("val");
            }
                
            this.model.set(qdata);
            // console.log(this.model);
            
        },
        remove: function(){
            if(confirm("Are you sure to delete this Qualifying Condition?")) {
                this.$("n5-tempate-close-condition").parent().parent().fadeOut();
                model.EventBus.off("validate:QCView",this.validate, this);
                this.collection.remove(this.model);
                this.model.destroy();                  
                this.undelegateEvents();
                this.$el.removeData().unbind();  
                Backbone.View.prototype.remove.call(this);

            }
                
        },
        removeWithoutConfirmation: function(){
            // this.$(".n5-tempate-close-condition").parent().fadeOut();
            // model.EventBus.off("validate:QCView",this.validate, this);
            this.collection.remove(this.model);
            this.model.destroy();                  
            this.undelegateEvents();
            this.$el.removeData().unbind();  
            $(this.el).empty();
        },
        removeQCView: function(){
            // this.$(".n5-tempate-close-condition").parent().fadeOut();
            // model.EventBus.off("validate:QCView",this.validate, this);
            this.collection.remove(this.model);                 
            this.undelegateEvents();
            this.$el.removeData().unbind();  
            $(this.el).empty();
        },
        removeCloseButton: function(){
            this.$(".n5-tempate-close-condition").hide();
        },
        togglePayout: function(e){
            e.preventDefault();
            this.$(".n5-add-payout").children().toggleClass("fa fa-plus fa fa-minus");
            this.$(".n5-add-payout").parent().next().toggle();
        },
        validate: function(){
            model.validateValueEvent(this.$(".n5-ui-qc-input-value"), this.tabNum);
            model.validatePayoutEvent(this.$(".n5-ui-qc-input-payout"), this.tabNum);
            if(this.$(".n5-qctype-select").select2("val") == "Ratio Value" || this.$(".n5-qctype-select").select2("val") == "Ratio Volume") {
                model.validateProductSelectEvent(this.$(".input-previous-product-select"), this.tabNum);
                model.validateProductSelectEvent(this.$(".input-current-product-select"), this.tabNum);
            }

            else {
                model.validateProductSelectEvent(this.$(".input-product-select"), this.tabNum);
            }
        }
    });

    return model;
}(_, jQuery, akzo, native5, Backbone, model || {}));