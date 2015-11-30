/*jshint loopfunc: true, quotmark:false */
/* global jQuery, native5, $, jsPDF, defaultStates, model, service, response, Modernizr, Placeholders, createCard */
var app = (function ($, app) {
    "use strict";

    var schemeState = $("#modelDetails").data("state");
    if (schemeState == defaultStates.staged) {
        $("#sendTemplateData").hide();
        $("#checkTemplateData").text("Save Updated Scheme").data("target", "update");
        $("#updateTemplateData").text("Initiate Scheme").data("target", "initiate");
    }
    else if (schemeState == defaultStates.updateRequested) {
        $("#sendTemplateData").hide();
        $("#checkTemplateData").text("Update Scheme").data("target", "update");
        $("#updateTemplateData").text("Initiate Scheme").data("target", "initiate");
    }
    else if (schemeState == defaultStates.initiated) {
        $("#sendTemplateData").hide();
        $("#checkTemplateData").text("Send for Approval").data("target", "review");
        $("#updateTemplateData").text("Request Update").data("target", "requestUpdate");
    }
    else if (schemeState == defaultStates.reviewed) {
        $("#checkTemplateData").text("Approve Scheme").data("target", "approve");
        $("#updateTemplateData").text("Request Update").data("target", "requestUpdate");
        $("#sendTemplateData").text("Request Review").data("target", "requestReview");
    }
    else {
        $("#sendTemplateData").hide();
        $("#checkTemplateData").text("Save as Draft").data("target", "stage");
        $("#updateTemplateData").text("Initiate Scheme").data("target", "initiate");
    }
    $(".page-footer.page-buttons").css("display","block");

    var commentModal = new native5.ui.modal({"top":200});
    commentModal.render({"modalElm":"#n5-comment-popup"});

    app.loader = new native5.ui.Loader({style: "gif"});
    app.loader.render();

    $(".page-scheme-submit").off("click");
    $(".page-scheme-submit").on("click",function(){
        var urlTarget = $(this).data("target");
        var url = window.absPath + "/template/"+urlTarget+"?rand_token=" + encodeURIComponent(model.token);

        commentModal.showModal();
        $("#n5-comment-submit").off("click");
        $("#n5-comment-submit").on("click", function() {
            commentModal.closeModal();
            var data = {
                comment: $("#n5-comment-box").val(),
                schemeCode: $("#modelDetails").data("id")
            };
            service.invoke({
                serviceURL: url, 
                invokeData: data, 
                successHandler: function(response){
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
                        native5.Notifications.show("Your request was processed successfully.", {
                            notificationType:"toast",
                            title:"Success",
                            position:"top",
                            distance:"50px",
                            persistent: true,
                            messageType: "success"
                        });

                        setTimeout(
                            function() {
                                window.location.href = window.absPath + "/myschemes?rand_token=" + encodeURIComponent(model.token);
                            },
                            2000
                        );
                    }

                        
                }, 
                errorHandler: function(){
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
                        native5.Notifications.show("Error processing request. Kindly try again later.", {
                            notificationType:"toast",
                            title:"Error",
                            position:"top",
                            distance:"50px",
                            persistent: false,
                            messageType: "error"
                        });

                        setTimeout(
                            function() {
                                window.location.href = window.absPath + "/myschemes?rand_token=" + encodeURIComponent(model.token);
                            },
                            2000
                        );
                    }
                       
                }
            });
            app.loader.showLoadingMessage({blocking: true});
        });
    });

    $("#editApprovedScheme").off("click");
    $("#editApprovedScheme").on("click",function(){
        var url = window.absPath + "/template/requestApprovedUpdate";
        var schemeCode = $("#modelDetails").data("id");

        commentModal.showModal();
        $("#n5-comment-submit").off("click");
        $("#n5-comment-submit").on("click", function() {
            commentModal.closeModal();
            var data = {
                comment: $("#n5-comment-box").val(),
                schemeCode: schemeCode
            };
            service.invoke({
                serviceURL: url, 
                invokeData: data, 
                successHandler: function(response){
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
                        native5.Notifications.show("Your request was processed successfully.", {
                            notificationType:"toast",
                            title:"Success",
                            position:"top",
                            distance:"50px",
                            persistent: true,
                            messageType: "success"
                        });

                        setTimeout(
                            function() {
                                window.location.href = window.absPath + "/template?schemeId="+schemeCode+"&rand_token=" + encodeURIComponent(model.token);
                            },
                            2000
                        );
                    }

                }, 
                errorHandler: function(){
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
                        native5.Notifications.show("Error processing request. Kindly try again later.", {
                            notificationType:"toast",
                            title:"Error",
                            position:"top",
                            distance:"50px",
                            persistent: false,
                            messageType: "error"
                        });
                    }
                       
                }
            });
            app.loader.showLoadingMessage({blocking: true});
        });
    });

    return app;
}(jQuery, app || {}));


$(document).ready(function() {
    Modernizr.load({
        test: Modernizr.input.placeholder,
        nope: '//cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js',
        complete: function() {
            if (typeof Placeholders !== "undefined" && Placeholders !== null) {
                return Placeholders.enable();
            }
        }
    });
    createCard($(".scheme-details-container"), "schemeDetailsCard", "Scheme Details", "fa-list-alt", "100%");
    createCard($(".scheme-qc-container"), "schemeQCCard", "Qualifying Conditions", "fa-list-alt", "100%");
    // createCard($("#schemes-pending-approval"), "schemesPendingApprovalCard", "Schemes Pending Approval", "fa-list-alt", "100%");
    // createCard($("#draft-schemes"), "draftSchemesCard", "Draft Schemes", "fa-list-alt", "100%");
    
    
    /* PDF code starts */
    $('#schemePDF').on("click", function() {
        // var html = document.documentElement.outerHTML;
        // var finalHtml = stripScripts(html);
        var schemeId = $("#modelDetails").data("id");
        var data = {
            schemeId: schemeId
        };

        var PDFService = service.invoke({serviceURL: "scheme/generatePDF", invokeData: data});

        PDFService.done(function(data) {
            var PdfPath = data.message.pdfPath;
            window.location.href = PdfPath;
            // console.log(PdfPath);
            // window.open(PdfPath);
        });
    });

    /*function stripScripts(inputStr) {
        var div = document.createElement('div');
        div.innerHTML = inputStr;
        var scripts = div.getElementsByTagName('script');
        var scriptsLen = scripts.length;

        while (scriptsLen--) {
            scripts[scriptsLen].parentNode.removeChild(scripts[scriptsLen]);
        }

        var cssTag = "<style type='text/css'>" + getPageCSS() + "</style>";

        $(div).prepend(cssTag);

        return div.innerHTML;
    }

    function getPageCSS() {
        var cssRules = "";
        $(document.styleSheets[0].cssRules).each(function() {
            cssRules += this.cssText;
        });

        return cssRules;
    }*/
    /* PDF code ends */
});


