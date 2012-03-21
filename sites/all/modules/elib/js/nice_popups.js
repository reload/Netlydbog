jQuery(document).ready(function($) {
  $('a.nice-popup').live('click', function() {
    var href = $(this).attr('href');

    clicked = $(this);
    clicked.parent().find('.ajax-loader').remove();
    clicked.hide();
    clicked.parent().append('<div class="ajax-loader"></div>');

    $('<iframe id="iframe_inside_dialog" width="100%" height="100%" marginWidth="0" marginHeight="0" frameBorder="0" scrolling="auto"></iframe>').dialog({
      modal     : true,
      width     : 'auto',
      height    : 'auto',
      resizable : true,
      //buttons: popup_buttons
    });

    $('#iframe_inside_dialog').attr('src', href + '/');
    clicked.parent().find('.ajax-loader').remove();
    clicked.show();

    return false; 
  });
});
