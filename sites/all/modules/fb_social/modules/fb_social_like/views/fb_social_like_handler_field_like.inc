<?php


/**
 * @file
 * Views handler fb like widget.
 *
 * This is a fake field that does not query anything. 
 */

/**
 * Field handler to provie the fb widget
 * Inherit from views_handler_field_node so we get the nid for free
 * @ingroup views_field_handlers
 */
class fb_social_like_handler_field_like extends views_handler_field_node {

  /**
   * query() override to not query this fake field.
   */
  function query(){
    $this->ensure_my_table();
  }

  /**
   * options definitions and their default values
   */
  function option_definition(){
    $options = parent::option_definition();
    
    $options['fb_social_like_layout_style'] = array('default' => 'button_count' );
    $options['fb_social_like_show_faces'] = array('default' => FALSE );
    $options['fb_social_like_width'] = array('default' => '350' );
    $options['fb_social_like_verb'] = array('default' => 'like' );
    $options['fb_social_like_font'] = array('default' => 'verdana');
    $options['fb_social_like_color'] = array('default' => 'dark');
    
    return $options;
  }

  /**
   * the fb like options form
   */
  function options_form(&$form, &$form_state){
    parent::options_form($form, $form_state);
    
    module_load_include('inc', 'fb_social_like', 'fb_social_like.admin');
    $widget_options = fb_social_like_widget_settings_form();
    foreach ( $widget_options as $key => $value ) {
      $form[$key] = $value;
      $form[$key]['#default_value'] = $this->options[$key];
    }
    
    // Remove irrelevant controls / settings.
    unset($form['empty']);
    unset($form['empty_zero']);
    unset($form['hide_empty']);
    unset($form['link_to_node']);
    unset($form['alter']);
  }

  /**
   * Render the fb like field
   */
  function render($values){
    global $_fb_script_init;
    $_fb_script_init = TRUE;
    $attrs = array(
        'href' => fb_social_url('node/'.$values->nid), 
        'layout' => $this->options['fb_social_like_layout_style'], 
        'show_faces' => $this->options['fb_social_like_show_faces'] ? 'true' : 'false', 
        'width' => $this->options['fb_social_like_width'], 
        'action' => $this->options['fb_social_like_verb'], 
        'font' => $this->options['fb_social_like_font'], 
        'colorscheme' => $this->options['fb_social_like_color'] 
    );
    
    $attrs = drupal_attributes($attrs);
    
    return '<fb:like ' . $attrs . '></fb:like>';
  
  }
}


