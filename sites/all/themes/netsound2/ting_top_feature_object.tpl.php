<?php
// $Id$

/**
 * @file
 * Template to render a Ting collection of books.
 */
?>
<li class="unit size1of5">
  <div class="inner display-book">
    

      <?php $image_url = ting_covers_collection_url($collection->objects[0], '170_x');
      
      //dsm($collection);
      
      $isbn = elib_get_isbn_from_object_id($collection->id);
      
      $image_url = 'http://www.elib.se/product_images/ISBN'.$isbn.'.jpg';
      
      ?>

      <?php if (strpos($image_url,'imagecache')): ?>
      <div class="picture">
        <?php print l(theme('image', $image_url, '', '', null, false), $collection->url, array('html' => true)); ?>
      </div>
      <?php else: ?>
      <div class="picture nopicture">
        <img src="<?php print $image_url?>" alt="" style="width:100%;height:100%"/>
      </div>
      <?php endif;?>


    <h3 class="title">
        <?php print l($collection->title, $collection->url, array('attributes' => array('class' =>'title'))) ;?> 
      </h3>
      <div class="author">
        <?php echo t('By !creator_name', array('!creator_name' => l($collection->creators_string,'ting/search/'.$collection->creators_string))) ?>
      </div>
       <div class="icons">
       <?php print l(theme('image', 'sites/all/themes/netsound/img/listen.png', '', '', null, false), $collection->url.'/stream', array('html' => true, 'attributes' => array('rel' => 'lightframe'))); ?>
       <?php print l(theme('image', 'sites/all/themes/netsound/img/fetch.png', '', '', null, false), $collection->url.'/download', array('html' => true, 'attributes' => array('rel' => 'lightframe'))); ?>
      </div>
  </div>
</li>