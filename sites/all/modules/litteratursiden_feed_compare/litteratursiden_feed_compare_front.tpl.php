<?php
/**
 * @file
 */
?>
<div class="feed-and-compare-front clear-block">
  <?php if ($items['status'] == 'empty') { ?>
    <div class="feed_and_compare_empty">
      <h1>Der var desv&aelig;rre ingen materialer som matchede anmeldelser hos Litteratursiden.</h1>
    </div>
  <?php } ?>

  <?php if ($items['status'] == 'error') { ?>
    <div class="feed_and_compare_error">
      <b>Error:</b> <?php echo $items['message']; ?>
    </div>
  <?php } ?>

  <?php if (($items['status'] == 'ok') || ($items['status'] == 'notfull')) { ?>
    <?php $i=0; ?>
    <?php foreach ($items['data'] as $key => $item) { ?>
      <?php if (is_numeric($key)) { ?>
        <div class="feed_and_compare_item display-book">
          <div class="left">
            <?php
            $alttext = t('@titel af @forfatter',array('@titel' => $item['title'], '@forfatter' => $item['author']));
            $cover = elib_book_cover($item['isbn'], '120_x');
	    echo l(theme('image', $cover, $alttext, $alttext, array('width' => '120px'), false), $item['url'], array('html' 
=> true));
            ?>
          </div>
          <div class="record right">
            <h3 class="title">
              <?php echo l($item['title'], $item['url'], array('html' => true)); ?>
            </h3>
            <div class="author">
              <?php echo l($item['author'], 'ting/search/' . urlencode($item['author']), array('html' => true)); ?>
            </div>
            <div class="descr">
              <?php echo substr(strip_tags($item['abstract']),0,150) . '...'; ?>
            </div>
            <div class="litteratursiden">
              <img src="sites/all/themes/ebog/images/litteratursiden.png" style="border:0;margin:0;padding:0;" />
            </div>
          </div>
        </div>
        <?php $i++; ?>
      <?php } ?>
      <?php
        if ($i == variable_get('litteratursiden_feed_compare_items_on_front', '2')) {
          break;
        }
      ?>
    <?php } ?>
  <?php } ?>

</div>

<div class="bottom-bar">
  <div class="see-more feed_and_compare_front_see_more">
    <?php echo l($conf['see_more_title'], $conf['see_more_link']); ?>
  </div>
</div>
