/* jshint quotmark: false */
/* global jQuery: false */
var native5 = (function ($, native5) {
    "use strict";

    native5.ui = native5.ui || {};
    native5.ui.checkboxTree = function(options) {
    	if(!options.contentElm) {
    		return null;
    	}

        this.elm             = $(options.contentElm);
        this.elmId           = $(this.elm).selector;
        this.treeStyle       = options.treeStyle || "";
        this.elmStyle        = options.elmStyle || "";
        this.maxTreeHeight   = options.maxTreeHeight ||  this.elm.height();
        this.elmHeight       = options.elmHeight || "0px";
        this.treeWidth       = options.treeWidth || this.elm.width();
        this.backEndPath     = options.backEndPath || "";
        this.spinerClass     = options.spiner || "fa fa-gear fa-spin";
        this.handleIndicator = options.handle || ".handle";
        this.closeIndicator  = options.closeIndicator || "fa fa-caret-right fa-1x";
        this.openIndicator   = options.openIndicator || "fa fa-caret-down fa-1x";
    };
    var checkboxList = native5.ui.checkboxTree.prototype;

    checkboxList.init = function(optsStr) {
    	this.spiner = $("<i>").addClass(this.spinerClass).css("margin-left", "5px");
		$(this.elm).append(createList1(optsStr, this.elmStyle, this.treeStyle));
		// $(this.elm).css("height", this.maxTreeHeight);
		$(this.elm).css("width", this.treeWidth);
		// $(this.elm).css("overflow", "auto");
    };
    checkboxList.add = function(optsStr, IdOfNode) {
    	$(this.elm).find("#" + IdOfNode).append(createList(optsStr, this.elmStyle, this.treeStyle)).css("padding-left", "0px");
    };
    checkboxList.remove = function(options) {
    	$(this.elm).find(options).remove();
    };
    checkboxList.render = function() {
    	var self = this;
    	$(this.elm).find(self.handleIndicator).unbind("click" );
    	var closeIndicator = this.closeIndicator;
		var openIndicator  = this.openIndicator;
        $(this.elm).find(self.handleIndicator).bind("click", function() {
        	var clicked = $(this);
          	var parentId = clicked.parent().attr("id"); 
          	if (parentId === "Asia" || parentId === "Africa" || parentId === "Europe") {
				if (clicked.hasClass(closeIndicator)) {
		            var request = {};
		            request.region = parentId;
		    		var call = new native5.core.Service(self.backEndPath, app.config);
		            call.configureHandlers(
		                function(data) {
		                    // console.log(data);
		                    var json = data;
					        clicked.parent().append(createList(json.message, this.elmStyle, this.treeStyle));
					        self.render();
					        toggleCheckbox(clicked, closeIndicator, openIndicator);
				            $(self.spiner).remove();     
		                },
		                function(err) {
		                	$(self.spiner).remove();
		                    // console.log(err);
		                }
		            );
		            call.invoke(request);
		            clicked.parent().append(self.spiner);
	        	}	
	        	else {
	        		toggleCheckbox(clicked, closeIndicator, openIndicator);
	        	}
	     	}
	        else {
	        	toggleCheckbox(clicked, closeIndicator, openIndicator);
	        }
    	});
    	$('.akzo_check').change(function() {
            addCheckBoxEvents($(this));
        });
        $(this.elm).find(".n5-checkbox-li").css("padding", this.elmHeight);
    };
    function createList(jsonData, elmStyle,  treeStyle){
	    var html='<ul class="n5-checkbox-ul">';
	    $.each(jsonData, function(key, value){
	    	if (value.children){
	        html+='<li level="' + value.level + '" class="n5-checkbox-li ' + elmStyle + '" id="' + value.name + '" ><input class="akzo_check ' + treeStyle +'" type="checkbox"><span class="handle fa fa-caret-right fa-1x"></span><span class="checkbox_label">' + value.name + '</span>';
	    }
	    else {
	        html+='<li level="' + value.level + '" class="n5-checkbox-li ' + elmStyle + '" id="' + value.name + '" ><input class="akzo_check ' + treeStyle +'" type="checkbox"><span class="checkbox_label">' + value.name + '</span>';
	    }
	        if( value.children){
	            html+=createList(value.children);
	        }
	        html+='</li>';
	    });
	     html+='</ul>';
	    return html;
	}
	function toggleCheckbox(clicked, closeIndicator, openIndicator) {
		var toggleTwoClasses = closeIndicator + " " + openIndicator;
		clicked.toggleClass(toggleTwoClasses); 
		clicked.siblings("ul").slideToggle();
	}
	function createList1(jsonData, elmStyle,  treeStyle){
	    var html='<ul class="n5-checkbox-ul">';
	    $.each(jsonData, function(key, value){
	    	if (value.children){
	        html+='<li level="' + value.level + '" class="n5-checkbox-li ' + elmStyle + '" id="' + value.name + '" ><input class="akzo_check ' + treeStyle +'" type="checkbox"><span class="handle fa fa-caret-right fa-1x"></span><span class="checkbox_label">' + value.name + '</span>';
	    }
	    else {
	        html+='<li level="' + value.level + '" class="n5-checkbox-li ' + elmStyle + '" id="' + value.name + '" ><input class="akzo_check ' + treeStyle +'" type="checkbox"><span class="handle fa fa-caret-right fa-1x"></span><span class="checkbox_label">' + value.name + '</span>';
	    }
	        if( value.children){
	            html+=createList(value.children);
	        }
	        html+='</li>';
	    });
	     html+='</ul>';
	    return html;
	}
	function addCheckBoxEvents(checkbox) {
		var checked = checkbox.prop("checked"),
            container = checkbox.parent();
        container.find('.akzo_check').prop({
            indeterminate: false,
            checked: checked,
        });
        function checkSiblings(el) {
            var parent = el.parent().parent(),
                all = true;

            el.siblings().each(function() {
                all = ($(this).children('.akzo_check').prop("checked") === checked);
                return all;
            });

            if (all && checked) {
                parent.children('.akzo_check').prop({
                    indeterminate: false,
                    checked: checked
                });
                checkSiblings(parent);
            } else if (all && !checked) {
                parent.children('.akzo_check').prop("checked", checked);
                parent.children('.akzo_check').prop("indeterminate", (parent.find('input[type="checkbox"]:checked').length > 0));
                checkSiblings(parent);
            } else {
                el.parents("li").children('.akzo_check').prop({
                    indeterminate: true,
                    checked: false
                });
            }
        }
        checkSiblings(container);
	}
   return native5;
}(jQuery, native5 || {}));
