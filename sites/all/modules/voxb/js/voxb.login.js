(function ($) {
  $(document).ready(function() {
    if ($('body').hasClass('section-users') && $('body').hasClass('logged-in')) {
      $('#voxb-user-create').remove();
      
      $.ajax({
        async: false,
        type: 'post',
        url: '/voxb/ajax/user/login',
        dataType: 'json',
        success: function(msg) {
          if (!msg.status) {
            var html = '<div id="voxb-user-create" style="text-align: center;">';
            html += '<p>' + Drupal.t('Please provide a username used in your reviews.') + '</p>';
            html += '<br />';
            html += '<p><input type="text" name="alias-name" value="" /></p>';
            html += '</div>';
            $('body').append(html);

            $('#voxb-user-create').dialog({
              title : Drupal.t('VoxB username'),
              modal : true,
              width: 'auto',
              height: 'auto',
              buttons: {
                "OK" : function() {
                  create_user($('#voxb-user-create input[name=alias-name]').val());
                }
              }
            });
          }
        }
      });
    }

    create_user = function(alias_name) {
      $('#voxb-user-create-message').remove();
      
      if (alias_name != '') {
        $.ajax({
          async: false,
          type: 'post',
          url: '/voxb/ajax/user/create',
          data: { 'alias_name' : alias_name },
          dataType: 'json',
          success: function(msg) {
            if (msg.status) {
              $('#voxb-user-create').dialog('close');
            }
          }
        });
      }
      else {
        var html = '<div id="voxb-user-create-message" style="text-align: center;"><p>' + Drupal.t('Please, fill in a name.') + '</p></div>';
        $('body').append(html);

        $('#voxb-user-create-message').dialog({
          title : Drupal.t('Error'),
          modal : true,
          width: 'auto',
          height: 'auto',
          buttons: {
            "OK" : function() {
              $(this).dialog('close');
            }
          }
        });
      }
    }
  });
})(jQuery);
