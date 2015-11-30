/*jshint loopfunc: true, quotmark:false */
/*global jQuery:false, native5:false, app: false */
var service = (function ($) {
    "use strict";

    var invoke = function (options) {
        window.app = {};
        app.registry = new native5.core.ServiceRegistry();
        
        app.config = {
            // path: "zqI9rp8Sy1409125725",
            path: "z5H8x1RT31406107752",
            // path: "akzo.discounts",
            method: options.method || 'POST',
            mode:'ui',
            count:3
        };

        var config = $.extend(true, {}, app.config);

        var opts = options || {};
        var serviceURL = opts.serviceURL || {};
        var invokeData = opts.invokeData || {};
        var successHandler = opts.successHandler || null;
        var errorHandler = opts.errorHandler || null;
 
        if(!serviceURL) {
            return;
        }

        var serviceName = serviceURL.replace("/", "_");

        if(!app.registry.getService(serviceName)) {
            config.method = opts.method || "POST";
            var service = new native5.core.Service(
                serviceURL,
                config
            );
            service.configureHandlers(successHandler, errorHandler);
            app.registry.addService(serviceName, service);
        }
        return app.registry.getService(serviceName).invoke(invokeData);
    };

    return {
        invoke: invoke,
    };
}(jQuery, service || {}));
