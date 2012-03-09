<?php
/**
 * @file
 */
?>
<div class="feed-and-compare-page clear-block">
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
    <?php foreach ($items['data'] as $key => $item) { ?>
      <div class="feed_and_compare_item display-book">
        <div class="left">
            <?php
              $alttext = t('@titel af @forfatter',array('@titel' => $item['title'], '@forfatter' => $item['author']));
              $cover = elib_book_cover($item['isbn'], '120_x');
              echo l(theme('image', $cover, $alttext, $alttext, array('width' => '170px'), false), $item['url'], array('html' => 
true));
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
            <?php echo $item['abstract']; ?>
          </div>
        </div>
      </div>
    <?php } ?>
  <?php } ?>

</div>
