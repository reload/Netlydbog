<?php
/**
 * @file webtrends_admin.inc
 */

function webtrends_admin_settings_form() {
  global $base_url;

  // Timezone list with webtrends values
  $timezone_list = array(
    '-11' => '(GMT-11:00) Midway Island,Samoa',
    '-10' => '(GMT-10:00) Hawaii',
    '-9' => '(GMT-09:00) Alaska',
    '-8' => '(GMT-08:00) Pacific Time (US & Canada); Tijuana',
    '-7' => '(GMT-07:00) Mountain Time (US & Canada)',
    '-6' => '(GMT-06:00) Central Time (US & Canada),Mexico City',
    '-5' => '(GMT-05:00) Eastern Time (US & Canada)',
    '-4' => '(GMT-04:00) Antigua,La Paz,Puerto Rico',
    '-3' => '(GMT-03:00) Buenos Aires,Georgetown',
    '-2' => '(GMT-02:00) Mid Atlantic',
    '-1' => '(GMT-01:00) Azores,Cape Verde Islands',
    '0' => '(GMT+00:00) Greenwich Mean Time: London,Dublin,Lisbon',
    '1' => '(GMT+01:00) Central European Standard Time,West Central Africa',
    '2' => '(GMT+02:00) Athens,Istanbul,Jerusalem,Helsinki',
    '3' => '(GMT+03:00) Kuwait,Moscow,St.Petersburg,Nairobi',
    '3.5' => '(GMT+03:30) Iran',
    '4' => '(GMT+04:00) Abu Dhabi,Muscat,Baku',
    '4.5' => '(GMT+04:30) Kabul',
    '5' => '(GMT+05:00) Islamabad,Karachi,Tashkent',
    '5.5' => '(GMT+05:30) Calcutta,Chennai,Mumbai,New Delhi',
    '5.75' => '(GMT+05:45) Kathmandu',
    '6' => '(GMT+06:00) Astana,Dhaka,Sri Jayawardenepura',
    '7' => '(GMT+07:00) Bangkok,Hawaii,Jakarta,Krasnoyark',
    '8' => '(GMT+08:00) Beijing,Kuala Lumpur,Perth,Singapore',
    '9' => '(GMT+09:00) Tokyo,Seoul,Jayapura,Irkutsk',
    '9.5' => '(GMT+09:30) Adelaide,Darwin',
    '10' => '(GMT+10:00) Brisbane,Sydney,Hobart,Guam',
    '11' => '(GMT+11:00) Magadan,Solomon Is.,New Caledonia',
    '12' => '(GMT+12:00) Auckland,Fiji,Kamchatka,Marshall Is.',
  );

  $form['general'] = array(
    '#type' => 'fieldset',
    '#title' => t('General Settings'),
  );
  $form['general']['fpcdom'] = array(
    '#type' => 'textfield',
    '#title' => t('The site domain you want to track'),
    '#default_value' => variable_get('webtrends_fpcdom', $base_url),
    '#description' => 'Enter the domain in the following format: example.com, example.co.uk',
  );
  $form['general']['source_id'] = array(
    '#type' => 'textfield',
    '#title' => t('Source Id'),
    '#default_value' => variable_get('webtrends_source_id', ''),
    '#description' => 'The Webtrends source id (DCSID), in the following format: dcsxxxxxxxxxxxxxxxxxxxxxx_xxxx',
  );
  $form['general']['domain'] = array(
    '#type' => 'textfield',
    '#title' => t('Data collection server'),
    '#default_value' => variable_get('webtrends_domain', 'statse.webtrendslive.com'),
    '#description' => 'The Internet address of the WebTrends server that collects your web data.',
  );
  $form['general']['timezone'] = array(
    '#type' => 'select',
    '#options' => $timezone_list,
    '#title' => t('Timezone'),
    '#default_value' => variable_get('webtrends_timezone', 0),
    '#description' => 'Select the time zone for your WebTrends data source, typically the same time zone as your web server',
  );
  $form['roles'] = array(
    '#type' => 'fieldset',
    '#title' => t('Roles Tracking'),
    '#description' => 'Select the roles for which tracking is enabled.'
  );

  $user_roles = user_roles();
  $tracked_roles = explode('_', variable_get('webtrends_enabled_roles', ''));

  if (is_array($user_roles) && count($user_roles)) {
    foreach ($user_roles as $role_id => $role_name) {
      $form['roles']['role_'.$role_id] = array(
        '#type' => 'checkbox',
        '#title' => $role_name,
        '#default_value' => in_array($role_id, $tracked_roles) ? 1 : 0,
      );
    }
  }

  $form['submit'] = array('#type' => 'submit', '#value' => t('Save'));

  return $form;
}

/**
 * webtrends_admin_settings_form validator function
 * @TODO: properly validate the fields
 */
function webtrends_admin_settings_form_validate($form, &$form_state) {
  if (!strlen(trim($form_state['values']['fpcdom']))) {
    form_set_error('fpcdom', t('The provided domain url is invalid. Correct format is example.com!'));
  }
  if (!strlen(trim($form_state['values']['source_id']))) {
    form_set_error('source_id', t('The Source Id (DCSID) cannot be empty!'));
  }
  if (!strlen(trim($form_state['values']['domain']))) {
    form_set_error('domain', t('The data collection server url is invalid. Correct format is statse.webtrendslive.com!'));
  }
}

function webtrends_admin_settings_form_submit($form, &$form_state) {
  variable_set('webtrends_fpcdom', $form_state['values']['fpcdom']);
  variable_set('webtrends_source_id', $form_state['values']['source_id']);
  variable_set('webtrends_domain', $form_state['values']['domain']);
  variable_set('webtrends_timezone', $form_state['values']['timezone']);

  $roles_enabled = array();
  foreach ($form_state['values'] as $key => $value) {
    if ((substr($key, 0, 4) == 'role') && $value) {
      $key_pieces = explode('_', $key);
      $roles_enabled[] = $key_pieces[1];
    }
  }

  variable_set('webtrends_enabled_roles', implode('_', $roles_enabled));
}