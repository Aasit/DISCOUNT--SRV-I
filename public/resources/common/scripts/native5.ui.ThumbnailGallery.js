/*jshint loopfunc: true, quotmark:false */
/*global jQuery:false */
var native5 = (function ($, native5) {
    "use strict";

    native5.ui = native5.ui || {};

    native5.ui.thumbnailGallery = function(elm, options) {
		this.element = $(elm) || "";
		var opts = options || {};
		this.height = opts.height || "300px";
		this.width = opts.width || "300px";
		this.thumbHeight = opts.thumbHeight || "120px";
		this.thumbWidth = opts.thumbWidth || "120px";
    };

    var thumbPrototype = native5.ui.thumbnailGallery.prototype;

    thumbPrototype.init = function() {
		var self = this;
		var elm = self.element;

		var viewport = $("<div>").addClass("viewport").css({height: self.height, width: self.width});
		$(elm).append(viewport);
		var indicator = $("<div>").addClass("nav-div");
		$(elm).append(indicator);
		var thumbnails = $("<div>").addClass("thumbnails");
		$(elm).append(thumbnails);
		$(elm).addClass("n5-thumb").css({width: $(viewport).outerWidth()});
    };

    thumbPrototype.addThumb = function(arr) {
		var self = this;
		var elm = self.element;
		var thumbElm = $(elm).find(".thumbnails")[0];
		var navDiv = $(elm).find(".nav-div")[0];

		var holder = $("<div>").addClass("holder").appendTo(thumbElm);

		$.each(arr, function(key, value) {
			var imageHolder = $("<div>").addClass("img-holder").css({
				"width": self.thumbWidth,
				"height": self.thumbHeight,
			}).append($("<img>").attr("src", value.thumb).attr("data-src", value.image));
			$(holder).append(imageHolder);
			$(navDiv).append($("<div>").addClass("pill"));
		});

		$(holder).css({width: arr.length * (parseInt($(".img-holder", holder).outerHeight(), 10))});
		$(thumbElm).height($(".img-holder", holder).outerHeight());
    };

    thumbPrototype.render = function(index) {
		var self = this;

		if(!index) {
			index = 0;
		}

		bindTouchEvents(self.element);

		bindClickEvents(self.element, index);
    };

    function bindTouchEvents(elm) {
		var container = $(elm).find(".thumbnails")[0];
		var content = $(container).find(".holder")[0];

		var touch = {start: {}, end: {}};
		var max  = $(content).outerWidth() - $(container).width();
		touch.end.position = 0;
		var startTime = 0;
		var endTime = 0;

		$(content).on("touchstart", function(event) {
			touch.start.x = event.originalEvent.targetTouches[0].pageX;
			touch.start.y = event.originalEvent.targetTouches[0].pageY;
			touch.start.position = touch.end.position;
			touch.start.time = Number(new Date());
			$(content).css("-webkit-transition", "");
			startTime = new Date().getTime();
		});

		$(content).on("touchmove", function(event) {
			event.preventDefault();
			touch.end.x = event.originalEvent.targetTouches[0].pageX;
			touch.end.y = event.originalEvent.targetTouches[0].pageY;

			var deltaX = touch.end.x - touch.start.x;
			
			endTime = new Date().getTime();
			
			var touchSpeed = Math.abs(deltaX / (endTime - startTime));
			if(deltaX >= 0) {
				deltaX = touchSpeed * max;
			} else {
				deltaX = -(touchSpeed * max);
			}
			
			var target = touch.start.position + deltaX;

			/* constrain the target */
			if (target > 0) target = 0;
			if (target < -max) target = -max;
			
			moveElement($(content), target);
			touch.end.position = target;
		});

		$(content).on("touchend", function() {
			var imageArr = $(elm).find(".img-holder");

			var width = $(imageArr).outerWidth();
			var goToIndex = parseInt((Math.abs(touch.end.position)) / width, 10);

			var target = -(width * goToIndex);

			moveElement($(content), target);

			$(imageArr)[goToIndex].click();
		});
    }

    function moveElement(elm, target) {
		var width = $(elm).parent().width() - $(elm).width();
		if(target < width) {
			target = width;
		}
		$(elm).css({
				"transform": "translate3d(" + target + "px, 0, 0)",
				"-webkit-transform": "translate3d(" + target + "px, 0, 0)",
				"-moz-transform": "translate3d(" + target + "px, 0, 0)",
				"-ms-transform": "translate3d(" + target + "px, 0, 0)",
			});
    }

    function bindClickEvents(elm, index) {
		var viewport = $(elm).find(".viewport")[0];
		var imageArr = $(elm).find(".img-holder");
		var content = $(elm).find(".holder")[0];
		var pillDiv = $(elm).find(".nav-div")[0];

		$.each(imageArr, function(key, value) {
			var imageElm = $(value).find("img")[0];
			$(value).on("click", function() {
				$(viewport).empty();
				var width = $(this).outerWidth();
				var index = $(imageArr).index(this);
				moveElement($(content), -(width * index));

				var pill = $("div:nth-child(" + (key + 1) + ")", pillDiv);
				$(".pill", pillDiv).removeClass("filled");
				$(pill).addClass("filled");

				$("<img>").attr("src", $(imageElm).data("src")).appendTo(viewport);
				$(imageArr).removeClass("selected");
				$(this).addClass("selected");
			});
		});
		
		$(imageArr[index]).click();
    }

    return native5;
}(jQuery, native5 || {}));