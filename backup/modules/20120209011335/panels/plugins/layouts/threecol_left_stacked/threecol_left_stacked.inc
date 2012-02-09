<?php
// $Id$

/**
 * Implementation of hook_panels_layouts()
 */
function panels_threecol_left_stacked_panels_layouts() {
  $items = array();
  $items['threecol_left_stacked'] = array(
    'title' => t('Three column left stacked wide left'),
    'icon' => 'threecol_left_stacked.png',
    'theme' => 'panels_threecol_left_stacked',
    'css' => 'threecol_left_stacked.css',
    'panels' => array(
      'top' => t('Top'),
      'left' => t('Left side'),
      'middle' => t('Middle column'),
      'right' => t('Right side'),
      'bottom' => t('Bottom'),
    ),
  );
  return $items;
}

