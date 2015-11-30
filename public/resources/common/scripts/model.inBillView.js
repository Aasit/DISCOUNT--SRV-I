/* jshint loopfunc: true, quotmark: false */
/* global jQuery, akzo, Backbone, model */
(function ($, akzo, Backbone, schemeModel) {
    "use strict";

   schemeModel.inBillView = Backbone.View.extend({
        initialize: function(){
            this.model = new schemeModel.inBillModel();
            schemeModel.inBillInstance.add(this.model);
        },

        render: function(inBillTab, addTempLib, data) {
            var self = this;
            self.inBillTab = inBillTab;
            if($.isEmptyObject(data)) {
                data = self.model.toJSON();
            }
            new akzo.ui.inBillTemplate({"inBillTab":inBillTab, "tabInstance":addTempLib, data: data});

            $("#n5-ui-template-add-temp-qc .n5add").on("click", function() {
                if($("#n5-ui-inBill" + inBillTab).length > 0) {
                    self.setData();
                }
            });

            var parentId = $("#n5-ui-inBill" + self.inBillTab).parent().attr("id");
            var parentNum = parseInt(parentId.slice(1));
            // var parentNum = parentId.substr(parentId.length - 1);
            var elm = $("#t" + parentNum + " .n5close")[0];
            var oldEvent = $._data(elm, "events").click[0].handler;

            $(elm).off("click");
            $(elm).on("click", function() {
                var deleteConfirmation = window.confirm("Are you sure to delete this template?");

                if(deleteConfirmation) {
                    oldEvent();
                    schemeModel.inBillInstance.remove(self.model);
                }
            });
        },

        setData: function() {
            var self = this;

            var parentDivId = $("#n5-ui-inBill" + self.inBillTab).parent().attr("id");
            var tabNumber = parseInt(parentDivId.slice(1));

            if(self.validateTemplate()) {
                $("#t" + tabNumber).css("color", "black");
                schemeModel.errorInstance.remove({
                    id: "#t" + tabNumber
                });

                var packCondition = {};

                if($(".js-pack-start", "#n5-ui-inBill" + self.inBillTab).is(":visible")) {
                    packCondition.type = $(".js-pack-select", "#n5-ui-inBill" + self.inBillTab).select2("val");
                    packCondition.startValue = $(".js-pack-start", "#n5-ui-inBill" + self.inBillTab).val();
                }

                if($(".js-pack-end", "#n5-ui-inBill" + self.inBillTab).is(":visible")) {
                    packCondition.endValue = $(".js-pack-end", "#n5-ui-inBill" + self.inBillTab).val();
                }

                if($.isEmptyObject(packCondition)) {
                    packCondition = null;
                }

                var inBillData = {
                    id: "INBILL_" + self.inBillTab,
                    templateName: $("#n5-ui-inBill" + self.inBillTab + " .template-name").val(),
                    numLaps: parseInt($("#n5-ui-inBill" + self.inBillTab + " #noofslabsTextStr-inBill" + self.inBillTab).val()),
                    segment: model.getSelectedValues($("select.template-segment-values", "#n5-ui-inBill" + self.inBillTab).select2("data")),
                    projectSku: $(".js-project-sku", "#n5-ui-inBill" + self.inBillTab).prop("checked"),
                    products: $(".product-select-main", "#n5-ui-inBill" + self.inBillTab).data("products"),
                    inBillLaps: self.getLaps(),
                    packCondition: packCondition,
                };

                self.model.set("id", "inBill_TPL_" + self.inBillTab);
                self.model.set("inBillDnI", inBillData);
            } else {
                $("#t" + tabNumber).css("color", "red");
                schemeModel.errorInstance.add({
                    id: "#t" + tabNumber
                });
            }
        },

        getLaps: function() {
            var self = this;
            var retArr = [];
            var numLaps = parseInt($("#nooflapsTextStr-inBill" + self.inBillTab, "#n5-ui-inBill" + self.inBillTab).val());
            var tbody = $("#n5-Q-cond-table-inBill" + self.inBillTab).find("table:nth-child(1)").find("tbody")[0];
            var rows = $(tbody).find("tr");

            for(var laps = 0; laps < numLaps; laps++) {
                var tempArr = [];

                var calendar = $("#n5-date-reservation-inBill-table" + (laps + 1), "#n5-ui-inBill" + self.inBillTab);
                var startDate = schemeModel.getFormattedDate(new Date($(calendar).data('daterangepicker').startDate));
                var endDate = schemeModel.getFormattedDate(new Date($(calendar).data('daterangepicker').endDate));
                var period = {startDate: startDate, endDate: endDate};
                
                $.each(rows, function(key, row) {
                    var length = $(row).find("td").length;
                    var ProductElm = $(row).find("td")[0];
                    var payoutElm = $(row).find("td")[length - 2];
                    var packsElm = $(row).find("td")[length - 1];
                    var lapElm = $(row).find("td")[laps + 1];

                    var products = $(".product-select", $(ProductElm)).data("products");
                    var payoutType = schemeModel.getPayoutType($(".n5-ui-sc-label-sub", $(payoutElm)).text());
                    var lapRate = $(lapElm).find("input:nth-child(1)").val();
                    var packs = schemeModel.getPack($(packsElm));

                    tempArr.push({
                        id: "PAYOUT_" + (key + 1),
                        products: products,
                        payoutType: payoutType,
                        lapRate: lapRate,
                        packs: packs,
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
            var templateName = $("#n5-ui-inBill" + self.inBillTab + " .template-name");

            if(!($(templateName).val() && $(templateName).val() !== $(templateName).attr("placeholder"))) {
                $(templateName).parent().attr("tip-title", "Template name cannot be empty");
                $(templateName).parent().addClass("error-tooltip input");
                validated = false;
            } else {
                $(templateName).parent().removeClass("error-tooltip input");
            }

           var isValidDates = self.validateDateRanges(self.inBillTab);
           validated = isValidDates && validated;

            var isValidRow = self.validateTableRows($("#n5-ui-inBill" + self.inBillTab + " #dynamicTable tbody tr"));
            validated = isValidRow && validated;

            /* Pack Validation Start */
            var packEnd = $(".js-pack-end", "#n5-ui-inBill" + self.inBillTab);
            var packStart = $(".js-pack-start", "#n5-ui-inBill" + self.inBillTab);

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

            $("#n5-ui-inBill" + tab + " [name='reservation']").each(function() {
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

        validateTableRows: function(elms) {
            var validatedRow = true;
            var tableRows = [];

            $(elms).each(function() {
                var self = this;
                var rowLength = $(self).children().length;

                $(".lap-rate", $(self)).each(function() {
                    if(!($.isNumeric($(this).val()) && Number($(this).val()) > 0)) {
                        $(this).parent().attr("title", "Lap Rates is required can only be positive integer.");
                        $(this).parent().addClass("error-table");
                        validatedRow = false;
                    } else {
                        $(this).parent().removeAttr("title");
                        $(this).parent().removeClass("error-table");
                    }
                });

                var ProductElm = $(self).find("td")[0];
                var pids = schemeModel.getPids($(".product-select", $(ProductElm)).data("products"));

                var packsElm = $(self).find("td")[rowLength - 1];
                var packs = schemeModel.getPack($(packsElm));

                if(packs.length === 0) {
                    $(packsElm).attr("title", "At least one Product Type must be selected");
                    $(packsElm).addClass("error-table");
                    validatedRow = false;
                } else {
                    $(packsElm).removeAttr("title");
                    $(packsElm).removeClass("error-table");
                }

                if(pids.length === 0) {
                    $(ProductElm).attr("title", "Products cannot be empty");
                    $(ProductElm).addClass("error-table");
                    validatedRow = false;
                } else {
                    $(ProductElm).removeAttr("title");
                    $(ProductElm).removeClass("error-table");

                    $.each(pids, function(key, pid) {
                        $.each(packs.slice(0), function(k, pack) {
                            var combinedArray = [pack];
                            combinedArray.push(pid);

                            if(tableRows.length === 0) {
                                tableRows.push(combinedArray);
                                $(ProductElm).removeAttr("title");
                                $(ProductElm).removeClass("error-table");
                            } else {
                                $.each(tableRows, function(key, value) {
                                    if(schemeModel.uniqueArrays(value, combinedArray)) {
                                        tableRows.push(combinedArray);
                                    } else {
                                        $(ProductElm).attr("title", "Combination of Product + Product Type (Bulk / Retail) should be unique among the slabs");
                                        $(ProductElm).addClass("error-table");
                                        validatedRow = false;
                                    }
                                });
                            }
                        });
                    });
                }
            });

            return validatedRow;
        },
    });

    return schemeModel;
} (jQuery, akzo, Backbone, model || {}));
