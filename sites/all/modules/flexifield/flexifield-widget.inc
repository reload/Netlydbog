<?php
// $Id: flexifield-widget.inc $

/**
 * @file
 * Functions needed when editing a node with a flexifield. This file is not loaded
 * if the user is on a page other than editing a flexifield.
 */

/**
 * Process the fieldset that contains the child fields. 
 */
function flexifield_fieldset_process($aElement, $aSubmittedElementData, $aFormState, $aForm) {
  // Ensure we have a valid content type with valid type information
  $sContentType = $aElement['#flexifield_item_type'];
  if (!$sContentType) {return $aElement;}
  $aContentTypeInfo = content_types($sContentType);
  if (!$aContentTypeInfo) {return $aElement;}
  
  // For each field in that content type, add its widget form as a child of this element
  if (!isset($aForm['#node'])) {
    $aForm['#node'] = new stdClass();
  }
  module_load_include('inc', 'content', 'includes/content.node_form');
  foreach ($aContentTypeInfo['fields'] as $sChildFieldName => $aChildFieldSettings) {
    // Note: we take $aFormState by value, so this sets what is needed by content_field_form,
    // but doesn't alter the global form state.
    if (isset($aElement['#value'][$sChildFieldName])) {
      $aFormState['values'][$sChildFieldName] = $aElement['#value'][$sChildFieldName];
    }
    $aElement += (array) content_field_form($aForm, $aFormState, $aChildFieldSettings);
    drupal_alter('flexifield_child_field_form', $aElement[$sChildFieldName], $aForm, $aFormState, $aChildFieldSettings);
    if (isset($aElement[$sChildFieldName]['#theme']) && ($aElement[$sChildFieldName]['#theme'] === 'content_multiple_values')) {
      _flexifield_alter_multiple_values_form($aElement[$sChildFieldName], $aForm, $aFormState, $aChildFieldSettings);
    }
  }
  drupal_alter('flexifield_child_fields_form', $aElement, $aForm, $aFormState);
  
  // Hack for having $aForm['#field_info'] be what it needs to be inside each of
  // the widgets' #process functions.
  _flexifield_setup_form_field_info_hack($aElement, $aContentTypeInfo['fields']);
  
  return $aElement;
}

/**
 * Setup the result of content_multiple_values_form() for both the 
 * flexifield field and child fields to have some extra stuff happen
 * during form building (#process).
 */
function _flexifield_alter_multiple_values_form(&$aElement, &$aForm, &$aFormState, $aField, $aItems = array()) {
  $aElement['#process'] = array_merge(array('_flexifield_alter_multiple_values_form_process'), flexifield_get_element_property($aElement, '#process', array()));
  $aElement['#field_name'] = $aField['field_name'];
  
  // For the #process function to work, we need to set #input,
  // but doing so affects #value, and we want to be able to
  // clean that up.
  if (!flexifield_get_element_property($aElement, '#input', FALSE)) {
    $aElement['#input'] = TRUE;
    $aElement['#flexifield_forced_input'] = TRUE;
    $aElement['#flexifield_input_original'] = $aElement['#input'];
    $aElement['#flexifield_value_original'] = isset($aElement['#value']) ? $aElement['#value'] : null;
    if (!isset($aElement['#type'])) {
      $aElement['#type'] = 'markup';
    }
  }
}

/**
 * Adjust the result of content_multiple_values_form() for both the 
 * flexifield field and child fields. The problem is that 
 * content_multiple_values_form() sets tabledrag and AHAH up with
 * assumptions that aren't true when nesting fields within flexifield.
 */
function _flexifield_alter_multiple_values_form_process($aElement) {
  // Solve tabledrag issues by using our version of the theme hook.
  $aElement['#theme'] = 'flexifield_multiple_values';
    
  // Clean up what was done by forcing #input in order to have this function run.
  if ($aElement['#flexifield_forced_input']) {
    $aElement['#input'] = $aElement['#flexifield_input_original'];
    $aElement['#value'] = $aElement['#flexifield_value_original'];
  }
  
  // Solve AHAH.
  $sId = $aElement['#id'];
  $sKeyAddMore = $aElement['#field_name'] . '_add_more';
  if (isset($aElement[$sKeyAddMore])) {
    $aElement['#prefix'] = '<div id="'. $sId .'-items">';
    $aElement[$sKeyAddMore]['#ahah']['wrapper'] = $sId . '-items';
    $aPathParts = explode('/', $aElement[$sKeyAddMore]['#ahah']['path']);
    $aElement[$sKeyAddMore]['#ahah']['path'] = implode('/', array_merge(array('flexifield/ahah/addmore'), array_slice($aPathParts, 2, 2), array(implode(':', $aElement['#array_parents']), implode(':', $aElement['#parents']))));
  }
  return $aElement;
}

