<?php


/**
 * Settings form
 */
function fb_social_share_settings_form(){

  $form = array();
  $form['node_types'] = array(
    '#type' => 'fieldset',
    '#title' => t('Content types'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );
  
  $form['node_types']['fb_social_share_node_types'] = array(
    '#type' => 'checkboxes',
    '#description' => t('Select types that will use the facebook share plugin'),
    '#default_value' => variable_get('fb_social_share_node_types', array()),
    '#options' => node_get_types('names'),
  );
  
  $form['widget_location'] = array(
    '#type' => 'fieldset',
    '#title' => t('Widget location and display'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );
  $form['widget_location']['fb_social_share_location'] = array(
    '#type' => 'radios',
    '#title' => t('widget location'),
    '#default_value' => variable_get('fb_social_share_location', 0),
    '#options' => array(t('Node links'), t('Node content')),
    '#description' => t('The widget can be printed in the "links" are of the node or as part of the node content'),
  );
  
  $form['widget_location']['fb_social_share_display_teasers'] = array(
    '#type' => 'checkbox',
    '#title' => t('Show on teasers'),
    '#default_value' => variable_get('fb_social_share_display_teasers', 1),
    '#description' => t('Should the widget be displayed on teasers?'),
  );
  

  $form['fb_social_share_layout_style'] = array(
    '#type' => 'select',
    '#title' => t('Layout style'),
    '#description' => t('Determines the size and the amount of the social context next to the button'),
    '#default_value' => variable_get('fb_social_share_layout_style', 'button_count'),
    '#options' => array(' box_count' => t(' box_count'), 'button_count' => t('button_count'), 'button' => t('button'), 'icon' => t('icon'), 'icon_link' => t('icon_link'))
  );
  
   $form['fb_social_share_check_teasers'] = array(
    '#type' => 'checkbox',
    '#title' => t('Show on teasers'),
    '#default_value' => variable_get('fb_social_share_check_teasers', 1),
    '#description' => t('Should the widget be displayed on teasers?')
      );
      
   
  

  return system_settings_form($form);
}