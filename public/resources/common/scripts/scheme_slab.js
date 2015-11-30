/* jshint quotmark:false */
/* global jQuery, native5, _, model, createCard */
(function($, native5){
    "use strict";

    var modelData = $("#modelDetails").data("model").slabTpls;

    if(!$.isEmptyObject(modelData)) {
        $.each(modelData, function(key, data) {
            var slabTab = key + 1;
            var tableArr = [];
            var dateArr = [];

            var defaults = {
                qcList: [],
                slabDnI: {
                    templateName: "",
                    numSlabs: 1,
                    packs: ["BULK", "RETAIL"],
                    slabType: "VOLUME",
                    products: [],
                    laps: [],
                    segment: [],
                    projectSku: false
                }
            };

            data = $.extend(true, defaults, data);
            data.counter = slabTab;

            $.each(data.slabDnI.laps, function(k, val) {
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

            var slabTemp = _.template($("#n5-ui-template-slab-template").html());
            var clonesslab = slabTemp(data);
            var tabContent = $("<div>").append(clonesslab);
            $("#scheme-slab-parent").append(tabContent);

            if(data.qcList.length > 0){
                var slabQC = _.template($("#slab-qc"+slabTab).html());
                $("#slab-template-qc"+slabTab).append(slabQC);
            }

            $.each( data.slabDnI.laps[0].payouts, function( idx, payout ) {
                var slabPayoutQC = _.template($("#slab"+slabTab+"-slab-qc"+(idx+1)).html());
                $("#slab"+slabTab+"-inslabqc"+(idx+1)).append(slabPayoutQC);
            });

            createCard($("#n5-ui-slab" + slabTab), "slabCard" + slabTab, "Slab Details - " + data.slabDnI.templateName, "fa-list-alt", "100%");

            var rowLength = data.slabDnI.laps.length;
            createTable("#n5-Q-cond-table-slab" + slabTab);
            templateslab(slabTab, data);

            for(var inc = 1; inc <= rowLength; inc++) {
                addDate($("#n5-date-reservation-slab-table" + inc,  "#n5-ui-slab" + slabTab), dateArr[inc - 1]);
            }
        });
    }

    function addDate(elm, date) {
        var str = date.startDate + " -- " + date.endDate;
        $(elm).attr("value", str);
    }

    function createTable(parentElm) {
        var tableElm = $(parentElm).children("table")[0];

        var tableInstance = new native5.ui.table({
            parentElm: $(parentElm),
            theme:"",
            isPaginated: false,
            table: tableElm
        });

        tableInstance.render();
    }

    function templateslab(tab, data) {
        var products = data.slabDnI.products;

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
            $(".product-select", "#n5-ui-slab" + tab).append(str);
        }     
        
        var selectElm = $(".template-segment-values", "#n5-ui-slab" + tab)[0];
        var segmentData = [];
        
        if(data.slabDnI.segment && data.slabDnI.segment.length > 0) {
            var str = "";
            $.each(data.slabDnI.segment, function(key, value) {
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