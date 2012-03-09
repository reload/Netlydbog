<?php
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

function fetchNewestComment($node = false, $count = 1) {
  $sql = db_query_range("
    SELECT
      c.*
    FROM
      {comments} AS c
    WHERE
      c.nid = %d
  ", $node->nid, 0, $count);
    $result = db_fetch_object($sql);
    
    return $result;
}

/**
 * Fetch all terms from specified vocabulary
 *
 * @param Object $node
 * @param Integer $vid
 * @return Arrau
 * @author Hasse R. Hansen
 **/
function showEntriesFromVocab($node, $vid) {
  $entries = array();
  $items = taxonomy_node_get_terms_by_vocabulary($node, $vid);
  foreach ($items as $value) {
    $entries[] = $value->name;
  }
  return $entries;
}

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
 * Override or insert variables into the comment templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("comment" in this case.)
 */
function ebog_preprocess_comment(&$variables) {
  $comment = $variables['comment'];
  $node = $variables['node'];
  
  $uA = elib_user_get_cred($comment->uid);
  
  $variables['author']    = $uA['user'];//theme('username', $comment);
  $variables['content']   = $comment->comment;
  $variables['date']      = format_date($comment->timestamp);
 // $variables['links']     = isset($variables['links']) ? theme('links', $variables['links']) : '';
  $variables['new']       = $comment->new ? t('new') : '';
  $variables['picture']   = theme_get_setting('toggle_comment_user_picture') ? theme('user_picture', $comment) : '';
  $variables['signature'] = $comment->signature;
  $variables['submitted'] = theme('comment_submitted', $comment);
  $variables['title']     = l($comment->subject, $_GET['q'], array('fragment' => "comment-$comment->cid"));
  $variables['template_files'][] = 'comment-'. $node->type;
  // set status to a string representation of comment->status.
  if (isset($comment->preview)) {
    $variables['status']  = 'comment-preview';
  }
  else {
    $variables['status']  = ($comment->status == COMMENT_NOT_PUBLISHED) ? 'comment-unpublished' : 'comment-published';
  }
}


/**
 * Create a string of attributes form a provided array.
 *
 * @param $attributes
 * @return string
 */
function ebog_render_attributes($attributes) {
  return omega_render_attributes($attributes);
}
