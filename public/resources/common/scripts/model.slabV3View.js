/*jshint loopfunc: true, quotmark: false */
/* global _, jQuery, akzo, native5, Backbone, model */
(function (_, $, akzo, native5, Backbone, schemeModel) {
    "use strict";

    model.SlabV3TabsView = Backbone.View.extend({
        initialize: function(){
            this.model = new schemeModel.SlabV3TabModel();
            schemeModel.SlabV3TabsInstance.add(this.model);
            this.QCIndex = 0;
        },

        render: function(slabV3Tab, addTempLib, data) {
            var self = this;
            this.slabV3Tab = slabV3Tab;
            if($.isEmptyObject(data)) {
                data = self.model.toJSON();
            }
            new akzo.ui.slabV3Template({"slabV3Tab":slabV3Tab, "tabInstance":addTempLib, data: data});
            this.model.set('qcList', new schemeModel.QualifyingConditions(data.qcList));

            $("#n5-ui-template-add-temp-qc .n5add").on("click", function() {
                if($("#n5-ui-slabV3" + slabV3Tab).length > 0) {
                    self.setData();
                }
            });

            self.model.attributes.qcList.each(function(model){
                var condition = self.addCondition(model);
                condition.render();
            });

            var parentId = $("#n5-ui-slabV3" + self.slabV3Tab).parent().attr("id");
            // var parentNum = parseInt(parentId.substr(parentId.length - 1)) ;
            var parentNum = parseInt(parentId.slice(1));
            var elm = $("#t" + parentNum + " .n5close")[0];
            var oldEvent = $._data(elm, "events").click[0].handler;

            $(elm).off("click");
            $(elm).on("click", function() {
                var deleteConfirmation = window.confirm("Are you sure to delete this template?");

                if(deleteConfirmation) {
                    oldEvent();
                    schemeModel.SlabV3TabsInstance.remove(self.model);
                }
            });

            $("#n5-ui-slabV3"+slabV3Tab+" .add-condition").on("click", function() {
                var condition = self.addCondition();
                condition.render();
            });

            $("#n5-ui-slabV3"+slabV3Tab+" .add-condition").one("click", function() {
                schemeModel.createSatisfyAllButton($("#n5-ui-slabV3"+slabV3Tab+" .slabV3-qualifying-conditions .qualifying-conditions-list"), "slabV3");    
            });
        },

        addCondition: function(model){
            var self = this;
            var parentDivId = $("#n5-ui-slabV3" + self.slabV3Tab).parent().attr("id");
            var tabNumber = parseInt(parentDivId.slice(1));

            $(".qualifying-conditions-list", $("#n5-ui-slabV3"+this.slabV3Tab)).append('<span class = "qc-wrapper"><span>');
            this.QCIndex++;
            var conditionView = new schemeModel.QualifyingConditionView({ 
                el: $(".qc-wrapper",$("#n5-ui-slabV3"+this.slabV3Tab)).last(),
                model: model || new schemeModel.QualifyingCondition({
                    "name":"HISTORICAL",
                    "type":"VALUE",
                    "op":"GREATER_THAN_EQUALS",
                    "val":"",
                    "payoutCondition":"",
                    "topLevelSegment": false,
                    "qid": "DEFAULT_slabV3" + tabNumber + "_QC" +(this.QCIndex+1)
                }),
                collection: self.model.attributes.qcList,
                tabNum: $("#t" + tabNumber)
            });
            conditionView.tabNum = $("#t" + tabNumber);
            return conditionView;
            
        },

        setData: function() {
            var self = this;

            var parentDivId = $("#n5-ui-slabV3" + self.slabV3Tab).parent().attr("id");
            var tabNumber = parseInt(parentDivId.slice(1));

            if(self.validateTemplate()) {
                $("#t" + tabNumber).css("color", "black");
                schemeModel.errorInstance.remove({id: "#t" + tabNumber});

                var slabType = (schemeModel.getType("#n5-ui-slabV3" + self.slabV3Tab)).toUpperCase();

                var prevCalendar = $(".js-period-prev", "#n5-ui-slabV3" + self.slabV3Tab);
                var prevStartDate = schemeModel.getFormattedDate(new Date($(prevCalendar).data('daterangepicker').startDate));
                var prevEndDate = schemeModel.getFormattedDate(new Date($(prevCalendar).data('daterangepicker').endDate));

                var currCalendar = $(".js-period-curr", "#n5-ui-slabV3" + self.slabV3Tab);
                var currStartDate = schemeModel.getFormattedDate(new Date($(currCalendar).data('daterangepicker').startDate));
                var currEndDate = schemeModel.getFormattedDate(new Date($(currCalendar).data('daterangepicker').endDate));
                var prevPeriod;
                var currPeriod;

                if(slabType === "GROWTH") {
                    prevPeriod = {startDate: prevStartDate, endDate: prevEndDate};
                    currPeriod = {startDate: currStartDate, endDate: currEndDate};
                } else {
                    prevPeriod = null;
                    currPeriod = null;
                }

                var packCondition = {};

                if($(".js-pack-start", "#n5-ui-slabV3" + self.slabV3Tab).is(":visible")) {
                    packCondition.type = $(".js-pack-select", "#n5-ui-slabV3" + self.slabV3Tab).select2("val");
                    packCondition.startValue = $(".js-pack-start", "#n5-ui-slabV3" + self.slabV3Tab).val();
                }

                if($(".js-pack-end", "#n5-ui-slabV3" + self.slabV3Tab).is(":visible")) {
                    packCondition.endValue = $(".js-pack-end", "#n5-ui-slabV3" + self.slabV3Tab).val();
                }

                if($.isEmptyObject(packCondition)) {
                    packCondition = null;
                }

                var slabV3Data = {
                    id: "slabV3_" + self.slabV3Tab,
                    templateName: $("#n5-ui-slabV3" + this.slabV3Tab + " .template-name").val(),
                    numslabV3s: parseInt($("#n5-ui-slabV3" + self.slabV3Tab + " #noofslabV3TextStr" + self.slabV3Tab).val()),
                    slabType: slabType,
                    prevPeriod: prevPeriod,
                    currPeriod: currPeriod,
                    laps: self.getLaps(),
                    segment: model.getSelectedValues($("select.template-segment-values", "#n5-ui-slabV3" + self.slabV3Tab).select2("data")),
                    packs: schemeModel.getPack($("#n5-ui-slabV3" + self.slabV3Tab + " .n5-ui-sc-col .n5-ui-sc-col")[0]),
                    // products: schemeModel.getProducts($(".select2-choices", $("#n5-ui-slabV3" + self.slabV3Tab))[0]),
                    products: $(".product-select", "#n5-ui-slabV3" + self.slabV3Tab).data("products"),
                    payoutProducts: $(".product-payout", "#n5-ui-slabV3" + self.slabV3Tab).data("products"),
                    projectSku: $(".js-project-sku", "#n5-ui-slabV3" + self.slabV3Tab).prop("checked"),
                    packCondition: packCondition,
                };
                self.model.set("id", "slabV3_TPL_" + self.slabV3Tab);
                self.model.set("slabV3DnI", slabV3Data);
                self.setSatisfyAll();
            } else {
                $("#t" + tabNumber).css("color", "red");
                schemeModel.errorInstance.add({
                    id: "#t" + tabNumber
                });
            }
        },

        setSatisfyAll: function(){
            var satisfy = $(".slabV3-qualifying-conditions .satisfyAll").is(":checked");
            this.model.set("satisfyAll", satisfy);
        },

        getLaps: function() {
            var self = this;
            var retArr = [];
            var numLaps = parseInt($("#nooflapsV3TextStr" + this.slabV3Tab, "#n5-ui-slabV3" + this.slabV3Tab).val());
            var tbody = $("#n5-Q-cond-table-slabV3" + this.slabV3Tab).find("table:nth-child(1)").find("tbody")[0];
            var rows = $(tbody).find("tr");
            
            for(var laps = 0; laps < numLaps; laps++) {
                var tempArr = [];

                var calendar = $("#n5-date-reservation-slabV3-table" + (laps + 1), "#n5-ui-slabV3" + self.slabV3Tab);
                var startDate = schemeModel.getFormattedDate(new Date($(calendar).data('daterangepicker').startDate));
                var endDate = schemeModel.getFormattedDate(new Date($(calendar).data('daterangepicker').endDate));
                var period = {startDate: startDate, endDate: endDate};

                $.each(rows, function(key, row) {
                    var length = $(row).find("td").length;
                    var startTd = $(row).find("td")[0];
                    var endTd = $(row).find("td")[1];
                    var type = $(row).find("td")[length - 2];
                    var lapElm = $(row).find("td")[laps + 2];
                    var qcElm = $(row).find("td")[length - 1];

                    var slabV3StartValue = $(startTd).find("input:nth-child(1)").val();
                    var slabV3EndValue = $(endTd).find("input:nth-child(1)").val();
                    var payoutValue = $(lapElm).find("input:nth-child(1)").val();
                    var payoutType = schemeModel.getPayoutType($("#noofslabV3sTextStr-slabV3-payout" + (key + 1), $(type)).val());
                    var payoutDescription = $(".js-gift-desc" + (key + 1), $(row)).val();
                    var qc = $(".n5-table-qc-add", $(qcElm)).data("qc");
                    var satisfyAll = $(".n5-table-qc-add", $(qcElm)).data("satisfy");

                    if($.isEmptyObject(qc)) {
                        qc = null;
                    }

                    if(payoutType !== "GIFT") {
                        payoutDescription = null;
                    }

                    tempArr.push({
                        id: "PAYOUT_" + (key + 1),
                        slabV3StartValue: slabV3StartValue,
                        slabV3EndValue: slabV3EndValue,
                        payoutValue: payoutValue,
                        payoutType: payoutType,
                        payoutDescription: payoutDescription,
                        qcList: qc,
                        satisfyAll: satisfyAll
                    });
                });

                retArr.push({
                    id: "LAPS_" + (laps + 1),
                    period: period,
                    payouts: tempArr,
                });
            }            
            return retArr;
        },

        validateTemplate: function() {
            var validated = true;
            var self = this;
            var templateName = $("#n5-ui-slabV3" + self.slabV3Tab + " .template-name");

            if(!($(templateName).val() && $(templateName).val() !== $(templateName).attr("placeholder"))) {
                $(templateName).parent().attr("tip-title", "Template name cannot be empty");
                $(templateName).parent().addClass("error-tooltip input");
                validated = false;
            } else {
                $(templateName).parent().removeClass("error-tooltip input");
            }

            var slabType = (schemeModel.getType("#n5-ui-slabV3" + self.slabV3Tab)).toUpperCase();
            if(slabType === "GROWTH") {
                validated = schemeModel.validateGrowthRanges($(".js-period-prev", "#n5-ui-slabV3" + self.slabV3Tab), $(".js-period-curr", "#n5-ui-slabV3" + self.slabV3Tab));
            }

           var isValidDates = self.validateDateRanges(self.slabV3Tab);
           validated = isValidDates && validated;

            // var selectUl = $(".select2-choices", $("#n5-ui-slabV3" + self.slabV3Tab))[0];
            // if(schemeModel.getProducts($(selectUl)).length === 0) {
            //     $(selectUl).parents(".span-select2-parent").attr("tip-title", "At least one product must be selected");
            //     $(selectUl).parents(".span-select2-parent").addClass("error-tooltip error-border");
            //     validated = false;
            // } else {
            //     $(selectUl).parents(".span-select2-parent").removeClass("error-tooltip error-border");
            // }

            var schemeProducts = $(".product-select", "#n5-ui-slabV3" + self.slabV3Tab);
            if(schemeProducts.data("products") === undefined || schemeProducts.data("products").length === 0) {
                $(schemeProducts).attr("tip-title", "At least one product must be selected");
                $(schemeProducts).addClass("error-tooltip error-border");
                validated = false;
            } else {
                $(schemeProducts).removeClass("error-tooltip error-border");
            }

            var payoutProducts = $(".product-payout", "#n5-ui-slabV3" + self.slabV3Tab);
            if(payoutProducts.data("products") === undefined || payoutProducts.data("products").length === 0) {
                $(payoutProducts).attr("tip-title", "At least one product must be selected");
                $(payoutProducts).addClass("error-tooltip error-border");
                validated = false;
            } else {
                $(payoutProducts).removeClass("error-tooltip error-border");
            }

            var isValidRow = self.validateTableRows($("#n5-ui-slabV3" + self.slabV3Tab + " #dynamicTable tbody tr"));
            validated = isValidRow && validated;

            /* Pack Validation Start */
            var packEnd = $(".js-pack-end", "#n5-ui-slabV3" + self.slabV3Tab);
            var packStart = $(".js-pack-start", "#n5-ui-slabV3" + self.slabV3Tab);

            if($(packEnd).is(":visible") && !$(packEnd).val()) {
                $(packEnd).parent().attr("tip-title", "Value is required");
                $(packEnd).parent().addClass("error-tooltip input");
                validated = false;
            } else {
                $(packEnd).parent().removeClass("error-tooltip input");
            }

            if($(packStart).is(":visible") && !$(packStart).val()) {
                $(packStart).parent().attr("tip-title", "Value is required");
                $(packStart).parent().addClass("error-tooltip input");
                validated = false;
            } else {
                $(packStart).parent().removeClass("error-tooltip input");
            }
            /* Pack Validation End */

            return validated;
        },

        validateDateRanges: function(tab) {
            var validRange = true;
            var dateRanges = [];

            var dateStart = $("#sales-period").data('daterangepicker').startDate;
            var dateEnd = $("#sales-period").data('daterangepicker').endDate;

            $("#n5-ui-slabV3" + tab + " [name='reservation']").each(function() {
                var self = this;
                if(!($(self).val() && $(self).val() !== "Select Period")) {
                    $(self).parent().attr("tip-title", "Dates cannot be empty");
                    $(self).parent().addClass("error-tooltip");
                    validRange = false;
                } else {
                    var dates = [
                        new Date($(self).data("daterangepicker").startDate),
                        new Date($(self).data("daterangepicker").endDate)
                    ];

                    if(new Date(dates[0]).getTime() < new Date(dateStart).getTime() || new Date(dates[1]).getTime() > new Date(dateEnd).getTime()) {
                        validRange = false;
                    } else {
                        if(dateRanges.length === 0) {
                            dateRanges.push(dates);
                            $(self).parent().removeClass("error-tooltip");
                        } else {
                            $.each(dateRanges, function(key, value) {
                                if(new Date(value[0]).getTime() < new Date(dates[1]).getTime() && new Date(dates[0]).getTime() < new Date(value[1]).getTime()) {
                                    $(self).parent().attr("tip-title", "Dates cannot overlap with each other");
                                    $(self).parent().addClass("error-tooltip");
                                    validRange = false;
                                } else {
                                    dateRanges.push(dates);
                                    $(self).parent().removeClass("error-tooltip");
                                }
                            });
                        }
                    }
                }
            });

            return validRange;
        },

        validateTableRows: function(rows) {
            var validated = true;
            var slabV3sArr = [];
            var inc = 0;

            $(rows).each(function() {
                var self = this;
                inc++;
                var payoutType = schemeModel.getPayoutType($("#noofslabV3sTextStr-slabV3-payout" + inc, $(self)).val());

                var payoutTpyeTd = $(self).children()[$(self).children().length - 2];

                $(".lap-rate", $(self)).each(function() {
                    if(!($.isNumeric($(this).val()) && Number($(this).val()) > 0)) {
                        $(this).parent().attr("title", "Lap Rates is required can only be positive integer.");
                        $(this).parent().addClass("error-table");
                        validated = false;
                    } else {
                        $(this).parent().removeAttr("title");
                        $(this).parent().removeClass("error-table");

                        if(payoutType.toUpperCase() === "PERCENTAGE") {
                            if(Number($(this).val()) > 200) {
                                $(this).parent().attr("title", "Percentage payout rate cannot be more than 200");
                                $(this).parent().addClass("error-table");
                                validated = false;
                            }
                        }
                    }
                });

                if(payoutType.toUpperCase() === "GIFT") {
                    if(!$(".js-gift-desc" + inc, $(self)).val()) {
                        $(payoutTpyeTd).attr("title", "Gift description is needed");
                        $(payoutTpyeTd).addClass("error-table");
                        validated = false;
                    }
                } else {
                    $(payoutTpyeTd).removeAttr("title", "Gift description is needed");
                    $(payoutTpyeTd).removeClass("error-table");
                }

                var slabV3Start = $(self).children()[0];
                var inputStart = $(slabV3Start).children("input")[0];
                var startVal = $(inputStart).val();

                var slabV3End = $(self).children()[1];
                var inputEnd = $(slabV3End).children("input")[0];
                var endVal = $(inputEnd).val();

                if(!($.isNumeric(startVal) && $.isNumeric(endVal))) {
                    $(inputEnd).parent().attr("title", "Numeric slab Values are required");
                    $(inputEnd).parent().addClass("error-table");
                    validated = false;
                } else if(Number(startVal) <= 0 || Number(endVal) <= 0) {                
                    $(inputEnd).parent().attr("title", "Slab values must be greater than 0");
                    $(inputEnd).parent().addClass("error-table");
                    validated = false;
                } else if(Number(endVal) <= Number(startVal)) {
                    $(inputEnd).parent().attr("title", "slab End value cannot be smaller than slab Start value");
                    $(inputEnd).parent().addClass("error-table");
                    validated = false;
                } else {
                    $(inputEnd).parent().removeAttr("title");
                    $(inputEnd).parent().removeClass("error-table");

                    if(slabV3sArr.length === 0) {
                        slabV3sArr.push([Number(startVal), Number(endVal)]);
                    } else {
                        var length = slabV3sArr.length;
                        var lastEndValue = slabV3sArr[length - 1][1];
                        if(Number(startVal) !== (lastEndValue + 1)) {
                            $(inputEnd).parent().attr("title", "slab Values can only be sequestial and without any gaps.");
                            $(inputEnd).parent().addClass("error-table");
                            validated = false;
                        } else {
                            slabV3sArr.push([Number(startVal), Number(endVal)]);
                            $(inputEnd).parent().removeAttr("title");
                            $(inputEnd).parent().removeClass("error-table");
                        }
                    }
                }
            });

            return validated;
        },
    });

    return schemeModel;
}(_, jQuery, akzo, native5, Backbone, model || {}));