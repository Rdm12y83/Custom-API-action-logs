<?php
/*
Plugin Name: Custom API action (logs)
Plugin URI: http://yourls.org
Description: Define custom API action 'logs'
Version: 0.1
Author: rdm12y83
Author URI: github.com/rdm12y83
*/

// Define custom action "logs"
yourls_add_filter( 'api_action_logs', 'my_logs_function' );

// Actually list
function my_logs_function() {

	$table = YOURLS_DB_TABLE_LOG;
	return array(
		'statusCode' => 200,
		'message'    => 'success',
		'result' => yourls_get_db()->fetchAll("SELECT * FROM `$table`"),
	);
}
