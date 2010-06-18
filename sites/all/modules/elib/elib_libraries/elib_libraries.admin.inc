<?php 

function ting_admin_settings_form_elib($form_state) {
  //$form = array();

  $form['elib']['elib_libraries'] = array(
    '#type'          => 'textarea',
    '#title'         => t('Libraries MATRIX'),
    '#description'   => t('One library per line, the syntax is RetailerID | Retailer Keycode | Label'),
    '#required'      => TRUE,
    '#default_value' => variable_get('elib_libraries', ''),
  );
  
 
  return system_settings_form($form);
}
?>