<?php
// $Id: flexifield-cck-overides.inc $

/**
 * @file
 * This file contains functions that are almost exact clones of functions
 * provided by CCK. Flexifield calls on these functions instead of the ones
 * that would normally be called in a similar situation without flexifield.
 * 
 * The comment above each function indicates which CCK function it's 
 * based on. The following comments within the function indicate where the
 * function is different than the CCK original:
 * 
 *  //<flexifield+>   Indicates start of code that is not part of the CCK function
 *  //</flexifield+>  Indicates end of code that is not part of the CCK function
 *  //<flexifield->   Indicates start of code that is part of the CCK function, but that is commented out of this function
 *  //</flexifield->  Indicates end of code that is part of the CCK function, but that is commented out of this function
 * 
 * These functions were cloned from CCK version 6.x-2.3. As new releases of CCK
 * become available, we should check to see if the below functions need updating
 * as a result.
 * 
 * My long term goal is to submit these patches (or appropriate patch alternatives)
 * to the CCK project so that I do not have to maintain redundant code.
 */

/**
 * Near clone of content.module's theme_content_multiple_values().
 * Our version allows tabledrag to not be enabled. We do this,
 * because nested tabledrag (for example, a multi-valued field
 * inside a multi-valued flexifield) does not currently work in drupal.
 */
function theme_flexifield_multiple_values($element) {
  //<flexifield+>
  $bDisableTableDrag = FALSE;
  $bDisableTableDragChildren = FALSE;
  static $nDisableTableDragChildren = 0;
  //</flexifield+>
  
  $field_name = $element['#field_name'];
  $field = content_fields($field_name);
  
  //<flexifield+>
  // This function is called for both flexifield fields and child fields.
  // When called for flexifield fields, we want to get the widget settings
  // for whether to disable tabledrag behavior.
  if ($field['type'] === 'flexifield') {
    $field = content_fields($field_name, $element['#type_name']);
    $bDisableTableDrag = isset($field['widget']['disable_tabledrag']) ? $field['widget']['disable_tabledrag'] : FALSE;
    $bDisableTableDragChildren = isset($field['widget']['disable_tabledrag_children']) ? $field['widget']['disable_tabledrag_children'] : FALSE;
  }
  // This function is called recursively, so if a parent invocation had
  // specified to disable tabledrag on children, we need to disable tabledrag
  // on this invocation.
  if ($nDisableTableDragChildren > 0) {
    $bDisableTableDrag = TRUE;
  }
  // Allow child invocations to know they need to disable tabledrag.
  if ($bDisableTableDragChildren) {
    $nDisableTableDragChildren++;
  }
  //</flexifield+>
  
  $output = '';

  if ($field['multiple'] >= 1) {
    //<flexifield+>
    // For fields inside of flexifields, #field_name isn't unique
    // for configuring drag-and-drop. 
    $table_id = implode('_', $element['#array_parents']) .'_values';
    $order_class = implode('-', $element['#array_parents']) .'-delta-order';
    //</flexifield+>
    //<flexifield->
    //$table_id = $element['#field_name'] .'_values';
    //$order_class = $element['#field_name'] .'-delta-order';
    //</flexifield->
    $required = !empty($element['#required']) ? '<span class="form-required" title="'. t('This field is required.') .'">*</span>' : '';

    $header = array(
      array(
        'data' => t('!title: !required', array('!title' => $element['#title'], '!required' => $required)),
        'colspan' => 2
      ),
      t('Order'),
    );
    $rows = array();

    // Sort items according to '_weight' (needed when the form comes back after
    // preview or failed validation)
    $items = array();
    foreach (element_children($element) as $key) {
      if ($key !== $element['#field_name'] .'_add_more') {
        $items[] = &$element[$key];
      }
    }
    usort($items, '_content_sort_items_value_helper');

    // Add the items as table rows.
    foreach ($items as $key => $item) {
      $item['_weight']['#attributes']['class'] = $order_class;
      $delta_element = drupal_render($item['_weight']);
      $cells = array(
        array('data' => '', 'class' => 'content-multiple-drag'),
        drupal_render($item),
        array('data' => $delta_element, 'class' => 'delta-order'),
      );
      $rows[] = array(
        'data' => $cells,
        //<flexifield+>
        'class' => $bDisableTableDrag ? '' : 'draggable',
        //</flexifield+>
        //<flexifield->
        //'class' => 'draggable',
        //</flexifield->
      );
    }

    $output .= theme('table', $header, $rows, array('id' => $table_id, 'class' => 'content-multiple-table'));
    $output .= $element['#description'] ? '<div class="description">'. $element['#description'] .'</div>' : '';
    $output .= drupal_render($element[$element['#field_name'] .'_add_more']);

    //<flexifield+>
    if (!$bDisableTableDrag) {
      drupal_add_tabledrag($table_id, 'order', 'sibling', $order_class);
    }
    //</flexifield+>
    //<flexifield->
    //drupal_add_tabledrag($table_id, 'order', 'sibling', $order_class);
    //</flexifield->
  }
  else {
    foreach (element_children($element) as $key) {
      $output .= drupal_render($element[$key]);
    }
  }

  //<flexifield+>
  // Maintain the correct count of recursion depth.
  if ($bDisableTableDragChildren) {
    $nDisableTableDragChildren--;
  }
  //</flexifield+>
  return $output;
}

/**
 * Near clone of content.node_form.inc's content_add_more_js().
 * Our version ensures that javascript settings generated by 
 * rendering the new content gets included in the response.
 */
