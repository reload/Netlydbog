<?php

/**
 * Helper to implementation of hook_node_info().
 */
function _ting_collection_node_info() {
  $items = array(
    'collection' => array(
      'name' => t('Ting Collection'),
      'module' => 'features',
      'description' => t('Create a collection of objects from \'Ting\''),
      'has_title' => '1',
      'title_label' => t('Title'),
      'has_body' => '0',
      'body_label' => '',
      'min_word_count' => '0',
      'help' => '',
    ),
  );
  return $items;
}
