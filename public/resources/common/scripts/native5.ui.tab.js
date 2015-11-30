/* jshint loopfunc: true, quotmark:false */
/* global jQuery:false */
var native5 = (function ($, native5) {
    "use strict";

    native5.ui = native5.ui || {};

    native5.ui.tab = function(options) {
        var opts = options || {};
        this.tabStyle         = opts.tabStyle || "";
        this.backgroundStyle  = opts.backgroundStyle || "blue";
        this.addIcon          = opts.addIcon || "fa fa-plus";
        this.maxAddTabs       = opts.maxAddTabs || 20;
    };

    var tabPrototype = native5.ui.tab.prototype;

    tabPrototype.render = function(parentElm) {
        if(!(parentElm || $(parentElm).length)) {
            return;
        }

        var self            = this;
        this.elm            = $(parentElm).css("background", self.backgroundStyle);
        this.n5tabmenu      = $("<div>").addClass("n5menutab");
        this.n5tabcontents  = $("<div>").addClass("n5tabcontents").attr("id","n5tabcontentId").css("background", self.tabStyle);
        this.n5tabul        = $("<ul>").attr("id", "n5tabul");
        this.n5addtab       = $("<span>").addClass(self.addIcon);
        this.n5tabli        = $("<li>").addClass("n5add").append(self.n5addtab);

        this.n5tabmenu.append(self.n5tabul.append(self.n5tabli));
        this.elm.append(self.n5tabmenu).append(self.n5tabcontents);

        return true;
    };

    tabPrototype.setPlusEvent = function(callback) {
        if(!callback) {
            return false;
        }

        $(".n5add", this.elm).on("click", function() {
            callback(this);
        });
    };

    tabPrototype.setDefaultContent = function(content) {
        this.n5tabcontents.append(content);
    };

    tabPrototype.addTab = function(options) {
        var opts = options || {};
        this.title = opts.title || "";
        this.html  = opts.html || "";
        var self = this;
        var index = "";

        if(typeof self.total_tabs === "undefined") {
            self.total_tabs = 0;
        }

        self.total_tabs++;
        $(self.n5tabcontents).children().hide();
        index = _createTab(self.total_tabs, self.n5tabcontents, self.title, self.html, self.n5tabul, options, self.tabStyle);
        return index;
    };

    tabPrototype.addTabs = function(tabsOptions) {
        var self = this;
        var arr = [];

        if (tabsOptions.length <= self.maxAddTabs) {
            $.each(tabsOptions, function (idx, options) {
                arr[idx] = self.addTab(options);
            });
        }

        return arr;
    };

    tabPrototype.setSelectedTab = function(options) {
        var opts = options || {};
        var self = this;
        self.titles   = options.title || "";
        self.indexOfTab   = options.index || -1;    
        if(!(opts|| $(opts).length)) {
            return;
        }
        if((self.titles!== "") && (self.indexOfTab > 0)) {
            $("li", $(self.n5tabul)).removeClass("n5ctab").css("background","");
            $("li", $(self.n5tabul)).eq(self.indexOfTab - 1).addClass("n5ctab").css("background", self.tabStyle);
            $(self.n5tabcontents).children().hide();
            $("#c"+self.indexOfTab, $(self.n5tabcontents).parent()).fadeIn("slow");
        } else if(self.titles !== "") {
            $.each($("li", $(self.n5tabul)), function(key) {
                var check = $("li span:first-child", $(self.n5tabul))[key].innerText;

                if (check == self.titles) {
                    $("li", $(self.n5tabul)).removeClass("n5ctab").css("background","");
                    $(this).addClass("n5ctab").css("background",self.tabStyle);
                    $(self.n5tabcontents).children().hide();
                    $("#c"+key, $(self.n5tabcontents).parent()).fadeIn("slow");
                }
            });
        } else if(self.indexOfTab > 0) {
            $("li", $(self.n5tabul)).removeClass("n5ctab").css("background","");
            $("li", $(self.n5tabul)).eq(self.indexOfTab - 1).addClass("n5ctab").css("background", self.tabStyle);
            $(self.n5tabcontents).children().hide();
            $("#c"+self.indexOfTab, $(self.n5tabcontents).parent()).fadeIn("slow");
        } else {
            return;
        }
    };

    function _createTab(count, idOfElm, title, htmlCont, n5tabul, options, seltabcol) {
        var closetab = "<span href='' id='n5close" + count + "' class='n5close'><i class='fa fa-times'></i></span>";
        $("#n5tabul li:last").before("<li id='t" + count + "' class='n5ntabs'><span>" + title + "</span>" + closetab + "</li>");
        $(idOfElm).append("<div id='c"+count+"'>" + htmlCont + "</div>");
        $(n5tabul).children().removeClass("n5ctab").css("background","");
        $("#t"+count, $(n5tabul)).addClass("n5ctab").css("background",  seltabcol);

        $("#t"+count, $(n5tabul)).bind("click", function() {
            $("li", $(n5tabul)).removeClass("n5ctab").css("background","");
            $(this).addClass("n5ctab").css("background", seltabcol);
            $(idOfElm).children().hide();
            $("#c"+count, $(idOfElm).parent()).fadeIn("slow");
        });

        $("#n5close" + count, $(n5tabul)).on("click", function() {
            $("li", $(n5tabul)).removeClass("n5ctab").css("background","");
            $(idOfElm).children().hide();
            $("#n5close" + count, $(n5tabul)).parent().prev().addClass("n5ctab").css("background", seltabcol);
            $("#c"+count, $(idOfElm).parent()).prev().fadeIn("slow");
            $("#n5close" + count, $(n5tabul)).parent().remove();
            $("#c"+count, $(idOfElm).parent()).remove();
        });

        return count;
    }

    return native5;
}(jQuery,native5 || {}));