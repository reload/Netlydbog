<?php

function fb_social_send_settings_form(){
  $form = array();
  
 $form['node_types'] = array(
    '#type' => 'fieldset',
    '#title' => t('Content types'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );
  
  $form['node_types']['fb_social_send_node_types'] = array(
    '#type' => 'checkboxes',
    '#description' => t('Select types that will use the facebook send plugin'),
    '#default_value' => variable_get('fb_social_send_node_types', array()),
    '#options' => node_get_types('names'),
  );
  
  $form['widget_location'] = array(
    '#type' => 'fieldset',
    '#title' => t('Widget location and display'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );
  $form['widget_location']['fb_social_send_location'] = array(
    '#type' => 'radios',
    '#title' => t('widget location'),
    '#default_value' => variable_get('fb_social_send_location', 0),
    '#options' => array(t('Node links'), t('Node content')),
    '#description' => t('The widget can be printed in the "links" are of the node or as part of the node content'),
  );
  
  $form['widget_location']['fb_social_send_display_teasers'] = array(
    '#type' => 'checkbox',
    '#title' => t('Show on teasers'),
    '#default_value' => variable_get('fb_social_send_display_teasers', 1),
    '#description' => t('Should the widget be displayed on teasers?'),
  );
  
  $form['fb_social_send_font'] = array(
    '#type' => 'select', 
    '#title' => t('Font'), 
    '#description' => t('The font of the plugin'), 
    '#default_value' => variable_get('fb_social_send_font', ""), 
    '#options' => array(
      'arial' => t('arial'), 
      'lucida grande' => t('lucida grande'),
      'segoe ui' => t('segoe ui'),
      'tahoma' => t('tahoma'),
      'trebuchet ms' => t('trebuchet ms'),
      'verdana' => t('verdana'),
    ) 
  );
  
  $form['fb_social_send_colorscheme'] = array(
    '#type' => 'select', 
    '#title' => t('Color'), 
    '#description' => t('The color scheme of the widget'), 
    '#default_value' => variable_get('fb_social_send_colorscheme', 'light'), 
    '#options' => array(
      'dark' => t('dark'), 
      'light' => t('light') 
    ) 
  );
  
  $form = system_settings_form($form);
  return $form;

}


