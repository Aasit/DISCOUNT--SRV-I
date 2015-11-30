var native5 = (function(native5){
    native5.ui = native5.ui || {};
    native5.ui.graph = native5.ui.graph || {};

    /**
     * Creates a new circular chart. Acts as a wrapper to easypiechart
     * Usage : 
     *      var chart = new native5.ui.graph.circularChart($('.my-element'), params);
     * Requires jquery.easypiechart.min.js
     *
     */
    native5.ui.graph.circularChart = function(container, params){
        var chart = $(container).easyPieChart(params);
    }

    
    return native5;
}(native5 || {}));
