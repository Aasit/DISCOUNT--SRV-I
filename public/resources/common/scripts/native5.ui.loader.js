/*global $:false */

/**
 * @preserve Copyright 2012 Native5
 * version 0.5
 * author: Native5 Solutions Inc.
 */

/**
 * Loader is UI library which shows/hides the loading message on demand. 
 * @class Loader
 */

var native5 = (function (jQuery, native5) {
    "use strict";
    native5.ui = native5.ui || {};

    native5.ui.Loader = function (options) {
        var opts = options || {};
        var loaderStyle = opts.style || "android";
        this.loaderElm = $("<div>").addClass("loader-container " + loaderStyle);
    };

    var loaderPrototype = native5.ui.Loader.prototype;

    /**
     * This function renders the Native5 Loader.
     * @method render
     * @example
     * native5.ui.Loader.render();
    */
    loaderPrototype.render = function() {
        /*jshint multistr: true */
        var loaderStr = '<div class="loader"> \
                <div class="loaderDiv" id="loaderDiv_1"><div class="InnerDiv"></div></div> \
                <div class="loaderDiv" id="loaderDiv_2"><div class="InnerDiv"></div></div> \
                <div class="loaderDiv" id="loaderDiv_3"><div class="InnerDiv"></div></div> \
                <div class="loaderDiv" id="loaderDiv_4"><div class="InnerDiv"></div></div> \
                <div class="loaderDiv" id="loaderDiv_5"><div class="InnerDiv"></div></div> \
                <div class="loaderDiv" id="loaderDiv_6"><div class="InnerDiv"></div></div> \
                <div class="loaderDiv" id="loaderDiv_7"><div class="InnerDiv"></div></div> \
                <div class="loaderDiv" id="loaderDiv_8"><div class="InnerDiv"></div></div> \
            </div';

        this.loaderElm.append(loaderStr);
        $("body").append(this.loaderElm);
    };

    /**
     * This function displays the loading message when invoked.
     * @method showLoadingMessage
     * @param [blocking] {Boolean} Decides whether the loader be blocking the UI or not.
     * @example
     * native5.ui.Loader.showLoadingMessage({"blocking": true});
    */
    loaderPrototype.showLoadingMessage = function(options) {
        var opts = options || {}, blocking = opts.blocking || false;

        if(blocking) {
            this.loaderElm.addClass("blocking");
        }

        $(".loader", this.loaderElm).show();
    };

    /**
     * This function hides the already displaying loading message.
     * @method hideLoadingMessage
     * @example
     * native5.ui.Loader.hideLoadingMessage();
    */
    loaderPrototype.hideLoadingMessage = function() {
        this.loaderElm.removeClass("blocking");
        $(".loader", this.loaderElm).hide();
    };

    return native5;

}($, native5 || {}));