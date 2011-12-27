<?php
// $Id: template.php,v 1.1.2.9 2010/07/09 14:53:42 himerus Exp $

/*
 * Add any conditional stylesheets you will need for this sub-theme.
 *
 * To add stylesheets that ALWAYS need to be included, you should add them to
 * your .info file instead. Only use this section if you are including
 * stylesheets based on certain conditions.  */
/* -- Delete this line if you want to use and modify this code
// Example: optionally add a fixed width CSS file.
if (theme_get_setting('ebog_fixed')) {
  drupal_add_css(path_to_theme() . '/layout-fixed.css', 'theme', 'all');
}
// */


/**
 * Implementation of HOOK_theme().
 */
function ebog_theme(&$existing, $type, $theme, $path) {
  $hooks = omega_theme($existing, $type, $theme, $path);
  // Add your theme hooks like this:
  /*
  $hooks['hook_name_here'] = array( // Details go here );
  */
  // @TODO: Needs detailed comments. Patches welcome!
  return $hooks;
}

/**
 * Override or insert variables into all templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered (name of the .tpl.php file.)
 */
//function ebog_preprocess(&$vars, $hook) {
  //fb($vars,$hook);
  //$vars['sample_variable'] = t('Lorem ipsum.');
//}
//function ebog_preprocess_views_view(&$vars) {
  //switch ($vars['name']) {
    //case 'anmeldelser':
      //fb($vars,'vars');
      //break;
    //default:
      //break;
  //}
//}

/**
 * Override or insert variables into the page templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("page" in this case.)
 */
function ebog_preprocess_page(&$vars, $hook) {
  global $user;

  array_pop($vars['primary_links']) ;
  if ($user->uid != 0) {
    $vars['primary_links']['account-link'] = array(
      'href'  => 'min_side',
      'title' => t('Min side'),
    );
  }
  else {
    $vars['primary_links']['login-link'] = array(
      'href'  => 'user',
      'title' => t('Login')
    );
  }

  $rendered_primary_links = theme('links', $vars['primary_links'], array('class' => 'menu'));
  $vars['navigation'] = '<div class="block block-menu" id="block-menu-primary-links"><div class="content">' . $rendered_primary_links . '</div></div>';

  if(arg(0) == 'min_side' && $user->uid == 0){
    drupal_goto('user',drupal_get_destination());
  }

  if(arg(3) == 'stream' || arg(3) == 'download' || $_GET['clean'] == 1 ){
    $vars['template_files'] = array('page-clean');
    $vars['css']['all']['theme']['sites/all/themes/ebog/css/style.css'] = false;
  }
}

/**
 * Override or insert variables into the node templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("node" in this case.)
 */
/* -- Delete this line if you want to use this function
function ebog_preprocess_node(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the comment templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("comment" in this case.)
 */
/* -- Delete this line if you want to use this function
function ebog_preprocess_comment(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the block templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
/* -- Delete this line if you want to use this function
function ebog_preprocess_block(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */


/**
 * Create a string of attributes form a provided array.
 *
 * @param $attributes
 * @return string
 */
function ebog_render_attributes($attributes) {
  return omega_render_attributes($attributes);
}
