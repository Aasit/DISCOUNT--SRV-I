/* jshint loopfunc: true, quotmark:false */
/* global jQuery, native5, _, model, app, createCard */
var akzo = (function($, native5, akzo){
    "use strict";

    var modelData = $("#modelDetails").data("model").slabV2Tpls;

    if(!$.isEmptyObject(modelData)) {
        $.each(modelData, function(key, data) {
            var newSlabTab = key + 1;
            var tableArr = [];
            var dateArr = [];
            
            var defaults = {
                slabV2DnI: {
                    templateName: "",
                    numLaps: 1,
                    products: [],
                    laps: [],
                    segment: []
                }
            };

            data = $.extend(true, defaults, data);
            data.counter = newSlabTab;

            $.each(data.slabV2DnI.laps, function(k, val) {
                var slabObj = $.extend({}, val);
                $.each(val.payouts, function(key, value) {
                    var tempObj = $.extend({}, value);
                    if(!tableArr[key]) {
                        tableArr[key] = tempObj;
                        tableArr[key].lap = tableArr[key].lap || [];
                        tableArr[key].lap.push(tempObj.payoutValue);
                        delete tableArr[key].payoutValue;
                    } else {
                        tableArr[key].lap.push(tempObj.payoutValue);
                    }
                });
                dateArr.push(slabObj.period);
            });

            data.tableArr = tableArr;
            data.numProducts = tableArr.length;

            var newSlabTemp = _.template($("#n5-ui-template-newSlab-template").html());
            var clonenewSlab = newSlabTemp(data);
            var tabContent = $("<div>").append(clonenewSlab);

            $("#scheme-newslab-parent").append(tabContent);
            
            if(data.qcList.length > 0){
                var newSlabQC = _.template($("#newSlab-qc"+newSlabTab).html());
                $("#newSlab-template-qc"+newSlabTab).append(newSlabQC);
            }

            $.each( data.slabV2DnI.laps[0].payouts, function( idx, payout ) {
                var slabV2PayoutQC = _.template($("#newslab"+newSlabTab+"-slab-qc"+(idx+1)).html());
                $("#newslab"+newSlabTab+"-inslabqc"+(idx+1)).append(slabV2PayoutQC);
            });

            createCard($("#n5-ui-newSlab" + newSlabTab), "newSlabCard" + newSlabTab, "New Slab Details - " + data.slabV2DnI.templateName, "fa-list-alt", "100%");

            var rowLength = data.slabV2DnI.laps.length;
            createTable("#n5-Q-cond-table-newSlab"+newSlabTab, rowLength, tableArr, newSlabTab);
            templatenewSlab(newSlabTab, data, newSlabTab);

            for(var inc = 1; inc <= rowLength; inc++) {
                addDate($("#n5-date-reservation-newSlab-table" + inc,  "#n5-ui-newSlab" + newSlabTab), dateArr[inc - 1]);
            }
        });
    }

    function addDate(elm, date) {
        var str = date.startDate + " -- " + date.endDate;
        $(elm).attr("value", str);
    }

    function createTable(parentElm, length, tableArr, newSlabTab) {
        var tableElm = $(parentElm).children("table")[0];

        var tableInstance = new native5.ui.table({
            parentElm: $(parentElm),
            theme:"",
            isPaginated: false,
            table: tableElm
        });
        tableInstance.render();

        /*jshint unused: false*/
        $.each($("tbody tr", $(tableElm)), function(inc, elm) {
            if($.isEmptyObject(tableArr)) {
                intailizeTableElement(parseInt(inc) + 1, [], newSlabTab);
            } else if(tableArr[inc] && tableArr[inc].products) {
                intailizeTableElement(parseInt(inc) + 1, tableArr[inc].products, newSlabTab);
            } else {
                intailizeTableElement(parseInt(inc) + 1, [], newSlabTab);
            }
            
            // console.log(elm);
        });
    }

    function intailizeTableElement(tab, products, newSlabTab) {        
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
            $(".product-select", "#n5-ui-newSlab" + newSlabTab).append(str);
        }
        
        $(".n5-table-qc-add.btn").off("click");
        $(".n5-table-qc-add.btn").on("click",function(){
            app.slabQCModal.showModal();
            model.addSlabQC(this, "DEFAULT_SLAB" + newSlabTab, "SLAB");
        });

        model.checkPositiveInteger();
    }

    function templatenewSlab(tab, data, newSlabTab) {
        var segmentData = [];
        var selectElm = $(".template-segment-values", "#n5-ui-newSlab" + newSlabTab)[0];
        
        if(data.slabV2DnI.segment && data.slabV2DnI.segment.length > 0) {
            var str = "";
            $.each(data.slabV2DnI.segment, function(key, value) {
                segmentData.push({
                    id: value,
                    text: model.getSegmentText(value)
                });

                str += "<div>" + model.getSegmentText(value) + "</div>";
            });

            $(selectElm).append(str);
        }
    }

    return akzo;
}(jQuery, native5, akzo || {}));