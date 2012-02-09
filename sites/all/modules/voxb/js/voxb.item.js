/**
 * @file
 *
 * JavaScript for the item.
 */

(function ($) {
  Drupal.voxb_item = {

    initial_rating : 0,
    rating_set : false,

    // show ajax loader
    showAjaxLoader: function(container, el) {
      el.hide();
      var x = $('.ajaxLoaderTpl').clone();
      x.find('img').removeClass('ajax_anim');
      container.append(x);
    },
    // show ajax loader
    hideAjaxLoader: function(container, el) {
      container.find('.ajaxLoaderTpl').remove();
      el.show();
    },

    // Init function, binds method to user input and sets variables
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
      

      // Show the ajax animation and blink the stars 3 times
      $('div.userRate div.rating').click(function() {
        if (!Drupal.voxb_item.rating_set) {
          Drupal.voxb_item.rating_set = true;
          $('div.ratingsContainer .ajax_anim').show();

          var rating = $(this).parent().children().index($(this));
          var item = $(this).parent().attr('id');

          if (rating >= 0 && item != '') {
            $.ajax({
              type:'post',
              url:'/voxb/ajax/rating/' + item + '/' + (rating + 1),
              dataType:'json',
              success:function(msg) {
                $('div.ratingsContainer .ajax_anim').hide();
                if (msg['status']) {
                  $('.ratingCountSpan').html('(' + msg['rating_count'] + ')');
                  // update rating
                  Drupal.voxb_item.initial_rating = msg['rating'];
                  $('.addRatingContainer').each(function() {
                    parent = $(this);
                    parent.find('div.userRate div.rating:lt(' + Drupal.voxb_item.initial_rating + ')').removeClass('star-off').removeClass('star-black').addClass('star-on');
                    parent.find('div.userRate div.rating:gt(' + (Drupal.voxb_item.initial_rating - 1) + ')').removeClass('star-on').removeClass('star-black').addClass('star-off');
                  }).cyclicFade({
                    repeat: 3,
                    params: [
                      {fadeout:200, stayout:100, opout:0, fadein:200, stayin:100, opin:1},
                      {fadeout:200, stayout:100, opout:0, fadein:200, stayin:100, opin:1},
                      {fadeout:200, stayout:100, opout:0, fadein:200, stayin:100, opin:1}
                    ]
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
          }
        }
      });

      $('#ding-voxb-tag-form .form-submit').click(function() {
        var tag = $('#ding-voxb-tag-form input[name=name]').val();
        var item = $('#ding-voxb-tag-form input[name=faustNumber]').val();

        if (tag != '' && item != '') {
          var button = $(this);
          Drupal.voxb_item.showAjaxLoader(button.parent(), button);
          $.ajax({
            type:'post',
            url:'/voxb/ajax/tag/' + item + '/' + tag,
            dataType:'json',
            success:function(msg) {
              if (msg['status']) {
                $('.recordTagHighlight').append('<span class="tag"><a href="/ting/search/'+msg['message']+'">'+msg['message']+'</a>&nbsp;</span>');
                $('.recordTagHighlight .tag:last').cyclicFade({
                  repeat: 3,
                  params: [
                    {fadeout:200, stayout:100, opout:0, fadein:200, stayin:100, opin:1},
                    {fadeout:200, stayout:100, opout:0, fadein:200, stayin:100, opin:1},
                    {fadeout:200, stayout:100, opout:0, fadein:200, stayin:100, opin:1}
                  ]
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
        }

        return false;
      });

      $('#ding-voxb-review-form .form-submit').click(function(){
        var review = $('#ding-voxb-review-form textarea[name=review_content]').val();
        var item = $('#ding-voxb-tag-form input[name=faustNumber]').val();

        if (review != '' && item != '') {
          var button = $(this);
          Drupal.voxb_item.showAjaxLoader(button.parent(), button);
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
        }

        return false;
      });

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
    }
  };

  $(document).ready(function() {
    Drupal.voxb_item.init();
    $('#dialog').jqm();
  });
})(jQuery);
