/* jshint loopfunc: true, quotmark:false */
/* global jQuery:false */
var native5 = (function($, native5) {
    "use strict";

    native5.ui = native5.ui || {};

    native5.ui.dropdown = function(elm, options) {
        if (!(elm || $(elm).length)) {
            return;
        }

        this.elm = $(elm);
        var opts = options || {};
        this.width = opts.width || "240";
        this.maxHeight = opts.maxHeight || "auto";
        this.elmClass = opts.elmClass || "";
        this.leftMargin = opts.leftMargin || 35 - this.width;
        this.top = opts.top || "";
        this.topMargin = opts.topMargin || "";

        this.listHeight = opts.listHeight || 40;
        this.listHasImage = opts.listHasImage || false;
        this.listClass = opts.listClass || "";

        this.listHeader = opts.listHeader || "";
        this.listHasHeader = opts.listHasHeader || false;
        this.listHeaderHeight = opts.listHeaderHeight || 40;
        this.listHeaderClass = opts.listHeaderClass || "";

        this.listFooter = opts.listFooter || "";
        this.listHasFooter = opts.listHasFooter || false;
        this.listFooterHeight = opts.listFooterHeight || 30;
        this.listFooterClass = opts.listFooterClass || "";

        this.showArrow = opts.showArrow || false;
        this.listHasAttrs = opts.listHasAttrs || false;

    };

    var dropPrototype = native5.ui.dropdown.prototype;

    dropPrototype.render = function(options) {
        var self = this;
        var header, footer, lists = $("<ul>").addClass("ui-dropdown-parent");
        var arrow = $("<div>").addClass("dropdown-arrow").css({
            "margin-left": self.width - 35
        });
        if(self.showArrow == true) {
            lists.append(arrow);    
        }
        
        lists.addClass(self.elmClass).css({
            "max-height": self.maxHeight,
            // "width": "inherit",
            "margin-left": self.leftMargin,
            "margin-top": self.topMargin,
            "top": self.top
        }).hide();

        if (self.maxHeight !== "auto") {
            lists.css("overflow", "auto");
        }

        if (self.listHasHeader) {
            header = $("<li>").html(self.listHeader).addClass("ui-header " + self.listHeaderClass).height(self.listHeaderHeight);
        }

        if (self.listHasFooter) {
            footer = $("<div>").html(self.listFooter).addClass("ui-footer " + self.listFooterClass).height(self.listFooterHeight);
        }

        if (header) {
            lists.append(header);
        }

        if (footer) {
            lists.append(footer);
        }

        if (options) {
            $.each(options, function(key, value) {
                var tempElm = $("<li>").addClass("ui-dropdown-list " + self.listClass).css({
                    height: self.listHeight
                });
                if (self.listHasImage) {
                    if (value.imageStr.match(">$")) {
                        tempElm.append(value.imageStr);
                    } else {
                        tempElm.append("<img class='ui-img' src='" + value.imageStr + "' />");
                    }
                }
                if(self.listHasAttrs){
                    tempElm.attr( "data-"+value.attr.name, value.attr.value);
                }
                tempElm.append($("<span>").addClass("ui-text").html(value.textStr));
                tempElm.append($("<span>").addClass("ui-subtext").html(value.subTextStr));

                if (value.listAction) {
                    $(tempElm).on("click", function() {
                        value.listAction();
                    });
                }

                lists.append(tempElm);
            });
        }

        if (footer) {
            lists.append(footer);
        }

        self.elm.append(lists);

        self.dropList = lists;

        self.elm.on("click", function(evt) {
            var visibility = $(lists, self.elm).is(":visible");
            if(visibility) {
                self.closeDropDown();
            } else {
                self.openDropDown();
            }
        });

        $(document).on("click", function() {
            self.closeDropDown();
        });

        defaultEvents(self);
    };

    dropPrototype.closeDropDown = function() {
        if(!this.isInvoked) {
            this.dropList.slideUp();
        }
        this.isInvoked = false;
    };

    dropPrototype.openDropDown = function() {
        this.isInvoked = true;
        this.dropList.slideDown();
    };

    dropPrototype.addRows = function(options) {
        var self = this;

        if (!self.dropList) {
            return;
        }

        var header, footer, lists = self.dropList;

        lists.addClass(self.elmClass).css({
            "max-height": self.maxHeight,
            // "width": "inherit",
            "margin-left": self.leftmargin
        }).hide();

        if (self.listHasHeader) {
            header = $("<li>").html(self.listHeader).addClass("ui-header" + self.listHeaderClass).height(self.listHeaderHeight);
        }

        if (self.listHasFooter) {
            footer = $("<li>").html(self.listFooter).addClass("ui-footer" + self.listFooterClass).height(self.listFooterHeight);
        }

        if (header) {
            lists.append(header);
        }

        if (footer) {
            lists.append(footer);
        }

        if (options) {
            $.each(options, function(key, value) {
                var tempElm = $("<li>").addClass("ui-dropdown-list");
                if (self.listHasImage) {
                    if (value.imageStr.match(">$")) {
                        tempElm.append(value.imageStr);
                    } else {
                        tempElm.append("<img class='ui-img' src='" + value.imageStr + "' />");
                    }
                }
                tempElm.append($("<span>").addClass("ui-text").html(value.textStr));
                tempElm.append($("<span>").addClass("ui-subtext").html(value.subTextStr));

                if (value.listAction) {
                    $(tempElm).on("click", function() {
                        value.listAction();
                    });
                }

                lists.append(tempElm);
            });
        }

        if (footer) {
            lists.append(footer);
        }

        defaultEvents(self);
    };

    dropPrototype.destroy = function() {
        if (this.dropList) {
            $(this.dropList).remove();
            return true;
        } else {
            return false;
        }
    };

    dropPrototype.addEvents = function(options) {
        var self = this;
        var list = self.dropList;
        var header = list.find(".ui-header")[0];
        var footer = list.find(".ui-footer")[0];
        var elements = list.find(".ui-dropdown-list");

        if (header) {
            header.off("click");
            header.on("click", function() {
                options.headerEvent();
            });
        }

        if (footer) {
            footer.off("click");
            footer.on("click", function() {
                options.footerEvent();
            });
        }

        var listEvents = options.listEvents;

        if (listEvents) {
            $.each(listEvents, function(key, value) {
                if (elements[key]) {
                    $(elements[key]).off("click");
                    $(elements[key]).on("click", function() {
                        if (value) {
                            value();
                        }
                    });
                }
            });
        }

        defaultEvents(self);
    };

    function defaultEvents(obj) {
        var list = obj.dropList;
        var elements = list.find(".ui-dropdown-list");

        $.each(elements, function(key, value) {
            $(value).on("click", function() {
                list.slideUp();
            });
        });
    }

    return native5;
}(jQuery, native5 || {}));
