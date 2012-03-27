(function ($) {
  $(document).ready(function() {
    $('a').live('click', function() {
      href = $(this).attr('href');
      if (!href.match(/ting\/object\/(.)+\/sample/)) {
        return true;
      }
      $.ajax({
        type : 'post',
        url : href + '/preview',
        dataType : 'json',
        success : function(response) {
          if (response.status == 'dl') {
            $('#dl-ebook').remove();
            $('body').append('<iframe id="dl-ebook" style="display:none;"></iframe>');
            $('#dl-ebook').attr('src', response.msg);
          }
          else {
            alert(response.msg);
          }
        }
      });

      return false;
    });
  });
})(jQuery);
