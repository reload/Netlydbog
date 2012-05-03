(function ($) {
  $('.ebog-dlink').live('click', function() {
    $('#ting-download-popup-info').dialog('close');
  });

  var href = '';
  var clicked = null;
  var dlg = null;

  // Handle clicked loan link, those matching 'ting/object/%/sample' pattern
  $(document).ready(function() {
    AudioPlayer.setup('/' + Drupal.settings.elib_popup.theme_path + "/js/audio-player/player.swf", {
      width: 'auto',
      leftbg: "7DAFC3",
      rightbg: "BECE8C",
      leftbghover: "ADCBD7",
      rightbghover: "C4D296",
      loader: "C4D296",
      transparentpagebg: "yes",
      autostart: 'yes'
    });

    $('a[action="sample"]').live('click', function() {
      href = $(this).attr('href');

      clicked = $(this);
      clicked.parent().find('.ajax-loader').remove();
      clicked.hide();
      clicked.parent().append('<div class="ajax-loader"></div>');

      process_sample();

      return false;
    });

    // Process loan/reloan/download
    var process_sample = function() {
      $.ajax({
        type : 'post',
        url : href + '/popup',
        dataType : 'json',
        success : function(response) {
          $('#ting-download-popup').remove();
          clicked.parent().find('.ajax-loader').remove();
          clicked.show();

          if (response.status == false) {
            popup_buttons = {};
            popup_buttons[ok_button] = function() {
              $('#ting-download-popup').dialog('close');
            }

            dlg = $('<div id="ting-download-popup" title="' + response.title + '">' + response.content + '</div>').dialog({
              modal : true,
              width: 'auto',
              height: 'auto',
              buttons: popup_buttons
            });

            if ($.browser.msie) {
              $(dlg).dialog('option', 'position', $(dlg).dialog('option','position'));
            }

            return;
          }

          dlg = $('<div id="ting-download-popup" title="' + response.title + '">' + response.content + '</div>').dialog({
            modal : true,
            width: 'auto',
            height: 'auto'
          });

          // Some special behavior for IE
          if ($.browser.msie) {
            $(dlg).dialog('option', 'position', $(dlg).dialog('option','position'));
            dlg.bind('dialogclose', function(event, ui){ $(this).remove(); });
          }

          AudioPlayer.embed("audio-player", {
            soundFile: response.file,
            titles: response.itemIitle,
            artists: response.itemAuthor
          });
        }
      });
    }
  });
})(jQuery);
