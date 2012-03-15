jQuery(document).ready(function($) {
  $('a.nice-popup').live('click', function() {
    var href = $(this).attr('href');

    clicked = $(this);
    clicked.parent().find('.ajax-loader').remove();
    clicked.hide();
    clicked.parent().append('<div class="ajax-loader"></div>');

    $.ajax({
      type     : 'post',
      url      : href,
      dataType : 'html',
      success  : function(response) {
        clicked.parent().find('.ajax-loader').remove();
        clicked.show();
        $('<div id="nice_popup_response">' + response + '</div>').dialog({
          modal  : true,
          width  : 'auto',
          height : 'auto',
          //buttons: popup_buttons
        });
      }
    })
    return false; 
  });
});
