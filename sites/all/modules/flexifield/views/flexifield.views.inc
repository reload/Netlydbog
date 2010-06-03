<?php
// $Id: flexifield.views.inc $
/**
 * @file
 * Provide views data for flexifield.module.
 */

/**
 * Implementation of hook_views_data().
 * 
 * Provide a base table for relationships to join on.
 */
function flexifield_views_data() {
  $aData['flexifield_items']['table']['group']  = t('Flexifield');
  $aData['flexifield_items']['table']['base'] = array(
    'field' => 'item_id',
    'title' => t('Flexifield Item Id'),
  );
  return $aData;
}

/**
 * Implementation of hook_views_data_alter().
 *
 * Exposes all CCK fields to support relationships with flexifield items.
 */
function flexifield_views_data_alter(&$aData) {
  foreach (content_fields() as $field) {
    $sTableAlias = content_views_tablename($field);
    if (isset($aData[$sTableAlias]['table']['join']['node_revisions'])) {
      $aData[$sTableAlias]['table']['join']['flexifield_items'] = $aData[$sTableAlias]['table']['join']['node_revisions'];
      $aData[$sTableAlias]['table']['join']['flexifield_items']['left_field'] = 'item_id';
    }
  }
}