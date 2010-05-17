<?php

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
