<?php 

function ting_admin_settings_form_elib($form_state) {
  $form = array();

  $form['elib'] = array(
    '#type'        => 'fieldset',
    '#title'       => t('eLib - SOAP webservice settings'),
    '#description' => t('<p>The API is developed to allow libraries to integrate Elibs distribution platform closely with a site, portal, content management system or library system etc. Not all parts of the API are necessary for all types of use, for example a user validation might not be needed if the system used already has access to user validation features.</p>
<p>The main feature of the API is the web services, which can be used to create a functional solution. Documentation is also a central part. Controlled and legal distribution of files and information is the main goal of the API.</p>
<p>All web services are available here https://www.elib.se/webservices detailed documentation for each web service is available there with examples. This document in its most updated form can also be found there. Most of the API should be self explanatory; the following is to make things a little bit more understandable.</p>'),
    '#tree'        => FALSE,
  );
  $form['elib']['elib_base_url_wsdl'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Base URL of webservices'),
    '#description'   => t('- : -'),
    '#required'      => TRUE,
    '#default_value' => variable_get('elib_base_url_wsdl', ''),
  );
  $form['elib']['elib_retailer_id'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Retailer ID'),
    '#description'   => t(''),
    '#required'      => TRUE,
    '#default_value' => variable_get('elib_retailer_id', ''),
  );
  $form['elib']['elib_retailer_keycode'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Retailer Key Code'),
    '#description'   => t(''),
    '#required'      => TRUE,
    '#default_value' => variable_get('elib_retailer_keycode', ''),
  );
  $form['elib']['elib_language_code'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Language Code'),
    '#description'   => t(''),
    '#required'      => FALSE,
    '#default_value' => variable_get('elib_language_code', ''),
  );

  $form['elib']['elib_proxy_settings'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Proxy settings'),
    '#description'   => t('If you need to proxy the SOAP request, then add the proxy host and port in the format "host:port" ex "localhost:8080" - without the quotes.<br />Note that proxy username and password is not currently supported.'),
    '#required'      => FALSE,
    '#default_value' => variable_get('elib_proxy_settings', ''),
  );

  
  return system_settings_form($form);
}

function elib_loginform(&$form_state) {
  $form = array();
   $form['elib']['elib_language_code'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Language Code'),
    '#description'   => t(''),
    '#required'      => FALSE,
    '#default_value' => variable_get('elib_language_code', ''),
  );


  return drupal_render($form);
}

?>