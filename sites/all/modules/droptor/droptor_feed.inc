<?php

// $Id: droptor_feed.inc,v 1.1.2.17 2011/01/27 02:01:20 urbanjustin Exp $ 

/**
 * @file
 * The Droptor bridge module  
 * Droptor.com - Drupal site organization, monitoring, management and best practices
 * 
 * For more information, see:
 * - http://www.droptor.com
 * - http://drupal.org/project/droptor
 */

/**
 * Main feed wrapper routine, which calls all of the functions that gather data for returning to Droptor
 *
 * @param n/a
 *
 * @return
 *   A great big serialized set of data that Droptor improts
 */
function droptor_feed() {

  /* 
    We only show the feed if the hash key is passed in and if the request comes from droptor.com 
   (headers can be spoofed, so we use the hash keys too). It's not paranoia if they're really after you.
  */
  cache_clear_all('droptor', 'cache');
  
  // get hash, domain
  $correct_hash = droptor_check_hash();
  $correct_host = droptor_check_domain();
  $correct_security = droptor_check_connection_security();

  if ( $correct_hash && $correct_host && $correct_security ) {
    $data = array();
    $data['droptor-data-feed']['droptor_feed_version'] = '170';
    $data['droptor-data-feed']['monitor_text_match'] = variable_get('droptor_monitor_text_match', NULL);
    $data['droptor-data-feed']['ssl_login'] = droptor_ssl_login();
    $data['droptor-data-feed']['ssl_enabled'] = droptor_ssl_enabled();
    $data['droptor-data-feed']['settings_permissions_read_only'] = droptor_settings_permissions_read_only();
    $data['droptor-data-feed']['extra_files_removed'] = droptor_extra_files_removed();
    $data['droptor-data-feed']['node_statistics'] = droptor_node_statistics();
    $data['droptor-data-feed']['user_statistics'] = droptor_user_statistics();
    $data['droptor-data-feed']['statistics'] = droptor_statistics();
    $data['droptor-data-feed']['last_nodes'] = droptor_last_nodes();
    $data['droptor-data-feed']['last_users'] = droptor_last_users();
    $data['droptor-data-feed']['watchdog_size'] = droptor_watchdog_size();
    $data['droptor-data-feed']['site_name'] = variable_get('site_name', '{unknown}');
    $data['droptor-data-feed']['modules'] = droptor_modules();
    $data['droptor-data-feed']['variables_data'] = droptor_variables_data();
    $data['droptor-data-feed']['recent_pages_not_found'] = droptor_recent_pages_not_found();
    $data['droptor-data-feed']['last_logins'] = droptor_last_logins();
    $data['droptor-data-feed']['feed_over_ssl'] = variable_get('droptor_ssl_feed', 0);
    $data['droptor-data-feed']['memory_monitoring_status'] = droptor_memory_monitoring_status();
    $data['droptor-data-feed']['memory_monitoring_logs'] = droptor_memory_monitoring_logs();
    $data['droptor-data-feed']['user_1_name'] = droptor_user_1_name();
    $data['droptor-data-feed']['high_permission_count'] = droptor_high_permission_count();
    $data['droptor-data-feed']['module_update_data'] = droptor_module_update_data();
    
    if (variable_get('droptor_debug_mode', 0) == 1)
      $data['droptor-data-feed']['debug_remote_addr'] = $_SERVER['REMOTE_ADDR'];
  
    //droptor_pr($data);
    echo serialize($data);
  }
  elseif (!$correct_hash)
    echo t('Invalid hash');
  elseif (!$correct_host)
    echo t('Invalid host') . '(' . $_SERVER['REMOTE_ADDR'] . ')';
  elseif (!$correct_security)
    echo t('Invalid security');
  
  exit; // http://stackoverflow.com/questions/2102688/how-do-you-replace-the-page-tpl-php-that-loads-from-a-module-in-drupal
}

/**
 * Get the full module update status data for all modules
 * Deprecated in feed version 2
 *
 * @param n/a
 *
 * @return
 *   A serialized dump of the module update array data
 */
function droptor_module_update_data() {
  $module_meta_data = update_get_available(TRUE);
  return serialize(update_calculate_project_data($module_meta_data));
}

/**
 * The number of users who have admin user role.
 *
 * @param n/a
 *
 * @return
 *   A number
 */
function droptor_high_permission_count() {
   $count = null;
   $sql = 'SELECT COUNT(DISTINCT u.uid) as count FROM {users} u JOIN {users_roles} ur ON u.uid = ur.uid JOIN {permission} p ON ur.rid = p.rid WHERE u.status = 1 AND p.perm LIKE \'%administer permissions%\' OR p.perm LIKE \'%administer users%\'';
   $result = db_query($sql);
   while ($r = db_fetch_array($result)) {
      $count = $r['count'];      
      break;
   }
   
   return is_numeric($count) ? $count : null;
}

