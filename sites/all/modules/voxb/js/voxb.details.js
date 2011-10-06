/**
 * @file
 *
 * Get ratings for search results page.
 */
/**
* Generate rating stars method
*/
function voxb_draw_rating(rating) {
  var rating_container = $('<div>').addClass('addRatingContainer');
  var tpl = $('<div>').addClass('rating');
  for(i = 1; i <= 5; i++) {
   var x = tpl.clone().addClass((i<=rating ? 'star-on' : 'star-off'));
   rating_container.append(x);
  }
  return rating_container;
}

$(document).ready(function(){
  var ids = new Array();
  $('.rating-for-faust div').each(function(index){
    ids.push($(this).attr('class'));
  });
  if (ids.length > 0) {
    $.ajax({
      url:'/voxb/ajax/details',
      dataType: 'json',
      data: 'ids=' + ids.join(','),
      success: function(data) {
        $.each(data, function(key, value) {
          $('.rating-for-faust .' + key).append(voxb_draw_rating(value.rating));
        });
      }
    });
  }
});

$(document).ajaxComplete(function(event,request, settings){
  if(
    settings.url.search('/ting/search/js') == 0
  &&
    $('#ting-search-result').lenght != 0
  ){
    var ids = new Array();
    $('#ting-search-result li').each(function(index) {
      ids.push($(this).attr('id').substring($(this).attr('id').lastIndexOf(':') + 1));
    });
    if (ids.length > 0) {
      $.ajax({
        url:'/voxb/ajax/details',
        dataType: 'json',
        data: 'ids=' + ids.join(','),
        success: function(data) {
          var faust_prefix = $('#ting-search-result li:first').attr('id').substring(0, 6);
          $.each(data, function(key, value) {
            $('div#' + key).append(voxb_draw_rating(value.rating)).after('<div class="clearfix"></div>');
          });
        }
      });
    }
  }
});
