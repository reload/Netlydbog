<?php
/**
 * @file
 *
 * Admin related stuff for popular items page.
 */

define('ELIB_POPULAR_ITEM_COUNT_DEFAULT', 100);
define('ELIB_POPULAR_TRIM_LENGTH_DEFAULT', 200);

/**
 * Popular page settings form.
 */
function elib_block_lastloans_admin($form_state) {
  $form = array();

  $form['elib'] = array(
    '#type'        => 'fieldset',
    '#title'       => t('eLib - Popular items page settings'),
    '#description' => t(''),
    '#tree'        => FALSE,
  );

  $form['elib']['elib_popular_trim_length'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Item description trimmed length'),
    '#description'   => t(''),
    '#required'      => TRUE,
    '#default_value' => variable_get('elib_popular_trim_length', ELIB_POPULAR_TRIM_LENGTH_DEFAULT),
  );

  $form['elib']['elib_popular_item_count'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Number of popular loans displayed'),
    '#description'   => t(''),
    '#required'      => TRUE,
    '#default_value' => variable_get('elib_popular_item_count', ELIB_POPULAR_ITEM_COUNT_DEFAULT),
  );

  $form['#submit'] = array('elib_block_lastloans_admin_submit');

  return system_settings_form($form);
}

/**
 * Popular page setting form submit handler.
 *
 * Used for clearing cache.
 */
function elib_block_lastloans_admin_submit($form, &$form_state) {
  $cache_name = 'elib_popular_books_extended_cache';
  $cache_table = 'cache';

  cache_clear_all($cache_name, $cache_table);
}
