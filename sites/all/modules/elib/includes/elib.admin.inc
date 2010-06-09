<?php 

function ting_admin_settings_form_elib($form_state) {
  $form = array();

  $form['elib'] = array(
    '#type'        => 'fieldset',
    '#title'       => t('Ting - Additional Information settings'),
    '#description' => t('The Additional Information service is used to retrieve cover images and other information about objects. <a href="http://www.danbib.dk/index.php?doc=forsideservice">More information about the service (in Danish)</a>'),
    '#tree'        => FALSE,
  );
  $form['elib']['addi_wdsl_url'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Service URL'),
    '#description'   => t('URL to the Additional Information webservice, e.g. http://forside.addi.dk/addi.wsdl'),
    '#required'      => TRUE,
    '#default_value' => variable_get('addi_wdsl_url', ''),
  );
  $form['elib']['addi_username'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Username'),
    '#description'   => t('Username for the Additional information webservice'),
    '#required'      => TRUE,
    '#default_value' => variable_get('addi_username', ''),
  );
  $form['elib']['addi_group'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Group'),
    '#description'   => t('User group for the Additional information webservice'),
    '#required'      => TRUE,
    '#default_value' => variable_get('addi_group', ''),
  );
  $form['elib']['addi_password'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Password'),
    '#description'   => t('Password for the Additional information webservice'),
    '#required'      => TRUE,
    '#default_value' => variable_get('addi_password', ''),
  );
  $form['elib']['addi_enable_logging'] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Enable logging'),
    '#default_value' => variable_get('addi_enable_logging', false),
  );
 
  return system_settings_form($form);
}
?>