var native5 = (function(native5){
    native5.ui = native5.ui || {};

    /**
     * Creates a new filter menu.
     * Usage : 
     *      var filter = new native5.ui.filtermenu(params);
     * 
     *
     */
    native5.ui.filtermenu = function(params){
        this.container = params.container;
        this.filterElm = params.filter;
        this.contentElm = params.content;
        this.button = params.button;
        this.width = params.width;
        this.duration = params.duration || 500;
        this._open = false;
        this._height = $(this.container).height() - 10;
        this._lastPos = 0;
        this._currPos = 0;

        $(this.filterElm).hide();
        this.filterElm.height(this._height);
        var self = this;
        $(this.button).click(function(){
            self.toggle();
        });

        $(this.container).parent().scroll(function() {
            self._currPos = $(self.container).parent().scrollLeft();
            if ((self._lastPos < (self._currPos - 5)) || (self._lastPos > (self._currPos + 5))) {
                self.close();
            }
            self._lastPos = self._currPos;
        });


    }

    var fprototype = native5.ui.filtermenu.prototype;
    fprototype.open = function(){
        $(this.contentElm).animate({
                left: this.width
            }, 
            {
                duration: this.duration,
                queue: false
        });

        $(this.filterElm).animate({
                width: this.width
            }, 
            {
                duration: this.duration,
                queue: false
        });
        $(this.filterElm).fadeIn(3*this.duration);
        $(this.contentElm).css("margin-left", "10px");
        this._open = true;
    }

    fprototype.close = function(){
        $(this.filterElm).fadeOut("fast");
        $(this.contentElm).animate({
                left: 0
            }, 
            {
                duration: this.duration,
                queue: false
        });

        $(this.filterElm).animate({
                width: 0
            }, 
            {
                duration: this.duration,
                queue: false
        });
        $(this.contentElm).css("margin-left", 0);

       this._open = false;
   }

   fprototype.toggle = function(){
        if(!this._open) {
            //code to open
            this.open();
        }
        else {
            //code to close
            this.close();
        }
    }


    return native5;
}(native5 || {}));