/**
 * The username of the Drupal super-duper user
 *
 * @param n/a
 *
 * @return
 *   The username field for user id = 1
 */
function droptor_user_1_name() {
   $return = null;
   $sql = 'SELECT name from {users} WHERE uid = 1 LIMIT 1';
   $result = db_query($sql);
   while ($r = db_fetch_array($result)) {
      $return = $r['name'];      
      break;
   }
   
   return $return;
}

/**
 * Memory monitoring has three states: on, off or not supported
 *
 * @param n/a
 *
 * @return
 *   The status of memory monitoring: 1, 0 or unsupported
 */
function droptor_memory_monitoring_status() {
	return !droptor_has_memory_management() ? 'unsupported' : variable_get('droptor_memory_monitoring',0);
}

/**
 * Pulls the memory usage logs from the database and cleans out the old ones
 *
 * @param n/a
 *
 * @return
 *   An array of memory log data or FALSE if turned off
 */
function droptor_memory_monitoring_logs() {
   $logs = false;
   if(variable_get('droptor_memory_monitoring',0) == 1) {
		$logs = array();
		// pull it out
		$query = 'SELECT q, dt, memory, execution_time FROM {droptor_memory} ORDER BY dt';
  		$results = db_query($query);
		while ($result = db_fetch_array($results)) {
		   $logs[] = array('q'=>$result['q'],'dt'=>$result['dt'],'memory'=>$result['memory'],'execution_time'=>$result['execution_time']);  			
		}
		// delete the data now that we have it
		$delete_query = 'DELETE FROM {droptor_memory}';
		db_query($delete_query);	
	}
	
	return $logs;
}

/**
 * Grabs the failed logins in the last hour
 *
 * @param n/a
 *
 * @return
 *   An array of who and when of failed logins
 */
function droptor_last_logins() {
  $query = 'SELECT message, variables, timestamp FROM {watchdog} WHERE message LIKE "login attempt failed%" AND now()-timestamp > 60*60 ORDER BY timestamp DESC';
  $results = db_query($query);
  $last_logins = array();
  
  while ($result = db_fetch_array($results)) {
    $variables = unserialize($result['variables']);
    $last_logins['failed'][$result['timestamp']] = $variables['%user'];
  }
  return $last_logins;
}

/**
 * Grabs all system variables
 *
 * @param n/a
 *
 * @return
 *   An array of all of the variables for the site
 */
function droptor_variables_data() {
  $variables = array();
  $results = db_query('SELECT name, value FROM {variable} ORDER BY name');
  
  while ($result = db_fetch_array($results)) {
    $variables[$result['name']] = unserialize($result['value']);
  }
  return serialize($variables);
}

/**
 * Grabs the last 404 errors in logs, excluding the checks we run for drupal files like README
 *
 * @param n/a
 *
 * @return
 *   An array of the pages not found and some associated data
 */
function droptor_recent_pages_not_found() {
  $data = array();
  $row = 0;
  
  $results = db_query_range('SELECT message, hostname, referer, timestamp FROM {watchdog} WHERE type = "page not found" AND message NOT IN("UPGRADE.txt", "MAINTAINERS.txt", "README.txt", "INSTALL.pgsql.txt", "INSTALL.txt", "LICENSE.txt", "INSTALL.mysql.txt", "COPYRIGHT.txt", "CHANGELOG.txt") ORDER BY timestamp DESC', 0, 10);
  
  while ($result = db_fetch_array($results)) {
    $data[$row]['message'] = $result['message'];
    $data[$row]['hostname'] = $result['hostname'];
    $data[$row]['referer'] = $result['referer'];
    $data[$row]['timestamp'] = $result['timestamp'];
    
    $row++;
  }
  
  return $data;
}

/**
 * Grabs all system variables
 *
 * @param n/a
 *
 * @return
 *   An array of all of the variables for the site
 */
function droptor_watchdog_size() {
  return db_result(db_query('SELECT COUNT(*) FROM {watchdog}'));
}

/**
 * Get total nodes created by day, for the last 30 days, for charting
 *
 * @param n/a
 *
 * @return
 *   An array of total nodes created each day for the last month
 */
function droptor_node_statistics() {
  $results = db_query_range("SELECT COUNT(*) AS total, DATE_FORMAT(FROM_UNIXTIME(created), '%m/%%d/%Y') AS dt FROM {node}  GROUP BY DATE_FORMAT(FROM_UNIXTIME(created), '%m/%%d/%Y') ORDER BY created DESC", 0, 30);
  $data = array();
  while ($result = db_fetch_array($results)) {
    $data[$result['dt']] = $result['total'];
  }
  
  return $data;
}

