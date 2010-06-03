<?php

// $Id: term_node_count.views.inc,v 1.2 2009/02/03 00:23:38 archard Exp $

/**
 * Implementation of hook_views_data().
 */
function term_node_count_views_data() {
	$data = array();
	
	$data['term_node_count']['table']['group'] = t('Taxonomy');
	$data['term_node_count']['table']['join']['term_data'] = array(
		'left_field' => 'tid',
		'field' => 'tid'
	);
	$data['term_node_count']['node_count'] = array(
		'field' => array(
			'handler' => 'term_node_count_handler_field'
		),
		'filter' => array(
			'handler' => 'views_handler_filter_numeric'
		),
		'sort' => array(
			'handler' => 'views_handler_sort'
		)
	);
	$data['term_node_count']['node_count']['title'] = t('Term Node Count');
	$data['term_node_count']['node_count']['help'] = t('The number of nodes associated with this term');
	return $data;
}

/**
 * Implementation of hook_views_handlers().
 */
function term_node_count_views_handlers() {
	return array(
		'handlers' => array(
			'term_node_count_handler_field' => array(
				'parent' => 'views_handler_field_numeric'
			)
		)
	);
}