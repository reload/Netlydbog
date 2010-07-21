<?php
// $Id$
/* *
 * @file
 * comment-folded.tpl.php
 * These two variables are provided for context.
 * - $comment: Full comment object.
 * - $node: Node object the comments are attached to.
 *
 * @see template_preprocess_comment()
 * @see theme_comment()
 */
/*
 * ad a class="" if we have anything in the $classes var
 * this is so we can have a cleaner output - no reason to have an empty <div class="" id="">
 */
if ($classes) {
  $classes = ' class="' . $classes . '"';
}

?>
<!--comment.tpl-->
<div<?php print $classes; ?>>
<div class="ruler-after">
  
  <div class="meta">
    <?php
      if($comment->picture){
        $image = theme('imagecache', 'user-thumbnail', $comment->picture); 
        print l($image, 'user/'.$comment->uid, $options= array('html'=>TRUE));
      }
    ?>
    <div class="author"><?php print $author ?></div> 
    <span class="date"><?php print $date ?></span>
    <?php if ($signature){ ?>
      <?php print $signature ?>
    <?php } ?>      
  </div>
  <div class="comment-inner">
    
    <div class="comment-content"><?php print $content ?></div>
    <?php print $links ?>    
  </div>

</div>
</div>
<!--/comment.tpl-->