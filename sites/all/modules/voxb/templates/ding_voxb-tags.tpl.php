<?php
/**
 * @file
 *
 * Template tag form and tags themselves.
 */

if(($data['voxb_item']->getTags()->getCount() > 0) || ($user->uid != 0 && $data['able'])) {
?>
  <div class="voxb">
    <div class="tagsContainer">
      <div class="review-title"><?php echo t('Tags'); ?></div>
      <div class="recordTagHighlight">
        <?php print $data['tags']; ?>
      </div>
      <div class="clearfix">&nbsp;</div>
      <?php print $data['tag_form']; ?>
    </div>
  </div>
<?php
}
?>
