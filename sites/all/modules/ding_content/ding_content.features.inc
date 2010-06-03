<?php

/**
 * Implementation of hook_content_default_fields().
 */
function ding_content_content_default_fields() {
  module_load_include('inc', 'ding_content', 'ding_content.defaults');
  $args = func_get_args();
  return call_user_func_array('_ding_content_content_default_fields', $args);
}

/**
 * Implementation of hook_imagecache_default_presets().
 */
function ding_content_imagecache_default_presets() {
  module_load_include('inc', 'ding_content', 'ding_content.defaults');
  $args = func_get_args();
  return call_user_func_array('_ding_content_imagecache_default_presets', $args);
}

/**
 * Implementation of hook_strongarm().
 */
function ding_content_strongarm() {
  module_load_include('inc', 'ding_content', 'ding_content.defaults');
  $args = func_get_args();
  return call_user_func_array('_ding_content_strongarm', $args);
}

/**
 * Implementation of hook_views_default_views().
 */
function ding_content_views_default_views() {
  module_load_include('inc', 'ding_content', 'ding_content.features.views');
  $args = func_get_args();
  return call_user_func_array('_ding_content_views_default_views', $args);
}
