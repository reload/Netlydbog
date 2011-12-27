<div id="ting-search-summary">
    <?php print t('Your search returned !count results',
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
  <option value=""><?php print t('Vælg sortering')?></option>
  <option value="title_ascending"><?php print t('Titel A → Å')?></option>
  <option value="title_descending"><?php print t('Titel Å → A')?></option>
  <option value="creator_ascending"><?php print t('Forfatter A → Å')?></option>
  <option value="creator_descending"><?php print t('Forfatter Å → A')?></option>
  <option value="date_descending"><?php print t('Udgivelsesår - Nyeste først')?></option>
  <option value="date_ascending"><?php print t('Udgivelsesår - Ældste først')?></option>
</select>

</div>

<div id="ting-search-result">
  <ul>
  </ul>
</div>
