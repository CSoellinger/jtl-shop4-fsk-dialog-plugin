/**
 * Extend jQuery with input maxlength function if not exists
 * 
 * @author PixelCrab <cs@pixelcrab.at>
 * @copyright 2016 PixelCrab
 * 
 * @global jQuery|$
 */

(function ($) {
  if (!$.fn.maxlength) {
    $.fn.maxlength = function (options) {
      var t = $(this);
      t.each(function () {
        $(this).keypress(function (event) {
          var key = event.which;
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
  }
})(jQuery);
