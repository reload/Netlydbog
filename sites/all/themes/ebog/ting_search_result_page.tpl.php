<?php
// $Id$

/**
 * @file ting_result_page.tpl.php
 * Template for the search result page itself.
 */
?>
<div id="ting-search-results">

  <div id="ting-result">
    <div id="ting-search-placeholder"></div>
  </div>

  <div id="content-result" class="ui-tabs-hide">
    <div id="content-search-summary">
      <?php print t('Your search returned !count results',
                    array(
                      '!searchPhrase' => arg(2),
                      '!firstResult' => '<span class="firstResult"></span>',
                      '!lastResult' => '<span class="lastResult"></span>',
                      '!count' => '<span class="count"></span>',
                    )); ?>
    </div>
    <div id="content-search-result"></div>
  </div>
</div>
<div id="ting-search-spinner">
  <h4><?php print t('Searching'); ?>…</h4>
  <div class="spinner"><img src="/sites/all/themes/ebog/images/spinner.gif" /></div>
</div>
