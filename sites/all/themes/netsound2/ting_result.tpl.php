<div id="ting-search-summary">
    <?php print t('Your search for "!searchPhrase" returned !count results',
                    array(
                      '!searchPhrase' => arg(2),
                      '!firstResult' => '<span class="firstResult"></span>',
                      '!lastResult' => '<span class="lastResult"></span>',
                      '!count' => '<span class="count"></span>',
                    )); ?>
</div>

<div id="ting-sort-by">

<?php print t('Sorter efter ')?>
<select class="sort-by-selector">
  <option value=""><?php print t('Relevans')?></option>
  <option value="title_ascending"><?php print t('Titel')?></option>
  <option value="creator_ascending"><?php print t('Forfatter')?></option>
  <option value="date_descending"><?php print t('Udgivelses år')?></option>
</select>

</div>

<div id="ting-search-result">
  <ul>
  </ul>
</div>