function flexifield_add_more_js($type_name_url, $field_name) {
  //<flexifield+>
  // Not sure if this is needed, but just in case, let's make sure
  // that the file that would be loaded if content_add_more_js() were 
  // running is loaded.
  module_load_include('inc', 'content', 'includes/content.node_form');
  //</flexifield+>
  
  $type = content_types($type_name_url);
  $field = content_fields($field_name, $type['type']);

  if (($field['multiple'] != 1) || empty($_POST['form_build_id'])) {
    // Invalid request.
    drupal_json(array('data' => ''));
    exit;
  }

  // Retrieve the cached form.
  $form_state = array('submitted' => FALSE);
  $form_build_id = $_POST['form_build_id'];
  $form = form_get_cache($form_build_id, $form_state);
  if (!$form) {
    // Invalid form_build_id.
    drupal_json(array('data' => ''));
    exit;
  }

  // We don't simply return a new empty widget to append to existing ones, because
  // - ahah.js won't simply let us add a new row to a table
  // - attaching the 'draggable' behavior won't be easy
  // So we resort to rebuilding the whole table of widgets including the existing ones,
  // which makes us jump through a few hoops.

  // The form that we get from the cache is unbuilt. We need to build it so that
  // _value callbacks can be executed and $form_state['values'] populated.
  // We only want to affect $form_state['values'], not the $form itself
  // (built forms aren't supposed to enter the cache) nor the rest of $form_data,
  // so we use copies of $form and $form_data.
  $form_copy = $form;
  $form_state_copy = $form_state;
  $form_copy['#post'] = array();
  form_builder($_POST['form_id'], $form_copy, $form_state_copy);
  // Just grab the data we need.
  $form_state['values'] = $form_state_copy['values'];
  // Reset cached ids, so that they don't affect the actual form we output.
  form_clean_id(NULL, TRUE);

  // Sort the $form_state['values'] we just built *and* the incoming $_POST data
  // according to d-n-d reordering.
  unset($form_state['values'][$field_name][$field['field_name'] .'_add_more']);
  foreach ($_POST[$field_name] as $delta => $item) {
    $form_state['values'][$field_name][$delta]['_weight'] = $item['_weight'];
  }
  $form_state['values'][$field_name] = _content_sort_items($field, $form_state['values'][$field_name]);
  $_POST[$field_name] = _content_sort_items($field, $_POST[$field_name]);

  // Build our new form element for the whole field, asking for one more element.
  $form_state['item_count'] = array($field_name => count($_POST[$field_name]) + 1);
  $form_element = content_field_form($form, $form_state, $field);
  // Let other modules alter it.
  drupal_alter('form', $form_element, array(), 'content_add_more_js');

  // Add the new element at the right place in the (original, unbuilt) form.
  if (module_exists('fieldgroup') && ($group_name = _fieldgroup_field_get_group($type['type'], $field_name))) {
    $form[$group_name][$field_name] = $form_element[$field_name];
  }
  else {
    $form[$field_name] = $form_element[$field_name];
  }

  // Save the new definition of the form.
  $form_state['values'] = array();
  form_set_cache($form_build_id, $form, $form_state);

  // Build the new form against the incoming $_POST values so that we can
  // render the new element.
  $delta = max(array_keys($_POST[$field_name])) + 1;
  $_POST[$field_name][$delta]['_weight'] = $delta;
  $form_state = array('submitted' => FALSE);
  $form += array(
    '#post' => $_POST,
    '#programmed' => FALSE,
  );
  $form = form_builder($_POST['form_id'], $form, $form_state);

  // Render the new output.
  $field_form = (!empty($group_name)) ? $form[$group_name][$field_name] : $form[$field_name];
  // We add a div around the new content to receive the ahah effect.
  $field_form[$delta]['#prefix'] = '<div class="ahah-new-content">'. (isset($field_form[$delta]['#prefix']) ? $field_form[$delta]['#prefix'] : '');
  $field_form[$delta]['#suffix'] = (isset($field_form[$delta]['#suffix']) ? $field_form[$delta]['#suffix'] : '') .'</div>';
  // Prevent duplicate wrapper.
  unset($field_form['#prefix'], $field_form['#suffix']);

  // If a newly inserted widget contains AHAH behaviors, they normally won't
  // work because AHAH doesn't know about those - it just attaches to the exact
  // form elements that were initially specified in the Drupal.settings object.
  // The new ones didn't exist then, so we need to update Drupal.settings
  // by ourselves in order to let AHAH know about those new form elements.
  
  //<flexifield+>
  // One, we want to reverse the order of the key operations below 
  // from 1. figure out the jvascript settings, 2. get the status messages, 3. render the element
  // to 1. render the element, 2. get the status messages, 3. figure out the jvascript settings
  //
  // Two, since flexifield already depends on the ahah_response module for doing this
  // in other AHAH callbacks, we might as well use it.
  print theme('ahah_response', drupal_render($field_form));
  //</flexifield+>
  //<flexifield->
  //$javascript = drupal_add_js(NULL, NULL);
  //$output_js = isset($javascript['setting']) ? '<script type="text/javascript">jQuery.extend(Drupal.settings, '. drupal_to_js(call_user_func_array('array_merge_recursive', $javascript['setting'])) .');</script>' : '';

  //$output = theme('status_messages') . drupal_render($field_form) . $output_js;
  //// Using drupal_json() breaks filefield's file upload, because the jQuery
  //// Form plugin handles file uploads in a way that is not compatible with
  //// 'text/javascript' response type.
  //$GLOBALS['devel_shutdown'] =  FALSE;
  //print drupal_to_js(array('status' => TRUE, 'data' => $output));
  //</flexifield->
  exit;
}

