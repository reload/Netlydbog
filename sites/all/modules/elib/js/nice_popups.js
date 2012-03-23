jQuery(document).ready(function($) {
  $('<iframe id="iframe_inside_dialog" width="100%" height="100%" marginWidth="0" marginHeight="0" frameBorder="0" scrolling="auto"></iframe>').dialog({
      modal    : true,
      width    : 'auto',
      height   : 'auto',
      resizable: true,
      autoOpen : false
      //buttons: popup_buttons
    }).bind('dialogclose', function(e, ui) {
      $(this).attr('src', '');
    });
  $('a.nice-popup').live('click', function() {
    var href = $(this).attr('href');

    clicked = $(this);
    clicked.parent().find('.ajax-loader').remove();
    clicked.hide();
    clicked.parent().append('<div class="ajax-loader"></div>');

    $('#iframe_inside_dialog').dialog('open').attr('src', href + '/');

    clicked.parent().find('.ajax-loader').remove();
    clicked.show();

    return false; 
  });
});
