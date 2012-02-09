<?php
/**
 * @file
 *
 * Template for review form and reviews themselves.
 */

if(($data['voxb_item']->getReviews('review')->getCount() > 0) || ($user->uid != 0 && $data['able'])) {
?>
  <div class="voxb">
    <div class="reviewsContainer">
      <div class="review-title"><?php print t('User reviews'); ?></div>
      <div class="userReviews">
        <?php print $data['reviews']; ?>
      </div>
      <?php
    // Review count.
      // @todo Pager stuff requires a lot more development, instead of some refactor.
      //$reviews = $data['voxb_item']->getReviews('review')->getCount();

      // Display pagination links.
      //echo theme('voxb_review_pager', array('count' => $reviews, 'limit' => $limit, 'faust_number' => $data['faust_number'], 'cur_page' => 1));
      ?>
      <div id="pager_block"></div>
      <br />
      <div class="addReviewContainer">
        <?php
          print $data['review_form'];
          // echo drupal_get_form('ding_voxb_review_form', $params);
        ?>
      </div>
    </div>
  </div>
<?php
}
?>
