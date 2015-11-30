/* jshint loopfunc: true, quotmark: false */
/* global akzo, jQuery, Backbone, model */
(function ($, akzo, Backbone, schemeModel) {
    "use strict";

    schemeModel.newPpiView = Backbone.View.extend({
        initialize: function(){
            this.model = new schemeModel.PpiModel();
            schemeModel.PpiCollectionInstance.add(this.model);
            this.QCIndex = 0;
        },

        render: function(newPpiTab, addTempLib, data) {
            var self = this;
            this.newPpiTab = newPpiTab;
            if($.isEmptyObject(data)) {
                data = self.model.toJSON();
            }
            new akzo.ui.newPpiTemplate({"newPpiTab":newPpiTab, "tabInstance":addTempLib, data: data});
            this.model.set('qcList', new schemeModel.QualifyingConditions(data.qcList));

            $("#n5-ui-template-add-temp-qc .n5add").on("click", function() {
                if($("#n5-ui-newPpi" + newPpiTab).length > 0) {
                    self.setData();
                }
            });

            self.model.attributes.qcList.each(function(model){
                var condition = self.addCondition(model);
                condition.render();
            });

            var parentId = $("#n5-ui-newPpi" + self.newPpiTab).parent().attr("id");
            var parentNum = parseInt(parentId.slice(1));
            // var parentNum = parentId.substr(parentId.length - 1);
            var elm = $("#t" + parentNum + " .n5close")[0];
            var oldEvent = $._data(elm, "events").click[0].handler;

            $(elm).off("click");
            $(elm).on("click", function() {
                var deleteConfirmation = window.confirm("Are you sure to delete this template?");

                if(deleteConfirmation) {
                    oldEvent();
                    schemeModel.PpiCollectionInstance.remove(self.model);
                }
            });

            $("#n5-ui-newPpi"+newPpiTab+" .add-condition").on("click", function() {
                var condition = self.addCondition();
                condition.render();
            });

            $("#n5-ui-newPpi"+newPpiTab+" .add-condition").one("click", function() {
                schemeModel.createSatisfyAllButton($("#n5-ui-newPpi"+newPpiTab+" .newPpi-qualifying-conditions .qualifying-conditions-list"), "newPpi");    
            });

        },

        addCondition: function(model){
            var self = this;
            var parentDivId = $("#n5-ui-newPpi" + self.newPpiTab).parent().attr("id");
            var tabNumber = parseInt(parentDivId.slice(1));

            $(".qualifying-conditions-list", $("#n5-ui-newPpi"+this.newPpiTab)).append('<span class = "qc-wrapper"><span>');
            this.QCIndex++;
            var conditionView = new schemeModel.QualifyingConditionView({ 
                el: $(".qc-wrapper",$("#n5-ui-newPpi"+this.newPpiTab)).last(),
                model: model || new schemeModel.QualifyingCondition({
                    "name":"HISTORICAL",
                    "type":"VALUE",
                    "op":"GREATER_THAN_EQUALS",
                    "val":"",
                    "payoutCondition":"",
                    "topLevelSegment": false,
                    "qid": "DEFAULT_newPpi" + tabNumber + "_QC" +(this.QCIndex+1)
                }),
                collection: self.model.attributes.qcList,
                tabNum: $("#t" + tabNumber)
                
            });
            conditionView.tabNum = $("#t" + tabNumber);
            return conditionView;
            
        },

        setData: function() {
            var self = this;

            var parentDivId = $("#n5-ui-newPpi" + self.newPpiTab).parent().attr("id");
            var tabNumber = parseInt(parentDivId.slice(1));

            if(self.validateTemplate()) {
                $("#t" + tabNumber).css("color", "black");
                schemeModel.errorInstance.remove({
                    id: "#t" + tabNumber
                });

                var packCondition = {};

                if($(".js-pack-start", "#n5-ui-newPpi" + self.newPpiTab).is(":visible")) {
                    packCondition.type = $(".js-pack-select", "#n5-ui-newPpi" + self.newPpiTab).select2("val");
                    packCondition.startValue = $(".js-pack-start", "#n5-ui-newPpi" + self.newPpiTab).val();
                }

                if($(".js-pack-end", "#n5-ui-newPpi" + self.newPpiTab).is(":visible")) {
                    packCondition.endValue = $(".js-pack-end", "#n5-ui-newPpi" + self.newPpiTab).val();
                }

                if($.isEmptyObject(packCondition)) {
                    packCondition = null;
                }

                var calendar = $("#n5-date-reservation" + self.newPpiTab, "#n5-ui-newPpi" + self.newPpiTab);
                var startDate = schemeModel.getFormattedDate(new Date($(calendar).data('daterangepicker').startDate));
                var endDate = schemeModel.getFormattedDate(new Date($(calendar).data('daterangepicker').endDate));
                var period = {startDate: startDate, endDate: endDate};

                var ppiType = (schemeModel.getType("#n5-ui-newPpi" + self.newPpiTab)).toUpperCase();

                var prevCalendar = $(".js-period-prev", "#n5-ui-newPpi" + self.newPpiTab);
                var prevStartDate = schemeModel.getFormattedDate(new Date($(prevCalendar).data('daterangepicker').startDate));
                var prevEndDate = schemeModel.getFormattedDate(new Date($(prevCalendar).data('daterangepicker').endDate));

                var currCalendar = $(".js-period-curr", "#n5-ui-newPpi" + self.newPpiTab);
                var currStartDate = schemeModel.getFormattedDate(new Date($(currCalendar).data('daterangepicker').startDate));
                var currEndDate = schemeModel.getFormattedDate(new Date($(currCalendar).data('daterangepicker').endDate));
                var prevPeriod;
                var currPeriod;

                if(ppiType === "GROWTH") {
                    prevPeriod = {startDate: prevStartDate, endDate: prevEndDate};
                    currPeriod = {startDate: currStartDate, endDate: currEndDate};
                } else {
                    prevPeriod = null;
                    currPeriod = null;
                }

                var repeatData = {
                    slabRange: $(".js-slab-value", "#n5-ui-newPpi" + self.newPpiTab).val(),
                    lapChange: $(".js-lap-rate", "#n5-ui-newPpi" + self.newPpiTab).val(),
                    rowRepeat: $(".js-repeat", "#n5-ui-newPpi" + self.newPpiTab).val(),
                };

                var newPpiData = {
                    id: "newPpi_" + self.newPpiTab,
                    templateName: $("#n5-ui-newPpi" + this.newPpiTab + " .template-name").val(),
                    period: period,
                    prevPeriod: prevPeriod,
                    currPeriod: currPeriod,
                    numSlabs: parseInt($("#noofnewPpiTextStr" + self.newPpiTab, $("#n5-ui-newPpi" + this.newPpiTab)).val()),
                    ppiType: ppiType,
                    segment: model.getSelectedValues($("select.template-segment-values", "#n5-ui-newPpi" + self.newPpiTab).select2("data")),
                    slabPayouts: self.getLaps(),
                    packs: schemeModel.getPack($("#n5-ui-newPpi" + self.newPpiTab + " .n5-ui-sc-col")[0]),
                    // products: schemeModel.getProducts($(".select2-choices", $("#n5-ui-newPpi" + self.newPpiTab))[0]),
                    products: $(".product-select", "#n5-ui-newPpi" + self.newPpiTab).data("products"),
                    projectSku: $(".js-project-sku", "#n5-ui-newPpi" + self.newPpiTab).prop("checked"),
                    repeatData: repeatData,
                    packCondition: packCondition
                };

                self.model.set("id", "newPpi_TPL_" + self.newPpiTab);
                this.model.set("ppiDnI", newPpiData);
                this.setSatisfyAll();
            } else {
                $("#t" + tabNumber).css("color", "red");
                schemeModel.errorInstance.add({
                    id: "#t" + tabNumber
                });
            }
        },

        setSatisfyAll: function(){
            var satisfy = $(".newPpi-qualifying-conditions .satisfyAll").is(":checked");
            this.model.set("satisfyAll", satisfy);
        },

        getLaps: function() {
            var retArr = [];
            var tbody = $("#n5-Q-cond-table-newPpi" + this.newPpiTab).find("table:nth-child(1)").find("tbody")[0];
            var rows = $(tbody).find("tr");
            var lastSlabEndValue;
            var lastPayoutValue;
            var lastPayoutType;
            var idStart = rows.length;
            var slabRange = Number($(".js-slab-value", "#n5-ui-newPpi" + this.newPpiTab).val()) - 1;
            var lapChange = Number($(".js-lap-rate", "#n5-ui-newPpi" + this.newPpiTab).val());
            var rowRepeat = Number($(".js-repeat", "#n5-ui-newPpi" + this.newPpiTab).val());

            $.each(rows, function(key, row) {
                var startTd = $(row).find("td")[0];
                var endTd = $(row).find("td")[1];
                var type = $(row).find("td")[3];
                var lapElm = $(row).find("td")[2];
                // var qcElm = $(row).find("td")[4];

                var slabStartValue = $(startTd).find("input:nth-child(1)").val();
                var slabEndValue = $(endTd).find("input:nth-child(1)").val();
                var payoutValue = $(lapElm).find("input:nth-child(1)").val();
                var payoutType = schemeModel.getPayoutType($("#noofnewPpisTextStr-newPpi-payout" + (key + 1), $(type)).val());
                var payoutDescription = $(".js-gift-desc" + (key + 1), $(row)).val();
                // var qc = $(".n5-table-qc-add", $(qcElm)).data("qc");

                /*if($.isEmptyObject(qc)) {
                    qc = null;
                }*/

                if(payoutType !== "GIFT") {
                    payoutDescription = null;
                }

                lastSlabEndValue = Number(slabEndValue);
                lastPayoutValue = Number(payoutValue);
                lastPayoutType = payoutType;

                retArr.push({
                    id: "LAPS_" + (key + 1),
                    slabStartValue: slabStartValue,
                    slabEndValue: slabEndValue,
                    payoutValue: payoutValue,
                    payoutType: payoutType,
                    payoutDescription: payoutDescription,
                    // qc: qc,
                });
            });
            
            for(var inc = 0; inc < rowRepeat; inc++) {
                retArr.push({
                    id: "LAPS_" + (idStart + 1),
                    slabStartValue: lastSlabEndValue + 1,
                    slabEndValue: lastSlabEndValue + 1 + slabRange,
                    payoutValue: lastPayoutValue + lapChange,
                    payoutType: lastPayoutType,
                });

                lastSlabEndValue += 1 + slabRange;
                idStart++;
                lastPayoutValue += lapChange;
            }
            
            return retArr;
        },

        validateTemplate: function() {
            var validated = true;
            var self = this;
            var templateName = $("#n5-ui-newPpi" + self.newPpiTab + " .template-name");
            var slabRange = $(".js-slab-value", "#n5-ui-newPpi" + this.newPpiTab).val();
            var lapChange = $(".js-lap-rate", "#n5-ui-newPpi" + this.newPpiTab).val();
            var rowRepeat = $(".js-repeat", "#n5-ui-newPpi" + this.newPpiTab).val();
            var repeatParent = $(".js-repeat-box", "#n5-ui-newPpi" + this.newPpiTab);

            if(!($(templateName).val() && $(templateName).val() !== $(templateName).attr("placeholder"))) {
                $(templateName).parent().attr("tip-title", "Template name cannot be empty");
                $(templateName).parent().addClass("error-tooltip input");
                validated = false;
            } else {
                $(templateName).parent().removeClass("error-tooltip input");
            }

            var ppiType = (schemeModel.getType("#n5-ui-newPpi" + self.newPpiTab)).toUpperCase();
            if(ppiType === "GROWTH") {
                validated = schemeModel.validateGrowthRanges($(".js-period-prev", "#n5-ui-newPpi" + self.newPpiTab), $(".js-period-curr", "#n5-ui-newPpi" + self.newPpiTab));
            }

            var dateStart = new Date($("#sales-period").data('daterangepicker').startDate).getTime();
            var dateEnd = new Date($("#sales-period").data('daterangepicker').endDate).getTime();
            var calendarStart = new Date($("#n5-date-reservation" + self.newPpiTab, $("#n5-ui-newPpi" + self.newPpiTab)).data("daterangepicker").startDate).getTime();
            var calendarEnd = new Date($("#n5-date-reservation" + self.newPpiTab, $("#n5-ui-newPpi" + self.newPpiTab)).data("daterangepicker").endDate).getTime();

            if(!($("#n5-date-reservation" + self.newPpiTab, $("#n5-ui-newPpi" + self.newPpiTab)).val() && $("#n5-date-reservation" + self.newPpiTab).val() !== "Select Period")) {
                $("#n5-date-reservation" + self.newPpiTab, $("#n5-ui-newPpi" + self.newPpiTab)).parent().attr("tip-title", "Date cannot be empty");
                $("#n5-date-reservation" + self.newPpiTab, $("#n5-ui-newPpi" + self.newPpiTab)).parent().addClass("error-tooltip");
                validated = false;
            } else if(calendarStart < dateStart || calendarEnd > dateEnd) {
                $("#n5-date-reservation" + self.newPpiTab, $("#n5-ui-newPpi" + self.newPpiTab)).parent().attr("tip-title", "Dates should be with range of sales period");
                $("#n5-date-reservation" + self.newPpiTab, $("#n5-ui-newPpi" + self.newPpiTab)).parent().addClass("error-tooltip");
                validated = false;
            } else {
                $("#n5-date-reservation" + self.newPpiTab, $("#n5-ui-newPpi" + self.newPpiTab)).parent().removeClass("error-tooltip");
            }

            if(!(slabRange || lapChange || rowRepeat)) {
                $(repeatParent).removeClass("error-tooltip");
            } else if(Number(slabRange) && Number(slabRange) > 0 && Number(lapChange) && Number(lapChange) > 0 && Number(rowRepeat) && Number(rowRepeat) > 0) {
                $(repeatParent).removeClass("error-tooltip");
            } else {
                $(repeatParent).attr("tip-title", "Ensure either all values are filled with positive number or all be empty.");
                $(repeatParent).addClass("error-tooltip");
            }

            /*var selectUl = $(".select2-choices", $("#n5-ui-newPpi" + self.newPpiTab))[0];
            if(schemeModel.getProducts($(selectUl)).length === 0) {
                $(selectUl).parents(".span-select2-parent").attr("tip-title", "At least one product must be selected");
                $(selectUl).parents(".span-select2-parent").addClass("error-tooltip error-border");
                validated = false;
            } else {
                $(selectUl).parents(".span-select2-parent").removeClass("error-tooltip error-border");
            }*/

            var schemeProducts = $(".product-select", "#n5-ui-newPpi" + self.newPpiTab);
            if(schemeProducts.data("products") === undefined || schemeProducts.data("products").length === 0) {
                $(schemeProducts).attr("tip-title", "At least one product must be selected");
                $(schemeProducts).addClass("error-tooltip error-border");
                validated = false;
            } else {
                $(schemeProducts).removeClass("error-tooltip error-border");
            }

            var isValidRow = self.validateTableRows($("#n5-ui-newPpi" + self.newPpiTab + " #dynamicTable tbody tr"));
            validated = isValidRow && validated;

            /* Pack Validation Start */
            var packEnd = $(".js-pack-end", "#n5-ui-newPpi" + self.newPpiTab);
            var packStart = $(".js-pack-start", "#n5-ui-newPpi" + self.newPpiTab);

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

        validateTableRows: function(rows) {
            var validated = true;
            var slabsArr = [];
            var inc = 0;
            
            $(rows).each(function() {
                var self = this;
                inc++;

                var slabStart = $(self).children()[0];
                var inputStart = $(slabStart).children("input")[0];
                var startVal = $(inputStart).val();

                var slabEnd = $(self).children()[1];
                var inputEnd = $(slabEnd).children("input")[0];
                var endVal = $(inputEnd).val();

                var payouts = $(self).children()[2];
                var payoutChild = $(payouts).children("input")[0];
                var payoutVal = $(payoutChild).val();

                var payoutTpyeTd = $(self).children()[3];

                var payoutType = schemeModel.getPayoutType($("#noofnewPpisTextStr-newPpi-payout" + inc, $(self)).val());

                if(!(payoutVal && $.isNumeric(payoutVal) && Number(payoutVal) > 0)) {
                    $(payouts).attr("title", "A valid numeric Payout Rate is required");
                    $(payouts).addClass("error-table");
                    validated = false;
                } else {
                    $(payouts).removeAttr("title");
                    $(payouts).removeClass("error-table");

                    if(payoutType.toUpperCase() === "PERCENTAGE") {
                        if(Number(payoutVal) > 200) {
                            $(payouts).attr("title", "Percentage payout rate cannot be more than 200");
                            $(payouts).addClass("error-table");
                            validated = false;
                        }
                    }
                }

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

                if(!($.isNumeric(startVal) && $.isNumeric(endVal))) {
                    $(inputEnd).parent().attr("title", "Numeric Slab Values are required");
                    $(inputEnd).parent().addClass("error-table");
                    validated = false;
                } else if(Number(startVal) <= 0 || Number(endVal) <= 0) {                
                    $(inputEnd).parent().attr("title", "Slab values must be greater than 0");
                    $(inputEnd).parent().addClass("error-table");
                    validated = false;
                } else if(Number(endVal) <= Number(startVal)) {
                    $(inputEnd).parent().attr("title", "Slab End value cannot be smaller than Slab Start value");
                    $(inputEnd).parent().addClass("error-table");
                    validated = false;
                } else {
                    $(inputEnd).parent().removeAttr("title");
                    $(inputEnd).parent().removeClass("error-table");

                    if(slabsArr.length === 0) {
                        slabsArr.push([Number(startVal), Number(endVal)]);
                    } else {
                        var length = slabsArr.length;
                        var lastEndValue = slabsArr[length - 1][1];
                        if(Number(startVal) !== (lastEndValue + 1)) {
                            $(inputEnd).parent().attr("title", "Slab Values can only be sequestial and without any gaps.");
                            $(inputEnd).parent().addClass("error-table");
                            validated = false;
                        } else {
                            slabsArr.push([Number(startVal), Number(endVal)]);
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
} (jQuery, akzo, Backbone, model || {}));