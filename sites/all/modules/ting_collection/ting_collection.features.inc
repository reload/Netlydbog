<?php

/**
 * Implementation of hook_content_default_fields().
 */
function ting_collection_content_default_fields() {
  module_load_include('inc', 'ting_collection', 'ting_collection.defaults');
  $args = func_get_args();
  return call_user_func_array('_ting_collection_content_default_fields', $args);
}

/**
 * Implementation of hook_ctools_plugin_api().
 */
function ting_collection_ctools_plugin_api() {
  module_load_include('inc', 'ting_collection', 'ting_collection.defaults');
  $args = func_get_args();
  return call_user_func_array('_ting_collection_ctools_plugin_api', $args);
}

/**
 * Implementation of hook_node_info().
 */
function ting_collection_node_info() {
  module_load_include('inc', 'ting_collection', 'ting_collection.features.node');
  $args = func_get_args();
  return call_user_func_array('_ting_collection_node_info', $args);
}

/**
 * Implementation of hook_strongarm().
 */
function ting_collection_strongarm() {
  module_load_include('inc', 'ting_collection', 'ting_collection.defaults');
  $args = func_get_args();
  return call_user_func_array('_ting_collection_strongarm', $args);
}
