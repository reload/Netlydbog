<?php
/**
 * @file
 *
 */


/**
 * Prepare plugin info.
 */
function ebog_embed_video_embedvideo_ctools_content_types() {
  return array(
    'title' => t('Ebog Embed video'),
    'description' => t('Ebog Embed video description.'),
    'single' => TRUE,
    'category' => array('INLEAD'),
    //'no title override' => TRUE,
  );
}

/**
 * Rendering of the block.
 */
function ebog_embed_video_embedvideo_content_type_render($subtype, $conf, $args, $context) {
  $block = new stdClass();
  $block->title = check_plain('Ebog Embed video');
  $block->content = theme('ebog_embed_video', $conf);
  return $block;
}

/**
 * 'Edit form' callback for the content type.
 */
function ebog_embed_video_embedvideo_content_type_edit_form(&$form, &$form_state) {
  $conf = $form_state['conf'];
  $form['embed_url'] = array(
    '#type' => 'textfield',
    '#title' => t('url to youtube OR vimeo video'),
    '#size' => 50,
    '#description' => t('example: http://www.youtube.com/watch?v=XwmHoWfwHiw OR http://vimeo.com/3535418'),
    '#default_value' => !empty($conf['embed_url']) ? $conf['embed_url'] : '',
    '#prefix' => '<div class="clear-block no-float">',
    '#suffix' => '</div>',
  );
  $form['title'] = array(
    '#type' => 'textfield',
    '#title' => t('title'),
    '#size' => 100,
    '#default_value' => !empty($conf['title']) ? $conf['title'] : '',
    '#prefix' => '<div class="clear-block no-float">',
    '#suffix' => '</div>',
  );
  $form['descr'] = array(
    '#type' => 'textfield',
    '#title' => t('short description'),
    '#size' => 100,
    '#default_value' => !empty($conf['descr']) ? $conf['descr'] : '',
    '#prefix' => '<div class="clear-block no-float">',
    '#suffix' => '</div>',
  );
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

function ebog_embed_video_embedvideo_content_type_edit_form_submit(&$form, &$form_state) {

  $embed_url = $form_state['values']['embed_url'];
  $embed_code = '';

  if (strpos($embed_url, 'youtube')) {
    $type = 'youtube';
    $query = parse_url($embed_url, PHP_URL_QUERY);
    $query = explode('&', $query);
    foreach ($query as $param) {
      if (strrpos($param, 'v=') == 0) {
        $embed_code = drupal_substr($param, 2);
        break;
      }
    }
  }
  elseif (strpos($embed_url, 'vimeo')) {
    $type = 'vimeo';
    $embed_code = str_replace('http://vimeo.com/', '', $embed_url);
  }
  else {
    $type = 'undefined';
  }

  $form_state['conf']['embed_url'] = $form_state['values']['embed_url'];
  $form_state['conf']['embed_code'] = $embed_code;
  $form_state['conf']['type'] = $type;
  $form_state['conf']['title'] = $form_state['values']['title'];
  $form_state['conf']['descr'] = $form_state['values']['descr'];
  $form_state['conf']['see_more_title'] = $form_state['values']['see_more_title'];
  $form_state['conf']['see_more_link'] = $form_state['values']['see_more_link'];

}
