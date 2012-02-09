<?php

// $Id: droptor_form.inc,v 1.1.2.9 2011/02/02 19:44:31 urbanjustin Exp $ 

/**
 * @file
 * The Droptor bridge module  
 * Droptor.com - Drupal site organization, monitoring, management and best practices
 * 
 * For more information, see:
 * - http://www.droptor.com
 * - http://drupal.org/project/droptor
 */

function droptor_settings() {
  $fssl = droptor_ssl_enabled() == 1 ? TRUE : FALSE;
  $feed_url = url('droptorfeed/' . variable_get('droptor_hash', ''), array('absolute' => TRUE));

  if (variable_get('droptor_ssl_feed', 0) == 1 && drupal_substr($feed_url, 0, 5) != 'https')
    $feed_url = 'https' . drupal_substr($feed_url, 4, drupal_strlen($feed_url));
  elseif (variable_get('droptor_ssl_feed', 0) == 0 && drupal_substr($feed_url, 0, 5) == 'https')
    $feed_url = 'http' . drupal_substr($feed_url, 5, drupal_strlen($feed_url));
    
  $output = l(t('Droptor'), 'http://www.droptor.com/', array('attributes' => array('title' => t('Drupal site organization, monitoring, management and best practices.'))));
  $output .= ' ' . t('is a profiling and best practices service for Drupal. This module feeds information to the Droptor.com web site (mostly about your installed modules and system variables).');
  $output .= ' ' . t('You can learn more about the module at') . ' ';
  $output .= l(t('our web site'), 'http://www.Droptor.com/support/#droptor-monitoring-module', array('attributes' => array('title' => t('Our support page')))) . '.';
  $output .= '<br /><br />' . t('To maintain security the feed URL that provides data to Droptor will only be provided if the secret hash is provided, the request comes from the correct domain and');
  $output .= ' ' . '<span style="' . (!$fssl ? 'text-decoration:line-through' : '') . '">' . t('the request comes over SSL') . '</span>' . 
    t((!$fssl ? t(' (your site appears to not support SSL)') : '')  . ($fssl && variable_get('droptor_ssl_feed', 0) == 0 ? t('(you need to enable SSL below)') : '')  . '.');
  $output .= '<br/><br/>' . t('You can read more how we secure the feed') . ' ' . l(t('in our FAQ'), 'http://www.droptor.com/support/#droptor-monitoring-module-security') . '.';  
  $output .= t('Your feed URL:') . '<br />' .  l($feed_url, $feed_url, array('attributes' => array('target' => '_blank', 'title' => t('You will not be able to see this if the domain is set correctly below.'))));

  $droptor_form = drupal_get_form('droptor_settings_form'); // call the form first, so that error msg dissappears after debug mode is disabled.

  if (variable_get('droptor_debug_mode', 0) == 1)
    drupal_set_message(t('This returns additional data to Droptor.com that is helpful with troubleshooting connectivity issues. It is important to disable this mode for production use.'), 'error');

  return $output . $droptor_form;
}

function droptor_settings_form() {
  $fssl = droptor_ssl_enabled() == 1 ? TRUE : FALSE;
  $checkbox_text = $fssl ? 'Your site supports SSL. You should require the feed connect over SSL for security' 
    : 'Your site doesn\'t support SSL, so we can\'t encrypt the feed'; 

  $form['droptor_hash'] = array(
    '#type' => 'textfield', 
    '#title' => t('Hash key'), 
    '#default_value' => variable_get('droptor_hash', NULL), 
    '#size' => 50, 
    '#maxlength' => 50, 
    '#description' => t('A secret key you get from') . ' ' . l(t('Droptor.com'), 'http://www.Droptor.com/sites') 
      . '. ' . t('For') . ' ' . l(t('security reasons'), 'http://www.droptor.com/support/#droptor-monitoring-module-security')
      . '  ' . t('the feed won\'t be shown unless this key is provided. Register your site at Droptor.com to get this key.'), 
    '#required' => TRUE, 
  );
  
  $form['droptor_domain'] = array(
    '#type' => 'textfield', 
    '#title' => t('Allowed domain'), 
    '#default_value' => variable_get('droptor_domain', 'droptor.com'), 
    '#size' => 50, 
    '#maxlength' => 15, 
    '#description' => t('For security reasons, we limit the data feed by IP/domain name. Enter in droptor.com here or your IP(') .  $_SERVER['REMOTE_ADDR']  . t(') if you want to see what the feed looks like).'), 
    '#required' => TRUE, 
  );
  
  $form['droptor_ssl_feed'] = array(
    '#type' => 'checkbox', 
    '#title' => t('Send feed over SSL'), 
    '#default_value' => variable_get('droptor_ssl_feed', $fssl ? 'checked' : ''), 
    '#disabled' => $fssl ? FALSE : TRUE, 
    '#description' => t($checkbox_text), 
    '#required' => FALSE, 
  );
  
  $form['droptor_memory_monitoring'] = array(
    '#type' => 'checkbox', 
    '#title' => t('Enable memory monitoring'), 
    '#default_value' => variable_get('droptor_memory_monitoring', 0), 
    '#description' => droptor_has_memory_management() ?
  		t('When checked Droptor will capture the memory usage and page execution for every page request. ' . l('More information', 'http://www.droptor.com/support#memory-monitoring') . '.') :
  		t('Your version of PHP does not support this feature. You need at least PHP 5.2.'), 
    '#disabled' => droptor_has_memory_management() ? FALSE : TRUE,
    '#required' => FALSE, 
  );
  
  $form['droptor_debug_mode'] = array(
    '#type' => 'checkbox', 
    '#title' => t('Enable debug mode.'), 
    '#default_value' => variable_get('droptor_debug_mode', ''), 
    '#description' => t('Enable debug mode. It is important to disable this mode for production use.'), 
    '#required' => FALSE, 
  );
  
  $form['submit'] = array(
    '#type' => 'submit', 
    '#value' => t('Save'), 
  );

  return $form;  
}

function droptor_settings_form_validate(&$form, &$form_state) {
  if (drupal_strlen(trim($form_state['values']['droptor_hash'])) != 40)
    form_set_error('', t('Please enter a hash value. You can get one from Droptor.com.'));
}

function droptor_settings_form_submit(&$form, &$form_state) {
  variable_set('droptor_hash', $form_state['values']['droptor_hash']);
  variable_set('droptor_domain', $form_state['values']['droptor_domain']);
  variable_set('droptor_ssl_feed', $form_state['values']['droptor_ssl_feed']);
  variable_set('droptor_memory_monitoring', $form_state['values']['droptor_memory_monitoring']);
  variable_set('droptor_debug_mode', $form_state['values']['droptor_debug_mode']);
  drupal_set_message(t('Settings saved. Now return to') . ' ' . l(t('Droptor.com'), 'http://www.Droptor.com/sites') . ' ' . t('and run a scan!'));
}