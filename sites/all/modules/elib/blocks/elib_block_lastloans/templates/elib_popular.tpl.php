<?php
/**
 * @file
 *
 * Popular loaned items, main template.
 */
?>
<div id="ting-search-results">
  <div id="ting-result">
    <div id="ting-search-result">
      <ul>
        <?php print $data['elib_popular']; ?>
      </ul>
    </div>
    <?php print $data['elib_popular_pager']; ?>
  </div>
</div>
