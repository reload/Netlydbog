<?php 

function netsound_settings_form($form_state){
	
	$form['netsound']['netsound_keywords'] = array(
    '#type'          => 'textarea',
    '#title'         => t('Emneord'),
    '#description'   => t(''),
    '#required'      => FALSE,
    '#default_value' => variable_get('netsound_keywords', ''),
  );
  
  $form['netsound']['netsound_shortcutmenu'] = array(
    '#type'          => 'textarea',
    '#title'         => t('Genvejs menu til kontaktformularer'),
    '#description'   => t('Et element pr linie. Hver linie består af to elementer delt af lodret streg |. Første del af elementet er elementets titel og anden del er linket til siden med den tilhørende kontaktformular'),
    '#required'      => FALSE,
    '#default_value' => variable_get('netsound_shortcutmenu', ''),
  );
  
  return system_settings_form($form);
	
}


?>