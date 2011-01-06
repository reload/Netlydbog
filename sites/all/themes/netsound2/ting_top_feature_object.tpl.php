<?php
// $Id$

/**
 * @file
 * Template to render a Ting collection of books.
 */

elib_book_cover($collection->objects[0]);
$image_url = ting_covers_collection_url($collection->objects[0], '170_x');
$alttext = t('@titel af @forfatter',array('@titel' => $collection->title, '@forfatter' => $collection->creators_string));

?>
<li class="unit size1of5">
  <div class="inner display-book">
    
    <?php if (strpos($image_url,'imagecache')): ?>
    <div class="picture">
      <?php print l(theme('image', $image_url, $alttext, $alttext , null, false), $collection->url, array('html' => true)); ?>
    </div>
    <?php else: ?>
    <div class="picture nopicture">
      <?php print l('se bogen', $collection->url, array()); ?>
    </div>
    <?php endif;?>


    <h3 class="title">
      <?php print l($collection->title, $collection->url, array('attributes' => array('class' =>'title'))) ;?>
    </h3>
    <div class="author">
      <?php echo t('By !creator_name', array('!creator_name' => l($collection->creators_string,'ting/search/'.$collection->creators_string))) ?>
    </div>
    <?php print elib_get_rating($collection->id);?>
     <div class="icons">
     <?php print l(theme('image', 'sites/all/themes/netsound/img/stream.png', 'Lyt', 'Lyt', null, false), $collection->url.'/stream', array('html' => true, 'attributes' => array('rel' => 'lightframe'))); ?>
     <?php print l(theme('image', 'sites/all/themes/netsound/img/fetch.png', 'Hent', 'Hent', null, false), $collection->url.'/download', array('html' => true, 'attributes' => array('rel' => 'lightframe'))); ?>
    </div>
  </div>
</li>