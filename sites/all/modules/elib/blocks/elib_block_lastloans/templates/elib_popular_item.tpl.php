<?php
/**
 * @file
 *
 * Popular loaned items page, single item template.
 */
?>
<li class="display-book ting-collection ruler-after line clear-block" id="<?php print $data['ting_obj']->id ?>">
  <div class="picture">
    <?php
      $image_url = elib_book_cover($data['isbn'], '80_x');
      $alttext = t('@titel by @forfatter',array('@titel' => $data['ting_obj']->title, '@forfatter' => $data['ting_obj']->creators_string));
    ?>
    <?php if ($image_url) { ?>
      <?php print l(theme('image', $image_url, $alttext, $alttext, null, false), $data['ting_obj']->url, array('html' => true)); ?>
    <?php } ?>
  </div>

  <div class="record">
    <div class="left">
      <h3>
        <?php print l($data['ting_obj']->title, $data['ting_obj']->url, array('attributes' => array('class' =>'title'))) ;?>
      </h3>
      <div class="meta">
        <?php if ($data['ting_obj']->creators_string) : ?>
          <span class="creator">
            <?php echo t('By !creator_name', array('!creator_name' => l($data['ting_obj']->creators_string,'ting/search/'.$data['ting_obj']->creators_string,array('html' => true)))) ?>
          </span>
        <?php endif; ?>
        <div id="<?php print $data['ting_obj']->objects[0]->localId ?>"></div>
        <?php if ($data['ting_obj']->date) : ?>
          <span class="publication_date">
            <?php echo t('(%publication_date%)', array('%publication_date%' => $data['ting_obj']->date)) ?>
          </span>
        <?php endif; ?>
      </div>
      <?php if ($data['ting_obj']->subjects) : ?>
        <div class="subjects">
          <h4><?php echo t('Subjects:') ?></h4>
          <ul>
            <?php foreach ($data['ting_obj']->subjects as $subject) : ?>
              <li><?php echo $subject ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>
    </div>
    <div class="right">
      <?php if ($data['ting_obj']->abstract) : ?>
        <div class="abstract">
          <p>
            <?php print drupal_substr(check_plain($data['ting_obj']->abstract), 0, variable_get('elib_popular_trim_length', ELIB_POPULAR_TRIM_LENGTH_DEFAULT)) . '...'; ?>
          </p>
        </div>
      <?php endif; ?>
      <div class="icons">
        <ul>
          <li><?php print l(t('Sample'), $data['ting_obj']->url.'/sample', array('html' => true, 'attributes' => array('rel' => 'lightframe'))) ?></li>
          <li class="seperator"></li>
          <li><?php print l(t('Buy'), 'butik', array('html' => true, 'attributes' => array('rel' => 'lightframe')))?></li>
          <li class="seperator"></li>
          <li><?php print l(t('Loan'), $data['ting_obj']->url.'/download', array('html' => true, 'attributes' => array('rel' => 'lightframe[|width:350px; height:120px;]'))) ?></li>
        </ul>
      </div>
    </div>
  </div>
</li>
