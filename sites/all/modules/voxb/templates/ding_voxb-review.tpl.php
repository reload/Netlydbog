<?php
/**
 * @file
 *
 * Template for review form and reviews themselves.
 *
 */

?>
<div class="voxb">
  <div class="reviewsContainer">
    <h3><?php print t('User reviews'); ?></h3>
    <div class="userReviews">
    <?php print $data['reviews']; ?>
    </div>
    <div id="pager_block">
      <?php print $data['pager']; ?>
    </div>
    <br />
    <div class="addReviewContainer">
      <?php print $data['review_form']; ?>
    </div>
  </div>
</div>
