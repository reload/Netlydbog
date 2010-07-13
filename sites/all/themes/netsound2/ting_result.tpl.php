<div id="ting-search-summary">
    <?php print t('Your search for "!searchPhrase" returned !count results',
                    array(
                      '!searchPhrase' => arg(2),
                      '!firstResult' => '<span class="firstResult"></span>',
                      '!lastResult' => '<span class="lastResult"></span>',
                      '!count' => '<span class="count"></span>',
                    )); ?>
</div>
<div id="ting-search-result">
  <ul>
  </ul>
</div>