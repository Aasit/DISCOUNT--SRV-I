/* jshint loopfunc: true, quotmark:false */
/* global jQuery, native5, _, model, createCard */
(function($, native5){
    "use strict";

    var modelData = $("#modelDetails").data("model").priTpls;

    if(!$.isEmptyObject(modelData)) {
        $.each(modelData, function(key, data) {
            var priTab = key + 1;
            var products = [];
            var value;

            var defaults = {
                qcList: [],
                priDnI: {
                    templateName: "",
                    numSlabs: 1,
                    period: {},
                    priType: "VOLUME",
                    priProducts: [],
                    priPayouts: [],
                    segment: [],
                    projectSku: false
                }
            };

            data = $.extend(true, defaults, data);
            data.counter = priTab;

            if(data.priDnI.priProducts.length > 0) {
                value = data.priDnI.priProducts[0].value;
            } else {
                value = "";
            }

            data.value = value;

            $.each(data.priDnI.priProducts, function(key, val) {
                products.push(val.product);
            });

            data.products = products;

            var priTemp = _.template($("#n5-ui-template-pri-template").html());
            var clonespri = priTemp(data);
            var tabContent = $("<div>").append(clonespri);
            $("#scheme-pri-parent").append(tabContent);

            if(data.qcList.length > 0) {
                var priQC = _.template($("#pri-qc"+priTab).html());
                $("#pri-template-qc"+priTab).append(priQC);
            }

            $.each( data.priDnI.priPayouts, function( idx, payout ) {
                var priPayoutQC = _.template($("#pri"+priTab+"-slab-qc"+(idx+1)).html());
                $("#pri"+priTab+"-inslabqc"+(idx+1)).append(priPayoutQC);
            });
                
            createCard($("#n5-ui-pri" + priTab), "PRICard" + priTab, "PRI Details - " + data.priDnI.templateName, "fa-list-alt", "100%");

            createTable("#n5-Q-cond-table-pri"+priTab);
            templatepri(priTab, data);

            if(!$.isEmptyObject(data.priDnI.period)) {
                var date = data.priDnI.period;
                var str = date.startDate + " -- " + date.endDate;
                $("#n5-date-reservation-pri" + priTab).attr("value", str);
            }
        });
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

    function templatepri(tab, data) {
        var products = data.products;

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
            $(".product-select", "#n5-ui-pri" + tab).append(str);
        }
        
        var selectElm = $(".template-segment-values", "#n5-ui-pri" + tab)[0];
        var segmentData = [];

        if(data.priDnI.segment && data.priDnI.segment.length > 0) {
            var segStr = "";
            $.each(data.priDnI.segment, function(key, value) {
                segmentData.push({
                    id: value,
                    text: model.getSegmentText(value)
                });

                segStr += "<div>" + model.getSegmentText(value) + "</div>";
            });

            $(selectElm).append(segStr);
        }
    }
}(jQuery, native5));
