/* jshint loopfunc: true, quotmark: false, unused: false */
/* global jQuery, Backbone, _, getParameterByName, moment, confirm, akzo, native5, alert, prodExclusionModal, app */
var model = (function ($, _, model) {
    "use strict";
    model.EventBus = {};
    model.existingSchemeData = $("#modelDetails").data("model");
    _.extend(model.EventBus, Backbone.Events);

    var cidTextbox = null;
    var cidValue = null;
    var cidSelect = null;
    var cidProdSelect = null;
    var cidPayout = null;
    var priSlabQCIndex = 0;
    var ppiSlabQCIndex = 0;
    var slabSlabQCIndex = 0;
    var slabV2SlabQCIndex = 0;
    var slabV3SlabQCIndex = 0;
    model.renderDropdown = function(elm, placeholder, containerClass) {
        $(elm).select2({
            allowClear: true,
            closeOnSelect: false,
            containerCssClass : containerClass,
            placeholder: placeholder || ""
        });
    };

    model.renderSegmentDropdown = function(elm, placeholder, containerClass) {
        $(elm).select2({
            allowClear: true,
            closeOnSelect: false,
            containerCssClass : containerClass,
            placeholder: placeholder || ""
        });

        $(elm).on('select2-removing', function(e) {
            if($("#n5tabul").children("li").length > 1) {
                if (!confirm("Do you want to update template as well?")) {
                    e.preventDefault();
                } else {
                    var val = e.choice.text;
                    $("select.template-segment-values").each(function() {
                        var data = $(this).select2("data");
                        $.each(data, function(key, value) {
                            if(val === value.text) {
                                data.splice(key, 1);
                                return false;
                            }
                        });
                        $(this).select2("data", data);
                    });
                }
            }
        });

        $(elm).on('select2-selecting', function(e) {
            if($("#n5tabul").children("li").length > 1) {
                if (confirm("Do you want to update template as well?")) {
                    var text = e.object.text;
                    var val = e.val;
                    $("select.template-segment-values").each(function() {
                        var data = $(this).select2("data");
                        data.push({id: data.length - 1, text: text, val: val});
                        $(this).select2("data", data, true);
                    });
                }
            }
        });
    };

    model.getDataFromProductSelect = function(elm){
        var data = [];
        $($(elm).select2("data")).each(function(index, value){
            data.push({pid: value.pid, name: value.name});
        });
        return data;
    };

    model.getDataFromGeographySelect = function(elm){
        var data = [];
        $($(elm).select2("data")).each(function(index, value){
            data.push({gid: value.gid, name: value.name});
        });
        return data;
    };

    model.getProductsPRI = function(elm, val) {
        var retArr = [];
        var productLists = $(elm).find("[data-product]");

        $.each(productLists, function(key, value) {
            var tempObj = {};
            tempObj.product = $(value).data("product");
            tempObj.value = val;

            retArr.push(tempObj);
        });

        return retArr;
    };

    model.getProducts = function(elm) {
        var retArr = [];
        var productLists = $(elm).find("[data-product]");

        if(typeof productLists === "string") {
            productLists = JSON.parse(productLists);
        }

        $.each(productLists, function() {
            retArr.push($(this).data("product"));
        });

        return retArr;
    };

    model.getPids = function(data) {
        var retArr = [];
        // var productLists = $(elm).find("[data-product]");
        
        if(!data) {
            return [];
        }

        if(typeof data === "string") {
            data = JSON.parse(data);
        }
        
        $.each(data, function(key, value) {
            retArr.push(value.pid);
        });

        return retArr;
    };

    model.getType = function(elmStr) {
        var retVal;
        $.each($(".n5-radio-toolbar", $(elmStr)).children("input"), function() {
            if($(this).is(":checked")) {
                retVal = $(this).val().toUpperCase();
                return false;
            }
        });

        return retVal;
    };

    model.getPack = function(elm) {
        var retArr = [];

        var inputs = $(elm).find("input");

        if($(inputs[0]).is(":checked")) {
            retArr.push("BULK");
        }
        if($(inputs[1]).is(":checked")) {
            retArr.push("RETAIL");
        }

        return retArr;
    };
    
    model.getPayoutType = function(type) {
        if(type.toLowerCase() === "abs amount") {
            return "FLATPAYOUT";
        } else if(type.toLowerCase() === "gift") {
            return "GIFT";
        } else if(type.toLowerCase() === "percentage") {
            return "PERCENTAGE";
        } else {
            return "RSPERLITRE";
        }
    };

    model.getFormattedDate = function(input){
        var m_names = new Array("Jan", "Feb", "Mar", 
        "Apr", "May", "Jun", "Jul", "Aug", "Sep", 
        "Oct", "Nov", "Dec");
        var curr_date = input.getDate();
        var curr_month = input.getMonth();
        var curr_year = input.getFullYear();
        return (curr_date + "-" + m_names[curr_month] + "-" + curr_year);
    };

    model.validateGrowthRanges = function(input1, input2) {
        var validRanges = true;

        if(!($(input1).val() && $(input1).val() !== "Select Period")) {
            $(input1).parent().attr("tip-title", "Previous date cannot be empty");
            $(input1).parent().addClass("error-tooltip");
            validRanges = false;
        } else {
            $(input1).parent().removeClass("error-tooltip");
        }

        if(!($(input2).val() && $(input2).val() !== "Select Period")) {
            $(input2).parent().attr("tip-title", "Current date cannot be empty");
            $(input2).parent().addClass("error-tooltip");
            validRanges = false;
        } else {
            $(input2).parent().removeClass("error-tooltip");
        }

        var prevStartDate = new Date($(input1).data('daterangepicker').startDate).getTime();
        var prevEndDate = new Date($(input1).data('daterangepicker').endDate).getTime();
        var currStartDate = new Date($(input2).data('daterangepicker').startDate).getTime();
        var currEndDate = new Date($(input2).data('daterangepicker').endDate).getTime();

        if(validRanges) {
            if(prevStartDate < currEndDate && currStartDate < prevEndDate) {
                $(input2).parent().attr("tip-title", "Curent Date cannot overlap with Previous Date");
                $(input2).parent().addClass("error-tooltip");
                validRanges = false;
            } else {
                $(input1).parent().removeClass("error-tooltip");
                $(input2).parent().removeClass("error-tooltip");
            }
        }

        return validRanges;
    };

    model.createSatisfyAllButton = function(elm, str, state) {
        var satisfyAll;
        var satisfyOne;
        if(typeof state !== "undefined" && state) {
            satisfyAll = "checked";
            satisfyOne = "";
        }
        else {
            satisfyAll = "";
            satisfyOne = "checked";   
        }
        elm.prepend('<div class="n5-radio-toolbar n5-tab-radio" align = "right"><input type="radio" id="item-'+str+'" name="satisfyAll" class = "satisfyAll" value="false"' +satisfyAll+ '><label for="item-'+str+'">Satisfy All</label><input type="radio" name="satisfyAll" id="item1-'+str+'" class = "satisfyOne" value="true" ' +satisfyOne+ '><label for="item1-'+str+'">Satisfy Any One</label></div>');
    };

    model.setDate = function(elm, dates) {
        $(elm).data('daterangepicker').setStartDate(moment(dates.startDate, "DD-MMM-YYYY"));
        $(elm).data('daterangepicker').setEndDate(moment(dates.endDate, "DD-MMM-YYYY"));
        $(elm).data('daterangepicker').clickApply();
    };

    model.getSelectedValues = function(dataArr) {
        var retArr = [];
        $.each(dataArr, function(key, value) {
            retArr.push(value.id);
        });
        return retArr;
    };

    model.applyDaterangepicker = function(elm) {
        var dPicker = $(elm).daterangepicker({
            format: 'DD-MMM-YYYY',
            startDate: new Date(),
            endDate: moment().add('months', 1),
            opens: "center"
        });
        // $(elm).data('daterangepicker').clickApply();
        return dPicker;
    };

    model.addSegmentCheckBox = function(elm, value) {
        var checked = "";
        if (value) {
            checked = "checked";
        }
        $(elm).append('<input type="checkbox" name="template-qc-segment" value="true" '+ checked +'>Use Top Level Segment');
    };

    model.validateTextbox = function(elm) {
        $(elm).change(function(){
            model.validateTextboxEvent(this);
        }); 
        $(elm).blur(function(){
            model.validateTextboxEvent(this);
        }); 
        $(elm).focus(function(){
            $(this).parent().removeClass("error-tooltip input");
            if (cidTextbox) {
                model.errorInstance.remove(cidTextbox);
            }
        }); 
    };

    model.validateTextboxEvent = function(elm) {
        if((!$(elm).val() || $(elm).val() == $(elm).attr("placeholder")) && $(elm).length) {
            $(elm).parent().addClass("error-tooltip input");
            model.errorInstance.add(
                {id: elm}
            );
            if (model.errorInstance.length - 1 >= 0) {
                cidTextbox = model.errorInstance.models[model.errorInstance.length - 1].cid;
            }
        }
        else{
            $(elm).parent().removeClass("error-tooltip input");
            if (cidTextbox) {
                model.errorInstance.remove(cidTextbox);
            }
        }
    };

    model.validateValue = function(elm) {
        $(elm).change(function(){
            model.validateValueEvent(this);
        }); 
        $(elm).blur(function(){
            model.validateValueEvent(this);
        }); 
        $(elm).focus(function(){
            $(this).parent().removeClass("error-tooltip");
            if (cidValue) {
                model.errorInstance.remove(cidValue);
            }
        });
    };

    model.validateValueEvent = function(elm, tab) {
        if(!Number($(elm).val()) && $(elm).length  ) {
            $(elm).parent().addClass("error-tooltip");
            model.errorInstance.push(
                {id: elm}
            );
            if(tab) {
                $(tab).css("color", "red");
            }
            if (model.errorInstance.length - 1 >= 0) {
                cidValue = model.errorInstance.models[model.errorInstance.length - 1].cid;
            }
        }
        else{
            $(elm).parent().removeClass("error-tooltip");
            if (cidValue) {
                model.errorInstance.remove(cidValue);
            }
            if(tab) {
                $(tab).css("color", "black");
            }
        }
    };

    model.validateDatepicker = function(elm) {
        
        $(elm).on('apply.daterangepicker', function(ev, picker) {
            model.validateDatepickerEvent(elm, ev, picker);
            var show_notif = false;
            if($("#n5tabul").children("li").length > 1) {
                $("[name='reservation']").each(function() {
                    $(this).data("daterangepicker").setOptions({
                        minDate: picker.startDate,
                        maxDate: picker.endDate,
                        format: 'DD-MMM-YYYY',
                        opens: "center"
                    });
                    if($(this).data("daterangepicker").startDate.startOf('day').valueOf() < picker.startDate.valueOf() ||  $(this).data("daterangepicker").endDate.startOf('day').valueOf() > picker.endDate.valueOf()){
                        $(this).data('daterangepicker').setStartDate(picker.startDate);
                        $(this).data('daterangepicker').setEndDate(picker.endDate);
                        show_notif = true;
                        
                    }
                    
                    
                    $(this).data('daterangepicker').clickApply();
                });

                if(show_notif) {
                    native5.Notifications.show("Date ranges in your templates might have updated due to this change. Kindly review them before you submit.", {
                        notificationType:"toast",
                        title:"Info",
                        position:"top",
                        distance:"50px",
                        persistent: true,
                        messageType: "info"
                    });
                }
            }
        });
    };

    model.validateDatepickerEvent = function(elm, ev, picker) {
        var today = moment();
        if(picker.startDate.valueOf() < today.startOf('day').valueOf()) {
            alert('you have selected a range which is in the past.');
        }
    };

    model.validateSelect = function(elm) {
        $(elm).on("select2-blur", function(e) {
            model.validateSelectEvent(this);
        });

        $(elm).on("select2-focus", function(e){
            $(this).parent().parent().removeClass("error-tooltip input");
            $(".select2-choices", $(elm)).css("border-color", "#aaa");
            if (cidSelect) {
                model.errorInstance.remove(cidSelect);
            }
        });
            
    };

    model.validateSelectEvent = function(elm) {
        if ($(elm).select2("val").length <= 0  && $(elm).length) {
            $(elm).parent().parent().addClass("error-tooltip input");
            $(".select2-choices", $(elm)).css("border-color", "red");
            model.errorInstance.push(
                {id: elm}
            );
            if (model.errorInstance.length - 1 >= 0) {
                cidSelect = model.errorInstance.models[model.errorInstance.length - 1].cid;
            }
        }
        else {
            $(elm).parent().parent().removeClass("error-tooltip input");
            $(".select2-choices", $(elm)).css("border-color", "#aaa");
            if (cidSelect) {
                model.errorInstance.remove(cidSelect);
            }
        }
    };

    model.validateProductSelect = function(elm) {
        $(elm).on("change", function(e) {
            model.validateProductSelectEvent(this);
        });            
    };

    model.validateProductSelectEvent = function(elm, tab) {
        if ((typeof $(elm).data("products") === "undefined" || $(elm).data("products").length === 0) && $(elm).length > 0) {
            $(elm).parent().parent().addClass("error-tooltip");
            $(elm).css("border-color", "red");
            model.errorInstance.push(
                {id: elm}
            );
            if (model.errorInstance.length - 1 >= 0) {
                cidProdSelect = model.errorInstance.models[model.errorInstance.length - 1].cid;    
            }
            if(tab) {
                $(tab).css("color", "red");
            }
        }
        else {
            $(elm).parent().parent().removeClass("error-tooltip");
            $(elm).css("border-color", "#aaa");
            if (cidProdSelect) {
                model.errorInstance.remove(cidProdSelect);
            }
            if(tab) {
                $(tab).css("color", "black");
            }
        }
    };

    model.validatePayout = function(elm) {
        $(elm).change(function(){
            model.validatePayoutEvent(this);
        }); 
        $(elm).blur(function(){
            model.validatePayoutEvent(this);
        }); 
        $(elm).focus(function(){
            $(this).parent().removeClass("error-tooltip");
            if (cidPayout) {
                model.errorInstance.remove(cidPayout);
            }
        }); 
    };

    model.validatePayoutEvent = function(elm, tab) {
        var number = Number($(elm).val());
        if(!number && $(elm).length) {
            $(elm).parent().addClass("error-tooltip");
            model.errorInstance.push(
                {id: elm}
            );
            if (model.errorInstance.length - 1 >= 0) {
                cidPayout = model.errorInstance.models[model.errorInstance.length - 1].cid;
            }
            if(tab) {
                $(tab).css("color", "red");
            }
        }
        else{
            if((number < 1) || (number > 100)) {
                $(elm).parent().addClass("error-tooltip");
                model.errorInstance.push(
                    {id: elm}
                );
                if (model.errorInstance.length - 1 >= 0) {
                    cidPayout = model.errorInstance.models[model.errorInstance.length - 1].cid;
                }
                if(tab) {
                    $(tab).css("color", "red");
                }
            }
            else {
                $(elm).parent().removeClass("error-tooltip");
                if (cidPayout) {
                    model.errorInstance.remove(cidPayout);
                }
                if(tab) {
                    $(tab).css("color", "black");
                }
                // model.errorInstance.remove({id: elm});
            }
        }
    };

    model.checkPositiveInteger = function() {
        $(".lap-rate").each(function() {
            $(this).on("keydown", function(event) {
                if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode === 190 || event.keyCode || 110) {
                }
                else {
                    if (event.keyCode < 95) {
                        if (event.keyCode < 46 || event.keyCode > 57) {
                            event.preventDefault();
                        }
                    }
                    else {
                        if (event.keyCode < 96 || event.keyCode > 105) {
                            event.preventDefault();
                        }
                    }
                }
            });
        });
    };

    model.dealerAttrRun = function(){
        $(".dealertype-include-button").click(function(){
            var self = this;
            if($(this).hasClass("selected")) {
                $(this).removeClass("selected");
                model.dealerAttrCollection.remove(
                    $(self).parent().parent().data("value") + $(self).parent().data("value") + "false"
                );
            }
            else {
                $(this).parent().find(".highlight-button").removeClass("selected");
                $(this).addClass("selected");
                model.dealerAttrCollection.remove(
                    $(self).parent().parent().data("value") + $(self).parent().data("value") + "true"
                );
                model.dealerAttrCollection.add({
                    type: $(self).parent().parent().data("value"),
                    attr: $(self).parent().data("value"),
                    id: $(self).parent().parent().data("value") + $(self).parent().data("value") + "false",
                    excluded: false
                });
            }
        });

        $(".dealertype-exclude-button").click(function(){
            var self = this;
            if($(this).hasClass("selected")) {
                $(this).removeClass("selected");
                model.dealerAttrCollection.remove(
                    $(self).parent().parent().data("value") + $(self).parent().data("value") + "true"
                );
            }
            else {
                $(this).parent().find(".highlight-button").removeClass("selected");
                $(this).addClass("selected");
                model.dealerAttrCollection.remove(
                    $(self).parent().parent().data("value") + $(self).parent().data("value") + "false"
                );
                model.dealerAttrCollection.add({
                    type: $(self).parent().parent().data("value"),
                    attr: $(self).parent().data("value"),
                    id: $(self).parent().parent().data("value") + $(self).parent().data("value") + "true",
                    excluded: true
                });
            }
        });
    };

    model.uniqueArrays = function(array1, array2) {
        var unique = false;

        if(array1.length !== array2.length) {
            return true;
        } else {
            $.each(array1, function(key, value) {
                if(value !== array2[key]) {
                    unique = true;
                }
            });
        }

        return unique;
    };

    model.isNumberKey = function(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if(charCode > 31 && (charCode != 46 &&(charCode < 48 || charCode > 57))) {
            return false;
        }
        return true;
    };

    model.addSlabQC = function(elm, templateName, templateType){
        var satisfyAllExists;
        var errorsBeforevalidation = model.errorInstance.length;
        var satisfyButtonState = $(elm).data("satisfy");
        var prevData = $(elm).data("qc");
        var qcIndex;
        var slabSubmitIndex = 1;
        if (templateType == "SLAB"){
            qcIndex = templateName + "_SLAB_QC" + (slabSlabQCIndex + 1) + "_";
            slabSlabQCIndex++;
        }
        else if (templateType == "PPI"){
            qcIndex = templateName + "_SLAB_QC" + (ppiSlabQCIndex + 1) + "_";
            ppiSlabQCIndex++;
        }
        else if (templateType == "PRI"){
            qcIndex = templateName + "_SLAB_QC" + (priSlabQCIndex + 1) + "_";
            priSlabQCIndex++;
        }
        else if (templateType == "SLABV2"){
            qcIndex = templateName + "_SLAB_QC" + (slabV2SlabQCIndex + 1) + "_";
            slabV2SlabQCIndex++;
        }
        else if (templateType == "SLABV3"){
            qcIndex = templateName + "_SLAB_QC" + (slabV3SlabQCIndex + 1) + "_";
            slabV3SlabQCIndex++;
        }

        $("#slab-qc-container").empty();
        var slabQCCollection;
        if(prevData) {
            satisfyAllExists = true;
            model.createSatisfyAllButton($("#slab-qc-container"), "inSlabQC", satisfyButtonState);
            slabQCCollection = new model.QualifyingConditions(prevData);
            slabQCCollection.each(function(QCmodel){
                var condition = model.addInSlabCondition(QCmodel, slabQCCollection);
                condition.render();
            });
        }
        else {
            slabQCCollection = new model.QualifyingConditions();
        }

        var inSlabQCIndex = 0;
        $("#add-qc-inslab").off("click");
        $("#add-qc-inslab").on("click", function() {
            if(!satisfyAllExists) {
                model.createSatisfyAllButton($("#slab-qc-container"), "inSlabQC");
                satisfyAllExists = true;
            }
            inSlabQCIndex++;
            var slabQCModel = new model.QualifyingCondition({
                "name":"HISTORICAL",
                "type":"VALUE",
                "op":"GREATER_THAN_EQUALS",
                "val":"",
                "payoutCondition":"",
                "qid": qcIndex + inSlabQCIndex
            });
            var condition = model.addInSlabCondition(slabQCModel, slabQCCollection, elm);
            condition.render();
        });

        // var qc = new model.QualifyingConditionView({ 
        //     el: $("#slab-qc-container"),
        //     model: slabQCModel,
        //     collection: model.slabQCCollection
        // });
        // qc.render();
        // qc.removeCloseButton();
        $("#add-qc-slab").off("click");
        $("#add-qc-inslab-done").on("click",function(){
            
            // qc.validate();
            model.EventBus.trigger("validate:QCView");
            if((model.errorInstance.length > errorsBeforevalidation && slabSubmitIndex == 1) || (model.errorInstance.length = errorsBeforevalidation && slabSubmitIndex > 1)) {
                return false;
            }
            else {
                $(elm).data("qc", slabQCCollection.toJSON());
                $(elm).data("satisfy", $('#item-inSlabQC').is(':checked'));
                $(elm).addClass("btn-qc-active");
                // $(elm).attr("data-qc", slabQCModel.toJSON());
                // qc.removeWithoutConfirmation();
                app.slabQCModal.closeModal();
            } 

            slabSubmitIndex++;
        });

        $("#remove-qc-slab").off("click");
        $("#remove-qc-slab").on("click",function(){
            $(elm).data("qc", null);
            $(elm).removeClass("btn-qc-active");
            model.errorInstance.reset();
            slabQCCollection.each(function(QCmodel){
                slabQCCollection.remove(QCmodel);
                QCmodel.destroy();                  
            });
            slabQCCollection.reset();
            app.slabQCModal.closeModal();
        });

    };

    model.addInSlabCondition = function(QCmodel, collection, elm){
        var self = this;

        $("#slab-qc-container").append('<span class = "qc-wrapper"><span>');
        var conditionView = new model.QualifyingConditionView({ 
            el: $(".qc-wrapper",$("#slab-qc-container")).last(),
            model: QCmodel,
            collection: collection
        });
        conditionView.inSlabQCElm = elm;
        return conditionView;
    };

    var inc = 0;
    model.generateProductSelectOnclick = function(elm, type) {
        if(!type) {
            var type = "products";
        }
        $(elm).on("click", function() {
            akzo.ui.exclusionSelect(type);
            akzo.ui.exclusionSelect.result(this, type);
            prodExclusionModal.showModal();
        });
    };

    // FIXME: Make this dynamic
    model.getSegmentText = function(id) {
        if(isNaN(id)) {
            return id;
        }
        switch(parseInt(id)) {
            case 1: 
                return "70 Trade";
            case 4:
                return "76 Direct";
            case 990: 
                return "76 RS";
            case 991:
                return "76 Sub Dealer";
            case 992: 
                return "77 MR Bharat";
            case 5:
                return "77 MR Trade";
            case 3:
                return "74 Professional";
        }
    };

    model.getProjectSku = function(elm) {
        if($(elm).hasClass("fa-check-square-o")) {
            return true;
        } else {
            return false;
        }
    };

    model.token = getParameterByName("rand_token");

    model.SlabTabModel = Backbone.Model.extend({
        defaults: {
            qcList: [],
            slabDnI: {
                templateName: "",
                numSlabs: 1,
                packs: ["BULK", "RETAIL"],
                slabType: "VOLUME",
                prevPeriod: {},
                currPeriod: {},
                products: [],
                packCondition: {type: "greater", startValue: null, endValue: null},
                laps: [],
                segment: []
            }
        }
    });

    model.SlabV3TabModel = Backbone.Model.extend({
        defaults: {
            qcList: [],
            slabV3DnI: {
                templateName: "",
                numSlabs: 1,
                packs: ["BULK", "RETAIL"],
                slabType: "VOLUME",
                prevPeriod: {},
                currPeriod: {},
                products: [],
                payoutProducts: [],
                packCondition: {type: "greater", startValue: null, endValue: null},
                laps: [],
                segment: []
            }
        }
    });

    model.PpiModel = Backbone.Model.extend({
        defaults: {
            qcList: [],
            ppiDnI: {
                templateName: "",
                numSlabs: 1,
                packs: ["BULK", "RETAIL"],
                period: {},
                prevPeriod: {},
                currPeriod: {},
                ppiType: "VOLUME",
                products: [],
                packCondition: {type: "greater", startValue: null, endValue: null},
                slabPayouts: [],
                segment: []
            }
        }
    });

    model.PriModel = Backbone.Model.extend({
        defaults: {
            qcList: [],
            priDnI: {
                templateName: "",
                numSlabs: 1,
                period: {},
                priType: "VOLUME",
                priProducts: [],
                packCondition: {type: "greater", startValue: null, endValue: null},
                priPayouts: [],
                segment: []
            }
        }
    });

    model.inBillModel = Backbone.Model.extend({
        defaults: {
            inBillDnI: {
                templateName: "",
                numLaps: 1,
                products: [],
                packCondition: {type: "greater", startValue: null, endValue: null},
                inBillLaps: [],
                segment: []
            }
        }
    });

    model.newSlabModel = Backbone.Model.extend({
        defaults: {
            slabV2DnI: {
                templateName: "",
                numLaps: 1,
                prevPeriod: {},
                currPeriod: {},
                products: [],
                packCondition: {type: "greater", startValue: null, endValue: null},
                laps: [],
                segment: []
            }
        }
    });

    model.errorModel = Backbone.Model.extend();


    model.SchemeDetails = Backbone.Model.extend({});
    model.QualifyingCondition = Backbone.Model.extend({});

    model.SchemeModel = Backbone.Model.extend({});

    model.QualifyingConditions = Backbone.Collection.extend({
        model: model.QualifyingCondition
    });
    
    model.dealerAttr = Backbone.Collection.extend({});

    model.dealerAttrCollection = new model.dealerAttr();

    model.SlabQualifyingConditions = Backbone.Collection.extend({
        model: model.QualifyingCondition
    });
    model.slabQCCollection = new model.SlabQualifyingConditions();

    model.SlabTabsCollection = Backbone.Collection.extend({
        model: model.SlabTabModel,
    });

    model.SlabV3TabsCollection = Backbone.Collection.extend({
        model: model.SlabV3TabModel,
    });

    model.PpiCollection = Backbone.Collection.extend({
        model: model.PpiModel,
    });

    // model.newPpiCollection = Backbone.Collection.extend({
    //     model: model.newPpiModel,
    // });

    model.PriCollection = Backbone.Collection.extend({
        model: model.PriModel,
    });

    model.inBillCollection = Backbone.Collection.extend({
        model: model.inBillModel,
    });

    model.newSlabCollection = Backbone.Collection.extend({
        model: model.newSlabModel,
    });

    model.errorCollection = Backbone.Collection.extend({
        model: model.errorModel
    });

    model.SlabTabsInstance = new model.SlabTabsCollection();
    model.SlabV3TabsInstance = new model.SlabV3TabsCollection();
    model.PpiCollectionInstance = new model.PpiCollection();
    // model.newPpiCollectionInstance = new model.newPpiCollection();
    model.PriCollectionInstance = new model.PriCollection();
    model.inBillInstance = new model.inBillCollection();
    model.newSlabInstance = new model.newSlabCollection();
    model.errorInstance = new model.errorCollection();

    model.QCcollection = null;
    model.schemeDetailsModel = null;

    if (model.existingSchemeData.schemeHeaderTemplate) {
        model.QCcollection = new model.QualifyingConditions(model.existingSchemeData.schemeHeaderTemplate.qcList);
        model.schemeDetailsModel = new model.SchemeDetails(model.existingSchemeData.schemeHeaderTemplate);
    }
    else {
        model.QCcollection = new model.QualifyingConditions();
        model.schemeDetailsModel = new model.SchemeDetails();
    }

    return model;
} (jQuery, _, model || {}));
