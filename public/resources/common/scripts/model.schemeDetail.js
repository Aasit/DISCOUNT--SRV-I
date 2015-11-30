/*jshint loopfunc: true, quotmark: false */
/* global _, jQuery, akzo, native5, Backbone, moment, createCard, model */
(function (_, $, akzo, native5, Backbone, model) {
    "use strict";

    var SchemeDetailsView = Backbone.View.extend({
        el: "#scheme-details",
        initialize: function(){
            this.model = model.schemeDetailsModel;
            model.schemeDetailsModel.set("qcList", model.QCcollection);
            model.EventBus.on("save:SchemeDetailsView",this.setData, this);
            model.EventBus.on("validate:SchemeDetailsView",this.validate, this);
        },
        template : _.template($('#schemeHeader').html()),
        render: function(){
            //render select dropdowns
            $(this.el).append(this.template(this.model.toJSON()));
            model.renderDropdown(this.$("#n5-scheme-type .n5-schemetype-select"), "", "select-dropdown");
            model.renderDropdown(this.$("#n5-dealers-attribute .n5-dealers-select"), "Dealer's Attributes", "select-dropdown");
            model.renderSegmentDropdown(this.$("#n5-segment-type .n5-segment-select"), "Select Segment", "select-dropdown");
            //render datepickers
            
            // moment(this.model.toJSON().schemeHeader.startDate).format('DD-MM-YYYY')
            model.applyDaterangepicker(this.$("#sales-period"));

            //render select2
             model.generateProductSelectOnclick($(".geography-select", "#n5-sales-geography"), "geography");
            if(typeof this.model.toJSON().schemeHeader !== "undefined") {
                this.$('#sales-period').data('daterangepicker').setStartDate(moment(this.model.toJSON().schemeHeader.startDate, "DD-MMM-YYYY"));
                this.$('#sales-period').data('daterangepicker').setEndDate(moment(this.model.toJSON().schemeHeader.endDate, "DD-MMM-YYYY"));
                this.$('#sales-period').data('daterangepicker').clickApply();
                $(".geography-select", "#n5-sales-geography").data("products", this.model.toJSON().schemeHeader.salesGeography);
                model.dealerAttrCollection.add(
                    this.model.toJSON().schemeHeader.dealerAttributes
                );
            }
            createCard($("#scheme-details"), "schemeDetailsCard", "Scheme Details", "fa-list-alt");  

            //manual validation
            model.validateTextbox(this.$(".scheme-name"));
            model.validateDatepicker(this.$("#sales-period"));
            model.validateSelect(this.$(".sales-geo-select"));

            this.$(".dealer-attr-button").click(function(){
                window.dealerAttrModal.showModal();
            });
        },     
          // handle the "click" of the "#save" button
        setData: function(){
            var schemeData = {
                id: $("#modelDetails").data("id"),
                name: this.$(".scheme-name").val(),
                type: this.$(".n5-schemetype-select").select2("data").text,
                segment: this.$(".n5-segment-select").select2("val"),
                description: this.$(".scheme-name").val(),
                startDate: model.getFormattedDate(new Date(this.$("#sales-period").data("daterangepicker").startDate)),
                endDate: model.getFormattedDate(new Date(this.$("#sales-period").data("daterangepicker").endDate)),
                dealerAttributes: model.dealerAttrCollection.toJSON(),
                salesGeography: $(".geography-select", "#n5-sales-geography").data("products"),
                terms: this.$('.input-terms-conditions').val()
            };
            var id = $("#modelDetails").data("id");
            model.schemeDetailsModel.set("id", id);
            model.schemeDetailsModel.set("schemeHeader", schemeData);
        },
        validate: function(){
            model.validateTextboxEvent(this.$(".scheme-name"));
            model.validateSelectEvent(this.$(".sales-geo-select"));
        }
    });

    $(document).ready(function() {
        window.schemeDV = new SchemeDetailsView();
        schemeDV.render();
        window.dealerAttrModal = new native5.ui.modal({
            "top":50,
            closeCallback: function(){
                schemeDV.setData();
            }
        }); 
        window.dealerAttrModal.render({"modalElm":"#n5-dealer-attr-popup"});
        model.dealerAttrRun();
    });
    
    // return model;
}(_, jQuery, akzo, native5, Backbone, model));
