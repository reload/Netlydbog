<?php
/**
 * @file
 *
 * Single review template.
 * 
 */
?>

<div class="voxbReview">
  <?php print t('Written by'); ?> <em><?php print $data['author']; ?></em>
  <div class="reviewContent"><?php print $data['review']; ?></div>
</div>
