var akzo = (function(akzo){
    akzo.ui = akzo.ui || {};
    akzo.ui.budgetUtilization = akzo.ui.budgetUtilization || {};

    /**
     * Creates a new circular chart with defaults set below or specs provided.
     * Usage : 
     *      var chart = new akzo.ui.budgetUtilization.circularChart($('.my-element'), params);
     * Requires native5.ui.graph.circularChart.js and jquery.easypiechart.min.js
     *
     */
    akzo.ui.budgetUtilization.circularChart = function(container, params){
        var params = params || {};
        var chart = new native5.ui.graph.circularChart(container, {
            "size": params.size || 135,
            "barColor": params.color || "#7BC8A8",
            "trackColor": params.trackColor || "#f2f2f2",
            "scaleColor": params.scaleColor || "#dfe0e0",
            "lineCap": params.lineCap || "round",
            "lineWidth": params.lineWidth || 3,
            "animate": params.animate || 1000,  //false or time in ms
            "onStart": params.onStart || $.noop,
            "onStop": params.onStop || $.noop,
            "onStep": params.onStep || $.noop,

        });
        return chart;
    }

    return akzo;
}(akzo || {}));