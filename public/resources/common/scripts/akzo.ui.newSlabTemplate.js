/* jshint loopfunc: true, quotmark:false */
/* global jQuery, native5, _, model, app */
var akzo = (function($, native5, akzo){
    akzo.ui = akzo.ui || {};

    akzo.ui.newSlabTemplate = function(options){
        var opts = options || {};
        this.elmId = opts.elmId || "";
        this.tabId = opts.tabId || {};
        this.newSlabTab = opts.newSlabTab || {};
        var data = opts.data || {};
        this.parentTabIdInstance = opts.tabInstance || {};
        this.newSlabTabTable = 2;
        this.render(data);
    };

    var newSlabPrototype = akzo.ui.newSlabTemplate.prototype;

    newSlabPrototype.render = function (obj) {
        var self = this;
        var data = obj || {};
        var tableArr = [];
        var dateArr = [];
        
        var defaults = {
            slabV2DnI: {
                templateName: "",
                numLaps: 1,
                slabType: "VOLUME",
                prevPeriod: {},
                currPeriod: {},
                packCondition: {type: "greater", startValue: null, endValue: null},
                products: [],
                laps: [],
                segment: [],
                projectSku: true
            }
        };

        data = $.extend(true, defaults, data);
        data.counter = self.newSlabTab;

        if(!data.slabV2DnI.packCondition) {
            data.slabV2DnI.packCondition = {type: "greater", startValue: null, endValue: null};
        }

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

        (self.parentTabIdInstance).addTab({
           "title" : "newSlab_"+self.newSlabTab,
           "html"   : $(tabContent).html()
        });

        var rowLength = data.slabV2DnI.laps.length;
        self.createTable("#n5-Q-cond-table-newSlab"+self.newSlabTab, rowLength, tableArr);
        self.templatenewSlab(self.newSlabTab, data);

        for(var inc = 1; inc <= rowLength; inc++) {
            model.setDate($("#n5-date-reservation-newSlab-table" + inc,  "#n5-ui-newSlab" + self.newSlabTab), dateArr[inc - 1]);
        }

        if(!$.isEmptyObject(data.slabV2DnI.prevPeriod)) {
            model.setDate($(".js-period-prev", $("#n5-ui-newSlab" + self.newSlabTab)), data.slabV2DnI.prevPeriod);
        }

        if(!$.isEmptyObject(data.slabV2DnI.currPeriod)) {
            model.setDate($(".js-period-curr", $("#n5-ui-newSlab" + self.newSlabTab)), data.slabV2DnI.currPeriod);
        }
    };

    newSlabPrototype.createTable = function(parentElm, length, tableArr) {
        var self = this;
        var tableElm = $(parentElm).children("table")[0];

        this.tableInstance = new native5.ui.table({
            parentElm: $(parentElm),
            theme:"",
            isPaginated: false,
            table: tableElm
        });
        this.tableInstance.render();

        /*jshint unused: false*/
        $.each($("tbody tr", $(tableElm)), function(inc, elm) {
            if($.isEmptyObject(tableArr)) {
                self.intailizeTableElement(parseInt(inc) + 1, []);
            } else {
                self.intailizeTableElement(parseInt(inc) + 1, tableArr[inc].products);
            }
            
            // console.log(elm);
        });

        if(length === 0) {
            self.addColsTemplate(1);
        } else {
            self.addColsTemplate(length);
        }
    };

    newSlabPrototype.addRowsTemplate = function(numRows) {
        var self = this;
        self.updateRowString(2); 
        var rows1 = (self.tableInstance).getRows();
        var CalNoOfRows = numRows - rows1;
        parseInt(CalNoOfRows);
        if (CalNoOfRows > 0) {
            for (var i=0; i<CalNoOfRows; i++){
                var index = $("#dynamicTable tbody tr", $("#n5-ui-newSlab" + self.newSlabTab)).length;
                self.updateRowString(index + 1);
                (self.tableInstance).addData(self.rowData);
                self.intailizeTableElement(index + 1);
            }
        } else {
            CalNoOfRows *= -1;
            (self.tableInstance).deleteRows(CalNoOfRows);
        }
        $(".n5-ui-delete-table-row", "#n5-Q-cond-table-newSlab"+self.newSlabTab).on("click", function(){
            var confirm = window.confirm("Are you sure to delete this row?");

            if(confirm) {
                $(this).parent().parent().remove();
                var val = parseInt($("#noofslabsTextStr-newSlab" + self.newSlabTab).val()) - 1;
                $("#noofslabsTextStr-newSlab" + self.newSlabTab).select2("val", val);
                $("#noofslabsTextStr-newSlab" + self.newSlabTab).data("lastSel", val);
            }
        });
    };

    newSlabPrototype.addColsTemplate = function(numOfLaps) {
        var self = this;
        var data = '{"col":"<input class=\'n5-template-selectmenu2 n5-ui-qc-input-placeholder lap-rate\' placeholder=\'Lap Rate\' type=\'text\'/>"}';
        var colspresent = (this.tableInstance).getColumns();
        var ptrindex;
        var count;
        var min_cols = 5;

        if(numOfLaps > (colspresent - min_cols)) {
            count = numOfLaps - (colspresent - min_cols);
            var status = colspresent - min_cols;
            if(numOfLaps == count) {
                for (var i = 0; i < count; i++) {
                    ptrindex = i+(min_cols - 3);
                    (this.tableInstance).addColumnatIndex(data, ptrindex, i + 1);
                    createLapPeriod(i + 1);
                }            
            } else {
                for (var j = 0; j < count; j++) {
                    ptrindex = (j + (min_cols - 3)) + status;
                    var label = status + 1;
                    (this.tableInstance).addColumnatIndex(data, ptrindex, label + j);
                    var str = 
                    '<span class="col-md-4" style="margin: 10px 0;">' +
                        '<label for="first_name" class="n5-ui-sc-label">Lap Period '+ (label+ j) +'</label>' +
                        '<div class="input-prepend input-group"><span class="add-on input-group-addon">' +
                            '<i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>' +
                            '<input name="reservation" id="n5-date-reservation-newSlab-table'+ (label + j) +'" class=form-control placeholder="Select Period" readonly>' +
                        '</div>' +
                    '</span>';    
                    $(".js-calendar-container", "#n5-ui-newSlab" + self.newSlabTab).append(str);
                    intializeDateReservation(label + j);
                }
            }
        } else {
            var deleteIndex = (min_cols - 1) + numOfLaps;
            count = (colspresent - min_cols) - numOfLaps;
            for (var k = 0; k < count; k++) {
                (this.tableInstance).deleteColumnIndex(deleteIndex);
                $(".js-calendar-container .col-md-4:last-child", "#n5-ui-newSlab" + self.newSlabTab).remove();
            }
        }

        function createLapPeriod(i) {
            var str = '<span class="col-md-4" style="margin: 10px 0;"><label for="first_name" class="n5-ui-sc-label">Lap Period '+ i +'</label><div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span><input name="reservation" id="n5-date-reservation-newSlab-table'+ i +'" class=form-control placeholder="Select Period" readonly></div></span>';

            $(".js-calendar-container", "#n5-ui-newSlab" + self.newSlabTab).append(str);
            intializeDateReservation(i);
        }

        function intializeDateReservation(id) {
            var dateStart = $("#sales-period").data('daterangepicker').startDate;
            var dateEnd = $("#sales-period").data('daterangepicker').endDate;

            $("#n5-date-reservation-newSlab-table" + id, "#n5-ui-newSlab" + self.newSlabTab).daterangepicker({
                format: 'DD-MMM-YYYY',
                opens: "center",
                minDate: dateStart,
                maxDate: dateEnd
            }, function() {
                $("body").find(".daterangepicker").css("poistion","absolute !important");
            });
        }

        model.checkPositiveInteger();
    };

    newSlabPrototype.intailizeTableElement = function(tab, products) {
        var self = this;
        // var container = $("#n5-ui-newSlab-multiple-scheme-product-table"+tab,  "#n5-ui-newSlab" + self.newSlabTab);
        // var inputElm = $(container).children("input")[0];

        // new akzo.ui.select.multiple({
        //     "container" : container,
        //     "inputElm" : inputElm,
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

        model.generateProductSelectOnclick($(".product-select", "#n5-ui-newSlab" + self.newSlabTab));
        if(!$.isEmptyObject(products)) {
            var elm = $(".product-select", "#n5-ui-newSlab" + self.newSlabTab)[tab - 1];
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

        $("#dynamicTable tbody tr").each(function() {
            var tab = $(this).children("td:last-child");
            var checkElements = $(tab).find("input");

            $.each(checkElements, function(key, value) {
                $(value).on("click", function() {
                    if(!($(checkElements[0]).prop("checked") || $(checkElements[1]).prop("checked"))) {
                        $(checkElements[1]).prop("checked", "true");
                    }
                });
            });
        });
        
        $(".n5-table-qc-add.btn").off("click");
        $(".n5-table-qc-add.btn").on("click",function(){
            app.slabQCModal.showModal();
            model.addSlabQC(this, "DEFAULT_SLAB" + self.newSlabTab, "SLABV2");
        });

        model.checkPositiveInteger();
    };

    newSlabPrototype.updateRowString = function(tab) {
        var colspresent = (this.tableInstance).getColumns();
        var counter = colspresent - 5;

        this.rowData = {
            "rows": [
                {
                    // "A":"<span id='n5-ui-newSlab-multiple-scheme-product-table"+tab+"'><input /></span>"
                    "A":"<button class='n5-template-box product-select'>Select Products</button>",
                    "B":"<input class='n5-template-selectmenu2 n5-ui-qc-input-placeholder js-slab-start' placeholder='Slab Start' />"
                }
            ]
        };

        if(counter > 0) {
            for(var i = 1; i <= counter; i++) {
                this.rowData.rows[0]["B" + i] = "<input class=\'n5-template-selectmenu2 n5-ui-qc-input-placeholder lap-rate\' placeholder=\'Lap Rate\' type=\'text\'/>";
            }
        }
        this.rowData.rows[0].C = "<span id='n5-ui-newSlab-table-product"+tab+"'><span class='n5-template-selectmenu2 disabled'><span class='n5-ui-sc-label-sub' id='noofslabsTextStr-newSlab-payout"+tab+"'>Rs / Ltr</span></span></span>";
        this.rowData.rows[0].D = "<div class='bulk-retail'><input type='checkbox' class='n5-ui-newSlab-row-checkbox' checked /> Bulk</div><div class='bulk-retail'><input class='n5-ui-newSlab-row-checkbox' type='checkbox' checked /> Retail</div><span class='n5-ui-delete-table-row fa fa-times'></span>";
        this.rowData.rows[0].E = '<button class="n5-table-qc-add btn">QC</button>';
    };

    newSlabPrototype.templatenewSlab = function(tab, data) {
        var self = this;

        $("#noofslabsTextStr-newSlab" + tab).select2();

        $("#noofslabsTextStr-newSlab" + tab).on("click", function() {
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

        $("#nooflapsTextStr-newSlab" + tab).select2();

        $("#nooflapsTextStr-newSlab" + tab).on("click", function() {
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

        var length = data.slabV2DnI.laps.length;

        var dateStart = $("#sales-period").data('daterangepicker').startDate;
        var dateEnd = $("#sales-period").data('daterangepicker').endDate;

        for(var iter = 1; iter <= length; iter++) {
            $("#n5-date-reservation-newSlab-table" + iter, "#n5-ui-newSlab" + self.newSlabTab).daterangepicker({
                format: 'DD-MMM-YYYY',
                opens: "center",
                minDate: dateStart,
                maxDate: dateEnd
            }, postionDatePicker());
        }

        $(".js-period-prev", "#n5-ui-newSlab" + self.newSlabTab).daterangepicker({
            format: 'DD-MMM-YYYY',
            opens: "center",
            // minDate: dateStart,
            // maxDate: dateEnd,
            // startDate: dateStart,
            // endDate: dateEnd
        }, postionDatePicker());

        $(".js-period-curr", "#n5-ui-newSlab" + self.newSlabTab).daterangepicker({
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

        $.each($(".n5-radio-toolbar, #n5-ui-newSlab" + self.newSlabTab).children("input"), function() {
            var name = $(this).attr("name");
            $(this).attr("name", name + tab);
            var id = $(this).attr("id");
            $(this).attr("id", id + tab);
            $(this).next().attr("for", id + tab);

            $(this).on("click", function() {
                if($(this).val() === "growth") {
                    $(".js-growth-row", "#n5-ui-newSlab" + self.newSlabTab).removeClass("hidden");
                } else {
                    $(".js-growth-row", "#n5-ui-newSlab" + self.newSlabTab).addClass("hidden");
                }
            });
        });
        
        var segmentData = [];
        var selectElm = $(".template-segment-values", "#n5-ui-newSlab" + self.newSlabTab)[0];
        var segmentElm = $("#n5-segment-type").children("select")[0];
        
        if(data.slabV2DnI.segment && data.slabV2DnI.segment.length > 0) {
            $.each(data.slabV2DnI.segment, function(key, value) {
                segmentData.push({
                    id: value,
                    text: model.getSegmentText(value)
                });
            });
        } else {
            segmentData = $(segmentElm).select2("data");
        }

        $(selectElm).select2();
        $(selectElm).select2("data", segmentData);

        /* Pack Size Flow Start */
        var packSelectElm = $(".js-pack-select", "#n5-ui-newSlab" + self.newSlabTab);
        var packEndParent = $(".js-pack-end-parent", "#n5-ui-newSlab" + self.newSlabTab);
        var packStartParent = $(".js-pack-start-parent", "#n5-ui-newSlab" + self.newSlabTab);

        $(".js-pack-start", "#n5-ui-newSlab" + self.newSlabTab).on("keypress", function() {
            return model.isNumberKey(this);
        });

        $(".js-pack-end", "#n5-ui-newSlab" + self.newSlabTab).on("keypress", function() {
            return model.isNumberKey(this);
        });

        $(".js-pack-check", "#n5-ui-newSlab" + self.newSlabTab).on("click", function() {
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
                $(".js-pack-start-label", "#n5-ui-newSlab" + self.newSlabTab).text("Start Value");
                $(packEndParent).removeClass("hidden");
            } else {
                $(".js-pack-start-label", "#n5-ui-newSlab" + self.newSlabTab).text("Value");
                $(packEndParent).addClass("hidden");
            }
        }
        /* Pack Size Flow End */
    };

    return akzo;
}(jQuery, native5, akzo || {}));