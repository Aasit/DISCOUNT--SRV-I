/* jshint loopfunc: true, quotmark:false */
/* global jQuery, native5, _, model, createCard */
(function($, native5){
    "use strict";

    var modelData = $("#modelDetails").data("model").inBillTplsRO;

    if(!$.isEmptyObject(modelData)) {
        $.each(modelData, function(key, data) {
            var inBillTab = key + 1;
            var tableArr = [];
            var dateArr = [];
            
            var defaults = {
                inBillDnI: {
                    templateName: "",
                    numLaps: 1,
                    products: [],
                    inBillLaps: [],
                    segment: [],
                    projectSku: false
                }
            };

            data = $.extend(true, defaults, data);
            data.counter = inBillTab;

            $.each(data.inBillDnI.inBillLaps, function(k, val) {
                var slabObj = $.extend({}, val);
                $.each(val.payouts, function(key, value) {
                    var tempObj = $.extend({}, value);
                    if(!tableArr[key]) {
                        tableArr[key] = tempObj;
                        tableArr[key].lap = tableArr[key].lap || [];
                        tableArr[key].lap.push(tempObj.lapRate);
                        delete tableArr[key].payoutValue;
                    } else {
                        tableArr[key].lap.push(tempObj.lapRate);
                    }
                });
                dateArr.push(slabObj.period);
            });

            data.tableArr = tableArr;
            data.numProducts = tableArr.length;

            var inBillTemp = _.template($("#n5-ui-template-inBill-template").html());
            var cloneinBill = inBillTemp(data);
            var tabContent = $("<div>").append(cloneinBill);

            $("#scheme-inbill-parent").append(tabContent);
            createCard($("#n5-ui-inBill" + inBillTab), "inBillCard" + inBillTab, "InBill Details - " + data.inBillDnI.templateName, "fa-list-alt", "100%");

            var rowLength = data.inBillDnI.inBillLaps.length;
            createTable("#n5-Q-cond-table-inBill"+inBillTab, rowLength, tableArr, inBillTab);
            templateinBill(inBillTab, data, inBillTab);

            for(var inc = 1; inc <= rowLength; inc++) {
                addDate($("#n5-date-reservation-inBill-table" + inc,  "#n5-ui-inBill" + inBillTab), dateArr[inc - 1]);
            }
        });
    }

    function addDate(elm, date) {
        var str = date.startDate + " -- " + date.endDate;
        $(elm).attr("value", str);
    }

    function createTable(parentElm, length, tableArr, inBillTab) {
        var tableElm = $(parentElm).children("table")[0];

        var tableInstance = new native5.ui.table({
            parentElm: $(parentElm),
            theme:"",
            isPaginated: false,
            table: tableElm
        });
        tableInstance.render();

        $.each($("tbody tr", $(tableElm)), function(inc, elm) {
            if($.isEmptyObject(tableArr)) {
                intailizeTableElement(parseInt(inc) + 1, [], inBillTab);
            } else {
                intailizeTableElement(parseInt(inc) + 1, tableArr[inc].products, inBillTab);
            }
            
            // console.log(elm);
        });
    }

    function intailizeTableElement(tab, products, inBillTab) {
        if(!$.isEmptyObject(products)) {
            var str = "";
            $.each(products, function(key, product) {
                str += "<div>";
                if(product.excluded === true) {
                    str += "<i class='fa fa-times'></i> ";
                } else {
                    str += "<i class='fa fa-check'></i> ";
                }
                str += product.name + "</div>";
            });
            $(".product-select", "#n5-ui-inBill" + inBillTab).append(str);
        }

        model.checkPositiveInteger();
    }

    function templateinBill(tab, data, inBillTab) {
        var segmentData = [];
        var selectElm = $(".template-segment-values", "#n5-ui-inBill" + inBillTab)[0];
        
        if(data.inBillDnI.segment && data.inBillDnI.segment.length > 0) {
            var str = "";
            $.each(data.inBillDnI.segment, function(key, value) {
                segmentData.push({
                    id: value,
                    text: model.getSegmentText(value)
                });

                str += "<div>" + model.getSegmentText(value) + "</div>";
            });

            $(selectElm).append(str);
        }
    }

}(jQuery, native5));