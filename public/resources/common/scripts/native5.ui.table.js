/*jshint loopfunc: true, quotmark:false */
/*global jQuery, console, getPagerString */
var native5 = (function($, native5) {
    "use strict";
    native5.ui = native5.ui || {};

    var generateTableString = function(jsonData) {
        try {
            var data = $.parseJSON(jsonData);

            var tableClass = data.tableClass || "";
            var tableId = data.tableId || "";
            var headerLength = 0;
            var footerLength = 0;
            var rows = 0;

            if(data.header) {
                headerLength = data.header.length;
            }
            if(data.footer) {
                footerLength = data.footer.length;
            }
            if(data.rows) {
                rows = data.rows.length;
            }

            var tableElm = "<table class='" + tableClass + "' id='" + tableId + "'>";

            if(headerLength > 0) {
                tableElm += "<thead><tr>";
                $.each(data.header, function(key, value) {
                    tableElm += "<th>" + value + "</th>";
                });
                tableElm += "</tr></thead>";
            }

            if(footerLength > 0) {
                tableElm += "<tfoot><tr>";
                $.each(data.footer, function(key, value) {
                    tableElm += "<th>" + value + "</th>";
                });
                tableElm += "</tr></tfoot>";
            }

            if(rows > 0) {
                tableElm += "<tbody>";
                $.each(data.rows, function(key, value){
                    tableElm += "<tr>";
                    $.each(value, function(k, v) {
                        if(!v || v === " ") {
                            v = "-";
                        }
                        tableElm += "<td>" + v + "</td>";
                    });
                    tableElm += "</tr>";
                });
                tableElm += "</tbody>";
            }
            tableElm += "</table>";
            return tableElm;
        } catch(err) {
            return "Invalid JSON data provided";
        }
    };

    native5.ui.table = function(params) {
        var opts = params || {};
        var elm = opts.table;
        var tableData = opts.tableData;
        var tableTheme = "", tableString = "";
        if(!elm && !tableData) {
            return;
        }

        var parentElm = opts.parentElm || $("body");
        tableTheme = opts.theme || "bootstrap";

        if(tableData) {
        	tableString = generateTableString(tableData);
        }

        if(tableString === "Invalid JSON data provided") {
        	return;
        }

        this.render = function(redraw) {
            if(!redraw) {
                if(!elm) {
                    $(parentElm).append(tableString);
                    elm = $(parentElm).children("table")[0];
                }
                $("td", $(elm)).each(function() {
                    if(!$(this).html() || $(this).html() === " ") {
                        $(this).html("-");
                    }
                });
                $(elm).addClass(opts.tableClass);

            }

            if(opts.isPaginated) {
                var length = $(elm).children("tfoot").length;
                var output = getPagerString(tableTheme);

                if(length > 0) {
                    var tfootElm = $(elm).children("tfoot")[length - 1];
                    $(tfootElm).append(output);
                } else {
                    $(elm).append("<tfoot>" + output + "</tfoot>");
                }

            }
        };

        this.addDataAtIndex = function(jsonData, index, callback){
            if(!jsonData) {
                return;
            }
            var bodyElm = $(elm).children("tbody")[0];
            var columns = $(bodyElm).find("tr:first td").length;

            try {
                var data = $.parseJSON(jsonData);
                var rows = data.rows.length;
                var tableElm = "";
                if(rows > 0) {
                    $.each(data.rows, function(key, value){
                        var rowLength = Object.keys(value).length;
                        tableElm += "<tr>";
                        $.each(value, function(k, v) {
                            if(!v || v === " ") {
                                v = "-";
                            }
                            tableElm += "<td>" + v + "</td>";
                        });
                        while(columns > rowLength) {
                            tableElm += "<td>-</td>";
                            rowLength++;
                        }
                        tableElm += "</tr>";
                    });
                }
                $(bodyElm).find("tr").eq(index-1).after(tableElm);
                if(callback) {
                    callback();
                }
                return "Successfully added the JSON data";
            } catch(err) {
                // console.log(err);
                return "Invalid JSON data provided";
            }
        };
        this.addData = function(jsonData, callback) {
            if(!jsonData) {
                return;
            }
            var bodyElm = $(elm).children("tbody")[0];
            var columns = $(bodyElm).find("tr:first td").length;
            try {
                var data;
                if(typeof jsonData === "string") {
                    data = $.parseJSON(jsonData);
                } else {
                    data = jsonData;
                }
                var rows = data.rows.length;
                var tableElm = "";
                if(rows > 0) {
                    $.each(data.rows, function(key, value){
                        var rowLength = Object.keys(value).length;
                        tableElm += "<tr>";
                        $.each(value, function(k, v) {
                            if(!v || v === " ") {
                                v = "-";
                            }
                            tableElm += "<td>" + v + "</td>";
                        });
                        while(columns > rowLength) {
                            tableElm += "<td>-</td>";
                            rowLength++;
                        }
                        tableElm += "</tr>";
                    });
                }

                $(bodyElm).append(tableElm);


                if(callback) {
                    callback();
                }
                return "Successfully added the JSON data";
            } catch(err) {
                return "Invalid JSON data provided";
            }
        };
        this.getRows = function() {
            var bodyElm = $(elm).children("tbody")[0];
            var rows = $(bodyElm).find("tr").length;
            return rows;
        };
        this.getColumns = function() {
            var bodyElm = $(elm).children("tbody")[0];
            var columns = $(bodyElm).find("tr:first td").length;
            return columns;
        };
        this.addDuplicateRows =function(jsonData, noOfRows, callback) {
            if(!jsonData) {
                return;
            }
            var bodyElm = $(elm).children("tbody")[0];
            var columns = $(bodyElm).find("tr:first td").length;
            try {
                var data = $.parseJSON(jsonData);
                var rows = data.rows.length;
                var tableElm = "";
                if(rows > 0) {
                    for (var i=0; i<noOfRows; i++)
                    {
                        $.each(data.rows, function(key, value){
                            var rowLength = Object.keys(value).length;
                            tableElm += "<tr>";
                            $.each(value, function(k, v) {
                                if(!v || v === " ") {
                                    v = "-";
                                }
                                tableElm += "<td>" + v + "</td>";
                            });
                            while(columns > rowLength) {
                                tableElm += "<td>-</td>";
                                rowLength++;
                            }
                            tableElm += "</tr>";
                        });
                    }
                }
                $(bodyElm).append(tableElm);
                if(callback) {
                    callback();
                }
                return "Successfully added the JSON data";
            } catch(err) {
                return "Invalid JSON data provided";
            }
        };
        this.addColumn =function(jsonData, noOfCols, indexstart, classAdd) {
            var bodyElm = $(elm).children("tbody")[0];
            var headElm = $(elm).children("thead")[0];
            var data = $.parseJSON(jsonData);
            for (var i=0;i<noOfCols; i++) {
                var trBody = $(bodyElm).find("tr");
                $(trBody).find("td:last").before('"<td class="'+ classAdd +'"> '+ data.col + '</td>"');
                var thHead =  $(headElm).find("tr");
                $(thHead).find("th:last").before('"<th class="'+ classAdd +'">Lap Rate ' + indexstart + '</th>"');
                indexstart++;
            }
        };
        this.addColumnatIndex =function(jsonData, index, label) {
            var bodyElm = $(elm).children("tbody")[0];
            var headElm = $(elm).children("thead")[0];
            var data = $.parseJSON(jsonData);     
            $(bodyElm).find("tr").each(function() {
                $(this).find("td").eq(index-1).after("<td>" + data.col + "</td>");
            });
            $(headElm).find("tr").each(function() {
                $(this).find("th").eq(index-1).after("<th>Lap Rate" + label + "</th>");
            });
        };
        this.deleteColumnIndex = function(index){
            var bodyElm = $(elm).children("tbody")[0];
            var headElm = $(elm).children("thead")[0];
            $("tr", $(bodyElm)).each(function() {
                $(this).find("td").eq(index - 1).remove();
            });
            $("tr", $(headElm)).each(function() {
                $(this).find("th").eq(index - 1).remove();
            });
        };
        this.deleteColumn = function(noOfCols) {
            var bodyElm = $(elm).children("tbody")[0];
            var headElm = $(elm).children("thead")[0];
            for (var i=1; i<=noOfCols;i++) {
                var trBody = $(bodyElm).find("tr");
                $(trBody).find("td:last").prev("td").remove();
                var thHead =  $(headElm).find("tr");
                $(thHead).find("th:last").prev("th").remove();
            }
        };
        this.deleteRows = function(noOfRows) {
            var bodyElm = $(elm).children("tbody")[0];
            for (var i=0;i<noOfRows;i++) {
                $(bodyElm).find("tr:last").remove();
            }
        };
        // P2 : Animation is very jarring during reset state, make it a little smoother by fading in/out.

        
        // P2 : Animation is very jarring during reset state, make it a little smoother by fading in/out.
        this.setTheme = function(theme) {
            if(!theme) {
                return;
            }
            $("#pagerControl", $(elm)).remove();
            tableTheme = theme;
            this.render(true);

            var classes = $(elm).attr("class").split(" ");
            $(elm).attr("class", classes.join(" "));
            $(elm).trigger("change");
        };

        this.on = function(eventStr, callback) {
            if(eventStr === "click") {
                var bodyElm = $(elm).children("tbody")[0];
                $("td", $(bodyElm)).each(function() {
                    var retObj = [];
                    $(this).unbind(eventStr);
                    $(this).bind(eventStr, function() {
                        var row = $("tr", $(bodyElm)).index($(this).parent());
                        var col = $(this).parent().children().index($(this));
                        var val = $(this).html();
                        retObj.push(row, col, val);
                        callback(retObj);
                    });
                });
            }
        };

        return this;
    };
	return native5;
}(jQuery, native5 || {}));
