<?php
// $Id$
/**
 * @file
 * node.tpl.php
 */

//  dsm($node->links);
  // foreach ($node->links as $key => $value) {
  //   print $node->links[$key]['title'];
  // }

/**
 * dsm(get_defined_vars())
 * dsm($variables['template_files']);
 * dsm($node);
 * dsm($node->content);
 * print $FIELD_NAME_rendered;
 */

/**
 * $links splitted up
 * <?php print $statistics_counter; ?>
 * <?php print $link_read_more; ?>
 * <?php print $link_comment; ?>
 * <?php print $link_comment_add ?>
 * <?php print $link_attachments; ?>
 */

/**
 * ad a class="" if we have anything in the $classes var
 * this is so we can have a cleaner output - no reason to have an empty <div class="" id="">
 */

if ($classes) {
  $classes = ' class="'. $classes . '"';
}

if ($id_node) {
  $id_node = ' id="'. $id_node . '"';
}
?>

<?php print $node->field_embedcode[0]['value']?>

