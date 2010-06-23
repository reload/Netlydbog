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
  
  if(arg(3) == 'stream' || arg(3) == 'download' || $_GET['clean'] == 1 ){
  	$vars['template_files'] = array('page-clean');
  	$vars['css']['all']['theme']['sites/all/themes/netsound2/css/style.css'] = false;
  }
  //krumo($vars);
}