/**
 * Get total users created by day, for the last 30 days, for charting
 *
 * @param n/a
 *
 * @return
 *   An array of total users created each day for the last month
 */
function droptor_user_statistics() {
  $results = db_query_range("SELECT COUNT(*) AS total, DATE_FORMAT(FROM_UNIXTIME(created), '%m/%%d/%Y') AS dt FROM {users}  GROUP BY DATE_FORMAT(FROM_UNIXTIME(created), '%m/%%d/%Y') ORDER BY created DESC", 0, 30);
  $data = array();
  while ($result = db_fetch_array($results)) {
    $data[$result['dt']] = $result['total'];
  }
  
  return $data;
}

/**
 * Get lsat 15 nodes created
 *
 * @param n/a
 *
 * @return
 *   An array of the details of last 15 nodes created
 */
function droptor_last_nodes() {
  $last_five_nodes = array();
  $query = db_query_range('SELECT title, nid, created FROM {node} ORDER BY created DESC', 0, 15);

  $count = 0;
  while ($data = db_fetch_array($query)) {
    $last_five_nodes[$count]['url'] = drupal_get_path_alias('node/' . $data['nid']);
    $last_five_nodes[$count]['title'] = $data['title'];
    $last_five_nodes[$count]['created'] = $data['created'];
    $count++;
  }
  
  return $last_five_nodes;
  
}

/**
 * Get lsat 15 users created
 *
 * @param n/a
 *
 * @return
 *   An array of the details of last 15 users created
 */
function droptor_last_users() {
  $last_five_users = array();
  $query = db_query_range('SELECT uid, mail, name, created FROM {users} ORDER BY created DESC', 0, 15);

  $count = 0;
  while ($data = db_fetch_array($query)) {
    $last_five_users[$count]['uid'] = $data['uid'];
    $last_five_users[$count]['name'] = $data['name'];
    $last_five_users[$count]['email'] = $data['mail'];
    $last_five_users[$count]['created'] = $data['created'];
    $count++;
  }
  
  return $last_five_users;
}

/**
 * Wrapper function to get node and user stats
 *
 * @param n/a
 *
 * @return
 *   An array of various node and user statistics
 */  
function droptor_statistics() {
  $stats = array();
  
  // node and user creations over the last month
  $stats = droptor_node_and_user_time_stats();
  $stats = array_merge($stats, droptor_node_and_user_totals());
  
  return $stats;
}

/**
 * A list of every module in the system
 *
 * @param n/a
 *
 * @return
 *   A serialized list of module details array
 */
function droptor_modules() {
  $query_result = db_query('SELECT name, status, info, type FROM {system} ORDER BY status DESC, name');
  $modules = array();
    
  while ($data = db_fetch_object($query_result)) {
    $info = unserialize($data->info);
    $modules[$data->name]['version'] = $info['version'];
    $modules[$data->name]['status'] = $data->status;
    $modules[$data->name]['name'] = $info['name'];
    $modules[$data->name]['project'] = $info['project'];
    $modules[$data->name]['type'] = $data->type;
  }

  return serialize($modules);
}

/**
 * Check to see if the unneeded release files with Drupal are removed
 *
 * @param n/a
 *
 * @return
 *   True if they are removed, false if they aren't
 */
function droptor_extra_files_removed() {
  $clean_codebase = TRUE;
  $url = url(NULL, array('absolute' => TRUE));
  $files_to_remove = array('CHANGELOG.txt', 'COPYRIGHT.txt', 'INSTALL.mysql.txt', 'INSTALL.pgsql.txt', 'INSTALL.txt', 'LICENSE.txt', 
    'MAINTAINERS.txt', 'README.txt', 'UPGRADE.txt');
  
  foreach ($files_to_remove as $file) {
    $path = $_SERVER{'DOCUMENT_ROOT'} . base_path() . $file;
    if (file_exists($path))
      $clean_codebase = FALSE;
  }
  
  return $clean_codebase ? 1 : 0;
}

/**
 * Determines if settings.php is read-only
 *
 * @param n/a
 *
 * @return
 *   TRUE if the settings file is read-only, and FALSE if it isn't.
 */
function droptor_settings_permissions_read_only() {
  $settings_permissions_read_only = TRUE;
  $writes = array('2', '3', '6', '7'); // http://en.wikipedia.org/wiki/File_system_permissions
  $settings_file = './'. conf_path(FALSE, TRUE) .'/settings.php';
  $permissions = drupal_substr(sprintf('%o', fileperms($settings_file)), -4);  
  
  foreach ($writes as $bit) {
    if (strpos($permissions, $bit)) {
      $settings_permissions_read_only = FALSE;      
      break;
    }
  }
  
  return $settings_permissions_read_only;
  
}

