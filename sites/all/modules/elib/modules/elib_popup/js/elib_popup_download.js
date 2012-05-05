(function ($) {
  $('.ebog-dlink').live('click', function() {
    $('#ting-download-popup-info').dialog('close');
  });
  
  var href = '';
  var clicked = null;
  var button = null;
  var popup_buttons = null;
  var ok_button = Drupal.t('Ok');
  var cancel_button = Drupal.t('Cancel');
  var download_button = Drupal.t('Proceed to download');

  // Handle clicked loan link, those matching 'ting/object/%/download' pattern
  $(document).ready(function() {
    $('a[action="download"], a[action="stream"]').live('click', function() {
      href = $(this).attr('href');

      clicked = $(this);
      clicked.parent().find('.ajax-loader').remove();
      clicked.hide();
      clicked.parent().append('<div class="ajax-loader"></div>');

      if (clicked.hasClass('re-loan')) {
        $('#ting-download-popup').remove();
        clicked.parent().find('.ajax-loader').remove();
        clicked.show();

        popup_buttons = {};
        popup_buttons[ok_button] = function() {
          button = $('#ting-download-popup').parents('.ui-dialog:first').find('button');
          button.css('visibility', 'hidden');
          button.parent().append('<div class="ajax-loader"></div>');
          process_loan();
        }

        popup_buttons[cancel_button] = function() {
          $('#ting-download-popup').dialog('close');
        }

        $('<div id="ting-download-popup" title="' + Drupal.t('Confirm reloan') + '">' + Drupal.t('Are you sure you want to reloan this item') + ' (<a href=' + '"' + '/faq/generelt-0#31n128' + '">' + Drupal.t('read more') + '</a>)?' + '</div>').dialog({
          modal : true,
          width: 'auto',
          height: 'auto',
          buttons: popup_buttons
        });
      }
      else {
        process_loan();
      }

      return false;
    });

    // Process loan/reloan/download
    var process_loan = function() {
      $.ajax({
        type : 'post',
        url : href + '/popup',
        dataType : 'json',
        success : function(response) {
          $('#ting-download-popup').remove();
          clicked.parent().find('.ajax-loader').remove();
          clicked.show();

          popup_buttons = {};

          if (response.status == false) {
            popup_buttons[ok_button] = function() {
              $('#ting-download-popup').dialog('close');
            }

            $('<div id="ting-download-popup" title="' + response.title + '">' + response.content + '</div>').dialog({
              modal : true,
              width: 'auto',
              height: 'auto',
              buttons: popup_buttons
            });

            return;
          }

          if (response.processed && response.processed == true) {
            // Prepare download popup buttons
            if (response.platform == 2) {
              popup_buttons[ok_button] = function() {
                $('#ting-download-popup').dialog('close');
              }
              popup_buttons[cancel_button] = function() {
                $('#ting-download-popup').dialog('close');
              }
            }
            else {
              // Prepare the stream popup
              popup_buttons = {};
              popup_buttons[cancel_button] = function() {
                $('#ting-download-popup').dialog('close');
              }

              // Prepare popup content
              response.content = Drupal.t('Click on the Strem link in order to start streaming of this audiobook.') + '<br />' + '<a href="' + response.stream + '" target="_blank">' + Drupal.t('Stream') + '</a>';
            }
          } else {
            popup_buttons[download_button] = function() {
              button = $('#ting-download-popup').parents('.ui-dialog:first').find('button');
              button.css('visibility', 'hidden');
              button.parent().append('<div class="ajax-loader"></div>');
              if (response.final && response.final == true) {
                $('#ting-download-popup').dialog('close');
              } else {
                check_rules();
              }
            }
            popup_buttons[cancel_button] = function() {
              $('#ting-download-popup').dialog('close');
            }
          }
          $('<div id="ting-download-popup" title="' + response.title + '">' + response.content + '</div>').dialog({
            modal : true,
            width: 'auto',
            height: 'auto',
            buttons: popup_buttons
          });
        }
      });
    }

    // Check those checkboxes
    var check_rules = function() {
     
      $.ajax({
        type : 'post',
        url : href + '/request',
        dataType : 'json',
        success : function(response) {
          button.css('visibility', 'visible');
          button.parent().find('.ajax-loader').remove();
          $('#ting-download-popup').dialog('close');
          $('#ting-download-popup-info').remove();
          var options = {};
          if (response.status == false) {
            popup_buttons = {};
            popup_buttons[ok_button] = function() {
              $('#ting-download-popup-info').dialog('close');
            }

            options = {
              modal: true,
              width: 'auto',
              height: 'auto',
              buttons: popup_buttons
            }

            $('<div id="ting-download-popup-info" title="' + response.title + '">' + response.content + '</div>').dialog(options);
          }
          else {
            if (response.processed && response.processed == true) {
              if (response.platform == 2) {
                popup_buttons[ok_button] = function() {
                  $('#ting-download-popup-info').dialog('close');
                }
                popup_buttons[cancel_button] = function() {
                  $('#ting-download-popup-info').dialog('close');
                }
              }
              else {
              // Prepare the stream popup
              popup_buttons = {};
              popup_buttons[cancel_button] = function() {
                $('#ting-download-popup-info').dialog('close');
              }

              // Prepare popup content
              response.content = Drupal.t('Click on the Strem link in order to start streaming of this audiobook.') + '<br />' + '<a href="' + response.stream + '" target="_blank">' + Drupal.t('Stream') + '</a>';
              }
            } else {
              popup_buttons[download_button] = function() {
                button = $('#ting-download-popup').parents('.ui-dialog:first').find('button');
                button.css('visibility', 'hidden');
                button.parent().append('<div class="ajax-loader"></div>');
                $('#ting-download-popup-info').dialog('close');
              }
              popup_buttons[cancel_button] = function() {
                $('#ting-download-popup-info').dialog('close');
              }

              
            }
            $('<div id="ting-download-popup-info" title="' + response.title + '">' + response.content + '</div>').dialog({
                modal : true,
                width: 'auto',
                height: 'auto',
                buttons: popup_buttons
              });
          }
        }
      });
      return false;
    }
  });
})(jQuery);
