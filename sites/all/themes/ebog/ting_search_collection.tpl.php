<?php
// $Id$

/**
 * @file
 * Template to render a Ting collection of books.
 */

module_load_include('isbn_static_func.inc', 'elib');
foreach ($collection->objects as $obj){
    // @todo
    // Skip elib check
	if(TRUE/*$obj->type == 'Netdokument'*/) {
		$Obj = $obj;

  $isbn = convertToEAN($obj->record['dc:identifier']['dkdcplus:ISBN'][0]);
  $alttext = t('@titel af @forfatter',array('@titel' => $Obj->title, '@forfatter' => $Obj->creators_string));

?>
  <li class="display-book ting-collection ruler-after line clear-block" id="<?php print $Obj->id ?>">
  
    <div class="picture">
      <?php $image_url = elib_book_cover($isbn, '80_x'); ?>
      <?php if ($image_url) { ?>
        <?php print l(theme('image', $image_url, $alttext, $alttext, null, false), $Obj->url, array('html' => true)); ?>
      <?php } ?>
    </div>

    <div class="record">
      <div class="left">
        <h3>
          <?php print l($Obj->title, $Obj->url, array('attributes' => array('class' =>'title'))) ;?> 
        </h3>
        <div class="meta">
          <?php if ($Obj->creators_string) : ?>
            <span class="creator">
              <?php echo t('By !creator_name', array('!creator_name' => l($Obj->creators_string,'ting/search/'.$Obj->creators_string,array('html' => true)))); ?>
            </span>
          <?php endif; ?>
          <div id="<?php print $Obj->objects[0]->localId ?>"></div>
          <?php if ($Obj->date) : ?>
            <span class="publication_date">
              <?php echo t('(%publication_date%)', array('%publication_date%' => $Obj->date)) /* TODO: Improve date handling, localizations etc. */ ?>
            </span>
          <?php endif; ?>
        </div>
        <div class="rating-for-faust">
          <div class="<?php print $Obj->localId; ?>"></div>
        </div>
        <?php if ($Obj->subjects) : ?>
          <div class="subjects">
            <h4><?php echo t('Subjects:') ?></h4>
            <ul>
              <?php foreach ($Obj->subjects as $subject) : ?>
                <li><?php echo $subject ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>
      </div>
      <div class="right">
        <?php if ($Obj->abstract) : ?>
          <div class="abstract">
            <p>
              <?php print drupal_substr(check_plain($Obj->abstract), 0, 200) . '...'; ?>
            </p>
          </div>
        <?php endif; ?>
        <div class="icons">
          <ul>
          <li><?php print l(t('Stream'), $Obj->url.'/stream', array('html' => true, 'attributes' => array('rel' => 'lightframe'))) ?></li>
            <li class="seperator"></li>
          <li><?php print l(t('Fetch'), $Obj->url.'/download', array('html' => true, 'attributes' => array('rel' => 'lightframe')))?></li>
            <li class="seperator"></li>
          <li><?php print l(t('Sample'), $Obj->url.'/sample', array('html' => true, 'attributes' => array('rel' => 'lightframe[|width:350px; height:120px;]'))) ?></li>
          </ul>
        </div>
      </div>
    </div>

  </li>

<?php
	}
}
