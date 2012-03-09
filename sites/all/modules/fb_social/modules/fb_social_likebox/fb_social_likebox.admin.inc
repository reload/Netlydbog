<?php

/**
 * Settings form for choosing the operating mode of purl
 */
function fb_social_likebox_settings_form(){
  $form = array();

  $form['widget_setings'] = array(
    '#type' => 'fieldset',
    '#title' => t('Widget settings'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );

  $form['widget_setings']['fb_social_likebox_href'] = array(
    '#type' => 'textfield',
    '#title' => t('Facebook Page URL'),
    '#description' => t('The URL of the facebook page for this like box'),
    '#default_value' => variable_get('fb_social_likebox_href', ''),
  );
  
  $form['widget_setings']['fb_social_likebox_width'] = array(
    '#type' => 'textfield',
    '#title' => t('Width'),
    '#description' => t('The width of the wiget in pixel'),
    '#default_value' => variable_get('fb_social_likebox_width', 292),
  );
  
  $form['widget_setings']['fb_social_likebox_height'] = array(
    '#type' => 'textfield',
    '#title' => t('Height'),
    '#description' => t('The height of the wiget in pixel'),
    '#default_value' => variable_get('fb_social_likebox_height', 63),
  );
  
  $form['widget_setings']['fb_social_likebox_color'] = array(
    '#type' => 'select',
    '#title' => t('Color'),
    '#description' => t('The color scheme of the plugin'),
    '#default_value' => variable_get('fb_social_likebox_color', 'light'),
    '#options' => array('dark' => t('dark'), 'light' => t('light') )
  );
  
  $form['widget_setings']['fb_social_likebox_connections'] = array(
    '#type' => 'textfield',
    '#title' => t('Connections'),
    '#description' => t('Show a sample of this many users who have liked this page '),
    '#default_value' => variable_get('fb_social_likebox_connections', 10),
  );
  
  $form['widget_setings']['fb_social_likebox_stream'] = array(
    '#type' => 'radios',
    '#title' => 'Show stream',
    '#description' => t('Show the profile stream for the public profile'),
    '#default_value' => variable_get('fb_social_likebox_stream', 1),
    '#options' => array(t('False'), t('True')),
  );
  
  $form['widget_setings']['fb_social_likebox_header'] = array(
    '#type' => 'radios',
    '#title' => t('Show header'),
    '#description' => t('Show the "find us on facebook" bar at the top. Only shown when either stream or connections are present'),
    '#default_value' => variable_get('fb_social_likebox_header', 1),
    '#options' => array(t('False'), t('True')),
  );
  
  $form = system_settings_form($form);
  return $form;
}
