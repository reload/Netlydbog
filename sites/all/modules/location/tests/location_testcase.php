<?php
// $Id: location_testcase.php,v 1.2 2008/11/20 17:42:32 bdragon Exp $

/**
 * @file
 * Common functions for Location tests.
 */

class LocationTestCase extends DrupalWebTestCase {

  /**
   * Flatten a post settings array because drupalPost isn't smart enough to.
   */
  function flattenPostData(&$edit) {
    do {
      $edit_flattened = TRUE;
      foreach ($edit as $k => $v) {
        if (is_array($v)) {
          $edit_flattened = FALSE;
          foreach ($v as $kk => $vv) {
            $edit["{$k}[{$kk}]"] = $vv;
          }
          unset($edit[$k]);
        }
      }
    } while (!$edit_flattened);
  }

  function addLocationContentType(&$settings, $add = array()) {
    // find a non-existent random type name.
    do {
      $name = strtolower($this->randomName(3, 'type_'));
    } while (node_get_types('type', $name));

    // Get the (settable) defaults.
    $defaults = array();
    $d = location_invoke_locationapi($location, 'defaults');
    $fields = location_field_names();
    foreach ($fields as $k => $v) {
      $defaults[$k] = $d[$k];
    }

    foreach ($defaults as $k => $v) {
      // Change collection to allow.
      $defaults[$k]['collect'] = 1;
    }

    $settings = array(
      'name' => $name,
      'type' => $name,
      'location_settings' => array(
        'multiple' => array(
          'max' => 1,
        ),
        'form' => array(
          'fields' => $defaults,
        ),
      ),
    );

    //$settings['location_settings'] = array_merge_recursive($settings['location_settings'], $add);
    $this->flattenPostData($settings);
    $add = array('location_settings' => $add);
    $this->flattenPostData($add);
    $settings = array_merge($settings, $add);
    $this->drupalPost('admin/content/types/add', $settings, 'Save content type');
    $this->refreshVariables();
    $settings = variable_get('location_settings_node_'. $name, array());
    return $name;
  }

  /**
   * Delete a node.
   */
  function deleteNode($nid) {
    // Implemention taken from node_delete, with some assumptions regarding
    // function_exists removed.

    $node = node_load($nid);
    db_query('DELETE FROM {node} WHERE nid = %d', $node->nid);
    db_query('DELETE FROM {node_revisions} WHERE nid = %d', $node->nid);

    // Call the node-specific callback (if any):
    node_invoke($node, 'delete');
    node_invoke_nodeapi($node, 'delete');

    // Clear the page and block caches.
    cache_clear_all();
  }

  /**
   * Order locations in a node by LID for testing repeatability purposes.
   */
  function reorderLocations(&$node) {
    $locations = array();
    foreach ($node->locations as $location) {
      $locations[$location['lid']] = $location;
    }
    ksort($locations);
    $node->locations = array();
    foreach ($locations as $location) {
      $node->locations[] = $location;
    }
  }

}
