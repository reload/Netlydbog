<?php
// $Id$
/**
 * @file ting_object.tpl.php
 *
 * Template to render objects from the Ting database.
 *
 * Available variables:
 * - $object: The TingClientObject instance we're rendering.
 */

//$response = elib_client()->getBooks('01-01-1999');

//dsm($response);

if($object->type != 'Lydbog (online)') {
  drupal_set_message(t('Bogen findes ikke som lydbog, foretager søgning...'), 'error');
  drupal_goto('/ting/search/'.$object->title,NULL,NULL,301); // set the statuscode as MOVED PERMANENTLY
}

/*logic for rating */
elib_book_cover($object);

if(!$n = node_load(array('title' => $object->id,'type' => 'bookrating'))){
	$n = new stdClass();
	$n->type = 'bookrating';
	$n->title = $object->id;
	node_save($n);
}

$n = node_build_content($n);

?>
<!-- ting_object.tpl -->
<div id="ting-object" class="line rulerafter">

  <div class="picture unit ">
  <?php $image_url = ting_covers_collection_url($object, '170_x'); ?>
  
  <?php if (strpos($image_url,'imagecache')): ?>
    <div class="inner left" style="margin-bottom:10px;">
      <?php print theme('image', $image_url, $object->title, $object->title, null, false); ?>
    </div>
  <?php else: ?>
    <div class="inner left nopicture" style="height:270px;margin-bottom:10px;">
      <?php print theme('image', $image_url, $object->title, $object->title, null, false); ?>
    </div>
  <?php endif;?>
  
  <div class="icons">
        <?php print l(theme('image', 'sites/all/themes/netsound2/img/stream.png', '', '', null, false), $object->url.'/stream', array('html' => true, 'attributes' => array('rel' => 'lightframe'))) ?>
        <?php print l(theme('image', 'sites/all/themes/netsound2/img/fetch.png', '', '', null, false), $object->url.'/download', array('html' => true, 'attributes' => array('rel' => 'lightframe')))?>
        <?php print l(theme('image', 'sites/all/themes/netsound2/img/sample.png', '', '', null, false), $object->url.'/sample', array('html' => true, 'attributes' => array('rel' => 'lightframe[|width:350px; height:120px;]'))) ?>
        <?php 
        if($user->uid){
        	print l(theme('image', 'sites/all/themes/netsound2/img/husk.png', '', '', null, false), $object->url.'/huskeliste?'.drupal_get_destination(), array('html' => true));
        }
        ?>
      </div>
  
  
  </div>
  <div class="meta unit">
    <div class="inner">
      <h1 class="book-title"><?php print check_plain($object->record['dc:title'][''][0]); ?></h1>
      <div class="author"><?php echo t('By %creator_name%', array('%creator_name%' => $object->creators_string)) ?></div>
      <?php print $n->content["fivestar_widget"]['#value']; ?>
         
            <?php print theme('item_list', array($object->type), t('Type'), 'span', array('class' => 'type')); ?>
            <?php if (!empty($object->record['dc:format'][''])) { ?>
              <?php print theme('item_list', $object->record['dc:format'][''], t('Format'), 'span', array('class' => 'format'));?>
            <?php } ?>
            <?php if (!empty($object->record['dcterms:isPartOf'][''])) { ?>
              <?php print theme('item_list', $object->record['dcterms:isPartOf'][''], t('Available in'), 'span', array('class' => 'is-part-of'));?>
            <?php } ?>


            <?php if (!empty($object->language)) { ?>
              <?php print theme('item_list', array($object->language), t('Language'), 'span', array('class' => 'language'));?>
            <?php } ?>
            <?php if (!empty($object->record['dc:language']['oss:spoken'])) { ?>
              <?php print theme('item_list', $object->record['dc:language']['oss:spoken'], t('Speech'), 'span', array('class' => 'language'));?>
            <?php } ?>
            <?php if (!empty($object->record['dc:language']['oss:subtitles'])) { ?>
              <?php print theme('item_list', $object->record['dc:language']['oss:subtitles'], t('Subtitles'), 'span', array('class' => 'language'));?>
            <?php } ?>

            <?php if (!empty($object->record['dc:subject']['oss:genre'])) { ?>
              <?php print theme('item_list', $object->record['dc:subject']['oss:genre'], t('Genre'), 'span', array('class' => 'subject'));?>
            <?php } ?>
            <?php if (!empty($object->subjects)) { ?>
              <?php print theme('item_list', $object->subjects, t('Subjects'), 'span', array('class' => 'subject'));?>
            <?php } ?>
            <?php if (!empty($object->record['dcterms:spatial'][''])) { ?>
              <?php print theme('item_list', $object->record['dcterms:spatial'][''], NULL, 'span', array('class' => 'spatial')); ?>
            <?php } ?>

            

            <?php if (!empty($object->record['dc:contributor']['oss:dkind'])) { ?>
              <?php foreach($object->record['dc:contributor']['oss:dkind'] as $reader): ?>
                <?php $readers[] = l($reader,'ting/search/'.$reader); ?>
              <?php endforeach;?>
              <?php print theme('item_list', $readers, t('Reader'), 'span', array('class' => 'contributor'));?>
            <?php } ?>
            <?php if (!empty($object->record['dc:contributor']['oss:act'])) { ?>
              <?php print theme('item_list', $object->record['dc:contributor']['oss:act'], t('Actor'), 'span', array('class' => 'contributor'));?>
            <?php } ?>
            <?php if (!empty($object->record['dc:contributor']['oss:mus'])) { ?>
              <?php print theme('item_list', $object->record['dc:contributor']['oss:mus'], t('Musician'), 'span', array('class' => 'contributor'));?>
            <?php } ?>

            <?php if (!empty($object->record['dcterms:hasPart']['oss:track'])) { ?>
              <?php print theme('item_list', $object->record['dcterms:hasPart']['oss:track'], t('Contains'), 'span', array('class' => 'contains'));?>
            <?php } ?>

            <?php if (!empty($object->record['dcterms:isReferencedBy'][''])) { ?>
              <?php print theme('item_list', $object->record['dcterms:isReferencedBy'][''], t('Referenced by'), 'span', array('class' => 'referenced-by'));?>
            <?php } ?>


            <?php if (!empty($object->record['dc:description'])) { ?>
              <?php foreach ($object->record['dc:description'] as $type => $dc_description) { ?>
                <?php #print theme('item_list', $dc_description, t('Description'), 'span', array('class' => 'description'));?>
              <?php } ?>
            <?php } ?>

            <?php if (!empty($object->record['dc:source'][''])) { ?>
              <?php print theme('item_list', $object->record['dc:source'][''], t('Original title'), 'span', array('class' => 'titles'));?>
            <?php } ?>
            <?php if (!empty($object->record['dcterms:replaces'][''])) { ?>
              <?php print theme('item_list', $object->record['dcterms:replaces'][''], t('Previous title'), 'span', array('class' => 'titles'));?>
            <?php } ?>
            <?php if (!empty($object->record['dcterms:isReplacedBy'][''])) { ?>
              <?php print theme('item_list', $object->record['dcterms:isReplacedBy'][''], t('Later title'), 'span', array('class' => 'titles'));?>
            <?php } ?>

            <?php if (!empty($object->record['dc:identifier']['dkdcplus:ISBN'])) { ?>
              <?php print theme('item_list', $object->record['dc:identifier']['dkdcplus:ISBN'], t('ISBN no.'), 'span', array('class' => 'identifier'));?>
            <?php } ?>

            <?php
              if (!empty($object->record['dc:identifier']['dcterms:URI'])) {
                $uris = array();
                foreach ($object->record['dc:identifier']['dcterms:URI'] as $uri) {
                  $uris[] = l($uri, $uri);
                }
                #print theme('item_list', $uris, t('Host publication'), 'span', array('class' => 'identifier'));                
              }
            ?>


            <?php if (!empty($object->record['dkdcplus:version'][''])) { ?>
              <?php print theme('item_list', $object->record['dkdcplus:version'][''], t('Version'), 'span', array('class' => 'version'));?>
            <?php } ?>



            <?php if (!empty($object->record['dcterms:extent'][''])) { ?>
              <?php print theme('item_list', $object->record['dcterms:extent'][''], t('Extent'), 'span', array('class' => 'version'));?>
            <?php } ?>
            <?php if (!empty($object->record['dc:publisher'][''])) { ?>
              <?php print theme('item_list', $object->record['dc:publisher'][''], t('Publisher'), 'span', array('class' => 'publisher'));?>
            <?php } ?>
            <?php if (!empty($object->record['dc:rights'][''])) { ?>
              <?php print theme('item_list', $object->record['dc:rights'][''], t('Rights'), 'span', array('class' => 'rights'));?>
            <?php } ?>

            <?php /* print elib_book_teaser($object) */ ?>

    </div>
  </div>

  <div class="content-left unit lastUnit">
	  <div class="inner right">
    <?php print check_plain($object->record['dcterms:abstract'][''][0]); ?>
    
    <?php if (!empty($object->record['dc:description'])): ?>
    <?php foreach ($object->record['dc:description'] as $type => $dc_description): ?>
    <?php //print theme('item_list', $dc_description, t('Description'), 'span', array('class' => 'description'));?>
    <?php endforeach; ?>
    <?php endif; ?>
    
	  </div>
 </div>
 </div>
