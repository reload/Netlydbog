<?php
// $Id$

/**
 * @file
 * Template to render a Ting collection of books.
 */
?>
<li class="display-book unit size1of5">
  <div class="inner">
    <div class="picture">
      <?php $image_url = ting_covers_collection_url($collection->objects[0], '172_x'); ?>
      <?php if ($image_url) { ?>
        <?php print l(theme('image', $image_url, '', '', null, false), $collection->url, array('html' => true)); ?>
      <?php } ?>
    </div>

    <h3 class="title">
        <?php print l($collection->title, $collection->url, array('attributes' => array('class' =>'title'))) ;?> 
      </h3>
      <div class="author">
        <?php echo t('By %creator_name%', array('%creator_name%' => $collection->creators_string)) ?>
      </div>
       <div class="icons">
       <?php print l(theme('image', 'sites/all/themes/netsound/img/listen.png', '', '', null, false), $collection->url.'/stream', array('html' => true)); ?>
       <?php print l(theme('image', 'sites/all/themes/netsound/img/fetch.png', '', '', null, false), $collection->url.'/download', array('html' => true)); ?>
      </div>
  </div>
</li>