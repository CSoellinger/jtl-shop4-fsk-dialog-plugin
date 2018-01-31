(function ($) {
  $.fn.maxlength = function (options) {
    var t = $(this);
    t.each(function () {
      console.log('do magic');
      $(this).keypress(function (event) {
        var key = event.which;

        //all keys including return.
        if (key >= 33 || key == 13 || key == 32) {
          var maxLength = $(this).attr('maxlength');
          var length = this.value.length;
          if (length >= maxLength) {
            event.preventDefault();
          }
        }
      });
    });
    return t;
  };
})(jQuery);
