<?php



/**
 * @file
 * fb_social_like.views.inc
 */

/**
 * Implementation of hook_views_data()
 */
function fb_social_like_views_data(){
  $data = array();
  
  $data['fb_social_like']['table']['group'] = t('fb social');
  
  $data['fb_social_like']['table']['join'] = array(
      '#global' => array() 
  );
  
  $data['fb_social_like']['fb_social_like'] = array(
      'group' => t('fb social like button'), 
      'field' => array(
          'title' => t('fb social like button'), 
          'help' => t('Provide the fb like button as a view field'), 
          'handler' => 'fb_social_like_handler_field_like'
      ) 
  );
  
  return $data;
}

/**
 * Implementation of hook_views_handlers() to register all of the basic handlers
 * views uses.
 */
function fb_social_like_views_handlers(){
  return array(
      'info' => array(
          'path' => drupal_get_path('module', 'fb_social_like') . '/views',
      ), 
      'handlers' => array(
          'fb_social_like_handler_field_like' => array(
              'parent' => 'views_handler_field_node' 
          ) 
      ) 
  );
}

