/**
 * ecalendarview.js
 *
 * @author Martin Ludvik <matolud@gmail.com>
 * @copyright Copyright &copy; 2014 by Martin Ludvik
 * @license http://opensource.org/licenses/MIT MIT license
 */

!function($) {
  $.fn.ecalendarview = function(link) {
    if(link == undefined){
      link = '';
    }
    this.on('click', '.navigation-link', function(link) {
      if(link == ''){
        link = $(this).attr('href');
      }
      $.ajax({
        'url': link,
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