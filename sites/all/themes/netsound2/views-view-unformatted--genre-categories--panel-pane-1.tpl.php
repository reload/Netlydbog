<?php
// $Id: views-view-unformatted.tpl.php,v 1.6 2008/10/01 20:52:11 merlinofchaos Exp $
/**
 * @file views-view-unformatted.tpl.php
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<?php if (!empty($title)): ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>
<div class="line genre_categories">

<?php foreach ($rows as $id => $row): ?>

<?php
  $extra = NULL;
  if($id == 0){ $extra = 'first';}
  if($id == sizeof($rows)-1){ $extra = 'last';} 
?>
   

  <div class="unit size1of<?php print sizeof($rows) ?> <?php print $extra?>">
    <?php print $row; ?>
  </div>
<?php endforeach; ?>
</div>