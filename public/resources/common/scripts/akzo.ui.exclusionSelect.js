/* jshint loopfunc: true, quotmark:false */
/* global jQuery, native5, akzo, prodExclusionModal */

var akzo = (function($, native5, akzo){
    "use strict";

    akzo.ui = akzo.ui || {};

    var selectInclude = $("#selectInclude");
    var selectResult = $("#selectResult");

    akzo.ui.exclusionSelect = function(type) {
        selectInclude.select2("destroy");
        selectInclude.next().remove();

        if(!type) {
            type = "products";
        }

        createMultiselect({
            input: selectInclude,
        }, type);
    };

    akzo.ui.exclusionSelect.result = function(elm, type) {
        var data = $(elm).data("products");

        selectInclude.select2("data", []);
        selectResult.empty();

        addSelection(selectInclude);
        removeSelection(selectInclude);

        if(!$.isEmptyObject(data)) {
            if(typeof data === "string") {
                data = JSON.parse(data);
            }
            
            $.each(data, function(key, value) {
                var excluded = value.excluded;
                var list = "<div class = 'dealertype-value-container' data-products='" + JSON.stringify(value) + "'>";

                if(excluded) {
                    list += '<button class = "include dealertype-action-button product-exclusion-select">Include</button>' +
                        '<button class = "exclude dealertype-action-button product-exclusion-select selected">Exclude</button>';
                } else {
                    list += '<button class = "include dealertype-action-button product-exclusion-select selected">Include</button>' +
                        '<button class = "exclude dealertype-action-button product-exclusion-select">Exclude</button>';
                }

                list +=  "<div class='dealertype-value'>" + value.name + "</div></div>";
                selectResult.append(list);
            });

            selectInclude.select2("data", data, true);
            setSelectEvent();
        }
        $("#prodExclusionSubmit").off("click");
        $("#prodExclusionSubmit").on("click", function() {
            if(type==="products") {
                $(elm).next().remove();
            }
            var products = [];
            var resultStr = "";

            $(selectResult.children()).each(function() {
                var val = $(this).data("products");
                products.push(val);
                if(val.excluded) {
                    resultStr += "- ";
                } else {
                    resultStr += "+ ";
                }
                resultStr += val.name + ", ";
            });

            resultStr = resultStr.substring(0, 50);
            resultStr = "<div>" + resultStr + "</div>";

            $(elm).data("products", products);
            if(type==="products") {
                $(elm).parent().append(resultStr);    
            }
            $(elm).trigger("change");
            prodExclusionModal.closeModal();
        });

        selectAllProducts();
    };

    function addSelection(elm) {
        $(elm).off("select2-selecting");

        $(elm).on("select2-selecting", function(e) {
            var selection = e.object;
            selection.excluded = false;
            var list = "<div class = 'dealertype-value-container' data-products='" + JSON.stringify(selection) + "'>";

            list += '<button class = "include dealertype-action-button product-exclusion-select selected">Include</button>' +
                    '<button class = "exclude dealertype-action-button product-exclusion-select">Exclude</button>';

            list +=  "<div class='dealertype-value'>" + selection.name + "</div></div>";
            selectResult.append(list);
            setSelectEvent();
        });
    }

    function removeSelection(elm) {
        $(elm).off("select2-removing");

        $(elm).on("select2-removing", function(e) {
            var selection = e.val;

            var lists = selectResult.children();

            $(lists).each(function() {
                var text = $(".dealertype-value", $(this)).text();
                if(text === selection) {
                    $(this).remove();
                }
            });
        });
    }

    function selectAllProducts() {
        $(".product-manipulate-all").on("click", function() {
            var text = $(this).text();
            var lists = selectResult.children();

            $(lists).each(function() {
                if(text === "Include All") {
                    $(".include", $(this)).click();
                } else {
                    $(".exclude", $(this)).click();
                }
            });

            $(".product-manipulate-all").removeClass("selected");
            $(this).addClass("selected");
        });
    }

    function setSelectEvent() {
        $(".product-exclusion-select").on("click", function() {
            var buttons = $(this).parent().children("button");
            $(buttons).removeClass("selected");
            $(this).addClass("selected");
            var parent = $(this).parent();
            var data = $(parent).data("products");
            var text = $(this).text();

            if(text === "Include") {
                data.excluded = false;
            } else {
                data.excluded = true;
            }

            $(parent).data("products", data);
            $(".product-manipulate-all").removeClass("selected");
        });
    }

    function createMultiselect(obj, type) {
        var defaults = {
            input: "",
        };
        var selection, searchURL, placeholder;

        defaults = $.extend({}, defaults, obj);

        // type = geography
        var geoSelections = {
            "depots": "depot-select",
            "zones": "zone-select",
            "regions": "region-select",
            "dealers": "delaer-select",
        };

        // type = products
        var prodSelections = {
            products: "product-select",
            groups: "group-select",
            subbrands: "subbrand-select",
            clusters : "cluster-select",
        };

        // type = town
        var townSelections = {};

        if(type === "products") {
            selection = prodSelections;
            searchURL = "template/products";
            placeholder = "Search Products";
        } else if(type === "geography") {
            selection = geoSelections;
            searchURL = "template/geography";
            placeholder = "Search Geography";
        } else {
            selection = townSelections;
            searchURL = "template/towns";
            placeholder = "Search Towns";
        }

        new akzo.ui.select.multiple({
            inputElm            : defaults.input,
            serviceURL          : searchURL,
            listClass           : "demo-search-list",
            containerCssClass   : "n5-template1",
            selections          : selection,
            placeholder         : placeholder,
            showFilters         : true,
            cached              : defaults.cached,
        });
    }

    return akzo;
}(jQuery, native5, akzo || {}));