/**
 * Hack to deal with CCK widget elements using the top level form's #field_info
 * property for accessing their field information. 
 *
 * Using the top level form's #field_info property assumes there's only
 * one field of a given field name for the entire form, and this isn't 
 * necessarily true for fields inside of flexifield. So, what we do
 * here is place the #field_info information on the element, and insert
 * a #process function to copy this information to the top-level form
 * before the element's normal #process function that will need this 
 * info. We also add a final #process function to restore the top-level
 * form's #field_info to its original.
 *
 * We need to run this recursively for all descendant elements, because
 * depending on widget, we don't know which element is the one that will
 * need this information.
 */
function _flexifield_setup_form_field_info_hack(&$aElement, &$aFieldsInfo) {
  foreach (element_children($aElement) as $sKey) {
    if (
      isset($aElement[$sKey]['#field_name']) && 
      isset($aFieldsInfo[$aElement[$sKey]['#field_name']]) && 
      !isset($aElement[$sKey]['#flexifield_storage']['#field_info'])
    ) {
      $aProcess = flexifield_get_element_property($aElement[$sKey], '#process');
      if (isset($aProcess)) {
        $aElement[$sKey]['#process'] = array_merge(array('_flexifield_set_form_field_info'), $aProcess, array('_flexifield_setup_form_field_info_hack_recurse', '_flexifield_restore_form_field_info'));
        $aElement[$sKey]['#flexifield_storage']['#field_info'] = $aFieldsInfo[$aElement[$sKey]['#field_name']];
      }
    }
    _flexifield_setup_form_field_info_hack($aElement[$sKey], $aFieldsInfo);
  }
}

/**
 * Process function that runs before the element's "real" process function.
 * It sets up the top-level form's #field_info property.
 */
function _flexifield_set_form_field_info($aElement, $aSubmittedElementData, $aFormState, &$aForm) {
  if (isset($aElement['#field_name'])) {
    $aElement['#flexifield_storage']['#field_info_backup'] = isset($aForm['#field_info'][$aElement['#field_name']]) ? $aForm['#field_info'][$aElement['#field_name']] : null;
    $aForm['#field_info'][$aElement['#field_name']] = $aElement['#flexifield_storage']['#field_info'];
  }
  return $aElement;
}

/**
 * Process function that runs after the element's "real" process function.
 * In the event that the element's real process function added child elements,
 * we need to make sure the _flexifield_setup_form_field_info_hack() function can
 * apply to them as well.
 */
function _flexifield_setup_form_field_info_hack_recurse($aElement, $aSubmittedElementData, $aFormState, &$aForm) {
  if (isset($aElement['#field_name']) && isset($aElement['#flexifield_storage']['#field_info'])) {
    $aFieldsInfo = array($aElement['#field_name'] => $aElement['#flexifield_storage']['#field_info']);
    _flexifield_setup_form_field_info_hack($aElement, $aFieldsInfo);
  }
  return $aElement;
}

/**
 * Process function that runs after the element's "real" process function.
 * It restores the top-level form's #field_info property.
 *
 * Technically, we don't need to do this, because form.inc's 
 * _form_builder_handle_input_element() function takes $aForm by value instead
 * of by reference, so any changes made to it are temporary anyway. However, 
 * this might change in the future, so let's explicitly clean up after ourselves.
 */
function _flexifield_restore_form_field_info($aElement, $aSubmittedElementData, $aFormState, &$aForm) {
  if (isset($aElement['#field_name'])) {
    $aForm['#field_info'][$aElement['#field_name']] = $aElement['#flexifield_storage']['#field_info_backup'];
    unset($aElement['#flexifield_storage']['#field_info_backup']);
  }
  return $aElement;
}

/**
 * FAPI theme for a widget element for an individual field item.
 */
