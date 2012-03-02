/**
 * @file
 *
 * Provides AJAX-ified rating, tagging, reviewing functionality.
 */

(function ($) {
  Drupal.voxb_item = {

    initial_rating : 0,
    rating_set : false,
    op: null,
    button: null,
    params: {},
    anim_conf : [
      {fadeout:200, stayout:100, opout:0, fadein:200, stayin:100, opin:1},
      {fadeout:200, stayout:100, opout:0, fadein:200, stayin:100, opin:1},
      {fadeout:200, stayout:100, opout:0, fadein:200, stayin:100, opin:1}
    ],

    // Show ajax loader.
    showAjaxLoader: function(container, el) {
      el.hide();
      var x = $('.ajaxLoaderTpl').clone();
      x.find('img').removeClass('ajax_anim');
      container.append(x);
    },
    // Hide ajax loader.
    hideAjaxLoader: function(container, el) {
      container.find('.ajaxLoaderTpl').remove();
      el.show();
    },

    // Init function, binds method to user input and sets variables.
    init: function() {
      Drupal.voxb_item.initial_rating = $('.addRatingContainer:first div.userRate div.star-on').length;
      // Bind ratings on mouse over and out
      $('.addRatingContainer').each(function() {
        var parent = $(this);
        parent.find('div.userRate div.rating').mouseover(function() {
          if (!Drupal.voxb_item.rating_set) {
            parent.find('div.userRate div.rating:lt(' + ($(this).parent().children().index($(this)) + 1) + ')').removeClass('star-off').removeClass('star-on').addClass('star-black');
            parent.find('div.userRate div.rating:gt(' + $(this).parent().children().index($(this)) + ')').removeClass('star-black').removeClass('star-on').addClass('star-off');
          }
        });
      });
      
      $('.addRatingContainer').each(function() {
        var parent = $(this);
        parent.find('div.userRate div.rating').mouseout(function() {
          if (!Drupal.voxb_item.rating_set) {
            // Restore the stars after mouseout
            parent.find('div.userRate div.rating:lt(' + Drupal.voxb_item.initial_rating + ')').removeClass('star-off').removeClass('star-black').addClass('star-on');
            parent.find('div.userRate div.rating:gt(' + (Drupal.voxb_item.initial_rating - 1) + ')').removeClass('star-on').removeClass('star-black').addClass('star-off');
          }
        });
      });

      // Rating submit handler.
      $('div.userRate div.rating').click(function() {
        if (!Drupal.voxb_item.rating_set) {
          Drupal.voxb_item.rating_set = true;
          Drupal.voxb_item.op = 'rate';
          Drupal.voxb_item.params = {
            'rating' : $(this).parent().children().index($(this)),
            'item' : $(this).parent().attr('id')
          };
          Drupal.voxb_item.button = null;

          if (Drupal.voxb_item.params.rating >= 0 && Drupal.voxb_item.params.item != '') {
            $('div.ratingsContainer .ajax_anim').show();
            
            Drupal.voxb_item.login_popup();
          }
        }
      });

      // Tag submit handler.
      $('#ding-voxb-tag-form .form-submit').click(function() {
        Drupal.voxb_item.op = 'tag';
        Drupal.voxb_item.params = {
          'tag' : $('#ding-voxb-tag-form input[name=name]').val(),
          'item' : $('#ding-voxb-tag-form input[name=faust_number]').val()
        };
        Drupal.voxb_item.button = $(this);

        if (Drupal.voxb_item.params.tag != '' && Drupal.voxb_item.params.item != '') {
          Drupal.voxb_item.showAjaxLoader(
            Drupal.voxb_item.button.parent(),
            Drupal.voxb_item.button
          );

          Drupal.voxb_item.login_popup();
        }

        return false;
      });

      // Review submit handler.
      $('#ding-voxb-review-form .form-submit').click(function() {
        Drupal.voxb_item.op = 'review';
        Drupal.voxb_item.params = {
          'review' : $('#ding-voxb-review-form textarea[name=review_content]').val(),
          'item' : $('#ding-voxb-review-form input[name=faust_number]').val()
        };
        Drupal.voxb_item.button = $(this);

        if (Drupal.voxb_item.params.review != '' && Drupal.voxb_item.params.item != '') {
          Drupal.voxb_item.showAjaxLoader(
            Drupal.voxb_item.button.parent(),
            Drupal.voxb_item.button
          );

          Drupal.voxb_item.login_popup();
        }

        return false;
      });

      // Pager on-click handler.
      $('#pager_block ul li a').livequery('click', function() {
        if ($(this).attr('href') != '#') {
          var ele = $(this);
          $.ajax({
            type:'post',
            url:ele.attr('href'),
            dataType:'text',
            success:function(msg) {
              $('#pager_block').html(msg);

              $.ajax({
                type:'post',
                url:ele.attr('href') + '/reviews',
                dataType:'text',
                success:function(msg) {
                  $('.userReviews').html(msg);
                }
              });
            }
          });
        }

        return false;
      });
    },

    // Review functionality.
    voxb_do_review: function(review, item, clicked) {
      var button = clicked;
      
      $.ajax({
        type:'post',
        url:'/voxb/ajax/review/' + item + '/' + review,
        dataType:'json',
        success:function(msg) {
          if (msg['status']) {
            var html = msg['message'];
            $('.userReviews').html(html);
            $('#ding-voxb-review-form .form-submit').val('Update');
            $('.addVideoReviewContainer').hide();

            $.ajax({
              type:'post',
              url:'/voxb/ajax/seek/' + item +'/1',
              dataType:'text',
              success:function(msg) {
                $('#pager_block').html(msg);
              }
            });
          }
          else if(!msg['status']) {
            var error = msg['message'];
            $('#dialog .ajax_message').html(error);
            $('#dialog').css({
              'top': $(window).scrollTop() + 100,
              'left': ($(window).width() / 2 - $('#dialog').width() / 2) + 'px'
            }).jqmShow();
          }
          Drupal.voxb_item.hideAjaxLoader(button.parent(), button);
        }
      });
    },

    // Rate functionality.
    voxb_do_rate: function(rating, item) {
      $('div.ratingsContainer .ajax_anim').show();
      
      $.ajax({
          type:'post',
          url:'/voxb/ajax/rating/' + item + '/' + (rating + 1),
          dataType:'json',
          success:function(msg) {
            $('div.ratingsContainer .ajax_anim').hide();
            if (msg['status']) {
              $('.ratingCountSpan').html('(' + msg['rating_count'] + ' ' + Drupal.t('Rates') + ')');
              // update rating
              Drupal.voxb_item.initial_rating = msg['rating'];
              $('.addRatingContainer').each(function() {
                parent = $(this);
                parent.find('div.userRate div.rating:lt(' + Drupal.voxb_item.initial_rating + ')').removeClass('star-off').removeClass('star-black').addClass('star-on');
                parent.find('div.userRate div.rating:gt(' + (Drupal.voxb_item.initial_rating - 1) + ')').removeClass('star-on').removeClass('star-black').addClass('star-off');
              }).cyclicFade({
                repeat: 3,
                params: Drupal.voxb_item.anim_conf
              });

            }
            else if (!msg['status']) {
              var error = msg['message'];
              $('#dialog .ajax_message').html(error);
              $('#dialog').css({
                'top': $(window).scrollTop() + 100,
                'left': ($(window).width() / 2 - $('#dialog').width() / 2) + 'px'
              }).jqmShow();
            }

            Drupal.voxb_item.rating_set = false;
          }
        });
    },

    // Tag functionality.
    voxb_do_tag: function(tag, item, clicked) {
      var button = clicked;
      
      $.ajax({
        type:'post',
        url:'/voxb/ajax/tag/' + item + '/' + tag,
        dataType:'json',
        success:function(msg) {
          if (msg['status']) {
            $('.recordTagHighlight').append('<span class="tag"><a href="/ting/search/'+msg['message']+'">'+msg['message']+'</a>&nbsp;</span>');
            $('.recordTagHighlight .tag:last').cyclicFade({
              repeat: 3,
              params: Drupal.voxb_item.anim_conf
            });
          }
          else if(!msg['status']) {
            var error = msg['message'];
            $('#dialog .ajax_message').html(error);
            $('#dialog').css({
              'top': $(window).scrollTop() + 100,
              'left': ($(window).width() / 2 - $('#dialog').width() / 2) + 'px'
            }).jqmShow();
          }
          Drupal.voxb_item.hideAjaxLoader(button.parent(), button);
          $('#ding-voxb-tag-form input[name=name]').val('');
        }
      });
    },

    // Login prompt functionality.
    login_popup: function(callback) {
      $('#voxb-user-create').remove();
      var voxb_status = false;
      
      $.ajax({
        async: false,
        type: 'post',
        url: '/voxb/ajax/user/login',
        dataType: 'json',
        success: function(msg) {
          voxb_status = msg.status;
          if (!msg.status) {
            var html = '<div id="voxb-user-create" style="text-align: center;">';
            html += '<p>' + Drupal.t('Please provide a username used in your reviews.') + '</p>';
            html += '<br />';
            html += '<p><input type="text" name="alias-name" value="" /></p>';
            html += '<br />';
            html += '<p><input type="checkbox" id="voxb-terms" class="voxb-terms" /><label for="voxb-terms">' + Drupal.t('I accept to provide my certain credentials to 3-rd party services, such as VoxB.') + '</label></p>';
            html += '</div>';
            $('body').append(html);

            $('#voxb-user-create').dialog({
              title : Drupal.t('VoxB username'),
              modal : true,
              width: 'auto',
              height: 'auto',
              buttons: {
                "OK" : function() {
                  Drupal.voxb_item.create_user($('#voxb-user-create input[name=alias-name]').val(), callback);
                }
              }
            });
          }
        },
        complete: function() {
          if (voxb_status) {
            if (Drupal.voxb_item.op == 'tag') {
              Drupal.voxb_item.voxb_do_tag(
                Drupal.voxb_item.params.tag,
                Drupal.voxb_item.params.item,
                Drupal.voxb_item.button
              );
            }
            else if (Drupal.voxb_item.op == 'rate') {
              Drupal.voxb_item.voxb_do_rate(
                Drupal.voxb_item.params.rating,
                Drupal.voxb_item.params.item
              );
            }
            else if (Drupal.voxb_item.op == 'review') {
              Drupal.voxb_item.voxb_do_review(
                Drupal.voxb_item.params.review,
                Drupal.voxb_item.params.item,
                Drupal.voxb_item.button
              );
            }
          }
          else {
            if (Drupal.voxb_item.op == 'tag' || Drupal.voxb_item.op == 'review') {
              Drupal.voxb_item.hideAjaxLoader(
                Drupal.voxb_item.button.parent(),
                Drupal.voxb_item.button
              );
            }
            else if (Drupal.voxb_item.op == 'rate') {
              $('div.ratingsContainer .ajax_anim').hide();
              Drupal.voxb_item.rating_set = false;
            }
          }
        }
      });
    },

    // Voxb user creation functionality.
    create_user: function(alias_name, callback) {
      $('#voxb-user-create-message').remove();

      // Check for terms.
      if ($('#voxb-terms:checked').length == 0) {
        var html = '<div id="voxb-user-create-message" style="text-align: center;"><p>' + Drupal.t('Please, accept the terms is you wish to continue.') + '</p></div>';
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
      else {
        // Check for an empty name.
        if (alias_name != '') {
          var voxb_status = false;
          $.ajax({
            async: false,
            type: 'post',
            url: '/voxb/ajax/user/create',
            data: {'alias_name' : alias_name},
            dataType: 'json',
            success: function(msg) {
              if (msg.status) {
                $('#voxb-user-create').dialog('close');
                voxb_status = msg.status;
              }
            },
            complete: function() {
              if (voxb_status) {
                if (Drupal.voxb_item.op == 'tag' || Drupal.voxb_item.op == 'review') {
                  Drupal.voxb_item.showAjaxLoader(
                    Drupal.voxb_item.button.parent(),
                    Drupal.voxb_item.button
                  );
                }

                if (Drupal.voxb_item.op == 'tag') {
                  Drupal.voxb_item.voxb_do_tag(
                    Drupal.voxb_item.params.tag,
                    Drupal.voxb_item.params.item,
                    Drupal.voxb_item.button
                  );
                }
                else if (Drupal.voxb_item.op == 'rate') {
                  Drupal.voxb_item.voxb_do_rate(
                    Drupal.voxb_item.params.rating,
                    Drupal.voxb_item.params.item
                  );
                }
                else if (Drupal.voxb_item.op == 'review') {
                  Drupal.voxb_item.voxb_do_review(
                    Drupal.voxb_item.params.review,
                    Drupal.voxb_item.params.item,
                    Drupal.voxb_item.button
                  );
                }
              }
              else {
                if (Drupal.voxb_item.op == 'tag' || Drupal.voxb_item.op == 'review') {
                  Drupal.voxb_item.hideAjaxLoader(
                    Drupal.voxb_item.button.parent(),
                    Drupal.voxb_item.button
                  );
                }
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
    }
  };

  $(document).ready(function() {
    Drupal.voxb_item.init();
    $('#dialog').jqm();
  });
})(jQuery);
