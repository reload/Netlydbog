<?php

/**
 * Helper to implementation of hook_content_default_fields().
 */
function _ting_collection_content_default_fields() {
  $fields = array();

  // Exported field: field_ting_ref
  $fields[] = array(
    'field_name' => 'field_ting_ref',
    'type_name' => 'collection',
    'display_settings' => array(
      'label' => array(
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '2' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '3' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'ting_reference',
    'required' => '0',
    'multiple' => '5',
    'module' => 'ting_reference',
    'active' => '1',
    'widget' => array(
      'label' => 'Materials',
      'weight' => '-4',
      'description' => 'Enter part of author or material title.',
      'type' => 'ting_reference_default',
      'module' => 'ting_reference',
    ),
  );

  // Translatables
  array(
    t('Materials'),
  );

  return $fields;
}

/**
 * Helper to implementation of hook_ctools_plugin_api().
 */
function _ting_collection_ctools_plugin_api() {
  $args = func_get_args();
  $module = array_shift($args);
  $api = array_shift($args);
  if ($module == "strongarm" && $api == "strongarm") {
    return array("version" => 1);
  }
}

/**
 * Helper to implementation of hook_strongarm().
 */
function _ting_collection_strongarm() {
  $export = array();
  $strongarm = new stdClass;
  $strongarm->disabled = FALSE; /* Edit this to true to make a default strongarm disabled initially */
  $strongarm->api_version = 1;
  $strongarm->name = 'content_extra_weights_collection';
  $strongarm->value = array(
    'title' => '-5',
    'revision_information' => '-2',
    'comment_settings' => '1',
    'menu' => '-3',
    'path' => '0',
    'attachments' => '-1',
  );

  $export['content_extra_weights_collection'] = $strongarm;
  return $export;
}
