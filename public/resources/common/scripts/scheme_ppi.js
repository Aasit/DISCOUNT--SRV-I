/* jshint loopfunc: true, quotmark:false */
/* global _, jQuery, native5, model, createCard, app */
(function($, native5){
    "use strict";
    
    var modelData = $("#modelDetails").data("model").ppiTpls;

    if(!$.isEmptyObject(modelData)) {
        $.each(modelData, function(key, data) {
            var ppiTab = key + 1;
            var defaults = {
                qcList: [],
                ppiDnI: {
                    templateName: "",
                    numSlabs: 1,
                    packs: ["BULK", "RETAIL"],
                    period: {},
                    ppiType: "VOLUME",
                    products: [],
                    slabPayouts: [],
                    segment: [],
                    projectSku: false
                }
            };

            data = $.extend(true, defaults, data);
            data.counter = ppiTab;

            if(data.ppiDnI.repeatData && data.ppiDnI.repeatData.rowRepeat) {
                data.totalRows = parseInt(data.ppiDnI.repeatData.rowRepeat);
            } else {
                data.totalRows = 0;
            }

            var ppiTemp = _.template($("#n5-ui-template-ppi-template").html());
            var clonesppi = ppiTemp(data);
            var tabContent = $("<div>").append(clonesppi);

            $("#scheme-ppi-parent").append(tabContent);

            if(data.qcList.length > 0) {
                var ppiQC = _.template($("#ppi-qc"+ppiTab).html());
                $("#ppi-template-qc"+ppiTab).append(ppiQC);
            }

            /*jshint unused:false*/
            $.each(data.ppiDnI.slabPayouts, function(idx, payout) {
                var ppiPayoutQC = _.template($("#ppi"+ppiTab+"-slab-qc"+(idx+1)).html());
                $("#ppi"+ppiTab+"-inslabqc"+(idx+1)).append(ppiPayoutQC);
            });

            if(data.ppiDnI.repeatData && data.ppiDnI.repeatData.rowRepeat) {
                createCard($("#n5-ui-ppi" + ppiTab), "newPPICard" + ppiTab, "NEWPPI Details - " + data.ppiDnI.templateName, "fa-list-alt", "100%");
            } else {
                createCard($("#n5-ui-ppi" + ppiTab), "PPICard" + ppiTab, "PPI Details - " + data.ppiDnI.templateName, "fa-list-alt", "100%");
            }

            createTable("#n5-Q-cond-table-ppi" + ppiTab, ppiTab);
            templatePpi(ppiTab, data);

            if(!$.isEmptyObject(data.ppiDnI.period)) {
                var date = data.ppiDnI.period;
                var str = date.startDate + " -- " + date.endDate;
                $("#n5-date-reservation" + ppiTab).attr("value", str);
            }
        });
    }

    function createTable(parentElm, ppiTab) {
        var tableElm = $(parentElm).children("table")[0];

        var tableInstance = new native5.ui.table({
            parentElm: $(parentElm),
            theme:"",
            isPaginated: false,
            table: tableElm
        });
        tableInstance.render();
    }
    
    function templatePpi(tab, data) {
        var products = data.ppiDnI.products;

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
            $(".product-select", "#n5-ui-ppi" + tab).append(str);
        }

        var segmentElm = $(".template-segment-values", "#n5-ui-ppi" + tab)[0];
        var segmentData = [];

        if(data.ppiDnI.segment && data.ppiDnI.segment.length > 0) {
            var segStr = "";
            $.each(data.ppiDnI.segment, function(key, value) {
                segmentData.push({
                    id: value,
                    text: model.getSegmentText(value)
                });

                segStr += "<div>" + model.getSegmentText(value) + "</div>";
            });

            $(segmentElm).append(segStr);
        }
    }
}(jQuery, native5));