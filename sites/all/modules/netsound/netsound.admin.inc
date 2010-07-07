<?php 

function netsound_settings_form($form_state){
	
	$form['netsound']['netsound_keywords'] = array(
    '#type'          => 'textarea',
    '#title'         => t('Emneord'),
    '#description'   => t(''),
    '#required'      => FALSE,
    '#default_value' => variable_get('netsound_keywords', ''),
  );
  
  return system_settings_form($form);
	
}


?>