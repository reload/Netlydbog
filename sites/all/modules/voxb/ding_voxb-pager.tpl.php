<?php

/**
 * @file
 *
 * @todo Fill out this description.
 */

$pages = ceil($data['count'] / variable_get('voxb_reviews_per_page', VOXB_REVIEWS_PER_PAGE));
$page_prev = ($data['cur_page'] - 1 < 1) ? '1' : ($data['cur_page'] - 1);
$page_next = ($data['cur_page'] + 1 > $pages) ? $pages : $data['cur_page'] + 1;

if ($data['count'] > $data['limit']) {
    echo '<ul>';
      echo '<li class="prev_page">' . t('previous', 'voxb/ajax/seek/' . $data['faust_number'] . '/' . $page_prev) . '</li>';

      // Draw 5 tabs/buttons/links
      for ($i = $data['cur_page'] - 1; $i < 5 + $data['cur_page'] - 1; $i++) {
        echo '<li class="page_num';
        // Highlight the middle one
        if ($i == $data['cur_page'] + 1) {
          echo '  active_page"';
        }
        echo '">';

        if ($i > 1 && $i < $pages + 2) {
          echo l(($i - 1), 'voxb/ajax/seek/' . $data['faust_number'] . '/' . ($i - 1) . '');
        }
        else {
          echo '<a href="#"></a>';
        }

        echo '</li>';
      }
      echo '<li class="next_page">' . t('next', 'voxb/ajax/seek/' . $data['faust_number'] . '/' . $page_next) . '</li>';
    echo '</ul>';

}
