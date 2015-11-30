/* jshint loopfunc: true, quotmark: false */
/* global jQuery, akzo, Backbone, model, console */
(function ($, akzo, Backbone, schemeModel) {
    "use strict";

    schemeModel.PriView = Backbone.View.extend({
        initialize: function(){
            this.model = new schemeModel.PriModel();
            schemeModel.PriCollectionInstance.add(this.model);
            this.QCIndex = 0;
        },

        render: function(priTab, addTempLib, data) {
            var self = this;
            this.priTab = priTab;
            if($.isEmptyObject(data)) {
                data = self.model.toJSON();
            }
            new akzo.ui.priTemplate({"priTab":priTab, "tabInstance":addTempLib, data: data});
            this.model.set('qcList', new schemeModel.QualifyingConditions(data.qcList));

            $("#n5-ui-template-add-temp-qc .n5add").on("click", function() {
                if($("#n5-ui-pri" + priTab).length > 0) {
                    self.setData();
                }
            });

            self.model.attributes.qcList.each(function(model){
                var condition = self.addCondition(model);
                condition.render();
            });

            var parentId = $("#n5-ui-pri" + self.priTab).parent().attr("id");
            var parentNum = parseInt(parentId.slice(1));
            // var parentNum = parentId.substr(parentId.length - 1);
            var elm = $("#t" + parentNum + " .n5close")[0];
            var oldEvent = $._data(elm, "events").click[0].handler;

            $(elm).off("click");
            $(elm).on("click", function() {
                var deleteConfirmation = window.confirm("Are you sure to delete this template?");

                if(deleteConfirmation) {
                    oldEvent();
                    schemeModel.PriCollectionInstance.remove(self.model);
                }
            });

            $("#n5-ui-pri"+priTab+" .add-condition").on("click", function() {
                var condition = self.addCondition();
                condition.render();
            });

            $("#n5-ui-pri"+priTab+" .add-condition").one("click", function() {
                schemeModel.createSatisfyAllButton($("#n5-ui-pri"+priTab+" .pri-qualifying-conditions .qualifying-conditions-list"), "pri");    
            });
        },

        addCondition: function(model){
            var self = this;
            var parentDivId = $("#n5-ui-pri" + self.priTab).parent().attr("id");
            var tabNumber = parseInt(parentDivId.slice(1));
            $(".qualifying-conditions-list", $("#n5-ui-pri"+this.priTab)).append('<span class = "qc-wrapper"><span>');
            this.QCIndex++;
            var conditionView = new schemeModel.QualifyingConditionView({ 
                el: $(".qc-wrapper",$("#n5-ui-pri"+this.priTab)).last(),
                model: model || new schemeModel.QualifyingCondition({
                    "name":"HISTORICAL",
                    "type":"VALUE",
                    "op":"GREATER_THAN_EQUALS",
                    "val":"",
                    "payoutCondition":"",
                    "topLevelSegment": false,
                    "qid": "DEFAULT_PRI" + tabNumber + "_QC" +(this.QCIndex+1)
                }),
                collection: self.model.attributes.qcList,
                tabNum: $("#t" + tabNumber)
                
            });
            conditionView.tabNum = $("#t" + tabNumber);
            return conditionView;
            
        },

        setData: function() {
            var self = this;

            var parentDivId = $("#n5-ui-pri" + self.priTab).parent().attr("id");
            var tabNumber = parseInt(parentDivId.slice(1));

            if(self.validateTemplate()) {
                $("#t" + tabNumber).css("color", "black");
                schemeModel.errorInstance.remove({id: "#t" + tabNumber});

                var packCondition = {};

                if($(".js-pack-start", "#n5-ui-pri" + self.priTab).is(":visible")) {
                    packCondition.type = $(".js-pack-select", "#n5-ui-pri" + self.priTab).select2("val");
                    packCondition.startValue = $(".js-pack-start", "#n5-ui-pri" + self.priTab).val();
                }

                if($(".js-pack-end", "#n5-ui-pri" + self.priTab).is(":visible")) {
                    packCondition.endValue = $(".js-pack-end", "#n5-ui-pri" + self.priTab).val();
                }

                if($.isEmptyObject(packCondition)) {
                    packCondition = null;
                }

                var calendar = $("#n5-date-reservation-pri" + self.priTab, "#n5-ui-pri" + self.priTab);
                var startDate = schemeModel.getFormattedDate(new Date($(calendar).data('daterangepicker').startDate));
                var endDate = schemeModel.getFormattedDate(new Date($(calendar).data('daterangepicker').endDate));
                var period = {startDate: startDate, endDate: endDate};
                var valVolElm = $(".input-val-vol", $("#n5-ui-pri" + self.priTab))[0];
                var valVolAmount = $(valVolElm).val();

                var priData = {
                    id: "PRI_" + self.priTab,
                    templateName: $("#n5-ui-pri" + this.priTab + " .template-name").val(),
                    priType: (schemeModel.getType("#n5-ui-pri" + self.priTab)).toUpperCase(),
                    segment: model.getSelectedValues($("select.template-segment-values", "#n5-ui-pri" + self.priTab).select2("data")),
                    priProducts: schemeModel.getProductsPRI($(".select2-choices", $("#n5-ui-pri" + self.priTab))[1], valVolAmount),
                    period: period,
                    numSlabs: parseInt($("#noofprisTextStr" + self.priTab, $("#n5-ui-pri" + this.priTab)).val()),
                    priPayouts: self.getLaps(),
                    projectSku: $(".js-project-sku", "#n5-ui-pri" + self.priTab).prop("checked"),
                    packCondition: packCondition,
                };

                self.model.set("id", "PRI_TPL_" + self.priTab);
                this.model.set("priDnI", priData);
                this.setSatisfyAll();
            } else {
                $("#t" + tabNumber).css("color", "red");
                schemeModel.errorInstance.add({
                    id: "#t" + tabNumber
                });
            }
        },

        setSatisfyAll: function(){
            var satisfy = $(".pri-qualifying-conditions .satisfyAll").is(":checked");
            this.model.set("satisfyAll", satisfy);
        },

        getLaps: function() {
            var retArr = [];
            var tbody = $("#n5-Q-cond-table-pri" + this.priTab).find("table:nth-child(1)").find("tbody")[0];
            var rows = $(tbody).find("tr");

            $.each(rows, function(key, row) {
                var numProd = $(row).find("td")[0];
                var payRate = $(row).find("td")[1];
                var payoutTypeElm = $(row).find("td")[2];
                var qcElm = $(row).find("td")[3];

                var numProducts = $(numProd).find("input:nth-child(1)").val();
                var payout = $(payRate).find("input:nth-child(1)").val();
                var payoutType = schemeModel.getPayoutType($("#noofprisTextStr-pri-payout" + (key + 1), $(payoutTypeElm)).val());
                var payoutDescription = $(".js-gift-desc" + (key + 1), $(row)).val();
                var qc = $(".n5-table-qc-add", $(qcElm)).data("qc");
                var satisfyAll = $(".n5-table-qc-add", $(qcElm)).data("satisfy");

                if($.isEmptyObject(qc)) {
                    qc = null;
                }

                if(payoutType !== "GIFT") {
                    payoutDescription = null;
                }

                retArr.push({
                    id: "LAPS_" + (key + 1),
                    numProducts: numProducts,
                    payoutValue: payout,
                    payoutType: payoutType,
                    payoutDescription: payoutDescription,
                    qcList: qc,
                    satisfyAll: satisfyAll
                });
            });
            
            return retArr;
        },

        validateTemplate: function() {
            var validated = true;
            var self = this;
            var templateName = $("#n5-ui-pri" + self.priTab + " .template-name");

            if(!($(templateName).val() && $(templateName).val() !== $(templateName).attr("placeholder"))) {
                $(templateName).parent().attr("tip-title", "Template name cannot be empty");
                $(templateName).parent().addClass("error-tooltip input");
                validated = false;
            } else {
                $(templateName).parent().removeClass("error-tooltip input");
            }

            var dateStart = $("#sales-period").data('daterangepicker').startDate;
            var dateEnd = $("#sales-period").data('daterangepicker').endDate;
            var calendarStart = $("#n5-date-reservation-pri" + self.priTab).data("daterangepicker").startDate;
            var calendarEnd = $("#n5-date-reservation-pri" + self.priTab).data("daterangepicker").endDate;

            if(!($("#n5-date-reservation-pri" + self.priTab).val() && $("#n5-date-reservation-pri" + self.priTab).val() !== "Select Period")) {
                $("#n5-date-reservation-pri" + self.priTab).parent().attr("tip-title", "Date cannot be empty");
                $("#n5-date-reservation-pri" + self.priTab).parent().addClass("error-tooltip");
                validated = false;
            } else if(calendarStart < dateStart || calendarEnd > dateEnd) {
                $("#n5-date-reservation-pri" + self.priTab).parent().attr("tip-title", "Dates should be with range of sales period");
                $("#n5-date-reservation-pri" + self.priTab).parent().addClass("error-tooltip");
                validated = false;
            } else {
                $("#n5-date-reservation-pri" + self.priTab).parent().removeClass("error-tooltip");
            }

            var selectUl = $(".select2-choices", $("#n5-ui-pri" + self.priTab))[1];
            if(schemeModel.getProducts($(selectUl)).length === 0) {
                $(selectUl).parents(".span-select2-parent").attr("tip-title", "At least one product must be selected");
                $(selectUl).parents(".span-select2-parent").addClass("error-tooltip error-border");
                validated = false;
            } else {
                $(selectUl).parents(".span-select2-parent").removeClass("error-tooltip error-border");
            }

            /*var schemeProducts = $(".product-select", "#n5-ui-pri" + self.priTab);
            if(schemeProducts.data("products") === undefined || schemeProducts.data("products").length === 0) {
                $(schemeProducts).attr("tip-title", "At least one product must be selected");
                $(schemeProducts).addClass("error-tooltip error-border");
                validated = false;
            } else {
                $(schemeProducts).removeClass("error-tooltip error-border");
            }*/

            var valVol = $(".input-val-vol", $("#n5-ui-pri" + self.priTab))[0];

            if(!($.isNumeric($(valVol).val()) && $(valVol).val() > 0)) {
                $(valVol).parent().attr("tip-title", "Value must be positive integer");
                $(valVol).parent().addClass("error-tooltip");
                $(valVol).val("");
                validated = false;
            } else {
                $(valVol).parent().removeClass("error-tooltip");
            }

            // var productsLength;
            // if(schemeProducts.data("products")){
            //     productsLength = schemeProducts.data("products").length;
            // } else {
            //     productsLength = 0;
            // }
            
            var isValidRow = self.validateTableRows($("#n5-ui-pri" + self.priTab + " #dynamicTable tbody tr"), $(selectUl).children().length);
            validated = isValidRow && validated;

            /* Pack Validation Start */
            var packEnd = $(".js-pack-end", "#n5-ui-pri" + self.priTab);
            var packStart = $(".js-pack-start", "#n5-ui-pri" + self.priTab);

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

        validateTableRows: function(rows, maxLength) {
            var validated = true;
            var productArr = [];
            var inc = 0;
            $(rows).each(function() {
                var self = this;
                inc++;

                var products = $(self).children()[0];
                var input = $(products).children("input")[0];
                var val = $(input).val();

                var payouts = $(self).children()[1];
                var payoutChild = $(payouts).children("input")[0];
                var payoutVal = $(payoutChild).val();

                var payoutTpyeTd = $(self).children()[2];

                var payoutType = schemeModel.getPayoutType($("#noofprisTextStr-pri-payout" + inc, $(self)).val());

                if(!(val && $.isNumeric(val) && Number(val) < maxLength && Number(val) > 0)) {
                    $(products).attr("title", "Number of products is mandatory and should be numeric less than or equal to total number of PRI products, but greater than 0.");
                    $(products).addClass("error-table");
                    validated = false;
                } else {
                    $(products).removeAttr("title");
                    $(products).removeClass("error-table");

                    if(productArr.length === 0) {
                        productArr.push(val);
                        $(products).removeAttr("title");
                        $(products).removeClass("error-table");
                    } else {
                        if($.inArray(val, productArr) === -1) {
                            productArr.push(val);
                            $(products).removeAttr("title");
                            $(products).removeClass("error-table");
                        } else {
                            $(products).attr("title", "Selected products cannot be same as previously selected values");
                            $(products).addClass("error-table");
                            validated = false;
                        }
                    }
                }

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
            });

            return validated;
        },
    });

    return schemeModel;
} (jQuery, akzo, Backbone, model || {}));
