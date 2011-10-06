<?php
/**
 * @file
 *
 * The VoxB main template. Controls the output of all VoxB content.
 */
?>

<div id="voxb">
  <?php
    $ac_identifier = $data['object']->record['ac:identifier'][''][0];
    $ac_identifier = explode('|', $ac_identifier);
    $faust_number = $ac_identifier[0];

    require_once(VOXB_PATH . '/lib/VoxbItem.class.php');
    require_once(VOXB_PATH . '/lib/VoxbProfile.class.php');
    require_once(VOXB_PATH . '/lib/VoxbReviews.class.php');

    $voxb_item = new VoxbItem();
    $voxb_item->addReviewHandler('review', new VoxbReviews());
    $voxb_item->fetchByFaust($faust_number);
    $profile = unserialize($_SESSION['voxb']['profile']);
  ?>

 <div class="line clear-block rulerafter">
    <div class="unit size1of4 review-title">
      Bruger anmeldelser
    </div>
    <div class="unit lastUnit">
      <div class="view-display-id-panel_pane_1">
        <div class="userReviews">
        <?php
        $limit = variable_get('voxb_reviews_per_page', VOXB_REVIEWS_PER_PAGE);
        foreach ($voxb_item->getReviews('review') as $k => $v) {
          if ($k >= $limit) {
            break;
          }
          echo theme('voxb_review_record', array('author' => $v->getAuthorName(), 'review' => $v->getText()));
        }
        ?>
        </div>
      </div>
    </div>

    <?php
      $reviews = $voxb_item->getReviews('review')->getCount();
      echo '<div id="pager_block">';
      echo theme('voxb_review_pager', array('count' => $reviews, 'limit' => $limit, 'faust_number' => $faust_number, 'cur_page' => 1));
      echo '</div>';
      echo '<div style="clear: both;"></div>';
      if ($user->uid) {
        $data = $profile->getVoxbUserData($faust_number);
        if ($data['review']['title'] != 'videoreview') {
          if ($data['review']['title'] == 'review') {
            $params = array(
              'faust_number' => $faust_number,
              'review_content' => $data['review']['data'],
              'action' => 'update',
            );
          }
          else {
            $params = array(
              'faust_number' => $faust_number,
              'review_content' => '',
              'action' => 'submit',
            );
          }
    ?>
    </div>
    <div class="line clear-block rulerafter">
      <div class="unit size1of4 review-title">
        Skriv anmeldelse
      </div>
      <div class="unit lastUnit">
        <div class="addReviewContainer">
          <?php echo drupal_get_form('ding_voxb_review_form', $params); ?>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>

  <?php
      }
    }
  ?>
  </div>
