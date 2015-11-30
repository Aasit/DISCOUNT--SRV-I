/*jshint loopfunc: true, quotmark: false */
/* global _, jQuery, akzo, native5, Backbone, app, moment, getParameterByName, console, confirm */
(function (_, $, akzo, native5, Backbone) {
	"use strict";
    var i = 0;
    var EventBus = {};
    _.extend(EventBus, Backbone.Events);

    var SchemeDetailsView = Backbone.View.extend({
        el: "#scheme-details",
        initialize: function(){
            // this.model = new SchemeDetails();
            schemeDetailsModel.set("qcList", QCcollection);
            EventBus.on("save:SchemeDetailsView",this.setData, this);
        },
        render: function(){
            //render select dropdowns
            renderDropdown(this.$("#n5-scheme-type .n5-schemetype-select"), "", "select-dropdown");
            renderDropdown(this.$("#n5-dealers-attribute .n5-dealers-select"), "Dealer's Attributes", "select-dropdown");
            renderDropdown(this.$("#n5-segment-type .n5-segment-select"), "Select Segment", "select-dropdown");
            //render datepickers  
            this.$("#sales-period").daterangepicker({
                format: 'YYYY-MM-DD',
                startDate: new Date(),
                endDate: moment().add('months', 1).format()
            });

            //render select2
            model.generateProductSelectOnclick($(".geography-select", "#n5-sales-geography"), "geography");
        },
        events: {
            "click li": "setData"
        },            
          // handle the "click" of the "#save" button
        setData: function(){
            var schemeData = {
                id: (this.$(".scheme-name").val()).replace(/ /g,"_"),
                name: this.$(".scheme-name").val(),
                type: this.$(".n5-schemetype-select").select2("data").text,
                segment: this.$(".n5-segment-select").select2("data").text,
                description: this.$(".scheme-name").val(),
                startDate: getFormattedDate(new Date(this.$("#sales-period").data("daterangepicker").startDate)),
                endDate: getFormattedDate(new Date(this.$("#sales-period").data("daterangepicker").endDate)),
                dealerAttributes: this.$(".n5-dealers-select").select2("val"),
                salesGeography: getDataFromGeographySelect(this.$(".sales-geo-select"))
            };
            var id = (this.$(".scheme-name").text()).replace(/ /g,"_");
            schemeDetailsModel.set("id", id);
            schemeDetailsModel.set("schemeHeader", schemeData);
        },
        addOne: function(){
        },
        remove: function(){
        }
    });

    var QualifyingConditionsView = Backbone.View.extend({
        el: "#qualifying-conditions",
        initialize: function(){
            EventBus.on("save:QualifyingConditionsView",this.setData, this);
        },
        render: function(){
            var that = this;
            $("#n5-add-Q-conditions .qc-add-condition").on("click", function() {
                var condition = that.addCondition(that);
                condition.render();
            });
            $("#n5-add-Q-conditions .qc-add-condition").one("click", function() {
                $(this).css("float", "left");
            });
           
        },
        // events: {
        //     "click #seeCollection": "setData",
        // },  
        addCondition: function(){
            $("#n5-ui-qc-click-on").css("display","none");
            var QualifyingCondTemp = $("#n5-ui-template-qualCond-template").html().trim();
            var cloneqc = $(QualifyingCondTemp);
            var conditionInstance = $("#n5-qc-list").append($(cloneqc));
            return new QualifyingConditionView({ 
                el: $(".n5-template-qc-conditions",$(conditionInstance)).last(),
                model: new QualifyingCondition(),
                collection: QCcollection
            });
        },
          // handle the "click" of the "#save" button
        setData: function(){
            var satisfyAll = this.$(".satisfyAll").is(":checked");
            schemeDetailsModel.set("satisfyAll", satisfyAll);
            // console.log(QCcollection);
        }
    });

    var QualifyingConditionView = Backbone.View.extend({
        initialize: function(){
            this.collection.add(this.model);
        },
        events: {
            "click .n5-add-payout": "togglePayout",
            "click .n5-tempate-close-condition": "remove",
        },
        render: function(){
            var that = this;
            
            renderDropdown(this.$(".n5-qctype-select"),"", "qc-select-dropdown");
            renderDropdown(this.$(".n5-operator-select"),"", "qc-select-dropdown");
            this.dateRange = [];   
            this.productSelect = [];   
            this.dateRange[0] = this.$(".n5-ui-qc-input-datepicker").daterangepicker({
                format: "YYYY-MM-DD",
                startDate: new Date(),
                endDate: moment().add('months', 1).format(),
                opens: "left"
            }); 
            this.productSelect[0] = new akzo.ui.select.multiple({
                "container" : this.$(".n5-qc-multi-check"),
                "inputElm" : this.$(".input-product-select"),
                "serviceURL": "template/products",
                "listClass" : "demo-search-list",
                "containerCssClass" : "select-multi-dropdown qc-template-width",
                "selections" : {
                    "products": "product-select",
                    "groups": "group-select",
                    "subbrands": "subbrand-select",
                    "clusters" : "cluster-select"
                },
                "showFilters": true
            });

            //manual event listening
            this.$(".n5-qctype-select").on("change", function() {
                that.updateTemplate();
                that.setData();
            });
            this.$(".n5-operator-select").on("change", function() {
                that.setData();
            });
            this.$(".n5-ui-qc-input-value").on("change", function() {
                that.setData();
            });
            this.$(".n5-ui-qc-input-datepicker").on("apply.daterangepicker", function() {
                that.setData();
            });
            this.$(".qc-product-select").on("change", function() {
                that.setData();
            });
            this.$(".n5-ui-qc-input-payout").on("change", function() {
                that.setData();
            });
        },

        updateTemplate: function(){
            this.unbind();
            this.model.clear();
            if(this.$(".n5-qctype-select").select2("val") == "Ratio Value" || this.$(".n5-qctype-select").select2("val") == "Ratio Volume") {
                for (i = 0; i < this.dateRange.length; i++) {
                    this.dateRange[i].remove();
                }
                this.dateRange = [];
                for (i = 0; i < this.productSelect.length; i++) {
                    this.productSelect[i].select2("destroy");
                }
                this.productSelect = [];
                this.$(".n5-input-datepicker-container").html('<span class="n5-template-qc-conditions-col"> <span class="add-on input-group-addon"> <i class="glyphicon glyphicon-calendar fa fa-calendar"> </i> </span> <input type="text" class="qc-template-box n5-ui-qc-previous-datepicker" placeholder = "Previous Period" readonly/></span><span class="n5-template-qc-conditions-col"> <span class="n5-qc-multi-check"> <input class = "input-previous-product-select qc-product-select"> </span></span><span class="n5-template-qc-conditions-col"> <span class="add-on input-group-addon"> <i class="glyphicon glyphicon-calendar fa fa-calendar"> </i> </span> <input type="text" class="qc-template-box n5-ui-qc-current-datepicker" placeholder = "Current Period" readonly /></span><span class="n5-template-qc-conditions-col"> <span class="n5-qc-multi-check"> <input class = "input-current-product-select qc-product-select"> </span></span>');
                this.dateRange.previous = this.$(".n5-ui-qc-previous-datepicker").daterangepicker({
                    format: "YYYY-MM-DD",
                    startDate: new Date(),
                    endDate: moment().add('months', 1).format(),
                    opens: "left"
                }); 
                this.dateRange.current = this.$(".n5-ui-qc-current-datepicker").daterangepicker({
                    format: "YYYY-MM-DD",
                    startDate: new Date(),
                    endDate: moment().add('months', 1).format(),
                    opens: "left"
                }); 
                this.productSelect.previous = new akzo.ui.select.multiple({
                    "inputElm" : this.$(".input-previous-product-select"),
                    "serviceURL": "template/products",
                    "listClass" : "demo-search-list",
                    "containerCssClass" : "select-multi-dropdown n5-template1-width",
                    "selections" : {
                        "products": "product-select",
                        "groups": "group-select",
                        "subbrands": "subbrand-select",
                        "clusters" : "cluster-select"
                    },
                    "showFilters": true,
                    "placeholder": "Num Products"
                });
                this.productSelect.current = new akzo.ui.select.multiple({
                    "inputElm" : this.$(".input-current-product-select"),
                    "serviceURL": "template/products",
                    "listClass" : "demo-search-list",
                    "containerCssClass" : "select-multi-dropdown n5-template1-width",
                    "selections" : {
                        "products": "product-select",
                        "groups": "group-select",
                        "subbrands": "subbrand-select",
                        "clusters" : "cluster-select"
                    },
                    "showFilters": true,
                    "placeholder": "Den Products"
                });
            }

            else if(this.$(".n5-qctype-select").select2("val") == "Growth Value" || this.$(".n5-qctype-select").select2("val") == "Growth Volume"){
                for (i = 0; i < this.dateRange.length; i++) {
                    this.dateRange[i].remove();
                }
                this.dateRange = [];
                for (i = 0; i < this.productSelect.length; i++) {
                    this.productSelect[i].select2("destroy");
                }
                this.productSelect = [];
                this.$(".n5-input-datepicker-container").html('<span class="n5-template-qc-conditions-col"> <span class="add-on input-group-addon"> <i class="glyphicon glyphicon-calendar fa fa-calendar"> </i> </span> <input type="text" class="qc-template-box n5-ui-qc-previous-datepicker" readonly placeholder = "Previous Period" /> </span> <span class="n5-template-qc-conditions-col"> <span class="add-on input-group-addon"> <i class="glyphicon glyphicon-calendar fa fa-calendar"> </i> </span> <input type="text" class="qc-template-box n5-ui-qc-current-datepicker" readonly placeholder = "Current Period" /> </span> <span class="n5-template-qc-conditions-col"> <span class="n5-qc-multi-check"> <input class = "input-product-select qc-product-select"> </span> </span>');
                this.dateRange.previous = this.$(".n5-ui-qc-previous-datepicker").daterangepicker({
                    format: "YYYY-MM-DD",
                    startDate: new Date(),
                    endDate: moment().add('months', 1).format()
                }); 
                this.dateRange.current = this.$(".n5-ui-qc-current-datepicker").daterangepicker({
                    format: "YYYY-MM-DD",
                    startDate: new Date(),
                    endDate: moment().add('months', 1).format()
                }); 
                this.productSelect[0] = new akzo.ui.select.multiple({
                    "inputElm" : this.$(".input-product-select"),
                    "serviceURL": "template/products",
                    "listClass" : "demo-search-list",
                    "containerCssClass" : "select-multi-dropdown n5-template1-width",
                    "selections" : {
                        "products": "product-select",
                        "groups": "group-select",
                        "subbrands": "subbrand-select",
                        "clusters" : "cluster-select"
                    },
                    "showFilters": true
                });
            }

            else {
                for (i = 0; i < this.dateRange.length; i++) {
                    this.dateRange[i].remove();
                }
                this.dateRange = [];
                for (i = 0; i < this.productSelect.length; i++) {
                    this.productSelect[i].select2("destroy");
                }
                this.productSelect = [];
                this.$(".n5-input-datepicker-container").html('<span class="n5-template-qc-conditions-col"> <span class="add-on input-group-addon"> <i class="glyphicon glyphicon-calendar fa fa-calendar"></i> </span> <input type="text" name="sales-period" class="qc-template-box n5-ui-qc-input-datepicker" readonly placeholder = "Select Period" /> </span> <span class="n5-template-qc-conditions-col"> <span class="n5-qc-multi-check"> <input class = "input-product-select qc-product-select"> </span> </span>');
                this.dateRange[0] = this.$(".n5-ui-qc-input-datepicker").daterangepicker({
                    format: "YYYY-MM-DD",
                    startDate: new Date(),
                    endDate: moment().add('months', 1).format()
                }); 
                this.productSelect[0] = new akzo.ui.select.multiple({
                    "inputElm" : this.$(".input-product-select"),
                    "serviceURL": "template/products",
                    "listClass" : "demo-search-list",
                    "containerCssClass" : "select-multi-dropdown n5-template1-width",
                    "selections" : {
                        "products": "product-select",
                        "groups": "group-select",
                        "subbrands": "subbrand-select",
                        "clusters" : "cluster-select"
                    },
                    "showFilters": true
                });
            }
            this.delegateEvents();
            return this;
        },
        setData: function() {
            var qdata;
            if(this.$(".n5-qctype-select").select2("val") == "Ratio Value" || this.$(".n5-qctype-select").select2("val") == "Ratio Volume") {
                qdata = {
                    name: ((this.$(".n5-qctype-select").select2("val")).split(" ")[0]).toUpperCase(),
                    type: ((this.$(".n5-qctype-select").select2("val")).split(" ")[1]).toUpperCase(),
                    op: this.$(".n5-operator-select").select2("val"),
                    val: this.$(".n5-ui-qc-input-value").val(),
                    numPeriod: {
                        startDate: getFormattedDate(new Date(this.$(".n5-ui-qc-previous-datepicker").data("daterangepicker").startDate)),
                        endDate: getFormattedDate(new Date(this.$(".n5-ui-qc-previous-datepicker").data("daterangepicker").endDate))
                    },
                    denPeriod: {
                        startDate: getFormattedDate(new Date(this.$(".n5-ui-qc-current-datepicker").data("daterangepicker").startDate)),
                        endDate: getFormattedDate(new Date(this.$(".n5-ui-qc-current-datepicker").data("daterangepicker").endDate))
                    },
                    numProducts: getDataFromProductSelect(this.$(".input-previous-product-select")),
                    denProducts: getDataFromProductSelect(this.$(".input-current-product-select")),
                    payoutCondition: this.$(".n5-ui-qc-input-payout").val()
                };
            }

            else if(this.$(".n5-qctype-select").select2("val") == "Growth Value" || this.$(".n5-qctype-select").select2("val") == "Growth Volume"){
                qdata = {
                    name: ((this.$(".n5-qctype-select").select2("val")).split(" ")[0]).toUpperCase(),
                    type: ((this.$(".n5-qctype-select").select2("val")).split(" ")[1]).toUpperCase(),
                    op: this.$(".n5-operator-select").select2("val"),
                    val: this.$(".n5-ui-qc-input-value").val(),
                    previousPeriod: {
                        startDate: getFormattedDate(new Date(this.$(".n5-ui-qc-previous-datepicker").data("daterangepicker").startDate)),
                        endDate: getFormattedDate(new Date(this.$(".n5-ui-qc-previous-datepicker").data("daterangepicker").endDate))
                    },
                    currentPeriod: {
                        startDate: getFormattedDate(new Date(this.$(".n5-ui-qc-current-datepicker").data("daterangepicker").startDate)),
                        endDate: getFormattedDate(new Date(this.$(".n5-ui-qc-current-datepicker").data("daterangepicker").endDate))
                    },
                    products: getDataFromProductSelect(this.$(".input-product-select")),
                    payoutCondition: this.$(".n5-ui-qc-input-payout").val()
                };
            }
            else{
                qdata = {
                    name: ((this.$(".n5-qctype-select").select2("val")).split(" ")[0]).toUpperCase(),
                    type: ((this.$(".n5-qctype-select").select2("val")).split(" ")[1]).toUpperCase(),
                    op: this.$(".n5-operator-select").select2("val"),
                    val: this.$(".n5-ui-qc-input-value").val(),
                    period: {
                        startDate: getFormattedDate(new Date(this.$(".n5-ui-qc-input-datepicker").data("daterangepicker").startDate)),
                        endDate: getFormattedDate(new Date(this.$(".n5-ui-qc-input-datepicker").data("daterangepicker").endDate))
                    },
                    products: getDataFromProductSelect(this.$(".input-product-select")),
                    payoutCondition: this.$(".n5-ui-qc-input-payout").val()
                };
            }
            this.model.set(qdata);
            // console.log(this.model);
        },
        remove: function(){
            if(confirm("Are you sure to delete this Qualifying Condition?")) {
                this.$("n5-tempate-close-condition").parent().parent().fadeOut();
                this.collection.remove(this.model);
                this.model.destroy();                  
                this.undelegateEvents();
                this.$el.removeData().unbind();  
                Backbone.View.prototype.remove.call(this);

            }
                
        },
        togglePayout: function(e){
            e.preventDefault();
            this.$(".n5-add-payout").children().toggleClass("fa fa-plus fa fa-minus");
            this.$(".n5-add-payout").parent().next().toggle();
        }
    });

    function renderDropdown(elm, placeholder, containerClass) {
        $(elm).select2({
            allowClear: true,
            closeOnSelect: false,
            containerCssClass : containerClass,
            placeholder: placeholder || ""
        });
    }

    function getDataFromProductSelect(elm){
        var data = [];
        $($(elm).select2("data")).each(function(index, value){
            data.push({pid: value.pid, name: value.name});
        });
        return data;
    }

    function getDataFromGeographySelect(elm){
        var data = [];
        $($(elm).select2("data")).each(function(index, value){
            data.push({gid: value.gid, name: value.name});
        });
        return data;
    }

    function showSchemeDetails(){
        var schemeDV = new SchemeDetailsView();
        schemeDV.render();
    }

    function showqualifyingConditions(){
        var qconditionView = new QualifyingConditionsView();
        qconditionView.render();
    }
    // qc ends here

    var TemplatesView = Backbone.View.extend({
        el: "#n5-ui-template-add-temp-qc",

        initialize: function(){
            this.model = new SchemeModel();
        },

        render: function(){
            var self = this;
            var addTempOpts = {
                "tabStyle" : "white",
                "backgroundStyle" : "transparent",
                "addIcon"   : "fa fa-plus fa-lg"
            };

            var addTempLib = new native5.ui.tab(addTempOpts);
            addTempLib.render($("#n5-ui-template-add-temp-qc"));
            addTempLib.setDefaultContent('<div style="text-align:center;padding:10px;"><h3 style="margin-top:0px">Click on Add Button to Add a Template</h3></div>');
            addTempLib.setPlusEvent(plusEventhandle);
            var modal = new native5.ui.modal({"top":200}); 
            modal.render({"modalElm":"#n5-template-popup"});
            $(".modal_close").click(function() {
                modal.closeModal();
            });

            $("#listTemplate").select2();
            $("#copiesTemplate").select2();

            function plusEventhandle() {        
                modal.showModal();
            }

            var inBillTab = 0;
            $("#n5-ui-template-modal-inBill").on('click', function(){
                inBillTab++;
                modal.closeModal();
                var inBillTmpl = self.addinBillTemplate(inBillTab);
                inBillTmpl.render(inBillTab, addTempLib);
            });

            var priTab = 0;
            $("#n5-ui-template-modal-pri").on('click', function() {
                priTab++;
                modal.closeModal();
                var priTmpl = self.addPriTemplate(priTab);
                priTmpl.render(priTab, addTempLib);
            });

            var ppiTab = 0;
            $("#n5-ui-template-modal-ppi").on('click', function(){
                ppiTab++;
                modal.closeModal();
                var ppiTmpl = self.addPpiTemplate(ppiTab);
                ppiTmpl.render(ppiTab, addTempLib);
            });

            var slabTab = 0;
            $("#n5-ui-template-modal-slab").on('click', function() {
                slabTab++;
                modal.closeModal();
                var slabTmpl = self.addSlabTemplate(slabTab);
                slabTmpl.render(slabTab, addTempLib);
            });
        },

        addSlabTemplate: function(tab) {
            this.lastTab = new SlabTabsView({el: this.$("#n5-ui-slab" + tab)});
            return this.lastTab;
        },

        addPpiTemplate: function(tab) {
            this.lastTab = new PpiView({el: this.$("#n5-ui-ppi" + tab)});
            return this.lastTab;
        },

        addPriTemplate: function(tab) {
            this.lastTab = new PriView({el: this.$("#n5-ui-pri" + tab)});
            return this.lastTab;
        },

        addinBillTemplate: function(tab) {
            this.lastTab = new inBillView({el: this.$("n5-ui-inBill" + tab)});
            return this.lastTab;
        },

        events: {
            "click #checkTemplateData": "setData",
        },

        setData: function(){
            if(this.lastTab) {
                this.lastTab.setData();
            }

            //save individual data
            EventBus.trigger("save:SchemeDetailsView");
            EventBus.trigger("save:QualifyingConditionsView");

            this.model.set("schemeHeaderTemplate", schemeDetailsModel);
            this.model.set("slabTpls", SlabTabsInstance);
            this.model.set("ppiTpls", PpiCollectionInstance);
            this.model.set("priTpls", PriCollectionInstance);
            this.model.set("inBillTpls", inBillInstance);

            this.model.save(null, {
                success: function(model, response) {
                    app.loader.hideLoadingMessage();

                    native5.Notifications.show("Scheme saved successfully. Redirecting to Schemes page.", {
                        notificationType:"toast",
                        title:"Success",
                        position:"top",
                        distance:"50px",
                        persistent: true,
                        messageType: "success"
                    });

                    // console.log(model);
                    // console.log(response);

                    setTimeout(
                        function() {
                            window.location.href = "schemes?rand_token=" + encodeURIComponent(token);
                        },
                        2000
                    );
                },
                error: function(model, response) {
                    app.loader.hideLoadingMessage();

                    native5.Notifications.show("Unable to save scheme. Please retry.", {
                        notificationType:"toast",
                        title:"Error",
                        position:"top",
                        distance:"50px",
                        persistent: true,
                        messageType: "error"
                    });

                    // console.log(model);
                    // console.log(response);

                    // setTimeout(
                    //     function() {
                    //         window.location.href = "scheme?rand_token=" + encodeURIComponent(token);
                    //     },
                    //     2000
                    // );
                }
            });
        },

        remove: function() {}
    });

    var SlabTabsView = Backbone.View.extend({
        initialize: function(){
            this.model = new SlabTabModel();
            SlabTabsInstance.add(this.model);
            this.model.set('qcList', new QualifyingConditions());
        },

        render: function(slabTab, addTempLib) {
            var self = this;
            this.slabTab = slabTab;
            new akzo.ui.slabTemplate({"slabTab":slabTab, "tabInstance":addTempLib});

            $("#n5-ui-template-add-temp-qc .n5add").on("click", function() {
                if($("#n5-ui-slab" + slabTab).length > 0) {
                    self.setData();
                }
            });

            $("#t" + self.slabTab + " .fa-times").on("click", function() {
                // console.log("Inside delete model: t" + self.slabTab);
                SlabTabsInstance.remove(self.model);
            });

            $("#n5-ui-slab"+slabTab+" .add-condition").on("click", function() {
                var condition = self.addCondition();
                condition.render();
            });

            $("#n5-ui-slab"+slabTab+" .add-condition").one("click", function() {
                createSatisfyAllButton($("#n5-ui-slab"+slabTab+" .slab-qualifying-conditions .qualifying-conditions-list"), "slab");    
            });

            // this.setSatisfyAll();
        },

        addCondition: function(){
            var self = this;
            var QualifyingCondTemp = $("#n5-ui-template-qualCond-template").html().trim();
            var cloneqc = $(QualifyingCondTemp);
            var conditionInstance = $("#n5-ui-slab"+this.slabTab+" .slab-qualifying-conditions .qualifying-conditions-list").append($(cloneqc));
            return new QualifyingConditionView({ 
                el: $(".n5-template-qc-conditions",$(conditionInstance)).last(),
                model: new QualifyingCondition(),
                collection: self.model.attributes.qcList
            });
        },

        setData: function() {
            var self = this;

            var slabData = {
                id: "SLAB_" + self.slabTab,
                numSlabs: parseInt($("#n5-ui-slab" + self.slabTab + " #noofslabTextStr" + self.slabTab).val()),
                slabType: getType("#n5-ui-slab" + self.slabTab).toUpperCase() || "VOLUME",
                laps: self.getLaps(),
                packs: getPack($("#n5-ui-slab" + self.slabTab + " .n5-ui-sc-col .n5-ui-sc-col")[0]),
                products: getProducts($(".select2-choices", $("#n5-ui-slab" + self.slabTab))[0]),
            };
            self.model.set("id", "SLAB_TPL_" + self.slabTab);
            self.model.set("slabDnI", slabData);
            self.setSatisfyAll();
        },

        setSatisfyAll: function(){
            var satisfy = $(".slab-qualifying-conditions .satisfyAll").is(":checked");
            this.model.set("satisfyAll", satisfy);
        },

        getLaps: function() {
            var self = this;
            var retArr = [];
            var numLaps = parseInt($("#nooflapsTextStr" + this.slabTab, "#n5-ui-slab" + this.slabTab).val());
            var tbody = $("#n5-Q-cond-table-slab" + this.slabTab).find("table:nth-child(1)").find("tbody")[0];
            var rows = $(tbody).find("tr");
            for(var laps = 0; laps < numLaps; laps++) {
                var tempArr = [];

                var calendar = $("#n5-date-reservation-slab-table" + (laps + 1), "#n5-ui-slab" + self.slabTab);
                var startDate = getFormattedDate(new Date($(calendar).data('daterangepicker').startDate));
                var endDate = getFormattedDate(new Date($(calendar).data('daterangepicker').endDate));
                var period = {startDate: startDate, endDate: endDate};

                $.each(rows, function(key, row) {
                    var length = $(row).find("td").length;
                    var startTd = $(row).find("td")[0];
                    var endTd = $(row).find("td")[1];
                    var type = $(row).find("td")[length - 1];
                    var lapElm = $(row).find("td")[laps + 2];

                    var slabStartValue = $(startTd).find("input:nth-child(1)").val();
                    var slabEndValue = $(endTd).find("input:nth-child(1)").val();
                    var payoutValue = $(lapElm).find("input:nth-child(1)").val();
                    var payoutType = getPayoutType($(".n5-ui-sc-label-sub", $(type)).val());

                    tempArr.push({
                        id: "PAYOUT_" + (key + 1),
                        slabStartValue: slabStartValue,
                        slabEndValue: slabEndValue,
                        payoutValue: payoutValue,
                        payoutType: payoutType,
                    });
                });

                retArr.push({
                    id: "LAPS_" + (laps + 1),
                    period: period,
                    payouts: tempArr,
                });
            }            
            return retArr;
        },
    });

    var PpiView = Backbone.View.extend({
        initialize: function(){
            this.model = new PpiModel();
            PpiCollectionInstance.add(this.model);
            this.model.set('qcList', new QualifyingConditions());
        },

        render: function(ppiTab, addTempLib) {
            var self = this;
            this.ppiTab = ppiTab;
            new akzo.ui.ppiTemplate({"ppiTab":ppiTab, "tabInstance":addTempLib});

            $("#n5-ui-template-add-temp-qc .n5add").on("click", function() {
                if($("#n5-ui-ppi" + ppiTab).length > 0) {
                    self.setData();
                }
            });

            $("#t" + self.ppiTab + " .fa-times").on("click", function() {
                // console.log("Inside delete model: t" + self.ppiTab);
                SlabTabsInstance.remove(self.model);
            });

            $("#n5-ui-ppi"+ppiTab+" .add-condition").on("click", function() {
                var condition = self.addCondition();
                condition.render();
            });

            $("#n5-ui-ppi"+ppiTab+" .add-condition").one("click", function() {
                createSatisfyAllButton($("#n5-ui-ppi"+ppiTab+" .ppi-qualifying-conditions .qualifying-conditions-list"), "ppi");    
            });

        },
        addCondition: function(){
            var self = this;
            var QualifyingCondTemp = $("#n5-ui-template-qualCond-template").html().trim();
            var cloneqc = $(QualifyingCondTemp);
            var conditionInstance = $("#n5-ui-ppi"+this.ppiTab+" .ppi-qualifying-conditions .qualifying-conditions-list").append($(cloneqc));
            return new QualifyingConditionView({ 
                el: $(".n5-template-qc-conditions",$(conditionInstance)).last(),
                model: new QualifyingCondition(),
                collection: self.model.attributes.qcList
            });
        },

        setData: function() {
            var self = this;

            var calendar = $("#n5-date-reservation" + self.ppiTab, "#n5-ui-ppi" + self.ppiTab);
            var startDate = getFormattedDate(new Date($(calendar).data('daterangepicker').startDate));
            var endDate = getFormattedDate(new Date($(calendar).data('daterangepicker').endDate));
            var period = {startDate: startDate, endDate: endDate};

            var ppiData = {
                id: "PPI_" + self.ppiTab,
                period: period,
                numSlabs: parseInt($("#noofppiTextStr" + self.ppiTab, $("#n5-ui-ppi" + this.ppiTab)).val()),
                ppiType: (getType("#n5-ui-ppi" + self.ppiTab)).toUpperCase(),
                slabPayouts: self.getLaps(),
                packs: getPack($("#n5-ui-ppi" + self.ppiTab + " .n5-ui-sc-col .n5-ui-sc-col")[0]),
                products: getProducts($(".select2-choices", $("#n5-ui-ppi" + self.ppiTab))[0]),
            };

            self.model.set("id", "PPI_TPL_" + self.ppiTab);
            this.model.set("ppiDnI", ppiData);
            this.setSatisfyAll();
        },

        setSatisfyAll: function(){
            var satisfy = $(".ppi-qualifying-conditions .satisfyAll").is(":checked");
            this.model.set("satisfyAll", satisfy);
        },

        getLaps: function() {
            var retArr = [];
            var tbody = $("#n5-Q-cond-table-ppi" + this.ppiTab).find("table:nth-child(1)").find("tbody")[0];
            var rows = $(tbody).find("tr");

            $.each(rows, function(key, row) {
                var startTd = $(row).find("td")[0];
                var endTd = $(row).find("td")[1];
                var type = $(row).find("td")[3];
                var lapElm = $(row).find("td")[2];

                var slabStartValue = $(startTd).find("input:nth-child(1)").val();
                var slabEndValue = $(endTd).find("input:nth-child(1)").val();
                var payoutValue = $(lapElm).find("input:nth-child(1)").val();
                var payoutType = getPayoutType($(".n5-ui-sc-label-sub", $(type)).val());

                retArr.push({
                    id: "LAPS_" + (key + 1),
                    slabStartValue: slabStartValue,
                    slabEndValue: slabEndValue,
                    payoutValue: payoutValue,
                    payoutType: payoutType,
                });
            });
            
            return retArr;
        },
    });

    var PriView = Backbone.View.extend({
        initialize: function(){
            this.model = new PriModel();
            PriCollectionInstance.add(this.model);
            this.model.set('qcList', new QualifyingConditions());
        },

        render: function(priTab, addTempLib) {
            var self = this;
            this.priTab = priTab;
            new akzo.ui.priTemplate({"priTab":priTab, "tabInstance":addTempLib});

            $("#n5-ui-template-add-temp-qc .n5add").on("click", function() {
                if($("#n5-ui-pri" + priTab).length > 0) {
                    self.setData();
                }
            });

            $("#t" + self.priTab + " .fa-times").on("click", function() {
                // console.log("Inside delete model: t" + self.priTab);
                SlabTabsInstance.remove(self.model);
            });

            $("#n5-ui-pri"+priTab+" .add-condition").on("click", function() {
                var condition = self.addCondition();
                condition.render();
            });

            $("#n5-ui-pri"+priTab+" .add-condition").one("click", function() {
                createSatisfyAllButton($("#n5-ui-pri"+priTab+" .pri-qualifying-conditions .qualifying-conditions-list"), "pri");    
            });

        },

        addCondition: function(){
            var self = this;
            var QualifyingCondTemp = $("#n5-ui-template-qualCond-template").html().trim();
            var cloneqc = $(QualifyingCondTemp);
            var conditionInstance = $("#n5-ui-pri"+this.priTab+" .pri-qualifying-conditions .qualifying-conditions-list").append($(cloneqc));
            return new QualifyingConditionView({ 
                el: $(".n5-template-qc-conditions",$(conditionInstance)).last(),
                model: new QualifyingCondition(),
                collection: self.model.attributes.qcList
            });
        },

        setData: function() {
            var self = this;

            var calendar = $("#n5-date-reservation-pri" + self.priTab, "#n5-ui-pri" + self.priTab);
            var startDate = getFormattedDate(new Date($(calendar).data('daterangepicker').startDate));
            var endDate = getFormattedDate(new Date($(calendar).data('daterangepicker').endDate));
            var period = {startDate: startDate, endDate: endDate};
            var valVolElm = $(".input-val-vol", $("#n5-ui-pri" + self.priTab))[0];
            var valVolAmount = $(valVolElm).val();

            var priData = {
                id: "PPI_" + self.priTab,
                priProducts: getProductsPRI($(".select2-choices", $("#n5-ui-pri" + self.priTab))[0], valVolAmount),
                period: period,
                priPayouts: self.getLaps(),
            };

            self.model.set("id", "PRI_TPL_" + self.priTab);
            this.model.set("priDnI", priData);
            this.setSatisfyAll();
        },

        setSatisfyAll: function(){
            var satisfy = $(".pri-qualifying-conditions .satisfyAll").is(":checked");
            this.model.set("satisfyAll", satisfy);
        },

        getLaps: function() {
            var retArr = [];
            var tbody = $("#n5-Q-cond-table-pri" + this.priTab).find("table:nth-child(1)").find("tbody")[0];
            var rows = $(tbody).find("tr");

            $.each(rows, function(key, row) {
                var numProd = $(row).find("td")[0];
                var payRate = $(row).find("td")[1];
                var payoutTypeElm = $(row).find("td")[2];

                var numProducts = $(numProd).find("input:nth-child(1)").val();
                var payout = $(payRate).find("input:nth-child(1)").val();
                var payoutType = getPayoutType($(".n5-ui-sc-label-sub", $(payoutTypeElm)).val());

                retArr.push({
                    id: "LAPS_" + (key + 1),
                    numProducts: numProducts,
                    payoutValue: payout,
                    payoutType: payoutType,
                });
            });
            
            return retArr;
        },
    });

    var inBillView = Backbone.View.extend({
        initialize: function(){
            this.model = new inBillModel();
            inBillInstance.add(this.model);
        },

        render: function(inBillTab, addTempLib) {
            var self = this;
            self.inBillTab = inBillTab;
            new akzo.ui.inBillTemplate({"inBillTab":inBillTab, "tabInstance":addTempLib});

            $("#n5-ui-template-add-temp-qc .n5add").on("click", function() {
                if($("#n5-ui-inBill" + inBillTab).length > 0) {
                    self.setData();
                }
            });

            $("#t" + self.inBillTab + " .fa-times").on("click", function() {
                // console.log("Inside delete model: t" + self.inBillTab);
                SlabTabsInstance.remove(self.model);
            });

        },

        setData: function() {
            var self = this;

            var inBillData = {
                numProducts: parseInt($("#n5-ui-inBill" + self.inBillTab + " #noofslabsTextStr-inBill" + this.inBillTab).val()),
                // priType: "Value",
                inBillPayouts: self.getLaps(),
            };

            self.model.set("id", "inBill_TPL_" + self.inBillTab);
            this.model.set("inBillDnI", inBillData);
            // console.log(this.model.toJSON());
        },

        getLaps: function() {
            var self = this;
            var retArr = [];
            var numLaps = parseInt($("#nooflapsTextStr-inBill" + this.inBillTab, "#n5-ui-inBill" + this.inBillTab).val());
            var tbody = $("#n5-Q-cond-table-inBill" + this.inBillTab).find("table:nth-child(1)").find("tbody")[0];
            var rows = $(tbody).find("tr");

            for(var laps = 0; laps < numLaps; laps++) {
                var tempArr = [];

                var calendar = $("#n5-date-reservation-inBill-table" + (laps + 1), "#n5-ui-inBill" + self.inBillTab);
                var startDate = getFormattedDate(new Date($(calendar).data('daterangepicker').startDate));
                var endDate = getFormattedDate(new Date($(calendar).data('daterangepicker').endDate));
                var period = {startDate: startDate, endDate: endDate};
                
                $.each(rows, function(key, row) {
                    var length = $(row).find("td").length;
                    var ProductElm = $(row).find("td")[0];
                    var payoutElm = $(row).find("td")[length - 2];
                    var productTypeElm = $(row).find("td")[length - 1];
                    var lapElm = $(row).find("td")[key + 1];

                    var products = getProducts($('.select2-choices', $(ProductElm))); // Should be correct select2 value
                    var payoutType = getPayoutType($(".n5-ui-sc-label-sub", $(payoutElm)).val());
                    var lapRate = $(lapElm).find("input:nth-child(1)").val();
                    var productType = getPack($(productTypeElm).children("span")[0]);

                    tempArr.push({
                        id: "PAYOUT_" + (key + 1),
                        products: products,
                        payoutType: payoutType,
                        lapRate: lapRate,
                        productType: productType,
                    });
                });

                retArr.push({
                    id: "LAPS_" + (laps + 1),
                    period: period,
                    payouts: tempArr,
                });
            }            
            return retArr;
        },
    });

    function getProductsPRI(elm, val) {
        var retArr = [];
        var productLists = $(elm).find("[data-product]");

        $.each(productLists, function() {
            var tempObj = {};
            tempObj.product = $(this).data("product");
            tempObj.value = val;

            retArr.push(tempObj);
        });

        return retArr;
    }

    function getProducts(elm) {
        var retArr = [];
        var productLists = $(elm).find("[data-product]");

        $.each(productLists, function() {
            retArr.push($(this).data("product"));
        });

        return retArr;
    }

    function getType(elmStr) {
        var retVal;
        $.each($(".n5-radio-toolbar", $(elmStr)).children("input"), function() {
            if($(this).is(":checked")) {
                retVal = $(this).val();
                return false;
            }
        });

        return retVal;
    }

    function getPack(elm) {
        var retArr = [];

        var inputs = $(elm).find("input");

        if($(inputs[0]).is(":checked")) {
            retArr.push("BULK");
        }
        if($(inputs[1]).is(":checked")) {
            retArr.push("RETAIL");
        }

        return retArr;
    }
    
    function getPayoutType(type) {
        if(type.toLowerCase() === "abs amount") {
            return "FLATPAYOUT";
        } else if(type.toLowerCase() === "gift") {
            return "GIFT";
        } else {
            return "RSPERLITRE";
        }
    }

    function getFormattedDate(input){
        var m_names = new Array("Jan", "Feb", "Mar", 
        "Apr", "May", "Jun", "Jul", "Aug", "Sep", 
        "Oct", "Nov", "Dec");
        var curr_date = input.getDate();
        var curr_month = input.getMonth();
        var curr_year = input.getFullYear();
        return (curr_date + "-" + m_names[curr_month] + "-" + curr_year);
    }


    function createSatisfyAllButton(elm, str) {
        elm.prepend('<div class="n5-radio-toolbar n5-tab-radio" align = "right"><input type="radio" id="item-'+str+'" name="satisfyAll" class = "satisfyAll" value="false" checked><label for="item-'+str+'">Satisfy All</label><input type="radio" name="satisfyAll" id="item1-'+str+'" class = "satisfyOne" value="true"><label for="item1-'+str+'">Satisfy Any One</label></div>');
    }

    var token = getParameterByName("rand_token");

    var SlabTabModel = Backbone.Model.extend({});
    var PpiModel = Backbone.Model.extend({});
    var PriModel = Backbone.Model.extend({});
    var inBillModel = Backbone.Model.extend({});
    var SchemeDetails = Backbone.Model.extend({});
    var QualifyingCondition = Backbone.Model.extend({});
    // var TempModel = Backbone.Model.extend({});

    var SchemeModel = Backbone.Model.extend({
        url: "template/save?rand_token=" + encodeURIComponent(token)
    });

    var QualifyingConditions = Backbone.Collection.extend({
        model: QualifyingCondition
    });

    var SlabTabsCollection = Backbone.Collection.extend({
        model: SlabTabModel,
    });

    var PpiCollection = Backbone.Collection.extend({
        model: PpiModel,
    });

    var PriCollection = Backbone.Collection.extend({
        model: PriModel,
    });

    var inBillCollection = Backbone.Collection.extend({
        model: inBillModel,
    });

    var SlabTabsInstance = new SlabTabsCollection();
    var PpiCollectionInstance = new PpiCollection();
    var PriCollectionInstance = new PriCollection();
    var inBillInstance = new inBillCollection();
    var QCcollection = new QualifyingConditions();
    var schemeDetailsModel = new SchemeDetails();

    $(document).ready(function(){
        showSchemeDetails();
        showqualifyingConditions();
        var template = new TemplatesView();
        template.render();
    });


}(_, jQuery, akzo, native5, Backbone));
