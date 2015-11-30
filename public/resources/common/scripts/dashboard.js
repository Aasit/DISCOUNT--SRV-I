// dashboard sales performance chart

(function ($) {
    "use strict";

	$(document).ready(function() {
	    var options1 = {
	        "contentElm" : $("#active-scheme-content-card"),
	        "cardId" : "activeSchemes", 
	        "title": "Active Schemes",
	        "theme": "blue",
	        "collapsed": false
	    };
	    var card1 = new native5.ui.card(options1);
	    card1.init();
	    card1.setIcon("<i class='fa fa-bar-chart-o'></i>");
	    card1.render();

	    var options2 = {
	        "contentElm" : $("#scheme-budget-utilization"),
	        "cardId" : "schemeBudgetUtilization",
	        "title": "Scheme Budget Utilization",
	        "theme": "blue",
	        "collapsed": false
	    };
	    var card2 = new native5.ui.card(options2);
	    card2.init();
	    card2.setIcon("<i class='fa fa-bar-chart-o'></i>");
	    card2.render();

	    var options3 = {
	        "contentElm" : $("#schemes-pending-approval"),
	        "cardId" : "schemesPendingApproval",
	        "title": "Schemes Pending Approval",
	        "theme": "blue",
	        "collapsed": false
	    };
	    var card3 = new native5.ui.card(options3);
	    card3.init();
	    card3.setIcon("<i class='fa fa-suitcase'></i>");
	    card3.render();

	    var options4 = {
	        "contentElm" : $("#concluded-schemes"),
	        "cardId" : "concludedSchemes",
	        "title": "Concluded Schemes",
	        "theme": "blue",
	        "collapsed": false
	    };
	    var card4 = new native5.ui.card(options4);
	    card4.init();
	    card4.setIcon("<i class='fa fa-money'></i>");
	    card4.render();

	    var circularCharts = new akzo.ui.budgetUtilization.circularChart($('.panel-circular-chart'));

		var activeSchemesGraph = service.invoke({serviceURL: "dashboard/getSchemeGraph"});
	    activeSchemesGraph.done(function(data) {
	        //active schemes chart
		    var activeSchemes = data.message;
		    var activeSchemesChart = new akzo.activeScheme.createBarChart(activeSchemes);
		    $(".jqplot-table-legend",$("#active-scheme-content")).find("tr:first").remove();
			//active schemes chart ends
	    });

	    var schemeStates = service.invoke({serviceURL: "dashboard/getSchemeStates"});
	    schemeStates.done(function(data) {
	        //active schemes chart
		    var schemesData = data.message;
		    $("#schemes-pending-approval").html(data.message);
		    $(".scheme-minimize-button").click(function(){
		    	if ($("i",$(this)).hasClass("fa-chevron-down")){
		    		$(".scheme-minimize-button").parent().parent().find(".granular-info-box").hide();
		    		$("i", $(".scheme-minimize-button")).removeClass("fa-chevron-up").addClass("fa-chevron-down");
		    		$(this).parent().parent().find(".granular-info-box").show();
		    		$("i", $(this)).removeClass("fa-chevron-down").addClass("fa-chevron-up");
		    	}
		    	else{
		    		$(this).parent().parent().find(".granular-info-box").hide();
		    		$("i", $(this)).removeClass("fa-chevron-up").addClass("fa-chevron-down");
		    	}
		    });
			//active schemes chart ends
	    });
			

		// filters
		var sbufilter = new native5.ui.filtermenu({
			"container": $("#scheme-budget-utilization"),
			"filter": $(".filter-filter", $("#scheme-budget-utilization")),
			"content": $(".filter-content", $("#scheme-budget-utilization")),
			"button": $(".filter-toggle", $("#scheme-budget-utilization")),
			"width": "300px"
		});

		var ascfilter = new native5.ui.filtermenu({
			"container": $("#active-scheme-content-card"),
			"filter": $(".filter-filter", $("#active-scheme-content-card")),
			"content": $(".filter-content", $("#active-scheme-content-card")),
			"button": $(".filter-toggle", $("#active-scheme-content-card")),
			"width": "300px"
		});
		// filters


		//sliders

		$(".range-slider", $("#active-scheme-content-card")).noUiSlider({
			start: 40,
			connect: "lower",
			step: 1,
			range: {
				'min': 0,
				'max': 100
			}
		});
		//sliders

		//checkbox trees

	    var checkBox = new native5.ui.checkboxTree({
	        "contentElm" : ".filter-checkbox-tree",
	        "treeWidth"  : "80%",
	        "backEndPath" : "demo/data"
	    });
	    var jsonData = [{"name":"Asia", "level":"0", "event":"clickEvent","style":"abc","children":null}, {"name":"Africa", "level":"0", "event":"clickEvent","style":"abc","children":null}, {"name":"Europe", "level":"0", "event":"clickEvent","style":"abc","children":null}];
	    checkBox.init(jsonData);
	    checkBox.render();



	});
	// dashboard sales performance chart ends

}(jQuery));