/**
 * Checks to see if SSL login is required
 *
 * @param n/a
 *
 * @return
 *   True if login is secure, false if not
 */
function droptor_ssl_login() {
  $login_safe = 0;
  $securepages_login_query = db_query('SELECT value FROM {variable}  WHERE name = "%s"', 'securepages_pages');
  while ($securepages_login_results = db_fetch_object($securepages_login_query)) {
    $pages = $securepages_login_results->value;
    if (strpos($pages, 'user*') > 0) // 'user/* ' is invalid! see http://www.droptor.com/support/#ssl-login
      $login_safe = 1; // to do - check the ignore pages field      
  }
  
  return $login_safe;
}

/**
 * Gathers various user and node stats for various time ranges
 * @todo - Total stats revamp in feed version 2
 *
 * @param n/a
 *
 * @return
 *   An array of data for various activity data over various recent time frames
 */
function droptor_node_and_user_time_stats() {
  $thirty_days_ago_in_seconds = time() -(30*24*60*60);
  $seven_days_ago_in_seconds = time() -(7*24*60*60);
  $twenty_four_hours_ago_in_seconds = time() -(24*60*60);

  $stats = array();
  $stats['nodes_in_the_last_30_days'] = 0;
  $stats['nodes_in_the_last_7_days'] = 0;
  $stats['nodes_in_the_last_24_hours'] = 0;
  $stats['users_in_the_last_30_days'] = 0;
  $stats['users_in_the_last_7_days'] = 0;
  $stats['users_in_the_last_24_hours'] = 0;
  
  $nodes_result = db_query('SELECT created FROM {node}  WHERE created > %d', $thirty_days_ago_in_seconds);

  while ($node = db_fetch_object($nodes_result)) {
    if ($node->created > $twenty_four_hours_ago_in_seconds)
      $stats['nodes_in_the_last_24_hours']++;
      
    if ($node->created > $seven_days_ago_in_seconds)
      $stats['nodes_in_the_last_7_days']++;
      
    if ($node->created > $thirty_days_ago_in_seconds)
      $stats['nodes_in_the_last_30_days']++;
  }
  
  $users_result = db_query('SELECT created FROM {users}  WHERE created > %d', $thirty_days_ago_in_seconds);

  while ($user = db_fetch_object($users_result)) {
    if ($user->created > $twenty_four_hours_ago_in_seconds)
      $stats['users_in_the_last_24_hours']++;
    
    if ($user->created > $seven_days_ago_in_seconds)
      $stats['users_in_the_last_7_days']++;
    
    if ($user->created > $thirty_days_ago_in_seconds)
      $stats['users_in_the_last_30_days']++;
  }
  
  return $stats;
}

/* INTERNALS */
/* INTERNALS */
/* INTERNALS */

/**
 * Quickly check if a URL exists
 * b/c drupal_http_request() is wicked slow compared to straight curl
 *
 * @param n/a
 *
 * @return
 *   True if the URL exists, false otherwise
 */
function droptor_fast_url_check($url) {
  $valid = FALSE;
  
  if (in_array('curl', get_loaded_extensions())) {
    $curl = curl_init();  
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_HEADER, FALSE);
    curl_exec($curl);
    $result = curl_getinfo($curl);
    curl_close($curl);
    $valid = $result['http_code'] == '200' ? TRUE : FALSE;
  } 
  else {
    $result = drupal_http_request($url);
    $valid = $result->code == 200 ? TRUE : FALSE;
  }  
  
  return $valid;
}

/**
 * Total number of nodes (and by type) and total user count
 *
 * @param n/a
 *
 * @return
 *   An array of user and node stats
 */
function droptor_node_and_user_totals() {
  $stats = array();
    
  // total users
  $total_users_query = db_query('SELECT COUNT(*) as total_users FROM {users}');
  $total_users_result = db_fetch_array($total_users_query);
  $stats = is_array($total_users_result) && count($total_users_result) == 1 ? array_merge($stats, $total_users_result) : $stats;

  // total nodes
  $total_nodes_query = db_query('SELECT COUNT(*) as total_nodes, nt.name as type FROM {node} n JOIN {node_type} nt ON n.type = nt.type GROUP BY type ORDER BY nt.name');
  $total_nodes = 0;
  $nodes_by_type = array();
  
  while ($node_type_data = db_fetch_array($total_nodes_query)) {
    $nodes_by_type[$node_type_data['type']] = $node_type_data['total_nodes'];
    $total_nodes += $node_type_data['total_nodes'];
  }
  
  $stats['total_nodes'] = $total_nodes;
  $stats['total_nodes_by_type'] = $nodes_by_type;
    
  return $stats;
}

