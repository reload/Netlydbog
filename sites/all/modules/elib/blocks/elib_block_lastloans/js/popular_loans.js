jQuery(document).ready(function($) {

  make_cache_request = function(page) {
    page = parseInt(page);
    $.scrollTo('#ting-search-results', 500);
    updatePageUrl(page);
    set_pager();

    $.ajax({
      type: 'post',
      url: '/popular/page',
      data: { 'page': page },
      dataType: 'json',
      success: function(response) {
        if (response.status) {
          $('#ting-search-result ul').html(response.content);
        }
      }
    });
  }

  updatePageUrl = function(pageNumber) {
    var anchorVars = Drupal.getAnchorVars();
    anchorVars.page = pageNumber;
    Drupal.setAnchorVars(anchorVars);
  };

  set_pager = function() {
    var anchors = Drupal.getAnchorVars();

    var pager = {
      pages: Drupal.settings.elib_popular.pages,
      current_page: (anchors.page && !isNaN(parseInt(anchors.page, 10))) ? parseInt(anchors.page, 10) : 1
    }

    var pages = {
      '.first': 1,
      '.prev': (pager.current_page > 1) ? pager.current_page - 1 : 1,
      '.next': (pager.current_page < pager.pages) ? pager.current_page + 1 : pager.pages,
      '.last': pager.pages
    }

    $('#ting-result #pager').find('.nav-placeholder').each(function(i, e) {
      var page = i + 1;

      if (pager.current_page > 3 && pager.current_page <= (pager.pages - 3)) {
        page += pager.current_page - 3;
      }
      else if (pager.current_page > (pager.pages - 3)) {
        page += pager.pages - 5;
      }
      $(this).css({'display': 'block'});
      var link = $(this).find('a');

      if (page > 0 && page <= pager.pages) {
        link.html((pager.current_page == page) ? '[' + page + ']' : page).attr('href', '#page=' + page);
      } else {
        link.parent().css({'display': 'none'});
      }
    });

    $('#ting-result #pager .nav-placeholder a').unbind('click').click(function() {
      var page = $(this).attr('href').split('=');

      make_cache_request(page[1]);

      return false;
    });

    $.each(pages, function(i, e) {
      var page = pages[i];
      $('#ting-result #pager').find(i).unbind('click').click(function() {
        make_cache_request(page);

        return false;
      });
    });
  }

  set_pager();
});

Drupal.getAnchorVars = function() {
  anchorValues = {};

  anchor = jQuery.url.attr('anchor');
  anchor = (anchor == null) ? '' : anchor;

  anchor = anchor.split('&');
  for (a in anchor) {
    keyValue = anchor[a].split('=');
    if (keyValue.length > 1) {
      anchorValues[keyValue[0]] = keyValue[1];
    }
  }

  return anchorValues;
};

Drupal.setAnchorVars = function(vars) {
  anchorArray = new Array();
  for (v in vars) {
    anchorArray.push(v + '=' + vars[v]);
  }
  anchorString = anchorArray.join('&');
  window.location.hash = '#' + anchorString;
};



