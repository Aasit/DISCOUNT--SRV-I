/*jshint loopfunc: true, quotmark:false */
/*global app, native5, service, jQuery */
(function ($) {
    "use strict";

    //header button options
    var textLength = 22;
    var notif = "You got a notification";
    var finishString = "";
    if(textLength<notif.length){
        finishString = "...";
    }

    //derive data from notifData
    var notifData = service.invoke({serviceURL: "dashboard/getNotificationData"});
    notifData.done(function(data) {
        var ndata = data.message;

        $.each(ndata, function(key, value) {
            if(value.messageType === "notification") {
                value.imageStr = "<span class='icon-span blue'><i class='fa fa-user'></i></span>";
            } else if (value.messageType === "warning") {
                value.imageStr = "<span class='icon-span red'><i class='fa fa-warning'></i></span>";
            } else if(value.messageType === "success") {
                value.imageStr = "<span class='icon-span green'><i class='fa fa-comment'></i></span>";
            }

            ndata[key] = value;
        });
        // console.log(ndata);

        var nddown = new native5.ui.dropdown($("#header-notifications"), {listHasImage: true,
            maxHeight: "450px",
            listHeader: "<span>5 New Notifications</span>",
            listFooter: "<span><a href = '#'>View All Notifications</a></span>",
            listHasHeader: true,
            listHasFooter: true,
            width: 300,
            showArrow: true,
            listClass: "notification-dropdown",
            top: "50px"
        });
        nddown.render(ndata);
    });

    var pdata = [
        {imageStr: "<i class='fa fa-tags'></i>", textStr: "Profile"},
        {imageStr: "<i class='fa fa-key'></i>", textStr: "Logout"}
        
    ];

    var pddown = new native5.ui.dropdown($("#header-profile"), {listHasImage: true,
        maxHeight: "200px",
        width: 150,
        showArrow: true,
        listClass: "notification-dropdown",
        top: "50px"
    });
    pddown.render(pdata);
    pddown.addEvents({
        "listEvents" : [function(){}, logout]
    });

    function logout(){
        service.invoke({serviceURL: "logout"});
    }    

    window.getParameterByName = function (name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    };

    var locationPath = location.pathname.split("/")[1];
    if(locationPath) {
        locationPath = "/" + locationPath;
    }

    window.absPath = location.protocol + "//" + location.hostname + "/" + app.config.path;
}(jQuery));

/*jshint unused:false*/
/*global $*/
function createCard(elm, id, title, icon, width){
    var options = {
        "contentElm" : $(elm),
        "cardId" : id,
        "title": title,
        "theme": "blue",
        "collapsed": false,
        "width": width || null
    };
    var card = new native5.ui.card(options);
    card.init();
    card.setIcon("<i class='fa "+icon+"'></i>");
    card.render();
}
