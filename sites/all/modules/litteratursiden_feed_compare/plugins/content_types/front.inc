<?php
/**
 * @file
 *
 */


/**
 * Prepare plugin info.
 */
function litteratursiden_feed_compare_front_ctools_content_types() {
  return array(
    'title' => t('Litteratursiden feed and compare (front)'),
    'description' => t('Litteratursiden feed and compare (front), description.'),
    'single' => TRUE,
    'category' => array('INLEAD'),
  );
}

/**
 * Rendering of the block.
 */
function litteratursiden_feed_compare_front_content_type_render($subtype, $conf, $args, $context) {
  $block = new stdClass();
  $block->title = check_plain('Feed and Compare (front)');

  $items_on_front = variable_get('litteratursiden_feed_compare_items_on_front', '2');
  $items = litteratursiden_feed_compare_get_cached_feed($items_on_front);

  $block->content = theme('litteratursiden_feed_compare_front', $items, $conf);
  return $block;
}

/**
 * 'Edit form' callback for the content type.
 */
function litteratursiden_feed_compare_front_content_type_edit_form(&$form, &$form_state) {
  $conf = $form_state['conf'];
  $form['see_more_title'] = array(
    '#type' => 'textfield',
    '#title' => t('title for "see more link"'),
    '#size' => 100,
    '#default_value' => !empty($conf['see_more_title']) ? $conf['see_more_title'] : '',
    '#prefix' => '<div class="clear-block no-float">',
    '#suffix' => '</div>',
    '#required' => TRUE,
  );
  $form['see_more_link'] = array(
    '#type' => 'textfield',
    '#title' => t('link for "see more link"'),
    '#size' => 100,
    '#default_value' => !empty($conf['see_more_link']) ? $conf['see_more_link'] : '',
    '#prefix' => '<div class="clear-block no-float">',
    '#suffix' => '</div>',
    '#required' => TRUE,
  );
  return $form;
}

function litteratursiden_feed_compare_front_content_type_edit_form_submit(&$form, &$form_state) {
  $form_state['conf']['see_more_title'] = $form_state['values']['see_more_title'];
  $form_state['conf']['see_more_link'] = $form_state['values']['see_more_link'];
}
