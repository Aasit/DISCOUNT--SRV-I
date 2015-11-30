/* jshint loopfunc: true, quotmark:false */
/* global jQuery:false */
var native5 = (function ($, native5) {
    "use strict";

    native5.ui = native5.ui || {};

    native5.ui.modal = function(options) {
        var opts = options || {};
        this.top = opts.top || 100;
        this.overlay = opts.overlay || 0.5;
        this.closeCallback = opts.closeCallback || function(){};
    };

    var modalPrototype = native5.ui.modal.prototype;

    modalPrototype.render = function(options) {
        var opts = options || {};
        var modalElm = opts.modalElm || {};
        var modalStr = opts.modalStr || {};
        var self = this;

        if(!(modalElm || modalStr)) {
            return;
        }

        if(modalElm) {
            self.elm = $(modalElm);
        } else {
            self.elm = $(modalStr);
            $("body").append(self.elm);
        }

        self.overlayDiv = $("<div>").css({"position": "fixed", "z-index": "1300", "top": "0px", "left": "0px", "height": "100%", "width": "100%", "background": "#000", "display": "none"});
        $("body").append(self.overlayDiv);

        self.overlayDiv.on("click", function() {
            self.closeModal();
            if(self.closeCallback) {
                self.closeCallback();
            }
        });

        $(".modal_close",$(modalElm)).on("click", function() {
            self.closeModal();
            if(self.closeCallback) {
                self.closeCallback();
            }
        });
    };

    modalPrototype.showModal = function(evt) {
        var self = this;
        var modal_height = self.elm.outerHeight();
        var modal_width = self.elm.outerWidth();
        self.overlayDiv.css({
            "display": "block",
            opacity: 0
        });
        self.overlayDiv.fadeTo(200, self.overlay);
        self.elm.css({
            "display": "block",
            "position": "fixed",
            "opacity": 0,
            "z-index": 1400,
            "left": 50 + "%",
            "margin-left": -(modal_width / 2) + "px",
            "top": self.top + "px"
        });
        self.elm.fadeTo(200, 1);
        // evt.preventDefault();
    };

    modalPrototype.closeModal = function() {
        this.overlayDiv.fadeOut(200);
        this.elm.css({
            "display": "none",
        });
    };

    return native5;
}(jQuery, native5 || {}));