<?php
/**
 * @file
 *
 * Callback function to supply a list of content types.
 */
function ding_voxb_voxb_ctools_content_types() {
  return array(
    'single' => TRUE,
    'title' => t('VoxB user review'),
    'description' => t('Show VoxB user review'),
    'required context' => new ctools_context_optional(t('Ting object'), 'ting_object'),
    'category' => t('INLEAD'),
  );
}

/**
 * Output function for the 'voxb_rating' content type.
 */
function ding_voxb_voxb_content_type_render($subtype, $conf, $panel_args, $context) {
  $block = new stdClass();
  $object = isset($context->data) ? drupal_clone($context->data) : NULL;
  $block->content = theme('voxb', array('object' => $object));
  return $block;
}

/**
 * Return the pane titles.
 */
function ding_voxb_voxb_content_type_admin_title($subtype, $conf, $context) {
  return t('“@s”: VoxB user review', array('@s' => $context->identifier));
}

/**
 * Returns an edit form for the content type.
 *
 * We're not actually doing anything here, but we need to have this hook
 * for this content type to work.
 */
function ding_voxb_voxb_content_type_edit_form(&$form, &$form_state) {
  return $form;
}

?>
