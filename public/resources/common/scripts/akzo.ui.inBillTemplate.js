/* jshint loopfunc: true, quotmark:false */
/* global jQuery, native5, _, model */
var akzo = (function($, native5, akzo){
    akzo.ui = akzo.ui || {};

    akzo.ui.inBillTemplate = function(options){
        var opts = options || {};
        this.elmId = opts.elmId || "";
        this.tabId = opts.tabId || {};
        this.inBillTab = opts.inBillTab || {};
        var data = opts.data || {};
        this.parentTabIdInstance = opts.tabInstance || {};
        this.inBillTabTable = 2;
        this.render(data);
    };

    var inBillPrototype = akzo.ui.inBillTemplate.prototype;

    inBillPrototype.render = function (obj) {
        var self = this;
        var data = obj || {};
        var tableArr = [];
        var dateArr = [];
        
        var defaults = {
            inBillDnI: {
                templateName: "",
                numLaps: 1,
                products: [],
                packCondition: {type: "greater", startValue: null, endValue: null},
                inBillLaps: [],
                segment: [],
                projectSku: true
            }
        };

        data = $.extend(true, defaults, data);
        data.counter = self.inBillTab;

        if(!data.inBillDnI.packCondition) {
            data.inBillDnI.packCondition = {type: "greater", startValue: null, endValue: null};
        }

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

        (self.parentTabIdInstance).addTab({
           "title" : "inBill_"+self.inBillTab,
           "html"   : $(tabContent).html()
        });

        var rowLength = data.inBillDnI.inBillLaps.length;
        self.createTable("#n5-Q-cond-table-inBill"+self.inBillTab, rowLength, tableArr);
        self.templateinBill(self.inBillTab, data);

        for(var inc = 1; inc <= rowLength; inc++) {
            model.setDate($("#n5-date-reservation-inBill-table" + inc,  "#n5-ui-inBill" + self.inBillTab), dateArr[inc - 1]);
        }
    };

    inBillPrototype.createTable = function(parentElm, length, tableArr) {
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

    inBillPrototype.addRowsTemplate = function(numRows) {
        var self = this;
        // self.updateRowString(2);
        var rows1 = (this.tableInstance).getRows();
        var CalNoOfRows = numRows - rows1;
        parseInt(CalNoOfRows);
        if (CalNoOfRows > 0) {
            for (var i=0; i<CalNoOfRows; i++){
                var index = $("#dynamicTable tbody tr", $("#n5-ui-inBill" + self.inBillTab)).length;
                self.updateRowString(index + 1);
                (self.tableInstance).addData(self.rowData);
                self.intailizeTableElement(index + 1);  
            }
        } else {
            CalNoOfRows *= -1;
            (self.tableInstance).deleteRows(CalNoOfRows);
        }
        $(".n5-ui-delete-table-row", "#n5-Q-cond-table-inBill"+self.inBillTab).on("click", function(){
            var confirm = window.confirm("Are you sure to delete this row?");

            if(confirm) {
                $(this).parent().parent().remove();
                var val = parseInt($("#noofslabsTextStr-inBill" + self.inBillTab).val()) - 1;
                $("#noofslabsTextStr-inBill" + self.inBillTab).select2("val", val);
                $("#noofslabsTextStr-inBill" + self.inBillTab).data("lastSel", val);
            }
        });
    };

    inBillPrototype.addColsTemplate = function(numOfLaps) {
        var self = this;
        var data = '{"col":"<input class=\'n5-template-selectmenu2 n5-ui-qc-input-placeholder lap-rate\' placeholder=\'Lap Rate\' type=\'text\'/>"}';
        var colspresent = (this.tableInstance).getColumns();
        var ptrindex;
        var count;
        var min_cols = 3;

        if(numOfLaps > (colspresent - min_cols)) {
            count = numOfLaps - (colspresent - min_cols);
            var status = colspresent - min_cols;
            if(numOfLaps == count) {
                for (var i = 0; i < count; i++) {
                    ptrindex = i+(min_cols - 2);
                    (this.tableInstance).addColumnatIndex(data, ptrindex, i + 1);
                    createLapPeriod(i + 1);
                }            
            } else {
                for (var j = 0; j < count; j++) {
                    ptrindex = (j + (min_cols - 2)) + status;
                    var label = status + 1;
                    (this.tableInstance).addColumnatIndex(data, ptrindex, label + j);
                    var str = 
                    '<span class="col-md-4" style="margin: 10px 0;">' +
                        '<label for="first_name" class="n5-ui-sc-label">Lap Period '+ (label+ j) +'</label>' +
                        '<div class="input-prepend input-group"><span class="add-on input-group-addon">' +
                            '<i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>' +
                            '<input name="reservation" id="n5-date-reservation-inBill-table'+ (label + j) +'" class=form-control placeholder="Select Period" readonly>' +
                        '</div>' +
                    '</span>';    
                    $(".js-calendar-container", "#n5-ui-inBill" + self.inBillTab).append(str);
                    intializeDateReservation(label + j);
                }
            }
        } else {
            var deleteIndex = (min_cols - 1) + numOfLaps;
            count = (colspresent - min_cols) - numOfLaps;
            for (var k = 0; k < count; k++) {
                (this.tableInstance).deleteColumnIndex(deleteIndex);
                $(".js-calendar-container .col-md-4:last-child", "#n5-ui-inBill" + self.inBillTab).remove();
            }
        }

        function createLapPeriod(i) {
            var str = '<span class="col-md-4" style="margin: 10px 0;"><label for="first_name" class="n5-ui-sc-label">Lap Period '+ i +'</label><div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span><input name="reservation" id="n5-date-reservation-inBill-table'+ i +'" class=form-control placeholder="Select Period" readonly></div></span>';

            $(".js-calendar-container", "#n5-ui-inBill" + self.inBillTab).append(str);
            intializeDateReservation(i);
        }

        function intializeDateReservation(id) {
            var dateStart = $("#sales-period").data('daterangepicker').startDate;
            var dateEnd = $("#sales-period").data('daterangepicker').endDate;

            $("#n5-date-reservation-inBill-table" + id, "#n5-ui-inBill" + self.inBillTab).daterangepicker({
                format: 'DD-MMM-YYYY',
                opens: "center",
                minDate: dateStart,
                maxDate: dateEnd,
                startDate: dateStart,
                endDate: dateEnd
            }, function() {
                $("body").find(".daterangepicker").css("poistion","absolute !important");
            });
        }

        model.checkPositiveInteger();
    };

    inBillPrototype.intailizeTableElement = function(tab, products) {
        var self = this;
        // var container = $("#n5-ui-inBill-multiple-scheme-product-table"+tab,  "#n5-ui-inBill" + self.inBillTab);
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

        model.generateProductSelectOnclick($(".product-select", "#n5-ui-inBill" + self.inBillTab));

        var elm = $(".product-select", "#n5-ui-inBill" + self.inBillTab)[tab - 1];
        createProductsDisplay(elm, products, self.inBillTab);

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

        model.checkPositiveInteger();
    };

    inBillPrototype.updateRowString = function(tab) {
        var self = this;
        var colspresent = (this.tableInstance).getColumns();
        var counter = colspresent - 3;

        this.rowData = {
            "rows": [
                {
                    // "A":"<span id='n5-ui-inBill-multiple-scheme-product-table"+tab+"'><input /></span>"
                    "A": getProductStr(self.inBillTab)
                }
            ]
        };

        if(counter > 0) {
            for(var i = 1; i <= counter; i++) {
                this.rowData.rows[0]["A" + i] = "<input class=\'n5-template-selectmenu2 n5-ui-qc-input-placeholder lap-rate\' placeholder=\'Lap Rate\' type=\'text\'/>";
            }
        }
        this.rowData.rows[0].B = "<span id='n5-ui-inBill-table-product"+tab+"'><span class='n5-template-selectmenu2 disabled'><span class='n5-ui-sc-label-sub' id='noofslabsTextStr-inBill-payout"+tab+"'>Rs / Ltr</span></span></span>";
        this.rowData.rows[0].C = "<span class='n5-ui-delete-table-row fa fa-times'></span><div class='bulk-retail'><input type='checkbox' class='n5-ui-inBill-row-checkbox' checked /> Bulk</div><div class='bulk-retail'><input class='n5-ui-inBill-row-checkbox' type='checkbox' checked /> Retail</div>";
    };

    inBillPrototype.templateinBill = function(tab, data) {
        var self = this;

        $("#noofslabsTextStr-inBill" + tab).select2();

        $("#noofslabsTextStr-inBill" + tab).on("click", function() {
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

        $("#nooflapsTextStr-inBill" + tab).select2();

        $("#nooflapsTextStr-inBill" + tab).on("click", function() {
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

        var length = data.inBillDnI.inBillLaps.length;

        var dateStart = $("#sales-period").data('daterangepicker').startDate;
        var dateEnd = $("#sales-period").data('daterangepicker').endDate;

        for(var iter = 1; iter <= length; iter++) {
            $("#n5-date-reservation-inBill-table" + iter, "#n5-ui-inBill" + self.inBillTab).daterangepicker({
                format: 'DD-MMM-YYYY',
                opens: "center",
                minDate: dateStart,
                maxDate: dateEnd
            }, postionDatePicker());
        }

        function postionDatePicker() {
            $("body").find(".daterangepicker").css("poistion", "absolute !important");
        }
        
        var segmentData = [];
        var selectElm = $(".template-segment-values", "#n5-ui-inBill" + self.inBillTab)[0];
        var segmentElm = $("#n5-segment-type").children("select")[0];
        
        if(data.inBillDnI.segment && data.inBillDnI.segment.length > 0) {
            $.each(data.inBillDnI.segment, function(key, value) {
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
        
        $(".product-select-main").data("index", 0);
        model.generateProductSelectOnclick($(".product-select-main", "#n5-ui-inBill" + self.inBillTab));
        createProductsDisplay($(".product-select-main", "#n5-ui-inBill" + self.inBillTab), data.inBillDnI.products);

        /* Pack Size Flow Start */
        var packSelectElm = $(".js-pack-select", "#n5-ui-inBill" + self.inBillTab);
        var packEndParent = $(".js-pack-end-parent", "#n5-ui-inBill" + self.inBillTab);
        var packStartParent = $(".js-pack-start-parent", "#n5-ui-inBill" + self.inBillTab);

        $(".js-pack-start", "#n5-ui-inBill" + self.inBillTab).on("keypress", function() {
            return model.isNumberKey(this);
        });

        $(".js-pack-end", "#n5-ui-inBill" + self.inBillTab).on("keypress", function() {
            return model.isNumberKey(this);
        });

        $(".js-pack-check", "#n5-ui-inBill" + self.inBillTab).on("click", function() {
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
                $(".js-pack-start-label", "#n5-ui-inBill" + self.inBillTab).text("Start Value");
                $(packEndParent).removeClass("hidden");
            } else {
                $(".js-pack-start-label", "#n5-ui-inBill" + self.inBillTab).text("Value");
                $(packEndParent).addClass("hidden");
            }
        }
        /* Pack Size Flow End */
    };

    function getProductStr(templateNum) {
        var index = parseInt($(".product-select-main", "#n5-ui-inBill" + templateNum).data("index"));
        var str = "";
        if($.isEmptyObject($(".product-select-main", "#n5-ui-inBill" + templateNum).data("products"))) {
            str = "<button class='product-select'>Select Products</button>";
        } else {
            var data = $(".product-select-main", "#n5-ui-inBill" + templateNum).data("products");
            if(data && data[index]) {
                var tempArr = [];
                tempArr.push(data[index]);
                str  = "<button class='product-select' data-products=' " + JSON.stringify(tempArr) + " '>Select Products</button>";
                var resultStr = "<div>";

                if(data[index].excluded) {
                    resultStr += "- ";
                } else {
                    resultStr += "+ ";
                }
                resultStr += data[index].name + ", ";
                resultStr = resultStr.substring(0, resultStr.length - 2);
                resultStr += "</div>";

                str += resultStr;

                $(".product-select-main", "#n5-ui-inBill" + templateNum).data("index", (index + 1));
            } else {
                str = "<button class='product-select'>Select Products</button>";
            }
        }

        return str;
    }

    function createProductsDisplay(elm, products) {
        if(!$.isEmptyObject(products)) {
            if(typeof products === "string") {
                products = JSON.parse(products);
            }
            
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
    }

    return akzo;
}(jQuery, native5, akzo || {}));