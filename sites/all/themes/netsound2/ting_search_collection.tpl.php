<?php
// $Id$

/**
 * @file
 * Template to render a Ting collection of books.
 */

// updated so we show ALL objects in the collection in the search result

foreach ($collection->objects as $obj){
	if($obj->type == 'Lydbog (online)') {
		$lydbogObj = $obj;
//		$lydbogObj = ting_get_object_by_id($obj->id);

  elib_book_cover($lydbogObj);
  $alttext = t('@titel af @forfatter',array('@titel' => $lydbogObj->title, '@forfatter' => $lydbogObj->creators_string));

?>


  <li class="display-book ting-collection ruler-after line clear-block">
    <div class="picture unit">
      <?php $image_url = ting_covers_collection_url($lydbogObj, '80_x'); ?>
      <?php if ($image_url) { ?>
        <div class="inner left">
        <?php print l(theme('image', $image_url, $alttext, $alttext, null, false), $lydbogObj->url, array('html' => true)); ?>
        </div>
      <?php } ?>
    </div>
    <div class="meta unit">
      <div class="inner">
      <h3 class="title">
        <?php print l($lydbogObj->title, $lydbogObj->url, array('attributes' => array('class' =>'title'))) ;?> 
      </h3>
      <div class="author">
        <?php echo t('By !creator_name', array('!creator_name' => l($lydbogObj->creators_string,'ting/search/'.$lydbogObj->creators_string,array('html' => true)))); ?>
      </div>
      
      <?php print elib_get_rating($lydbogObj->id);?>
      
        
        <?php if (!empty($lydbogObj->record['dc:contributor']['oss:dkind'])): ?>
      <?php 
      
      foreach($lydbogObj->record['dc:contributor']['oss:dkind'] as $reader){
      	$readers[] = l($reader,'ting/search/'.$reader);
      }
      ?>
      
        <div class="reader">
        <?php print theme('item_list', $readers, t('Reader'), 'span', array('class' => 'contributor'));?>
        </div>
         <div>
        <?php print theme('item_list', array($lydbogObj->date), t('Udgivelses år'), 'span', array('class' => 'year'));?>
        </div>
      <?php endif; ?>
      <?php if (!empty($lydbogObj->subjects)): ?>
      <?php 
      
      foreach($lydbogObj->subjects as $subject){
      	$subs[] = l($subject,'ting/search/'.$subject);
      }
      
      ?>
        <?php print theme('item_list', $subs, t('Genre'), 'span', array('class' => 'subject'));?>
      <?php endif; ?>
       </div>
    </div>
    <div class="moreinfo unit lastUnit">
      <div class="inner right">
    
      <div class="abstract">
        <?php print check_plain($lydbogObj->abstract); ?>
      </div>
      <div class="icons">
        <?php print l(theme('image', 'sites/all/themes/netsound/img/stream.png', '', '', null, false), $lydbogObj->url.'/stream', array('html' => true, 'attributes' => array('rel' => 'lightframe'))) ?>
        <?php print l(theme('image', 'sites/all/themes/netsound/img/fetch.png', '', '', null, false), $lydbogObj->url.'/download', array('html' => true, 'attributes' => array('rel' => 'lightframe')))?>
        <?php print l(theme('image', 'sites/all/themes/netsound/img/sample.png', '', '', null, false), $lydbogObj->url.'/sample', array('html' => true, 'attributes' => array('rel' => 'lightframe[|width:350px; height:120px;]'))) ?>
      </div>
   
      </div>
    </div>
    
  </li>

<?php
	}
}