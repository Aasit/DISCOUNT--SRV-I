/* jshint loopfunc: true, quotmark:false */
/* global jQuery:false */
var native5 = (function ($, native5) {
    "use strict";

    native5.ui = native5.ui || {};
    native5.ui.card = function(options) {
        var self = this;
        this.contentElement = $(options.contentElm);
        this.elmId = options.cardId || "card" + Math.floor((Math.random() * 1000) + 1);
        this.height = options.height || this.contentElement.height();
        this.width = options.width || this.contentElement.width();
        this.title = options.title || "";
        this.collapsed = options.collapsed || false;
        this.theme    = "n5-card-" + options.theme || "n5-card-blue";
        this._devicewidth = $(window).width();
        this._textLength = 25;
    };

    var cardPrototype = native5.ui.card.prototype;
    cardPrototype.init = function() {
        this.container = $("<div>").addClass("n5-card " + this.theme).attr("id", this.elmId);
        this.headerCont = $("<div>").addClass("n5-card-header");
        this.headerBarCont = $("<h2>");
        this.headerIcon = $("<span>");
        this.headerBarCont.append(this.headerIcon);
        this.headerTitle = $("<span>").addClass("n5-card-title");
        this.headerBarCont.append(this.headerTitle);
        this.boxLeftIcons = $("<div>").addClass("n5-card-icon");
        this.headerMinBtn = $("<span>").addClass("n5-card-toggleIcon fa fa-chevron-up");
        this.headerCloseBtn = $("<span>").addClass("n5-card-closeIcon fa fa-times");
        this.boxLeftIcons.append(this.headerMinBtn
            // ,this.headerCloseBtn
        );
        this.contents = $("<div>").addClass("n5-card-content");
        var finishString = "";
        if(this._devicewidth < 500){
            this._textLength = 14;
        }
        if(this._textLength<this.title.length) {
            finishString = "...";
        }
        this.headerTitle.text(this.title.substring(0, this._textLength) + finishString);
        this.headerCont.append(this.headerBarCont);
        this.headerCont.append(this.boxLeftIcons);
        // Set click events for close
        (function (context) {
            $(context.headerCloseBtn).click(function() {
                context.container.fadeOut( "slow", function() {
                    context.container.css("display","none");
                });
                // Callback
                context.callCloseCallback();
            });
        })(this);
        //set click evnets for toggle
        (function (context) {
            $(context.headerMinBtn).on("click", function() {
                 if(context.headerMinBtn.hasClass("fa fa-chevron-up")) {
                    context.headerMinBtn.removeClass("fa fa-chevron-up");
                    context.headerMinBtn.addClass("fa fa-chevron-down");
                    $(".n5-card-content", context.container).slideToggle();
                    context.callMinToggleCallback();
                }
                else {
                  context.headerMinBtn.removeClass("fa fa-chevron-down");
                  context.headerMinBtn.addClass("fa fa-chevron-up");
                  $(".n5-card-content", context.container).slideToggle();
                  context.setMaxToggleCallback();
                }
                context.callToggleCallback();
            });
        })(this);
    };

    // Change top left icon to this
    cardPrototype.setIcon = function(iconHtml) {
        this.headerIcon.html(iconHtml);
    };

    // This function should be called after the dialog is closed
    cardPrototype.callCloseCallback = function() {
        if (this.closeCallback) {
            this.setCloseCallback();
        }
    };
    // This function should be called after the dialog is closed
    cardPrototype.setCloseCallback = function(callback) {
        this.closeCallback = callback;
    };

    cardPrototype.callToggleCallback = function() {
        if (this.callToggleCallback) {
            this.setToggleCallback();
        }
    };
    cardPrototype.setToggleCallback = function(callback) {
        this.toggleCallback = callback;
    };

    cardPrototype.callMinToggleCallback = function() {
        if(this.callMinToggleCallback) {
            this.setMinToggleCallback();
        }
    };
    cardPrototype.setMinToggleCallback = function(callback) {
        this.minToggleCallback = callback;
    };

    cardPrototype.callMaxToggleCallback = function() {
        if(this.callMaxToggleCallback) {
            this.setMaxToggleCallback();
        }
    };

    cardPrototype.setMaxToggleCallback = function(callback) {
        this.maxToggleCallback = callback;
    };
    cardPrototype.render = function() {
        this.container.append(this.contents);
        $(this.contentElement).wrap(this.container);
        this.container = $("#"+this.elmId);
        this.container.prepend(this.headerCont);
        $(this.contentElement).css({"padding":"10px", "overflow":"auto"});
        this.container.width(this.width);

    };
    return native5;
}(jQuery, native5 || {}));