var native5 = (function(native5){
    native5.ui = native5.ui || {};

    /**
     * Creates a new select element. Acts as a wrapper to select2
     * Usage : 
     *      var select = new native5.ui.select($('.my-element'), params);
     * Requires select2.min.js
     *
     */
    native5.ui.select = function(container, params){
        var params = params || {};
        var select = $(container).select2(params);
        return select;
    }
    
    return native5;
}(native5 || {}));
