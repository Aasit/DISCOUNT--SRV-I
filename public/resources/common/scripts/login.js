/* jshint loopfunc: true, quotmark:false */
/* global jQuery:false, form: false, console: false */
(function ($) {
    "use strict";

    var loginProgress = new native5.ui.Loader({style: "gif"});
    loginProgress.render();
    
    function loginSuccess(data) {
        if (data.message) {
            $(".error-msg").html(data.message.message);
            $(".login-wrapper").css("height", "280px");
            loginProgress.hideLoadingMessage();
        }
            
    }

    function loginError(err) {
        // console.log("error: "+ err);
        $(".error-msg").html("Invalid Credentials");
        $(".login-wrapper").css("height", "280px");
        loginProgress.hideLoadingMessage();
    }

    $("#form-login").submit(function(e){
        e.preventDefault();
        loginProgress.showLoadingMessage({blocking: true});
        var arr = form.emptyFields({formId: "form-login"});
        var arr2 = form.validate({formId: "form-login"});
        if(arr.length == 0 && arr2.length == 0) {
            form.submit({
                'formId' : "form-login",
                'serviceURL' : "login",
                'successHandler' : loginSuccess,
                'errorHandler' : loginError
            })
        }
    });

}(jQuery));
