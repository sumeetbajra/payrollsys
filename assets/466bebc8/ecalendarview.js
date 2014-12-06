/**
 * ecalendarview.js
 *
 * @author Martin Ludvik <matolud@gmail.com>
 * @copyright Copyright &copy; 2014 by Martin Ludvik
 * @license http://opensource.org/licenses/MIT MIT license
 */

!function($) {
  $.fn.ecalendarview = function(links) {
    this.on('click', '.navigation-link', function(links) {
      if(links == undefined){
        links = $(this).attr('href');
      }
      $.ajax({
        'url': links,
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