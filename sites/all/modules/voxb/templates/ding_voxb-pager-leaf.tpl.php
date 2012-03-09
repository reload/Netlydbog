<?php
/*
 * @file
 *
 * Template for pager leaves.
 */
?>

<li class="<?php print implode(' ', $data['classes']); ?>"><?php echo l($data['link'], $data['path']); ?></li>
