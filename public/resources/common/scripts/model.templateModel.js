/*jshint loopfunc: true, quotmark: false */
/* global _, jQuery, akzo, native5, Backbone, app, model */
(function (_, $, akzo, native5, Backbone, schemeModel) {
    "use strict";
    var cidTemplate = null;
    var TemplatesView = Backbone.View.extend({
        el: "#n5-ui-template-add-temp-qc",

        initialize: function(){
            this.model = new schemeModel.SchemeModel();
            /*BIKAS: Uncomment the following code to wrap the scheme data in model. So, one has to read scheme from $.POST["model"] */
            // Backbone.emulateJSON = true;
        },

        render: function(obj){
            var self = this;
            var addTempOpts = {
                "tabStyle" : "white",
                "backgroundStyle" : "transparent",
                "addIcon"   : "fa fa-plus fa-lg"
            };
            self.tabs = [];

            var addTempLib = new native5.ui.tab(addTempOpts);
            addTempLib.render($("#n5-ui-template-add-temp-qc"));
            addTempLib.setDefaultContent('<div style="text-align:center;padding:10px;"><h3 style="margin-top:0px">Click on Add Button to Add a Template</h3></div>');
            addTempLib.setPlusEvent(plusEventhandle);
            var modal = new native5.ui.modal({"top":200}); 
            modal.render({"modalElm":"#n5-template-popup"});
            var commentModal = new native5.ui.modal({"top":200});
            commentModal.render({"modalElm":"#n5-comment-popup"});
            $(".modal_close").click(function() {
                modal.closeModal();
                commentModal.closeModal();
            });

            $("#listTemplate").select2();
            $("#copiesTemplate").select2();
            
            function plusEventhandle() {
                $(".template-list").hide();
                modal.showModal();
            }

            var inBillTab = 0;
            $("#n5-ui-template-modal-inBill").on('click', function(){
                inBillTab++;
                modal.closeModal();
                var inBillTmpl = self.addinBillTemplate(inBillTab);
                inBillTmpl.render(inBillTab, addTempLib);
            });

            var newSlabTab = 0;
            $("#n5-ui-template-modal-newSlab").on('click', function(){
                newSlabTab++;
                modal.closeModal();
                var newSlabTmpl = self.addnewSlabTemplate(newSlabTab);
                newSlabTmpl.render(newSlabTab, addTempLib);
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

            var newPpiTab = 0;
            $("#n5-ui-template-modal-newPpi").on('click', function(){
                newPpiTab++;
                modal.closeModal();
                var newPpiTmpl = self.addNewPpiTemplate(newPpiTab);
                newPpiTmpl.render(newPpiTab, addTempLib);
            });

            var slabTab = 0;
            $("#n5-ui-template-modal-slab").on('click', function() {
                slabTab++;
                modal.closeModal();
                var slabTmpl = self.addSlabTemplate(slabTab);
                slabTmpl.render(slabTab, addTempLib);
            });

            var slabV3Tab = 0;
            $("#n5-ui-template-modal-slabv3").on('click', function() {
                slabV3Tab++;
                modal.closeModal();
                var slabV3Tmpl = self.addSlabV3Template(slabV3Tab);
                slabV3Tmpl.render(slabV3Tab, addTempLib);
            });

            $("#copyTemplate").on('click', function() {
                var templates = $("#n5tabul .n5ntabs span:first-child");
                var options = "<option>Select Template ..</option>";
                $.each(templates, function(key, value) {
                    options += "<option>" + $(value).text() + "</option>";
                });
                $("#listTemplate").html(options);
                $(".template-list").toggle();
            });

            $("#copyTemplateAction").on("click", function() {
                var i = 0;
                var templateParts = $("#listTemplate").val().split("_");
                var templateCount = parseInt($("#copiesTemplate").val());
                var templateNumber = parseInt(templateParts[1]) - 1;
                if(templateParts.length === 2) {
                    if(templateParts[0] === "inBill") {
                        for(i = 0; i < templateCount; i++) {
                            inBillTab++;
                            var inBillTmpl = self.addinBillTemplate(inBillTab);
                            inBillTmpl.render(inBillTab, addTempLib, model.inBillInstance.toJSON()[templateNumber]);
                        }
                    }
                    if(templateParts[0] === "newSlab") {
                        for(i = 0; i < templateCount; i++) {
                            newSlabTab++;
                            var newSlabTmpl = self.addnewSlabTemplate(newSlabTab);
                            newSlabTmpl.render(newSlabTab, addTempLib, model.newSlabInstance.toJSON()[templateNumber]);
                        }
                    }
                    if(templateParts[0] === "PPI") {
                        for(i = 0; i < templateCount; i++) {
                            ppiTab++;
                            var ppiTmpl = self.addPpiTemplate(ppiTab);
                            ppiTmpl.render(ppiTab, addTempLib, model.PpiCollectionInstance.toJSON()[templateNumber]);
                        }
                    }
                    if(templateParts[0] === "NEWPPI") {
                        for(i = 0; i < templateCount; i++) {
                            newPpiTab++;
                            var newPpiTmpl = self.addNewPpiTemplate(newPpiTab);
                            newPpiTmpl.render(newPpiTab, addTempLib, model.PpiCollectionInstance.toJSON()[templateNumber]);
                        }
                    }
                    if(templateParts[0] === "PRI") {
                        for(i = 0; i < templateCount; i++) {
                            priTab++;
                            var priTmpl = self.addPriTemplate(priTab);
                            priTmpl.render(priTab, addTempLib, model.PriCollectionInstance.toJSON()[templateNumber]);
                        }
                    }
                    if(templateParts[0] === "SLAB") {
                        for(i = 0; i < templateCount; i++) {
                            slabTab++;
                            var slabTmpl = self.addSlabTemplate(slabTab);
                            slabTmpl.render(slabTab, addTempLib, model.SlabTabsInstance.toJSON()[templateNumber]);
                        }
                    }
                    if(templateParts[0] === "SLABV3") {
                        for(i = 0; i < templateCount; i++) {
                            slabV3Tab++;
                            var slabV3Tmpl = self.addSlabV3Template(slabV3Tab);
                            slabV3Tmpl.render(slabV3Tab, addTempLib, model.SlabV3TabsInstance.toJSON()[templateNumber]);
                        }
                    }
                }
                modal.closeModal();
            });

            if(obj && $.type(obj) === "string") {
                obj = $.parseJSON(obj);
            }

            if(!$.isEmptyObject(obj)) {
                if(!$.isEmptyObject(obj.inBillTplsRO)) {
                    $.each(obj.inBillTplsRO, function(key, value) {
                        inBillTab = ++key;
                        var inBillTmpl = self.addinBillTemplate(inBillTab);
                        inBillTmpl.render(inBillTab, addTempLib, value);
                    });
                }

                if(!$.isEmptyObject(obj.slabV2Tpls)) {
                    $.each(obj.slabV2Tpls, function(key, value) {
                        newSlabTab = ++key;
                        var newSlabTmpl = self.addnewSlabTemplate(newSlabTab);
                        newSlabTmpl.render(newSlabTab, addTempLib, value);
                    });
                }

                if(!$.isEmptyObject(obj.ppiTpls)) {
                    $.each(obj.ppiTpls, function(key, value) {
                        if(value.ppiDnI.repeatData && value.ppiDnI.repeatData.rowRepeat) {
                            newPpiTab++;
                            var newPpiTmpl = self.addNewPpiTemplate(newPpiTab);
                            newPpiTmpl.render(newPpiTab, addTempLib, value);
                        } else {
                            ppiTab++;
                            var ppiTmpl = self.addPpiTemplate(ppiTab);
                            ppiTmpl.render(ppiTab, addTempLib, value);
                        }
                    });
                }

                if(!$.isEmptyObject(obj.priTpls)) {
                    $.each(obj.priTpls, function(key, value) {
                        priTab = ++key;
                        var priTmpl = self.addPriTemplate(priTab);
                        priTmpl.render(priTab, addTempLib, value);
                    });
                }

                if(!$.isEmptyObject(obj.slabTpls)) {
                    $.each(obj.slabTpls, function(key, value) {
                        slabTab = ++key;
                        var slabTmpl = self.addSlabTemplate(slabTab);
                        slabTmpl.render(slabTab, addTempLib, value);
                    });
                }

                if(!$.isEmptyObject(obj.slabV3Tpls)) {
                    $.each(obj.slabV3Tpls, function(key, value) {
                        slabV3Tab = ++key;
                        var slabV3Tmpl = self.addSlabV3Template(slabV3Tab);
                        slabV3Tmpl.render(slabV3Tab, addTempLib, value);
                    });
                }
            }
            
            $(".page-scheme-submit").on("click",function(){
                self.setData(commentModal,this);
            });
        },

        validateTemplatePresent: function(){
            if($("#n5tabul").children("li").length <= 1) {
                model.errorInstance.push(
                    {id: "noTemplatePresent"}
                );
                cidTemplate = model.errorInstance.models[model.errorInstance.length - 1].cid;
                $("#n5tabul").css("border", "1px solid red");
                $("#n5tabul").addClass("error-tooltip input");
                $("#n5tabul").attr("tip-title", "Add atleast one template");
            }
            else {
                if(cidTemplate){
                    model.errorInstance.remove(cidTemplate);
                }
                $("#n5tabul").css("border", "none");
                $("#n5tabul").removeClass("error-tooltip");
            }
            $(".n5add").bind("click", function(){
                if(cidTemplate){
                    model.errorInstance.remove(cidTemplate);
                }
                $("#n5tabul").css("border", "none");
                $("#n5tabul").removeClass("error-tooltip input");
            });
                
        },

        addSlabTemplate: function(tab) {
            var lastTab = new schemeModel.SlabTabsView({el: this.$("#n5-ui-slab" + tab)});
            this.tabs.push(lastTab);
            return lastTab;
        },

        addSlabV3Template: function(tab) {
            var lastTab = new schemeModel.SlabV3TabsView({el: this.$("#n5-ui-slabV3" + tab)});
            this.tabs.push(lastTab);
            return lastTab;
        },

        addPpiTemplate: function(tab) {
            var lastTab = new schemeModel.PpiView({el: this.$("#n5-ui-ppi" + tab)});
            this.tabs.push(lastTab);
            return lastTab;
        },

        addNewPpiTemplate: function(tab) {
            var lastTab = new schemeModel.newPpiView({el: this.$("#n5-ui-newPpi" + tab)});
            this.tabs.push(lastTab);
            return lastTab;
        },

        addPriTemplate: function(tab) {
            var lastTab = new schemeModel.PriView({el: this.$("#n5-ui-pri" + tab)});
            this.tabs.push(lastTab);
            return lastTab;
        },

        addinBillTemplate: function(tab) {
            var lastTab = new schemeModel.inBillView({el: this.$("n5-ui-inBill" + tab)});
            this.tabs.push(lastTab);
            return lastTab;
        },

        addnewSlabTemplate: function(tab) {
            var lastTab = new schemeModel.newSlabView({el: this.$("n5-ui-newSlab" + tab)});
            this.tabs.push(lastTab);
            return lastTab;
        },

        setData: function(commentModal, elm) {
            var self = this;
            if(this.tabs.length > 0) {
                $.each(this.tabs, function(key, val) {
                    var idParts = val.$el.selector.split(" ");
                    var tabElement = idParts[idParts.length - 1];
                    if(tabElement.charAt(0) == "#") {
                        if($(tabElement).length > 0) {
                            val.setData();
                        }
                    }
                    else {
                        if($("#" + tabElement).length > 0) {
                            val.setData();
                        }
                    }
                });
            }

            //save individual data
            schemeModel.EventBus.trigger("save:SchemeDetailsView");
            schemeModel.EventBus.trigger("save:QualifyingConditionsView");

            this.model.set("schemeHeaderTemplate", schemeModel.schemeDetailsModel);
            this.model.set("slabTpls", schemeModel.SlabTabsInstance);
            this.model.set("slabV3Tpls", schemeModel.SlabV3TabsInstance);
            this.model.set("ppiTpls", schemeModel.PpiCollectionInstance);
            // this.model.set("newPpiTpls", schemeModel.newPpiCollectionInstance);
            this.model.set("priTpls", schemeModel.PriCollectionInstance);
            this.model.set("inBillTplsRO", schemeModel.inBillInstance);
            this.model.set("slabV2Tpls", schemeModel.newSlabInstance);

            schemeModel.EventBus.trigger("validate:SchemeDetailsView");
            schemeModel.EventBus.trigger("validate:QCView");
            self.validateTemplatePresent();
            var url = $(elm).data("target");
            if(model.errorInstance.length === 0) {
                if(url == "stage" || url == "update") {
                    self.saveScheme(url);
                    app.loader.showLoadingMessage({blocking: true});
                }
                else{
                    commentModal.showModal();
                    $("#n5-comment-submit").on("click", function() {
                        commentModal.closeModal();
                        var commentData = {
                            comment: $("#n5-comment-box").val()
                        };
                        self.saveScheme(url, commentData);
                        app.loader.showLoadingMessage({blocking: true});
                    });
                }
            }
            else {
                native5.Notifications.show("There are errors in your Scheme, Kindly fix them before submitting.", {
                    notificationType:"toast",
                    title:"Error",
                    position:"top",
                    distance:"50px",
                    persistent: false,
                    messageType: "error"
                });
                return false;
            }            
        },

        remove: function() {},

        saveScheme: function(url, commentData){
            this.model.url = window.absPath + "/template/"+url+"?rand_token=" + encodeURIComponent(model.token);
            this.model.save(commentData, {
                /*jshint unused: false*/
                success: function(model, response) {
                    app.loader.hideLoadingMessage();

                    if(response.message && response.message.__redirect) {
                        var path = response.message.__redirect;

                        native5.Notifications.show("You've been logged out. Redirecting to: " + path, {
                            notificationType:"toast",
                            title:"Error",
                            position:"top",
                            distance:"50px",
                            persistent: true,
                            messageType: "error"
                        });

                        setTimeout(
                            function() {
                                window.location.href = window.absPath + "/" + path;
                                native5.Notifications.hide();
                            },
                            2000
                        );
                    } else {
                        native5.Notifications.show("Scheme saved successfully. Redirecting to Schemes page.", {
                            notificationType:"toast",
                            title:"Success",
                            position:"top",
                            distance:"50px",
                            persistent: true,
                            messageType: "success"
                        });

                        setTimeout(
                            function() {
                                window.location.href = window.absPath + "/myschemes?rand_token=" + encodeURIComponent(schemeModel.token);
                            },
                            2000
                        );
                    }
                },
                error: function(model, response) {
                    app.loader.hideLoadingMessage();

                    if(response.message && response.message.__redirect) {
                        var path = response.message.__redirect;

                        native5.Notifications.show("You've been logged out. Redirecting to: " + path, {
                            notificationType:"toast",
                            title:"Error",
                            position:"top",
                            distance:"50px",
                            persistent: true,
                            messageType: "error"
                        });

                        setTimeout(
                            function() {
                                window.location.href = window.absPath + "/" + path;
                                native5.Notifications.hide();
                            },
                            2000
                        );
                    } else {
                        native5.Notifications.show("Unable to save scheme. Please retry.", {
                            notificationType:"toast",
                            title:"Error",
                            position:"top",
                            distance:"50px",
                            persistent: true,
                            messageType: "error"
                        });

                        setTimeout(
                            function() {
                                // window.location.href = "scheme?rand_token=" + encodeURIComponent(token);
                                native5.Notifications.hide();
                            },
                            2000
                        );
                    }
                }
            });
        }
    });
    
    $(document).ready(function(){
        var template = new TemplatesView();
        template.render(model.existingSchemeData);
    });
}(_, jQuery, akzo, native5, Backbone, model));
