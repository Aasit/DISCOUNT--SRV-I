/* jshint loopfunc: true, quotmark:false */
/* global jQuery, native5, _, model, alert, app */
var akzo = (function($, native5, akzo){
    "use strict";
    akzo.ui = akzo.ui || {};

    akzo.ui.priTemplate = function(options){
        var opts = options || {};
        this.elmId = opts.elmId || "";
        this.tabId = opts.tabId || {};
        this.priTab = opts.priTab || {};
        var data = opts.data || {};
        this.parentTabIdInstance = opts.tabInstance || {};
        this.render(data);
        this.priTabTable = 2;
    };

    var priPrototype = akzo.ui.priTemplate.prototype;

    priPrototype.render = function (obj) {
        var self = this;
        var data = obj || {};
        var products = [];
        var value;

        var defaults = {
            qcList: [],
            priDnI: {
                templateName: "",
                numSlabs: 1,
                period: {},
                priType: "VOLUME",
                packCondition: {type: "greater", startValue: null, endValue: null},
                priProducts: [],
                priPayouts: [],
                segment: [],
                projectSku: true
            }
        };

        data = $.extend(true, defaults, data);
        data.counter = self.priTab;

        if(!data.priDnI.packCondition) {
            data.priDnI.packCondition = {type: "greater", startValue: null, endValue: null};
        }

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

        (self.parentTabIdInstance).addTab({
           "title" : "PRI_"+self.priTab,
           "html"  : $(tabContent).html()
        });

        self.createTable("#n5-Q-cond-table-pri"+self.priTab);
        self.templatepri(self.priTab, data);

        if(!$.isEmptyObject(data.priDnI.period)) {
            model.setDate($("#n5-date-reservation-pri" + self.priTab), data.priDnI.period);
        }
    };

    priPrototype.createTable = function(parentElm) {
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

    priPrototype.addRowsTemplate = function(numRows) {
        var self = this;
        var rows1 = (self.tableInstance).getRows();
        var CalNoOfRows = numRows - rows1;
        parseInt(CalNoOfRows);
        if (CalNoOfRows > 0) {
            for (var i=0; i<CalNoOfRows; i++){
                var index = $("#dynamicTable tbody tr", $("#n5-ui-pri" + self.priTab)).length;
                self.updateRowString(index + 1);
                (self.tableInstance).addData(self.rowData);
                self.intailizeTableElement(index + 1);
            }
        }
        else {
            CalNoOfRows *= -1;
            (self.tableInstance).deleteRows(CalNoOfRows);
        }
        $(".n5-ui-delete-table-row","#n5-Q-cond-table-pri"+self.priTab).on("click", function(){
            var confirm = window.confirm("Are you sure to delete this row?");

            if(confirm) {
                $(this).parent().parent().remove();
                var val = parseInt($("#noofprisTextStr" + self.priTab).val()) - 1;
                $("#noofprisTextStr" + self.priTab).select2("val", val);
                $("#noofprisTextStr" + self.priTab).data("lastSel", val);
            }
        });
     };

     priPrototype.updateRowString = function(tab) {
        this.rowData = {
            "rows": [
                {
                  "A": "<input class='n5-template-selectmenu2 n5-ui-qc-input-placeholder' placeholder='No Of Products' type='text'/>",
                  "B": "<input class='n5-template-selectmenu2 n5-ui-qc-input-placeholder' placeholder='Payout Rate' type='text'/>",
                  "C": "<span id='n5-ui-pri-table-product"+tab+"'><select class='select-dropdown n5-ui-sc-label-sub' id='noofprisTextStr-pri-payout"+tab+"'></select></span><input class='n5-template-box js-gift-desc"+tab+"' style='display:none;' placeholder='Gift Description' />",
                  "D": "<button class='n5-table-qc-add btn'>QC</button><span style= 'cursor: pointer;margin-left: 3%;' class='n5-ui-delete-table-row fa fa-times'></span>"
                }
              ]
            };
    };

    priPrototype.intailizeTableElement = function(tab) {
        var self = this;
        
        if($("#noofprisTextStr-pri-payout" + tab, "#n5-ui-pri" + (self.priTab)).children("option").length === 0) {
            $("#noofprisTextStr-pri-payout" + tab, "#n5-ui-pri" + (self.priTab)).append("<option>RS / Ltr</option><option>Abs Amount</option><option>Gift</option><option>Percentage</option>");
        }
        $("#noofprisTextStr-pri-payout" + tab, "#n5-ui-pri" + (self.priTab)).select2();

        $("#noofprisTextStr-pri-payout" + tab, "#n5-ui-pri" + (self.priTab)).on("select2-selecting", function(e) {
            var selection = e.object;
            if (selection.text.toLowerCase() === "gift") {
                $(".js-gift-desc" + tab, "#n5-ui-pri" + (self.priTab)).show();
            } else {
                $(".js-gift-desc" + tab, "#n5-ui-pri" + (self.priTab)).hide();
            }
        });

        $(".n5-table-qc-add.btn").off("click");
        $(".n5-table-qc-add.btn").on("click", function(){
            app.slabQCModal.showModal();
            model.addSlabQC(this, "DEFAULT_PRI" + self.priTab, "PRI");
        });
    };

    priPrototype.templatepri = function(tab, data) {
        var self = this;
        var preload_data = [{pid:"SS60", name:"Dulux Rainbow Colours (S60)"},{pid:"SS04",name:"Dulux Superclean 3IN1 (S04)"},{pid:"SS09",name:"Dulux Gloss (S09)"},{pid:"SS16", name:"Dulux Satin Finish (S16)"},{pid:"SS23",name:"Dulux VT Pearl Glow (S23)"},{pid:"SS26",name:"Dulux Weathershield (S26)"},{pid:"SS29",name:"Dulux Weathershield Max (S29)"},{pid:"SS59",name:"Dulux Promise (S59)"},{pid:"SCS6", name:"Dulux Rainbow Colours (CS6)"},{pid:"SU82",name:"Dulux Super Smooth Silk (U82)"},{pid:"SX78",name:"Dulux Promise (X78)"}];

        $("#noofprisTextStr" + tab).select2();

        $("#noofprisTextStr" + tab).on("click", function() {
            var productsElm = $(".select2-choices", $("#n5-ui-pri" + self.priTab))[1];
            var maxLength = $(productsElm).find("[data-product]").length;

            if (parseInt($(this).val()) > maxLength) {
                alert("Maxmium number of rows cannot be more than number of products selected.");
                $(this).select2("data", {text: $(this).attr("lastSel")});
            }
            
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

        var products = data.products;
        var selectElm = $("#n5-ui-pri-multiple-scheme-product" + tab).children("input")[0];

        new akzo.ui.select.multiple({
            "container" : "#n5-ui-pri-multiple-scheme-product" + tab,
            "inputElm" : $(selectElm),
            "serviceURL": "template/products",
            "listClass" : "demo-search-list",
            "containerCssClass" : "n5-template1",
            "selections" : {
                "products": "product-select",
                "groups": "group-select",
                "subbrands": "subbrand-select",
                "clusters" : "cluster-select"
            },
            "showFilters": true,
            "preselect": true
        });

        // model.generateProductSelectOnclick($(".product-select", "#n5-ui-pri" + self.priTab));

        if(!$.isEmptyObject(products)) {
            // $(".product-select", "#n5-ui-pri" + self.priTab).data("products", products);
            $($("#n5-ui-pri-multiple-scheme-product" + tab).children("input")[0]).select2('data', products);
        } else {
            // $(".product-select", "#n5-ui-pri" + self.priTab).data("products", preload_data);
            $($("#n5-ui-pri-multiple-scheme-product" + tab).children("input")[0]).select2('data', preload_data);
        }

        // $($("#n5-ui-pri-multiple-scheme-product" + tab).children("input")[0]).select2('data', preload_data);

        var dateStart = $("#sales-period").data('daterangepicker').startDate;
        var dateEnd = $("#sales-period").data('daterangepicker').endDate;

        $("#n5-date-reservation-pri" + tab, "#n5-ui-pri" + self.priTab).daterangepicker({
            format: 'DD-MMM-YYYY',
            opens: "center",
            minDate: dateStart,
            maxDate: dateEnd,
            startDate: dateStart,
            endDate: dateEnd
        }, function() {
            $("body").find(".daterangepicker").css("poistion","absolute !important");
        });
        $("#radio-pri-a"+tab, "#n5-ui-pri"+tab).on("click", function(){
            $(".n5-ui-minvalvol", "#n5-ui-pri"+tab).text("Minimum Value");
        });
        $("#radio-pri-b"+tab, "#n5-ui-pri"+tab).on("click", function(){
            $(".n5-ui-minvalvol", "#n5-ui-pri"+tab).text("Minimum Volume");
        });

        $.each($(".n5-radio-toolbar, #n5-ui-pri" + self.priTab).children("input"), function() {
            var name = $(this).attr("name");
            $(this).attr("name", name + tab);
            var id = $(this).attr("id");
            $(this).attr("id", id + tab);
            $(this).next().attr("for", id + tab);
        });
        
        var segTemplate = $(".template-segment-values", "#n5-ui-pri" + self.priTab)[0];
        var segmentElm = $("#n5-segment-type").children("select")[0];
        var segmentData = [];

        if(data.priDnI.segment && data.priDnI.segment.length > 0) {
            $.each(data.priDnI.segment, function(key, value) {
                segmentData.push({
                    id: value,
                    text: model.getSegmentText(value)
                });
            });
        } else {
            segmentData = $(segmentElm).select2("data");
        }

        $(segTemplate).select2();
        $(segTemplate).select2("data", segmentData);

        /* Pack Size Flow Start */
        var packSelectElm = $(".js-pack-select", "#n5-ui-pri" + self.priTab);
        var packEndParent = $(".js-pack-end-parent", "#n5-ui-pri" + self.priTab);
        var packStartParent = $(".js-pack-start-parent", "#n5-ui-pri" + self.priTab);

        $(".js-pack-start", "#n5-ui-pri" + self.priTab).on("keypress", function() {
            return model.isNumberKey(this);
        });

        $(".js-pack-end", "#n5-ui-pri" + self.priTab).on("keypress", function() {
            return model.isNumberKey(this);
        });

        $(".js-pack-check", "#n5-ui-pri" + self.priTab).on("click", function() {
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
                $(".js-pack-start-label", "#n5-ui-pri" + self.priTab).text("Start Value");
                $(packEndParent).removeClass("hidden");
            } else {
                $(".js-pack-start-label", "#n5-ui-pri" + self.priTab).text("Value");
                $(packEndParent).addClass("hidden");
            }
        }
        /* Pack Size Flow End */
    };
    return akzo;
}(jQuery, native5, akzo || {}));
