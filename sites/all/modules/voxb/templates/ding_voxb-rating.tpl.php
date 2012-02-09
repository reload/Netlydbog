<?php
/**
 * @file
 *
 * Template for rating form.
 */

global $user;

?>
<div class="voxb">
  <div class="ratingsContainer">
    <h3><?php print t('Ratings'); ?></h3>
      <div class="addRatingContainer">
        <div id="<?php echo $data['faust_number']; ?>" <?php echo(($user->uid && $data['able']) ? 'class="userRate"' : ''); ?>>
          <?php for ($i = 1; $i <= 5; $i++) : ?>
          <div class="rating <?php echo($i <= $data['rating'] ? 'star-on' : 'star-off'); ?>"></div>
          <?php ;endfor ?>
        </div>
      </div>
      <?php
      if ($data['rating_count'] > 0) {
        echo '<span class="ratingCountSpan">(<span class="ratingVotesNumber">' . $data['rating_count'] . '</span>)</span>';
      }
      ?>
      <img src="/<?php echo VOXB_PATH . '/img/ajax-loader.gif'; ?>" alt="" class="ajax_anim" />
  </div>
</div>
