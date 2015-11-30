/* jshint loopfunc: true, quotmark:false */
/* global _, jQuery, native5, app, model */
var akzo = (function($, native5, akzo){
    "use strict";
    akzo.ui = akzo.ui || {};

    akzo.ui.ppiTemplate = function(options){
        var opts = options || {};
        this.elmId = opts.elmId || "";
        this.tabId = opts.tabId || {};
        this.ppiTab = opts.ppiTab || {};
        var data = opts.data || {};
        this.parentTabIdInstance = opts.tabInstance || {};
        this.render(data);
        this.ppiTabTable = 2;
    };

    var ppiPrototype = akzo.ui.ppiTemplate.prototype;

    ppiPrototype.render = function (obj) {
        var self = this;
        var data = obj || {};

        var defaults = {
            qcList: [],
            ppiDnI: {
                templateName: "",
                numSlabs: 1,
                packs: ["BULK", "RETAIL"],
                period: {},
                prevPeriod: {},
                currPeriod: {},
                ppiType: "VOLUME",
                packCondition: {type: "greater", startValue: null, endValue: null},
                products: [],
                slabPayouts: [],
                segment: [],
                projectSku: true
            }
        };

        data = $.extend(true, defaults, data);
        data.counter = self.ppiTab;

        if(!data.ppiDnI.packCondition) {
            data.ppiDnI.packCondition = {type: "greater", startValue: null, endValue: null};
        }

        var ppiTemp = _.template($("#n5-ui-template-ppi-template").html());
        var clonesppi = ppiTemp(data);
        var tabContent = $("<div>").append(clonesppi);

        (self.parentTabIdInstance).addTab({
           "title" : "PPI_"+self.ppiTab,
           "html"  : $(tabContent).html()
        });

        self.createTable("#n5-Q-cond-table-ppi"+self.ppiTab);
        self.templatePpi(self.ppiTab, data);

        if(!$.isEmptyObject(data.ppiDnI.period)) {
            model.setDate($("#n5-date-reservation" + self.ppiTab, $("#n5-ui-ppi" + self.ppiTab)), data.ppiDnI.period);
        }

        if(!$.isEmptyObject(data.ppiDnI.prevPeriod)) {
            model.setDate($(".js-period-prev", $("#n5-ui-ppi" + self.ppiTab)), data.ppiDnI.prevPeriod);
        }

        if(!$.isEmptyObject(data.ppiDnI.currPeriod)) {
            model.setDate($(".js-period-curr", $("#n5-ui-ppi" + self.ppiTab)), data.ppiDnI.currPeriod);
        }
    };

    ppiPrototype.createTable = function(parentElm) {
        var self = this;
        var tableElm = $(parentElm).children("table")[0];

        this.tableInstance = new native5.ui.table({
            parentElm: $(parentElm),
            theme:"",
            isPaginated: false,
            table: tableElm
        });
        this.tableInstance.render();

        /*jshint unused:false*/
        $.each($("tbody tr", $(tableElm)), function(inc, elm) {
            self.intailizeTableElement(parseInt(inc) + 1);
            // console.log(elm);
        });
    };

    ppiPrototype.addRowsTemplate = function(numRows) {
        var self = this;
        // var tab = 2;
        var rows1 = (self.tableInstance).getRows();
        var CalNoOfRows = numRows - rows1;
        parseInt(CalNoOfRows);
        if (CalNoOfRows > 0) {
            for (var i=0; i<CalNoOfRows; i++){
                var index = $("#dynamicTable tbody tr", $("#n5-ui-ppi" + self.ppiTab)).length;
                self.updateRowString(index + 1);
                (self.tableInstance).addData(self.rowData);
                self.intailizeTableElement(index + 1);
            }
        }
        else {
            CalNoOfRows *= -1;
            (self.tableInstance).deleteRows(CalNoOfRows);
        }
        $(".n5-ui-delete-table-row","#n5-Q-cond-table-ppi"+self.ppiTab).on("click", function(){
            var confirm = window.confirm("Are you sure to delete this row?");

            if(confirm) {
                $(this).parent().parent().remove();
                var val = parseInt($("#noofppiTextStr" + self.ppiTab).val()) - 1;
                $("#noofppiTextStr" + self.ppiTab).select2("val", val);
                $("#noofppiTextStr" + self.ppiTab).data("lastSel", val);
            }
        });
        adjustTable(3, 1, self.ppiTab);
    };

    ppiPrototype.updateRowString = function(tab) {
        this.rowData = {
          "rows": [
            {
              "A": "<input class='n5-template-selectmenu2 n5-ui-qc-input-placeholder' placeholder='Slab Start' type='text'/>",
              "B": "<input class='n5-template-selectmenu2 n5-ui-qc-input-placeholder' placeholder='Slab End' type='text'/>",
              "C": "<input class='n5-template-selectmenu2 n5-ui-qc-input-placeholder' placeholder='Payout Rate' type='text'/>",
              "D": "<span id='n5-ui-ppi-table-product"+tab+"'><select class='select-dropdown n5-ui-sc-label-sub' id='noofppisTextStr-ppi-payout"+tab+"'></select></span><input class='n5-template-box js-gift-desc"+tab+"' style='display:none;' placeholder='Gift Description' />",
              "E": "<button class='n5-table-qc-add btn'>QC</button><span style= 'cursor: pointer;margin-left: 3%;' class='n5-ui-delete-table-row fa fa-times'></span>"
            }
          ]
        };
    };

    ppiPrototype.intailizeTableElement = function(tab) {
        var self = this;
        var rows = $("#n5-ui-ppi" + self.ppiTab + " #dynamicTable tbody tr");

        if($("#noofppisTextStr-ppi-payout" + tab, "#n5-ui-ppi" + (self.ppiTab)).children("option").length === 0) {
            $("#noofppisTextStr-ppi-payout" + tab, "#n5-ui-ppi" + (self.ppiTab)).append("<option>RS / Ltr</option><option>Abs Amount</option><option>Gift</option><option>Percentage</option>");
        }
        $("#noofppisTextStr-ppi-payout" + tab, "#n5-ui-ppi" + (self.ppiTab)).select2();

        $("#noofppisTextStr-ppi-payout" + tab, "#n5-ui-ppi" + (self.ppiTab)).on("select2-selecting", function(e) {
            var selection = e.object;
            if (selection.text.toLowerCase() === "gift") {
                $(".js-gift-desc" + tab, "#n5-ui-ppi" + (self.ppiTab)).show();
            } else {
                $(".js-gift-desc" + tab, "#n5-ui-ppi" + (self.ppiTab)).hide();
            }
        });

        if(tab > 1) {
            var row = rows[tab - 1];
            var prevRow = rows[tab - 2];
            var prevInput = $(prevRow).find("input")[1];
            var currInput = $(row).find("input")[0];
            var prevValue = $(prevInput).val();
            var currValue = $(currInput).val();

            if($.isNumeric(prevValue) && !currValue) {
                $(currInput).val(parseInt(prevValue) + 1);
            }

            $(currInput).attr("readonly", "true");
        }
        $(".n5-table-qc-add.btn").off("click");
        $(".n5-table-qc-add.btn").on("click", function(){
            app.slabQCModal.showModal();
            model.addSlabQC(this, "DEFAULT_PPI" + self.ppiTab, "PPI");
        });

        updateInputEvents(self.ppiTab);
    };
    
    ppiPrototype.templatePpi = function(tab, data) {
        var self = this;
        $("#noofppiTextStr" + tab).select2();

        $("#noofppiTextStr" + tab).on("click", function() {
            if(parseInt($(this).val()) < parseInt($(this).attr("lastSel"))) {
                var rowDel = window.confirm("Are you sure to reduce number of rows?");

                if(rowDel) {
                    self.addRowsTemplate(parseInt($(this).val()));
                    $(this).attr("lastSel", parseInt($(this).val()));
                } else {
                    $(this).select2("data", {text: $(this).attr("lastSel")});
                }
            } else {
                self.addRowsTemplate(parseInt($(this).val()));
                $(this).attr("lastSel", parseInt($(this).val()));
            }
        });

        var products = data.ppiDnI.products;
        // var selectElm = $("#n5-ui-ppi-multiple-scheme-product" + tab).children("input")[0];
        
        // new akzo.ui.select.multiple({
        //     "container" : "#n5-ui-ppi-multiple-scheme-product" + tab,
        //     "inputElm" : $(selectElm),
        //     "serviceURL": "template/products",
        //     "listClass" : "demo-search-list",
        //     "containerCssClass" : "n5-template1",
        //     "selections" : {
        //         "products": "product-select",
        //         "groups": "group-select",
        //         "subbrands": "subbrand-select",
        //         "clusters" : "cluster-select"
        //     },
        //     "showFilters": true
        // });

        model.generateProductSelectOnclick($(".product-select", "#n5-ui-ppi" + self.ppiTab));

        if(!$.isEmptyObject(products)) {
            var elm = $(".product-select", "#n5-ui-ppi" + self.ppiTab);
            $(elm).data("products", products);

            var productsStr = "<div>";
            $.each(products, function(key, val) {
                if(val.excluded) {
                    productsStr += "- ";
                } else {
                    productsStr += "+ ";
                }
                productsStr += val.name + ", ";
            });
            productsStr = productsStr.substring(0, productsStr.length - 2);
            productsStr += "</div>";
            $(elm).parent().append(productsStr);
        }

        var dateStart = $("#sales-period").data('daterangepicker').startDate;
        var dateEnd = $("#sales-period").data('daterangepicker').endDate;

        $("#n5-date-reservation" + tab, "#n5-ui-ppi" + self.ppiTab).daterangepicker({
            format: 'DD-MMM-YYYY',
            opens: "center",
            minDate: dateStart,
            maxDate: dateEnd,
            startDate: dateStart,
            endDate: dateEnd
        }, function() {
            $("body").find(".daterangepicker").css("poistion", "absolute !important");
        });

        $(".js-period-prev", "#n5-ui-ppi" + self.ppiTab).daterangepicker({
            format: 'DD-MMM-YYYY',
            opens: "center",
            // minDate: dateStart,
            // maxDate: dateEnd,
            // startDate: dateStart,
            // endDate: dateEnd
        }, function() {
            $("body").find(".daterangepicker").css("poistion", "absolute !important");
        });

        $(".js-period-curr", "#n5-ui-ppi" + self.ppiTab).daterangepicker({
            format: 'DD-MMM-YYYY',
            opens: "center",
            // minDate: dateStart,
            // maxDate: dateEnd,
            // startDate: dateStart,
            // endDate: dateEnd
        }, function() {
            $("body").find(".daterangepicker").css("poistion", "absolute !important");
        });

        var checkElements = $("#n5-ui-ppi" + self.ppiTab + " .n5-ui-sc-col :checkbox");
        $.each(checkElements, function(key, value) {
            $(value).on("click", function() {
                if(!($(checkElements[0]).prop("checked") || $(checkElements[1]).prop("checked"))) {
                    $(checkElements[1]).prop("checked", "true");
                }
            });
        });

        $.each($(".n5-radio-toolbar, #n5-ui-ppi" + self.ppiTab).children("input"), function() {
            var name = $(this).attr("name");
            $(this).attr("name", name + tab);
            var id = $(this).attr("id");
            $(this).attr("id", id + tab);
            $(this).next().attr("for", id + tab);

            $(this).on("click", function() {
                if($(this).val() === "growth") {
                    $(".js-growth-row", "#n5-ui-ppi" + self.ppiTab).removeClass("hidden");
                } else {
                    $(".js-growth-row", "#n5-ui-ppi" + self.ppiTab).addClass("hidden");
                }
            });
        });
        
        var ppiElm = $(".template-segment-values", "#n5-ui-ppi" + self.ppiTab)[0];
        var segmentElm = $("#n5-segment-type").children("select")[0];
        var segmentData = [];

        if(data.ppiDnI.segment && data.ppiDnI.segment.length > 0) {
            $.each(data.ppiDnI.segment, function(key, value) {
                segmentData.push({
                    id: value,
                    text: model.getSegmentText(value)
                });
            });
        } else {
            segmentData = $(segmentElm).select2("data");
        }

        $(ppiElm).select2();
        $(ppiElm).select2("data", segmentData);

        updateInputEvents(self.ppiTab);

        /* Pack Size Flow Start */
        var packSelectElm = $(".js-pack-select", "#n5-ui-ppi" + self.ppiTab);
        var packEndParent = $(".js-pack-end-parent", "#n5-ui-ppi" + self.ppiTab);
        var packStartParent = $(".js-pack-start-parent", "#n5-ui-ppi" + self.ppiTab);

        $(".js-pack-start", "#n5-ui-ppi" + self.ppiTab).on("keypress", function() {
            return model.isNumberKey(this);
        });

        $(".js-pack-end", "#n5-ui-ppi" + self.ppiTab).on("keypress", function() {
            return model.isNumberKey(this);
        });

        $(".js-pack-check", "#n5-ui-ppi" + self.ppiTab).on("click", function() {
            var checked = $(this).prop("checked");

            if(checked) {
                $(packSelectElm).removeClass("hidden");
                $(packStartParent).removeClass("hidden");

                setPackDisplay($(packSelectElm).select2("val"));
            } else {
                $(packSelectElm).addClass("hidden");
                $(packStartParent).addClass("hidden");

                setPackDisplay($(packSelectElm).select2("val"));
                $(packEndParent).addClass("hidden");
            }
        });

        packSelectElm.select2();

        packSelectElm.on("change", function() {
            var selectedVal = $(this).select2("val");

            setPackDisplay(selectedVal);
        });

        function setPackDisplay(value) {
            if(value === "range") {
                $(".js-pack-start-label", "#n5-ui-ppi" + self.ppiTab).text("Start Value");
                $(packEndParent).removeClass("hidden");
            } else {
                $(".js-pack-start-label", "#n5-ui-ppi" + self.ppiTab).text("Value");
                $(packEndParent).addClass("hidden");
            }
        }
        /* Pack Size Flow End */
    };

    function adjustTable(min_cols, numOfLaps, inc) {
        var totalCols = min_cols + numOfLaps;
        var colWidth = ($("#n5-Q-cond-table-ppi" + inc).width() / totalCols);
        $.each($(".table", $("#n5-Q-cond-table-ppi" + inc)).find("th, td"), function() {
            $(this).css({
                "max-width": colWidth,
            });
            $(this).find('*').css({
                "max-width": colWidth,
            });
        });
    }

    function updateInputEvents(tab) {
        var rows = $("#n5-ui-ppi" + tab + " #dynamicTable tbody tr");

        $.each(rows, function(key, value) {
            var inputRow = value;
            var input = $(inputRow).find("input")[1];

            $(input).on("keyup", function() {
                if(rows[key + 1]) {
                    var val = $(this).val();

                    if($.isNumeric(val)) {
                        var nextRow = rows[key + 1];
                        var nextInput = $(nextRow).find("input")[0];
                        $(nextInput).val(parseInt(val) + 1);
                    }
                }
            });
        });
    }

    return akzo;
}(jQuery, native5, akzo || {}));