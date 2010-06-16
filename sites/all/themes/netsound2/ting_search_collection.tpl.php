<?php
// $Id$

/**
 * @file
 * Template to render a Ting collection of books.
 */

//krumo($collection);

//get lydbog in collection

foreach ($collection->objects as $obj){
	if($obj->type == 'Lydbog (online)'){
		$lydbogObj = $obj;
	}
} 

?>


  <li class="display-book ting-collection ruler-after line clear-block">
    <div class="picture unit">
      <?php $image_url = ting_covers_collection_url($lydbogObj, '80_x'); ?>
      <?php if ($image_url) { ?>
        <div class="inner left">
        <?php print l(theme('image', $image_url, '', '', null, false), $lydbogObj->url, array('html' => true)); ?>
        </div>
      <?php } ?>
    </div>
    <div class="meta unit">
      <div class="inner">
      <h3 class="title">
        <?php print l($collection->title, $lydbogObj->url, array('attributes' => array('class' =>'title'))) ;?> 
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
      <?php if (!empty($lydbogObj->record['dc:contributor']['oss:dkind'])): ?>
        <div class="reader">
        <?php print theme('item_list', $lydbogObj->record['dc:contributor']['oss:dkind'], t('Reader'), 'span', array('class' => 'contributor'));?>
        </div>
      <?php endif; ?>
      <?php if (!empty($lydbogObj->record['dc:subject']['oss:genre'])): ?>
        <?php print theme('item_list', $lydbogObj->record['dc:subject']['oss:genre'], t('Genre'), 'span', array('class' => 'subject'));?>
      <?php endif; ?>
       </div>
    </div>
    <div class="moreinfo unit lastUnit">
      <div class="inner right">
    <?php if ($collection->abstract) : ?>
      <div class="abstract">
        <?php print check_plain($collection->abstract); ?>
      </div>
      <div class="icons">
        <img src="/sites/all/themes/netsound/img/listen.png" />
        <img src="/sites/all/themes/netsound/img/fetch.png" />
      </div>
      </div>
    </div>
    <?php endif; ?>
  </li>