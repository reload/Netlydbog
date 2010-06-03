<?php
// $Id: flexifield-test.inc $

/**
 * @file
 * Some functions that are part of the page flexifield/test. Only used during
 * development for quick experimentation.
 */

/**
 * Test Page Callback
 */
function flexifield_test() {
  $sRow1 = flexifield_test_tabledrag('testdrag1', 'testdrag1-order', array('row 1a', 'row 1b', 'row 1c'));
  $sRow2 = flexifield_test_tabledrag('testdrag2', 'testdrag2-order', array('row 2a', 'row 2b', 'row 2c'));
  $sOutput = flexifield_test_tabledrag('testdrag', 'testdrag-order', array($sRow1, $sRow2));
  return $sOutput;
}

/**
 * Test Form Builder
 */
function flexifield_test_form() {
}

/**
 * Test Draggable Table Builder
 */
function flexifield_test_tabledrag($sTableId, $sOrderClass, $aRowContent) {
  foreach ($aRowContent as $i => $sRowContent) {
    $aDeltaElement = array(
      '#attributes' => array('class' => $sOrderClass),
      '#type' => 'select',
      '#options' => range(0, 10),
      '#default_value' => $i,
    );
    $sDeltaElement = drupal_render($aDeltaElement);
    $aCells = array(
      array('data' => ''),
      $sRowContent,
      array('data' => $sDeltaElement),
    );
    $aRows[] = array(
      'data' => $aCells,
      'class' => 'draggable',
    );
  }
  $sOutput .= theme('table', array('col1', 'col2', 'col3'), $aRows, array('id' => $sTableId));
  drupal_add_tabledrag($sTableId, 'order', 'sibling', $sOrderClass);  
  return $sOutput;
}