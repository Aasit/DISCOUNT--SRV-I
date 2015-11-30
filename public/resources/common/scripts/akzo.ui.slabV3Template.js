/* jshint quotmark:false */
/* global jQuery, native5, _, model, app */
var akzo = (function($, native5, akzo){
    "use strict";
    akzo.ui = akzo.ui || {};

    akzo.ui.slabV3Template = function(options){
        var opts = options || {};
        this.elmId = opts.elmId || "";
        this.tabId = opts.tabId || {};
        this.slabV3Tab = opts.slabV3Tab || 1;
        var data = opts.data || {};
        this.parentTabIdInstance = opts.tabInstance || {};
        this.slabV3TabTable = 2;
        this.render(data);
    };

    var slabV3Prototype = akzo.ui.slabV3Template.prototype;

    slabV3Prototype.render = function (obj) {
        var self = this;
        var data = obj || {};
        var tableArr = [];
        var dateArr = [];

        var defaults = {
            qcList: [],
            slabV3DnI: {
                templateName: "",
                numslabV3s: 1,
                packs: ["BULK", "RETAIL"],
                slabType: "VOLUME",
                prevPeriod: {},
                currPeriod: {},
                products: [],
                payoutProducts: [],
                packCondition: {type: "greater", startValue: null, endValue: null},
                laps: [],
                segment: [],
                projectSku: true
            }
        };

        data = $.extend(true, defaults, data);
        data.counter = self.slabV3Tab;

        if(!data.slabV3DnI.packCondition) {
            data.slabV3DnI.packCondition = {type: "greater", startValue: null, endValue: null};
        }

        $.each(data.slabV3DnI.laps, function(k, val) {
            var slabV3Obj = $.extend({}, val);
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
            dateArr.push(slabV3Obj.period);
        });

        data.tableArr = tableArr;

        var slabV3Temp = _.template($("#n5-ui-template-slabV3-template").html());
        var clonesslabV3 = slabV3Temp(data);
        var tabContent = $("<div>").append(clonesslabV3);

        (self.parentTabIdInstance).addTab({
           "title"       : "slabV3_" + self.slabV3Tab,
           "html"        : $(tabContent).html()
        });

        var rowLength = data.slabV3DnI.laps.length;
        self.createTable("#n5-Q-cond-table-slabV3" + self.slabV3Tab, rowLength);
        self.templateslabV3(self.slabV3Tab, data);

        for(var inc = 1; inc <= rowLength; inc++) {
            model.setDate($("#n5-date-reservation-slabV3-table" + inc, "#n5-ui-slabV3" + self.slabV3Tab), dateArr[inc - 1]);
        }

        if(!$.isEmptyObject(data.slabV3DnI.prevPeriod)) {
            model.setDate($(".js-period-prev", $("#n5-ui-slabV3" + self.slabV3Tab)), data.slabV3DnI.prevPeriod);
        }

        if(!$.isEmptyObject(data.slabV3DnI.currPeriod)) {
            model.setDate($(".js-period-curr", $("#n5-ui-slabV3" + self.slabV3Tab)), data.slabV3DnI.currPeriod);
        }
    };

    slabV3Prototype.createTable = function(parentElm, length) {
        var self = this;
        var tableElm = $(parentElm).children("table")[0];

        this.tableInstance = new native5.ui.table({
            parentElm: $(parentElm),
            theme:"",
            isPaginated: false,
            table: tableElm
        });
        this.tableInstance.render();

        /*jshint unused: false */
        $.each($("tbody tr", $(tableElm)), function(inc, elm) {
            self.intailizeTableElement(parseInt(inc) + 1);
            // console.log(elm);
        });

        if(length === 0) {
            self.addColsTemplate(1);
        } else {
            self.addColsTemplate(length);
        }
    };

    slabV3Prototype.addRowsTemplate = function(numRows) {
        var self = this;
        var rows1 = (self.tableInstance).getRows();
        var CalNoOfRows = numRows - rows1;
        parseInt(CalNoOfRows);

        if(CalNoOfRows > 0) {
            for (var i = 0; i < CalNoOfRows; i++){
                var index = $("#dynamicTable tbody tr", $("#n5-ui-slabV3" + self.slabV3Tab)).length;
                self.updateRowString(index + 1);
                (self.tableInstance).addData(self.rowData);
                self.intailizeTableElement(index + 1); 
            }
        } else {
            CalNoOfRows *= -1;
            (self.tableInstance).deleteRows(CalNoOfRows);
        }

        $(".n5-ui-delete-table-row", "#n5-Q-cond-table-slabV3" + self.slabV3Tab).on("click", function(){
            var confirm = window.confirm("Are you sure to delete this row?");

            if(confirm) {
                $(this).parent().parent().remove();
                var val = parseInt($("#noofslabV3TextStr" + self.slabV3Tab).val()) - 1;
                $("#noofslabV3TextStr" + self.slabV3Tab).select2("val", val);
                $("#noofslabV3TextStr" + self.slabV3Tab).data("lastSel", val);
            }
        });
     };

    slabV3Prototype.updateRowString = function(tab) {
        var colspresent = (this.tableInstance).getColumns();
        var counter = colspresent - 5;

        this.rowData = {
            "rows":[
                {
                "A":"<input class='n5-template-selectmenu2 n5-ui-qc-input-placeholder' placeholder='slabV3 Start' type='text'/>",
                "B":"<input class='n5-template-selectmenu2 n5-ui-qc-input-placeholder' placeholder='slabV3 End' type='text'/>",
                "C":"<input class='n5-template-selectmenu2 n5-ui-qc-input-placeholder lap-rate' placeholder='Lap Rate' type='text'/>"
                }
            ]
        };

        if(counter > 0) {
            for( var i = 1; i <= counter; i++) {
                this.rowData.rows[0]["C" + i] = "<input class=\'n5-template-selectmenu2 n5-ui-qc-input-placeholder lap-rate\' placeholder=\'Lap Rate\' type=\'text\'/>";
            }
        }

        this.rowData.rows[0].D = "<span id='n5-ui-slabV3-table-product"+tab+"'><select class='select-dropdown table-dropdown n5-ui-sc-label-sub' id='noofslabV3sTextStr-slabV3-payout"+tab+"'>Rs / Ltr</select></span><input class='n5-template-box js-gift-desc"+tab+"' style='display:none;' placeholder='Gift Description' />";
        this.rowData.rows[0].E = "<button class='n5-table-qc-add btn'>QC</button><span class='n5-ui-delete-table-row fa fa-times'></span>";
    };

    slabV3Prototype.addColsTemplate = function(numOfLaps) {
        var self = this;
        var data = '{"col": "<input class=\'n5-template-selectmenu2 n5-ui-qc-input-placeholder lap-rate\' placeholder=\'Lap Rate\' type=\'text\'/>"}';
        var colspresent = (this.tableInstance).getColumns();
        var min_cols = 4;
        var count;
        var ptrindex;

        if(numOfLaps > (colspresent - min_cols)) {
            count = numOfLaps - (colspresent - min_cols);
            var status = colspresent - min_cols;
            if(numOfLaps == count) {
                for (var i = 0; i < count; i++) {
                    ptrindex = i + (min_cols - 2);
                    (this.tableInstance).addColumnatIndex(data, ptrindex, i + 1);
                    createLapPeriod(i);
                }
            } else {
                for (var j = 0; j < count; j++) {
                    ptrindex = (j + (min_cols - 2)) + status;
                    var label = status + 1;
                    (this.tableInstance).addColumnatIndex(data, ptrindex, label + j);
                    var str = 
                    '<span class="col-md-4" style="margin: 10px 0;">' +
                        '<label for="first_name" class="n5-ui-sc-label">Lap Period '+ (label+j) +'</label>' +
                        '<div class="input-prepend input-group">' +
                            '<span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>' +
                            '<input name="reservation" id="n5-date-reservation-slabV3-table'+ (label + j) +'" class="form-control" placeholder="Select Period" readonly>' +
                        '</div>' +
                    '</span>';
                    $(".js-calendar-container", "#n5-ui-slabV3" + self.slabV3Tab).append(str);
                    intializeDateReservation(label + j);
                }
            }
        } else {
            var deleteIndex = (min_cols) + numOfLaps;
            count = (colspresent - min_cols) - numOfLaps;
            for (var k = 0; k < count; k++) {
                (this.tableInstance).deleteColumnIndex(deleteIndex);
                $(".js-calendar-container .col-md-4:last-child", "#n5-ui-slabV3" + self.slabV3Tab).remove();
            }
        }

        function createLapPeriod(i) {
            var str = 
            '<span class="col-md-4" style="margin: 10px 0;">' +
                '<label for=first_name class="n5-ui-sc-label">Lap Period '+ (i+1) +'</label>' +
                '<div class="input-prepend input-group">' +
                    '<span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>' +
                    '<input name="reservation" id="n5-date-reservation-slabV3-table'+ (i + 1) +'" class=form-control placeholder="Select Period" readonly>' +
                '</div>' +
            '</span>';
            $(".js-calendar-container", "#n5-ui-slabV3" + self.slabV3Tab).append(str);
            intializeDateReservation(i + 1);
        }

        function intializeDateReservation(id) {
            var dateStart = $("#sales-period").data('daterangepicker').startDate;
            var dateEnd = $("#sales-period").data('daterangepicker').endDate;

            $("#n5-date-reservation-slabV3-table" + id, "#n5-ui-slabV3" + self.slabV3Tab).daterangepicker({
                format: 'DD-MMM-YYYY',
                opens: "center",
                minDate: dateStart,
                maxDate: dateEnd
            }, function() {
                $("body").find(".daterangepicker").css("poistion","absolute !important");
            });
        }
    };

    slabV3Prototype.intailizeTableElement = function(tab) {
        var self = this;
        var rows = $("#n5-ui-slabV3" + self.slabV3Tab + " #dynamicTable tbody tr");
        
        if($("#noofslabV3sTextStr-slabV3-payout" + tab, "#n5-ui-slabV3" + (self.slabV3Tab)).children("option").length === 0) {
            $("#noofslabV3sTextStr-slabV3-payout" + tab, "#n5-ui-slabV3" + (self.slabV3Tab)).append("<option>RS / Ltr</option><option>Abs Amount</option><option>Gift</option><option>Percentage</option>");
        }
        $("#noofslabV3sTextStr-slabV3-payout" + tab, "#n5-ui-slabV3" + (self.slabV3Tab)).select2();

        $("#noofslabV3sTextStr-slabV3-payout" + tab, "#n5-ui-slabV3" + (self.slabV3Tab)).on("select2-selecting", function(e) {
            var selection = e.object;
            if (selection.text.toLowerCase() === "gift") {
                $(".js-gift-desc" + tab, "#n5-ui-slabV3" + (self.slabV3Tab)).show();
            } else {
                $(".js-gift-desc" + tab, "#n5-ui-slabV3" + (self.slabV3Tab)).hide();
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
        $(".n5-table-qc-add.btn").on("click",function(){
            app.slabQCModal.showModal();
            model.addSlabQC(this, "DEFAULT_slabV3" + self.slabV3Tab, "slabV3");
        });

        updateInputEvents(self.slabV3Tab);
    };

    slabV3Prototype.templateslabV3 = function(tab, data) {
        var self = this;

        $("#nooflapsV3TextStr" + tab).select2();
        $("#noofslabV3TextStr" + tab).select2();

        $("#nooflapsV3TextStr" + tab).on("click", function() {
            if(parseInt($(this).val()) < parseInt($(this).attr("lastSel"))) {
                var rowDel = window.confirm("Are you sure to reduce number of columns?");

                if(rowDel) {
                    self.addColsTemplate(parseInt($(this).val()));
                    $(this).attr("lastSel", parseInt($(this).val()));
                } else {
                    $(this).select2("data", {text: $(this).attr("lastSel")});
                }
            } else {
                self.addColsTemplate(parseInt($(this).val()));
                $(this).attr("lastSel", parseInt($(this).val()));
            }
        });

        $("#noofslabV3TextStr" + tab).on("click", function() {
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

        var products = data.slabV3DnI.products;
        var payoutProducts = data.slabV3DnI.payoutProducts;
        // var selectElm = $("#n5-ui-slabV3-multiple-scheme-product" + tab).children("input")[0];

        // new akzo.ui.select.multiple({
        //     "container" : "#n5-ui-slabV3-multiple-scheme-product" + tab,
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

        model.generateProductSelectOnclick($(".product-select", "#n5-ui-slabV3" + self.slabV3Tab));

        if(!$.isEmptyObject(products)) {
            var elm = $(".product-select", "#n5-ui-slabV3" + self.slabV3Tab);
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

        model.generateProductSelectOnclick($(".product-payout", "#n5-ui-slabV3" + self.slabV3Tab));

        if(!$.isEmptyObject(payoutProducts)) {
            var payoutElm = $(".product-payout", "#n5-ui-slabV3" + self.slabV3Tab);
            $(payoutElm).data("products", payoutProducts);

            var payoutStr = "<div>";
            $.each(payoutProducts, function(key, val) {
                if(val.excluded) {
                    payoutStr += "- ";
                } else {
                    payoutStr += "+ ";
                }
                payoutStr += val.name + ", ";
            });
            payoutStr = payoutStr.substring(0, payoutStr.length - 2);
            payoutStr += "</div>";
            $(payoutElm).parent().append(payoutStr);
        }

        var length = data.slabV3DnI.laps.length;

        var dateStart = $("#sales-period").data('daterangepicker').startDate;
        var dateEnd = $("#sales-period").data('daterangepicker').endDate;

        for(var iter = 1; iter <= length; iter++) {
            $("#n5-date-reservation-slabV3-table" + iter, "#n5-ui-slabV3" + self.slabV3Tab).daterangepicker({
                format: 'DD-MMM-YYYY',
                opens: "center",
                minDate: dateStart,
                maxDate: dateEnd,
                startDate: dateStart,
                endDate: dateEnd
            }, postionDatePicker());
        }

        $(".js-period-prev", "#n5-ui-slabV3" + self.slabV3Tab).daterangepicker({
            format: 'DD-MMM-YYYY',
            opens: "center",
            // minDate: dateStart,
            // maxDate: dateEnd,
            // startDate: dateStart,
            // endDate: dateEnd
        }, postionDatePicker());

        $(".js-period-curr", "#n5-ui-slabV3" + self.slabV3Tab).daterangepicker({
            format: 'DD-MMM-YYYY',
            opens: "center",
            // minDate: dateStart,
            // maxDate: dateEnd,
            // startDate: dateStart,
            // endDate: dateEnd
        }, postionDatePicker());

        function postionDatePicker() {
            $("body").find(".daterangepicker").css("poistion", "absolute !important");
        }

        var checkElements = $("#n5-ui-slabV3" + self.slabV3Tab + " .n5-ui-sc-col .n5-ui-sc-col :checkbox");
        $.each(checkElements, function(key, value) {
            $(value).on("click", function() {
                if(!($(checkElements[0]).prop("checked") || $(checkElements[1]).prop("checked"))) {
                    $(checkElements[1]).prop("checked", "true");
                }
            });
        });

        $.each($(".n5-radio-toolbar, #n5-ui-slabV3" + self.slabV3Tab).children("input"), function() {
            var name = $(this).attr("name");
            $(this).attr("name", name + tab);
            var id = $(this).attr("id");
            $(this).attr("id", id + tab);
            $(this).next().attr("for", id + tab);

            $(this).on("click", function() {
                if($(this).val() === "growth") {
                    $(".js-growth-row", "#n5-ui-slabV3" + self.slabV3Tab).removeClass("hidden");
                } else {
                    $(".js-growth-row", "#n5-ui-slabV3" + self.slabV3Tab).addClass("hidden");
                }
            });
        });
        
        var slabV3Select = $(".template-segment-values", "#n5-ui-slabV3" + self.slabV3Tab)[0];
        var segmentElm = $("#n5-segment-type").children("select")[0];
        var segmentData = [];

        if(data.slabV3DnI.segment && data.slabV3DnI.segment.length > 0) {
            $.each(data.slabV3DnI.segment, function(key, value) {
                segmentData.push({
                    id: value,
                    text: model.getSegmentText(value)
                });
            });
        } else {
            segmentData = $(segmentElm).select2("data");
        }

        $(slabV3Select).select2();
        $(slabV3Select).select2("data", segmentData);

        updateInputEvents(self.slabV3Tab);
        

        /* Pack Size Flow Start */
        var packSelectElm = $(".js-pack-select", "#n5-ui-slabV3" + self.slabV3Tab);
        var packEndParent = $(".js-pack-end-parent", "#n5-ui-slabV3" + self.slabV3Tab);
        var packStartParent = $(".js-pack-start-parent", "#n5-ui-slabV3" + self.slabV3Tab);

        $(".js-pack-start", "#n5-ui-slabV3" + self.slabV3Tab).on("keypress", function() {
            return model.isNumberKey(this);
        });

        $(".js-pack-end", "#n5-ui-slabV3" + self.slabV3Tab).on("keypress", function() {
            return model.isNumberKey(this);
        });

        $(".js-pack-check", "#n5-ui-slabV3" + self.slabV3Tab).on("click", function() {
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
                $(".js-pack-start-label", "#n5-ui-slabV3" + self.slabV3Tab).text("Start Value");
                $(packEndParent).removeClass("hidden");
            } else {
                $(".js-pack-start-label", "#n5-ui-slabV3" + self.slabV3Tab).text("Value");
                $(packEndParent).addClass("hidden");
            }
        }
        /* Pack Size Flow End */
    };

    function updateInputEvents(tab) {
        var rows = $("#n5-ui-slabV3" + tab + " #dynamicTable tbody tr");

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