function theme_flexifield_default_widget($aElement) {
  // The widget element is just a wrapper.
  return theme('form_element', $aElement, $aElement['#children']);
}

/**
 * FAPI theme for the fieldset that contains the child fields.
 */
function theme_flexifield_fieldset($aElement) {
  // Avoid triggering a PHP Notice if #children has not been set, which can be the case
  // for the NULL flexifield item type used for heterogeneous flexifields.
  if (!isset($aElement['#children'])) {
    $aElement['#children'] = NULL;
  }
  
  // We setup the ahah code on the item type selector to target the element id
  // that is created by theme('form_element'). Therefore, we do not want to
  // create this element when re-rendering from the ahah callback.
  if (isset($aElement['#flexifield_from_ahah']) && $aElement['#flexifield_from_ahah']) {
    $sOutput = $aElement['#children'];
  }
  else {
    $sOutput = theme('form_element', $aElement, $aElement['#children']);
  }
  return $sOutput;
}

/**
 * Menu callback for AHAH replacement of flexifield item type.
 */
function flexifield_ahah_changetype($sElementParents = NULL) {
  // Retrieve the cached form.
  $aFormState = array('submitted' => FALSE);
  $sFormBuildId = $_POST['form_build_id'];
  $aForm = form_get_cache($sFormBuildId, $aFormState);
  if (!$aForm) {
    // Invalid form_build_id.
    drupal_json(array('data' => ''));
    exit;
  }
  
  // Build the form, so that we can render the element we want.
  // It seems like overkill to build the entire form, when we just
  // want one field item from it. Perhaps this can be optimized.
  $aFormCopy = $aForm;
  $aFormCopy['#post'] = $_POST;
  $aBuiltForm = form_builder($_POST['form_id'], $aFormCopy, $aFormState);
  
  // Get just the element that needs re-rendering.
  $aElement = $aBuiltForm;
  foreach (explode(':', $sElementParents) as $sParent) {
    $aElement = $aElement[$sParent];
  }
  $aElement = $aElement['value'];
  
  // Return the rendered element as an ahah response
  $aElement['#flexifield_from_ahah'] = TRUE;
  print theme('ahah_response', drupal_render($aElement));
  exit;
}

/**
 * Menu callback for adding another item to a multi-valued field.
 * Used for both flexifields and fields within flexifield.
 */
function flexifield_ahah_addmore($sTypeNameUrl, $sFieldName, $sParents, $sDataParents) {  
  $aParents = explode(':', $sParents);
  while (array_pop($aParents) != $sFieldName) {}
  $aDataParents = explode(':', $sDataParents);
  while (array_pop($aDataParents) != $sFieldName) {}
  
  // If this is the root flexifield, then use content.module's way of
  // adding another item (with a small modification).
  if (!count($aParents)) {
    module_load_include('inc', 'flexifield', 'flexifield-cck-overrides');
    return flexifield_add_more_js($sTypeNameUrl, $sFieldName);
  }
  
  // Retrieve the cached form.
  $aFormState = array('submitted' => FALSE);
  $sFormBuildId = $_POST['form_build_id'];
  $aForm = form_get_cache($sFormBuildId, $aFormState);
  if (!$aForm) {
    // Invalid form_build_id.
    drupal_json(array('data' => ''));
    exit;
  }
  
  // Build the form, so that we can render the element we want.
  // It seems like overkill to build the entire form, when we just
  // want one field item from it. Perhaps this can be optimized.
  $aFormCopy = $aForm;
  $aFormCopy['#post'] = $_POST;
  $aFormPostReference =& $aFormCopy['#post'];
  foreach ($aDataParents as $sParent) {
    $aFormPostReference =& $aFormPostReference[$sParent];
  }
  $aFormPostReference[$sFieldName][] = array();
  $aBuiltForm = form_builder($_POST['form_id'], $aFormCopy, $aFormState);
  
  // Get just the element that needs re-rendering.
  $aElement = $aBuiltForm;
  foreach ($aParents as $sParent) {
    $aElement = $aElement[$sParent];
  }
  $aElement = $aElement[$sFieldName];
  
  // Return the rendered element as an ahah response
  $sRenderedElement = drupal_render($aElement);
  print theme('ahah_response', $sRenderedElement);
  exit;
}

