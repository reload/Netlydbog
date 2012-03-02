<?php
/**
 * @file
 *
 * Template tag form and tags themselves.
 * 
 */

?>
<div class="voxb">
  <div class="tagsContainer">
    <h3><?php print t('Tags'); ?></h3>
    <div class="recordTagHighlight">
    <?php print $data['tags']; ?>
    </div>
    <div class="clearfix">&nbsp;</div>
    <?php print $data['tag_form']; ?>
  </div>
</div>
