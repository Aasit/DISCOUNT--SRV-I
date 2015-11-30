/*jshint loopfunc: true, quotmark: false */
/* global _, jQuery, akzo, native5, Backbone, createCard, model */
(function (_, $, akzo, native5, Backbone, schemeModel) {
    "use strict";

    var QualifyingConditionsView = Backbone.View.extend({
        el: "#qualifying-conditions",
        initialize: function(){
            schemeModel.EventBus.on("save:QualifyingConditionsView",this.setData, this);
            this.QCIndex = 0;
        },
        render: function(){
            var that = this;

            schemeModel.QCcollection.each(function(model){
                var condition = that.addCondition(model);
                condition.render();
            });
            $("#n5-add-Q-conditions .qc-add-condition").on("click", function() {
                var condition = that.addCondition();
                condition.render();
            });
            $("#n5-add-Q-conditions .qc-add-condition").one("click", function() {
                $("#qualifying-conditions .qc-satisfy-container").css("height", "40px");
            });
            createCard($("#qualifying-conditions"), "qualifyingConditionsCard", "Qualifying Conditions", "fa-suitcase");
        },
        // events: {
        //     "click #seeCollection": "setData",
        // },  
        addCondition: function(model){
            $("#n5-qc-list").append('<span class = "qc-wrapper"><span>');
            this.QCIndex++;
            return new schemeModel.QualifyingConditionView({ 
                el: $(".qc-wrapper",$("#n5-qc-list")).last(),
                model: model || new schemeModel.QualifyingCondition({
                    "name":"HISTORICAL",
                    "type":"VALUE",
                    "op":"GREATER_THAN_EQUALS",
                    "val":"",
                    "payoutCondition":"",
                    "qid": "DEFAULT_QC"+(this.QCIndex+1)
                }),
                collection: schemeModel.QCcollection
            });
            
        },
          // handle the "click" of the "#save" button
        setData: function(){
            var satisfyAll = this.$(".satisfyAll").is(":checked");
            schemeModel.schemeDetailsModel.set("satisfyAll", satisfyAll);
            // console.log(QCcollection);
        }
    });

    $(document).ready(function(){
        var qconditionView = new QualifyingConditionsView();
        qconditionView.render();
    });

}(_, jQuery, akzo, native5, Backbone, model));