/*jshint loopfunc: true, quotmark:false */
/*global jQuery:false, service: false */
var form = (function ($) {
    "use strict";

    // Following function converts the output JSON of serializeArray() to JavaScript object
    $.fn.serializeObject = function() {
        var object = {};
        var jsonArray = this.serializeArray();
        $.each(jsonArray, function() {
            if (object[this.name] !== undefined) {
                if (!object[this.name].push) {
                    object[this.name] = [object[this.name]];
                }
                object[this.name].push(this.value || '');
            } else {
                object[this.name] = this.value || '';
            }
        });
        return object;
    };

    function _trimSpaces (str) {
        str = str.replace(/^\s+/, '');
        for (var i = str.length - 1; i >= 0; i--) {
            if (/\S/.test(str.charAt(i))) {
                str = str.substring(0, i + 1);
                break;
            }
        }
        return str;
    }

    // Testing functions | returns bool
    var isEmail = function(email){
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(_trimSpaces(email));
    };

    // Testing functions | returns bool
    var isPassword = function(pass){
        var regex = /^([\x20-\x7F]{3,16})$/;
        return regex.test(pass);
    };

    // Testing functions | returns bool
    var isText = function(text) {
        //var regex = new RegExp("^([a-zA-Z0-9_.+-\\s]+)$");
        var regex = /^([a-zA-Z0-9\.\+\-\s]+)$/;
        return regex.test(_trimSpaces(text));
    };

    // Checks if any field is empty/unselected by the user. If yes then returns the array of those fields.
    var checkEmptyForm = function(options) {
        var opts = options || {};
        var formId = opts.formId || "";
        var returnArray = [];

        if(!formId) {
            return;
        }

        var validateData = $("#" + formId).serializeObject();

        $.each(validateData, function(key, value) {
            if(!value) {
                returnArray.push(key);
            }
        });

        return returnArray;
    };

    // Validates all the inputs in a form and returns the failed elements in an arra.
    var validate = function(options) {
        var opts = options || {};
        var formId = opts.formId || "";
        var invalidArr = [];

        $("#" + formId + " *").filter(':input').each(function(){
            var validInput = true;

            if($(this).prop("type").toLowerCase() === "email") {
                validInput = isEmail($(this).val());
            } else if($(this).prop("type").toLowerCase() === "password") {
                validInput = isPassword($(this).val());
            } 
            // else if($(this).prop("type").toLowerCase() === "text") {
            //     validInput = isText($(this).val());
            // }

            if(!validInput) {
                invalidArr.push($(this).prop("name"));
            }
        });

        return invalidArr;
    };

    // Submits the form using JavaScript
    var submit = function(options) {
        var opts = options || {};
        var formId = opts.formId || "";
        var serviceURL = opts.serviceURL || "";
        var successHandler = opts.successHandler || {};
        var errorHandler = opts.errorHandler || {};

        if(!formId || !serviceURL) {
            return;
        }

        var postData = $("#" + formId).serializeArray();

        return service.invoke({serviceURL: serviceURL, invokeData: postData, successHandler: successHandler, errorHandler: errorHandler});
    };
    
    return {
        emptyFields: checkEmptyForm,
        validate: validate,
        submit: submit,
    };
}(jQuery, form || {}));