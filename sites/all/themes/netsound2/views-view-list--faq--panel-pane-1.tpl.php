<?php
// $Id: views-view-list.tpl.php,v 1.3 2008/09/30 19:47:11 merlinofchaos Exp $
/**
 * @file views-view-list.tpl.php
 * Default simple view template to display a list of rows.
 *
 * - $title : The title of this group of rows.  May be empty.
 * - $options['type'] will either be ul or ol.
 * @ingroup views_templates
 */
?>
<?php $count = 0; ?>
<div class="unit size1of2">
<div class="inside2">
  <?php if (!empty($title)) : ?>
    <h2 class="pane-title"><?php print $title; ?></h2>
  <?php endif; ?>
  <ul>
    <?php foreach ($rows as $id => $row): ?>
      <?php 
        $count++;
        if($count == 7) { break;} 
      ?>
      <li><?php print $row; ?></li>
    <?php endforeach; ?>
  </ul>
  </div>
</div>