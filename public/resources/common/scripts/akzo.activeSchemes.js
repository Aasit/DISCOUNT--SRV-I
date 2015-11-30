/* globals jQuery: false */
var akzo = (function ($, akzo) {
    "use strict";
    akzo.activeScheme = akzo.activeScheme || {};
    akzo.activeScheme.createBarChart = function(optionsAkzo) {
        this.optionsBar = {
                "title"			: "",
                "showtitle"		: false,
                "stackSeries"   : true,
                "tickyaxis"      : optionsAkzo.tickyaxislabel,
                "xaxislabel"    : "SCHEMES",
                "yaxislabel"    : "FORECAST AMOUNT",
                "yaxismark"     : "cross",
                "yaxisLinelabel"  : false,
                "yaxisShowMark"  : true,
                "animate"       : true,
                "animationspeed" : 1000,
                "drawGridline"  : false,
                "background"    : "transparent",
                "borderwidth"   : 0,
                "shadow"		: false,
                "barMargin"     : 20,
                "highlighter"   : true,
                "legend"        : true,
                "legendlabel"   : ["Within Budget", "Exceeding Budget"]
        };
	    var dataseriesWidth  = optionsAkzo.dataSeries;
	  	var auxSeriesWidth	= dataseriesWidth[0];
	  	var widthofBarCont = (auxSeriesWidth.length * 80);
	    var barWidthOfbar  = $("#" + optionsAkzo.containerId).width();
	    // $("#" + optionsAkzo.containerId).parent().css("width", barWidthOfbar);
	    var parentWidth  = $("#" + optionsAkzo.containerId).parent().width();
	    if (widthofBarCont > parentWidth)
	    {
	    	$("#" + optionsAkzo.containerId).css("margin-top","20px").css("width", widthofBarCont);
	    	$("#" + optionsAkzo.containerId).parent().parent().parent().css({"overflow-x": "scroll","width": parentWidth + 20});
	    }
	    else
	    {
	    	$("#" + optionsAkzo.containerId).parent().css("width", parentWidth);
	    	$("#" + optionsAkzo.containerId).parent().parent().parent().css({"overflow-x": "hidden"});
	    }
	    $.jqplot.LabelFormatter = function(format, val) {
	        var abc = val + '%'  + '\n' + ' 5 Days';
	        return abc;
	    };
        var options = {
    		title: {
        		text: this.optionsBar.title,
       		    show: this.optionsBar.showtitle,
    		},
			animate: this.optionsBar.animate,
			animateReplot: true,
			stackSeries: this.optionsBar.stackSeries,
			seriesColors:['#7bc8a8', '#DB0000', '#E3E3E3'], //picks color from here
			seriesDefaults:{
				renderer:$.jqplot.BarRenderer,
				rendererOptions: {
		          barMargin: this.optionsBar.barMargin,
		          barWidth: 60,
		          shadow: this.optionsBar.shadow,
		          varyBarColor: true,
		          animation: {
		                    speed: this.optionsBar.animationspeed
		          },
		          highlightMouseDown: false   
		      	},
		      	pointLabels: {show: true, stackedValue: true,
		      	labelsFromSeries : false,
		      	// formatString :"%2s%",
		       	location: "n"}  
		    },
		    series: [ 
		    	{
            		pointLabels: {
                		show:false
            		}
        		},
        		{
        			pointLabels: {
        				show: false
        			}
        		},
       			{
            		pointLabels:{
	                	show:true,
	                	// labels : ['34', '55', '66', '33'],
	                	formatString: "%s",
               		  	formatter: $.jqplot.LabelFormatter,
	                	ypadding: 2
            		}
       		 	},
		            ],
		    grid: {
		            drawGridlines: this.optionsBar.drawGridline,
		            background: this.optionsBar.background,
		            shadow: false,
		            borderWidth: this.optionsBar.borderwidth
		    },
		    axes: {
		      xaxis: {
		          renderer: $.jqplot.CategoryAxisRenderer,
		          labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
		          label: this.optionsBar.xaxislabel,
		          formatString: "%'d",
		          ticks: this.optionsBar.tickyaxis
		      },
		      yaxis: {
		        tickOptions: {
		        	showMark: this.optionsBar.yaxisShowMark,
		            mark: this.optionsBar.yaxismark ,
		            showGridline: true,
		            markSize: 4,
		            show: true,
		            showLabel: this.optionsBar.yaxisLinelabel
		        },
		        label: this.optionsBar.yaxislabel,
		        labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
		        formatString: "%'d",
		        padMin: 0
		      }
		    },
		    legend: {
		            show: this.optionsBar.legend,
		            location: 'nw',
		            border : 4,
		            edgeTolerance : 10,
		            labels: this.optionsBar.legendlabel,
		             marginTop: -30,
		    },
		    highlighter: {
		        show: this.optionsBar.highlighter,
		        showTooltip: true,
		        tooltipAxes: 'xy',
		        tooltipFade: true,
		        showMarker : false,
		        tooltipLocation :'n',
		        sizeAdjust: 5,
		        formatString:'<table class="jqplot-highlighter"> \
		        			  <tr><td></td><td>5 Days Remaing</td></tr> \
						      <tr><td></td><td>AmountRs : %s</td></tr> \
						      <tr><td></td><td>PayOut Estimate Rs: %s</td></tr></table>',
		        //tooltipFormatString: "<b><i><span>FORECAST Amount: Rs</span></i></b> %.2f </br>",
		        useAxesFormatters: false
		      },
		    cursor: {
		        show: false,
		        style: 'crosshair'
		    }   
	  	};
	  	var dataseries  = optionsAkzo.dataSeries;
	  	var auxSeries	= dataseries[0];
	  	var auxdata     = dataseries[1];
	  	var statusSer   = optionsAkzo.statusSeries;
	  	var newSeries1  = [];
	  	var newSeries2  = [];

	  	$.each(statusSer, function( key, value ) {
  			if (value == "ex")
  			{
  				newSeries1[key] = auxSeries[key];
		  		newSeries2[key] = 0;
  			}
  			else if(value == "po")
  			{
  				newSeries2[key] = auxSeries[key];
		  		newSeries1[key] = 0;
  			}
  			else {
  				newSeries2[key] = auxSeries[key];
		  		newSeries1[key] = 0;
  			}
		});
	   var newDataSeries = [newSeries1, newSeries2, auxdata];
       var graphBar = new native5.ui.graph.bar(optionsAkzo.containerId, newDataSeries, options);
    };
    return akzo;
}(jQuery, akzo || {}));