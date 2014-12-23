/**
 * ecalendarview.js
 *
 * @author Martin Ludvik <matolud@gmail.com>
 * @copyright Copyright &copy; 2014 by Martin Ludvik
 * @license http://opensource.org/licenses/MIT MIT license
 */

!function($) {
  $.fn.ecalendarview = function(link) {
    this.on('click', '.navigation-link', function() {
      $.ajax({
        'url': (link == undefined ? $(this).attr('href') : link),
        'context': $(this).parents('.e-calendar-view'),
        'cache': false,
        'success': function(data) {
          var calendarId = '#' + this.attr('id');
          var calendarData = $(calendarId, data);
          this.html(calendarData.html());
        }
      });
      return false;
    });
  }
}(window.jQuery);