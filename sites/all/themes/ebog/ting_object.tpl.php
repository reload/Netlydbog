<?php
/**
 * @file ting_object.tpl.php
 *
 * Template to render objects from the Ting database.
 *
 * Available variables:
 * - $object: The TingClientObject instance we're rendering.
 */

module_load_include('isbn_static_func.inc', 'elib');

$isbn = preg_replace('/[^0-9]+/', '', $object->record['dc:identifier']['dkdcplus:ISBN'][0]);

if (module_exists('ding_voxb')) {
  drupal_add_css(VOXB_PATH . '/css/voxb-pager.css');
  drupal_add_css(VOXB_PATH . '/css/voxb.css');
  drupal_add_css(VOXB_PATH . '/css/jqModal.css');
  drupal_add_js(VOXB_PATH . '/js/jqModal.js');
  drupal_add_js(VOXB_PATH . '/js/livequery.js');
  drupal_add_js(VOXB_PATH . '/js/cyclic.fade.js');
  drupal_add_js(VOXB_PATH . '/js/voxb.item.js');
  drupal_add_js(VOXB_PATH . '/js/voxb.details.js');

  require_once(VOXB_PATH . '/lib/VoxbItem.class.php');
  require_once(VOXB_PATH . '/lib/VoxbProfile.class.php');
  require_once(VOXB_PATH . '/lib/VoxbReviews.class.php');

  $faust_number = $object->localId;
  $voxb_item = new VoxbItem();
  $voxb_item->addReviewHandler('review', new VoxbReviews());
  $voxb_item->fetchByFaust($faust_number);
  $profile = unserialize($_SESSION['voxb']['profile']);
}
?>

