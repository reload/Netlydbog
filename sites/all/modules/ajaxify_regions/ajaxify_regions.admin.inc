<?php
/**
 * Admin settings form for Ajaxify Regions
 */
function ajaxify_regions_admin_settings() {
  $form = array();
  $form['ajaxify_regions_auth'] = array(
    '#title' => t('Ajax replace for Authenticated users?'),
    '#type' => 'select',
    '#options' => array(
      '0' => 'No',
      '1' => 'Yes',
    ), 
    '#default_value' => variable_get('ajaxify_regions_auth', 0),
    '#description' => t('This is only useful if you are attempting to statically cache authenticated traffic. If you\'re not, then leave this off.'),
  );
  $options = array(t('Ajax replace on every page except the listed pages.'), t('Ajax replace on only the listed pages.'));
  $description = t("Enter one page per line as Drupal paths. The '*' character is a wildcard. Example paths are %blog for the blog page and %blog-wildcard for every personal blog. %front is the front page.", array('%blog' => 'blog', '%blog-wildcard' => 'blog/*', '%front' => '<front>'));
  $form['ajaxify_regions_p'] = array(
    '#type' => 'fieldset',
    '#title' => t('Page specific replacement settings'),
    '#collapsible' => TRUE,
  );
  $form['ajaxify_regions_p']['ajaxify_regions_p_vis'] = array(
    '#type' => 'radios',
    '#title' => t('Ajax replace on specific pages'),
    '#options' => $options,
    '#default_value' => variable_get('ajaxify_regions_p_vis', 0),
  );
  $form['ajaxify_regions_p']['ajaxify_regions_p_p'] = array(
    '#type' => 'textarea',
    '#title' => t('Pages'),
    '#default_value' => variable_get('ajaxify_regions_p_p', ''),
    '#description' => $description,
  );
  
  $options = array(t('Ajax replace for every block except the listed blocks.'), t('Ajax replace only the listed blocks.'));
  $description = t("Enter one block per line as block-delta pairs. The '*' character is a wildcard. Example paths are %block for the first admin created block and %block-wildcard for every admin created block.", array('%block' => 'block-0', '%block-wildcard' => 'block-*'));
  $form['ajaxify_regions_b'] = array(
    '#type' => 'fieldset',
    '#title' => t('Block specific replacement settings'),
    '#collapsible' => TRUE,
  );
  $form['ajaxify_regions_b']['ajaxify_regions_b_vis'] = array(
    '#type' => 'radios',
    '#title' => t('Ajax replace specific blocks'),
    '#options' => $options,
    '#default_value' => variable_get('ajaxify_regions_b_vis', 0),
  );
  $form['ajaxify_regions_b']['ajaxify_regions_b_b'] = array(
    '#type' => 'textarea',
    '#title' => t('Blocks'),
    '#default_value' => variable_get('ajaxify_regions_b_b', ''),
    '#description' => $description,
  );
  return system_settings_form($form);
}