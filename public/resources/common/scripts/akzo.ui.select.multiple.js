/* jshint loopfunc: true, quotmark:false */
/* global jQuery:false, native5:false,app,getParameterByName */

var akzo = (function($, native5, akzo){
    akzo.ui = akzo.ui || {};
    akzo.ui.select = akzo.ui.select || {};

    /**
     * Creates a new select box with defaults set below or specs provided.
     * Usage : 
     *      var select = new akzo.ui.select.multiple($('.my-element'), params);
     * Requires native5.ui.select.js and select2.min.js
     *
     */
    akzo.ui.select.multiple = function(objParams){
        var params = objParams || {};
        this.inputElm = params.inputElm;
        this.container = params.container || $(this.inputElm).parent();
        this.inputClass = params.inputClass || "";
        this.placeholder = params.placeholder || " Search Products";
        this.minimumInputLength = params.minimumInputLength || 3;
        this.serviceURL = params.serviceURL || "";
        this.listClass = params.listClass || "";
        this.callback = params.callback || null;
        this.multiple = params.multiple || true;
        this.selections = params.selections || "";
        this.showFilters = params.showFilters || false; 
        this.dropdownCssClass = params.dropdownCssClass || ""; //
        this.dropdownCss = params.dropdownCss || "";
        this.containerCssClass = params.containerCssClass || ""; //
        this.containerCs = params.containerCs || "";
        this.preselect = params.preselect || false;
        this.cached = params.cached || false;

        this._filter = {};
        this.render();

        return this.populate();
    };

    var selectPrototype = akzo.ui.select.multiple.prototype;


    selectPrototype.populate = function() {
        var self = this;

        var select = new native5.ui.select(this.inputElm, {
            placeholder: self.placeholder,
            minimumInputLength: self.minimumInputLength,
            closeOnSelect: false,
            clearResults: false,
            multiple: this.multiple,
            id: function(e) { return e.name; },
            cacheDataSource: [],
            query: function(query) {
                var that = this;
                var qkey = query.term;
                var cachedData = that.cacheDataSource[qkey];

                if(cachedData) {
                    query.callback({results: cachedData.message});
                    return;
                } else {
                    self._filter = {};
                    $.each( self.selections, function( key, value ) {
                        if($("." + value, $(self.container)).is(":checked")){
                            self._filter[key] = key;
                        }
                    });
                    q = {
                        searchStr: qkey,
                        page_limit: 10,
                        page: 1,
                        filter: self._filter,
                        rand_token: getParameterByName("rand_token")
                    };
                    $.ajax({
                        url: self.serviceURL,
                        data: q,
                        dataType: 'json',
                        type: 'GET',
                        success: function(data) {
                            if(data.message && data.message.__redirect) {
                                var path = data.message.__redirect;
                                
                                native5.Notifications.show("You've been logged out. Redirecting to: " + path, {
                                    notificationType:"toast",
                                    title:"Error",
                                    position:"top",
                                    distance:"50px",
                                    persistent: true,
                                    messageType: "error"
                                });

                                setTimeout(
                                    function() {
                                        window.location.href = window.absPath + "/" + path;
                                        native5.Notifications.hide();
                                    },
                                    2000
                                );
                            } else {
                                that.cacheDataSource[qkey] = data;
                                query.callback({results: data.message});
                            }
                        }
                    });
                }
            },
            formatResult: formatDataDisplay,
            formatSelection: formatListSelection,
            dropdownCssClass: self.dropdownCssClass || "bigdrop",
            dropdownCss: self.dropdownCss,
            containerCssClass: self.containerCssClass,
            containerCss: self.containerCss
        });

        return select;

        function formatDataDisplay(data) {
            var markup = "";
            // console.log(data);
            markup += "<div class = "+self.listClass+">" + data.name + "</div>";
            return markup;
        }

        function formatListSelection(data) {
            var elementClass = "view-unknown";
            if(data.pid) {
                if(data.pid.charAt(0) == "P"){
                    elementClass = "view-product";
                }
                else if(data.pid.charAt(0) == "G"){
                    elementClass = "view-group";
                }
                else if(data.pid.charAt(0) == "C"){
                    elementClass = "view-cluster";
                }
                else if(data.pid.charAt(0) == "S"){
                    elementClass = "view-subbrand";
                }
                else if(data.pid.charAt(0) == "B"){
                    elementClass = "view-brand";
                }
                var elm = "<div class = " + elementClass + " data-product = '" + JSON.stringify(data) + "'>"+data.name+"</div>";
                return elm;
            }

            if(data.gid) {
                if(data.gid.charAt(0) == "Z"){
                    elementClass = "view-zone";
                }
                else if(data.gid.charAt(0) == "R"){
                    elementClass = "view-region";
                }
                else if(data.gid.charAt(0) == "D"){
                    elementClass = "view-depot";
                }
                else {
                    elementClass = "view-dealer";    
                }
                var elm2 = "<div class = " + elementClass + " data-geo = '" + JSON.stringify(data) + "'>"+data.name+"</div>";
                return elm2;
            }
        }
    };

    selectPrototype.render = function() {
        var self = this;
        // self.renderInput();
        self.renderFilters();
    };

    selectPrototype.renderFilters = function() {
        var self = this;
        $(self.container).append('<div class = "filterButton"><button class = "filterButton-button"><i class = "fa fa-filter"></i></button><div class = "filterButton-dropdown" style= "display: none;"></div></div>');
        if(!self.showFilters) {
            self.hideFilter();
        }
        $.each( self.selections, function( key, value ) {
            $(".filterButton-dropdown",$(self.container)).append('<li><input type="checkbox" name="'+key+'" class = "'+value+' n5-ui-select-checkbox" checked><span class = "checkbox-label">'+key+'</span></li>');
        });
        $(".filterButton-button", $(self.container)).click(function () {
            $(".filterButton-dropdown", $(self.container)).slideToggle();
        });        
    };

    selectPrototype.hideFilter = function() {
        var self = this;
        $(".filterButton", $(self.container)).hide();
    };

    selectPrototype.showFilter = function() {
        var self = this;
        $(".filterButton", $(self.container)).show();
    };

    return akzo;
}(jQuery, native5, akzo || {}));