<!-- ting_object.tpl -->
<div id="ting-object" class="line rulerafter">

  <div class="picture unit grid-3 alpha">
    <?php $image_url = elib_book_cover($isbn, '170_x'); ?>
    <?php if (strpos($image_url,'imagecache')): ?>
      <div class="inner left" style="margin-bottom:10px;">
        <?php print theme('image', $image_url, $object->title, $object->title, null, false); ?>
      </div>
    <?php else: ?>
      <div class="inner left nopicture" style="height:270px;margin-bottom:10px;">
        <?php print theme('image', $image_url, $object->title, $object->title, null, false); ?>
      </div>
    <?php endif;?>
  </div>
  <div class="meta unit grid-9 omega">
    <div class="inner">
      <h1 class="book-title"><?php print check_plain($object->record['dc:title'][''][0]); ?></h1>
      <div class="author"><?php echo t('By !creator_name', array('!creator_name' => l($object->creators_string,'ting/search/'.$object->creators_string,array('html' => true)))) ?></div>
      <?php if (module_exists('ding_voxb')) { ?>
      <div class="ratingsContainer">
        <?php
          $rating = $voxb_item->getRating();
          $rating = intval($rating / 20);
        ?>
        <div class="addRatingContainer">
          <div id="<?php echo $faust_number; ?>" <?php echo(($profile && $profile->isAbleToRate($faust_number)) ? 'class="userRate"' : ''); ?>>
            <?php for ($i = 1; $i <= 5; $i++) { ?>
              <div class="rating <?php echo($i <= $rating ? 'star-on' : 'star-off'); ?>"></div>
            <?php } ?>
          </div>
        </div>
        <?php
        if ($voxb_item->getRatingCount() > 0) {
          echo '<span class="ratingCountSpan">(<span class="ratingVotesNumber">' . $voxb_item->getRatingCount() . '</span> stemmer)</span>';
        }
        ?>
        <img src="/<?php echo VOXB_PATH . '/img/ajax-loader.gif'; ?>" alt="" class="ajax_anim" />
        <div class="clearfix"></div>
      </div>
      <?php } ?>
      <div class="facebook-like">
        <iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fereolen.dk%2Fting%2Fobject%2F150028%3A<?php echo $isbn; ?>&amp;send=false&amp;layout=box_count&amp;width=130&amp;show_faces=false&amp;action=recommend&amp;colorscheme=light&amp;font&amp;height=75" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:130px; height:75px;" allowTransparency="true"></iframe>
      </div>
      <div class="abstract"><?php print check_plain($object->record['dcterms:abstract'][''][0]); ?></div>
      <div class="description">
      <?php if (!empty($object->record['dc:description'])): ?>
        <?php foreach ($object->record['dc:description'] as $type => $dc_description): ?>
          <?php //print theme('item_list', $dc_description, t('Description'), 'span', array('class' => 'description'));?>
        <?php endforeach; ?>
      <?php endif; ?>
      </div>
      <div class="details">
        <div class="left grid-4 omega alpha">
          <?php if (!empty($object->language)) { ?>
            <?php print theme('item_list', array($object->language), t('Language').t(':&nbsp;'), 'span', array('class' => 'language'));?>
          <?php } ?>
          <?php if (!empty($object->record['dkdcplus:version'][''])) { ?>
            <?php print theme('item_list', $object->record['dkdcplus:version'][''], t('Version').t(':&nbsp;'), 'span', array('class' => 'version'));?>
          <?php } ?>
          <?php if (!empty($object->subjects)) { ?>
            <?php print theme('item_list', $object->subjects, t('Subjects').t(':&nbsp;'), 'ul', array('class' => 'subject'));?>
          <?php } ?>
        </div>
        <div class="right grid-5 omega alpha">
          <?php if (!empty($object->record['dc:source'][''])) { ?>
            <?php print theme('item_list', $object->record['dc:source'][''], t('Original title').t(':&nbsp;'), 'span', array('class' => 'titles'));?>
          <?php } ?>
          <?php if (!empty($object->record['dc:identifier']['dkdcplus:ISBN'])) { ?>
            <?php print theme('item_list', $object->record['dc:identifier']['dkdcplus:ISBN'], t('ISBN').t(':&nbsp;'), 'span', array('class' => 'identifier'));?>
          <?php } ?>
          <?php if (!empty($object->record['dc:publisher'][''])) { ?>
            <?php print theme('item_list', $object->record['dc:publisher'][''], t('Publisher'.t(':&nbsp;')), 'span', array('class' => 'publisher'));?>
          <?php } ?>
        </div>

        <div class="various" style="display:none;">
          <?php print theme('item_list', array($object->type), t('Type').t(':&nbsp;'), 'span', array('class' => 'type')); ?>
          <?php if (!empty($object->record['dc:format'][''])) { ?>
            <?php print theme('item_list', $object->record['dc:format'][''], t('Format'), 'span', array('class' => 'format'));?>
          <?php } ?>
          <?php if (!empty($object->record['dcterms:isPartOf'][''])) { ?>
            <?php print theme('item_list', $object->record['dcterms:isPartOf'][''], t('Available in'), 'span', array('class' => 'is-part-of'));?>
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
          <?php if (!empty($object->record['dcterms:replaces'][''])) { ?>
            <?php print theme('item_list', $object->record['dcterms:replaces'][''], t('Previous title'), 'span', array('class' => 'titles'));?>
          <?php } ?>
          <?php if (!empty($object->record['dcterms:isReplacedBy'][''])) { ?>
            <?php print theme('item_list', $object->record['dcterms:isReplacedBy'][''], t('Later title'), 'span', array('class' => 'titles'));?>
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
          <?php if (!empty($object->record['dcterms:extent'][''])) { ?>
            <?php print theme('item_list', $object->record['dcterms:extent'][''], t('Extent'), 'span', array('class' => 'version'));?>
          <?php } ?>
          <?php if (!empty($object->record['dc:rights'][''])) { ?>
            <?php print theme('item_list', $object->record['dc:rights'][''], t('Rights'), 'span', array('class' => 'rights'));?>
          <?php } ?>
          <?php print elib_book_teaser($object) ?>
        </div>
      </div>
      <div class="icons">
        <ul>
          <li><?php print l(t('Sample'), $object->url.'/sample', array('html' => true, 'attributes' => array('rel' => 'lightframe'))) ?></li>
          <li class="seperator"></li>
          <li><?php print l(t('Buy'), 'butik', array('html' => true, 'attributes' => array('rel' => 'lightframe')))?></li>
          <li class="seperator"></li>
          <li><?php print l(t('Loan'), $object->url.'/download', array('html' => true, 'attributes' => array('rel' => 'lightframe[|width:350px; height:120px;]', 'class' => 'ting-object-loan'))) ?></li>
          <?php 
            if($user->uid){
              print '<li class="seperator"></li>';
              print '<li>';
              print l(t('Husk'), $object->url.'/huskeliste?'.drupal_get_destination(), array('html' => true));
              print '</li>';
            }
          ?>
         </ul>
      </div>
      <?php
      if (module_exists('ding_voxb')) {
        echo $object->voxb_tags;
        echo $object->voxb_reviews;
      }
      ?>
    </div>
  </div>
 </div>
<?php if (module_exists('ding_voxb')) { ?>
<div class="jqmWindow" id="dialog">
  <a href="#" class="jqmClose">Close</a>
  <hr>
  <p class="ajax_message">Service unavailable.</p>
</div>
<span class="ajaxLoaderTpl"><img src="/<?php echo VOXB_PATH . '/img/ajax-loader.gif'; ?>" alt="in progress.." class="ajax_anim" /></span>
<?php } ?>
