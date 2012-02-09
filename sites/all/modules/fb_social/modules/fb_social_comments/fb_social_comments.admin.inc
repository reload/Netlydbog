<?php

/**
 * Settings form
 */
function fb_social_comments_settings_form(){
  $form = array();

  $form['node_types'] = array(
    '#type' => 'fieldset',
    '#title' => t('Content types'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );
  $form['node_types']['fb_social_comments_node_types'] = array(
    '#type' => 'checkboxes',
    '#description' => t('Select the content types that will use fb_comments. NOTE: Drupal comment settings will be ignored for the selected content types'),
    '#default_value' => variable_get('fb_social_comments_node_types', array()),
    '#options' => node_get_types('names'),
  );
  

  $form['widget_setings'] = array(
    '#type' => 'fieldset',
    '#title' => t('Widget settings'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );

  $form['widget_setings']['fb_social_comments_numposts'] = array(
    '#type' => 'textfield',
    '#title' => t('Number of posts'),
    '#description' => t('The maximum number of posts to display. You can set numposts to 0 to not display any comments. (Default value is 10.)'),
    '#default_value' => variable_get('fb_social_comments_numposts', 10),
  );
  
  $form['widget_setings']['fb_social_comments_width'] = array(
    '#type' => 'textfield',
    '#title' => t('Width'),
    '#description' => t('The width of the Comments Box in pixels. (Default value is 550px.)'),
    '#default_value' => variable_get('fb_social_comments_width', 550),
  );
  
  $form['widget_setings']['fb_social_comments_colorscheme'] = array(
    '#type' => 'select',
    '#title' => t('Color Scheme'),
    '#description' => t('The color scheme of the plugin'),
    '#options' => array(
      'dark' => t('dark'),
      'light' => t('light'),
    ),
    '#default_value' => variable_get('fb_social_comments_colorscheme', 'light'),
  );
  
  $form['widget_setings']['fb_social_comments_migrated'] = array(
    '#type' => 'checkbox',
    '#title' => t('Migrate to the new version of facebook comments'),
    '#description' => t('If you are using the original version of the Facebook Comments box, check and the comments box will automatically switch to the new version'),
    '#default_value' => variable_get('fb_social_comments_migrated', 0),
  );
  
  
  $form = system_settings_form($form);
  return $form;
}