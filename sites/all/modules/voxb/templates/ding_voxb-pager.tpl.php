<?php
/**
 * @file
 *
 * Template for reviews pager.
 *
 */
?>

<ul>
  <li class="prev-page"><?php print l('<<', 'voxb/ajax/seek/' . $data['faust_number'] . '/' . $data['previous']); ?></li>
  <?php print $data['leaves']; ?>
  <li class="next-page"><?php print l('>>', 'voxb/ajax/seek/' . $data['faust_number'] . '/' . $data['next']); ?></li>
</ul>
