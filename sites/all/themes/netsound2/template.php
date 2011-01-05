<?php

function netsound2_theme() {
  return array(
    'ting_topfeature' => array(
      'arguments' => array('collection' => NULL),
      'template' => 'ting_top_feature_object'
    ),
  );
}

function netsound2_ting_reference_formatter_default($element) {
	 $collection = _ting_reference_get_collection($element['#item']['ting_ref_type'], $element['#item']['ting_object_id'], $element['#item']['description']);
  if (!$collection) {
    return t('Object not found.');
  }

  if($element['#node']->type == 'collection'){
    return theme('ting_topfeature', $collection);
  }
  return theme('ting_search_collection', $collection);
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





function netsound2_preprocess_page(&$vars, $hook) {
	global $user;
	
	if(arg(0) == 'min_side' && $user->uid == 0){
	 drupal_goto('user/login',drupal_get_destination());
	}
	
  
  if(arg(3) == 'stream' || arg(3) == 'download' || $_GET['clean'] == 1 ){
  	$vars['template_files'] = array('page-clean');
  	$vars['css']['all']['theme']['sites/all/themes/netsound2/css/style.css'] = false;
  }
  //krumo($vars);
}


function netsound2_preprocess_comment(&$variables) {
	
	//krumo($variables);
	
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
function netsound2_fivestar_static_element($value, $title = NULL, $description = NULL) {
  $output = '';
  $output .= '<div class="fivestar-static-form-item">';
  $element = array(
    '#type' => 'item',
    '#title' => $title,
    //'#description' => $description,
  );

  $output .= theme('form_element', $element, $value);
  $output .= '</div>';
  return $output;
}

/**
 * added book teaser to object
 *
 * @param TingClientObject $object
 * @return string
 */
function elib_book_teaser(TingClientObject $object) {
  module_load_include('isbn_static_func.inc', 'elib');
  $isbn = convertFromIsbn13ToIsbn10($object->record['dc:identifier']['dkdcplus:ISBN'][0]);

  $c = elib_client();
  $c->setLibrary(variable_get('elib_retailer_id', ''));
  try {
    $book = $c->getBook((int) $isbn);
  }
  catch (Exception $e) {
    error_log(__FILE__ . ' +' . __LINE__ . ' ' . print_r($e, 1));
    return;
  }

  if (!empty($book->data->product->teaser->link)) {
    drupal_add_js('sites/all/themes/netsound2/js/audio-player/audio-player.js');
    drupal_add_js('
      AudioPlayer.setup("' . url(drupal_get_path('theme', 'netsound2') . '/js/audio-player/player.swf', array('absolute' => TRUE)) .'", {
        width: 290,
        leftbg: "7DAFC3",
        rightbg: "BECE8C",
        leftbghover: "ADCBD7",
        rightbghover: "C4D296",
        loader: "C4D296",
        transparentpagebg: "yes"
      });
    ', 'inline');

    return '
      <h4>Hør smagsprøve</h4>
      <div id="audio-player">Da din browser ikke understøtter flash kan vi ikke afspille smagsprøven for dig, men du kan downloade det ' .l('her', $book->data->product->teaser->link) . ' og selv afspille det på din computer.</div>
      <script type="text/javascript">
        AudioPlayer.embed("audio-player", {
          soundFile: "' . $book->data->product->teaser->link . '",
          titles: "' . $book->data->product->title . '",
          artists: "' . $book->data->product->contributors->contributor[0]->first_name . ' ' . $book->data->product->contributors->contributor[0]->family_name . '"
        });
      </script>
    ';
  }
}
