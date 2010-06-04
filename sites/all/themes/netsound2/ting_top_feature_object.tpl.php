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
      <ul class="rating">
        <li class="on">star</li>
        <li class="on">star</li>
        <li class="on">star</li>
        <li class="off">star</li>
        <li class="off">star</li>
      </ul>
       <div class="icons">
        <img src="/sites/all/themes/netsound/img/listen.png" />
        <img src="/sites/all/themes/netsound/img/fetch.png" />
      </div>
  </div>
</li>