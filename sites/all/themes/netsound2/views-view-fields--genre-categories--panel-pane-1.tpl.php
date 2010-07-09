<?php
// $Id: views-view-fields.tpl.php,v 1.6 2008/09/24 22:48:21 merlinofchaos Exp $
/**
 * @file views-view-fields.tpl.php
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->separator: an optional separator that may appear before a field.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */
?>
<?php drupal_add_css(drupal_get_path('module', 'netsound') .'/styles.css'); ?>

<?php foreach ($fields as $id => $field): ?>

<?php if($field->class == 'name'):?>
  <h2 class="pane-title"><?php print $field->raw?></h2>
<?php endif;?>

<?php if($field->class == 'tid'):?>
  <?php $items = netsound_get_genres_from_categories(trim($field->raw));?>
  <ul>
  <?php foreach ($items as $item):?> 
    <li><?php print l($item['node_title'],'ting/search/'.$item['searchphrase']);?> (<?php print $item['amount']?>)</li>
  <?php endforeach;?>
  </ul>
  <?php ?>
<?php endif;?>

<?php endforeach; ?>
