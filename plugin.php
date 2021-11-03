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

// Actually logs
function my_logs_function() {

	$table = YOURLS_DB_TABLE_LOG;
	return array(
		'statusCode' => 200,
		'message'    => 'success',
		'result' => yourls_get_db()->fetchAll("SELECT * FROM `$table`"),
	);
}

yourls_add_action ('plugins_loaded', 'logs');
function logs() {
	yourls_register_plugin_page('logs', 'Logs page', 'logs_display_page');
}

//draw the admin page
function logs_display_page(){
	echo "<html><h1>Logs page</></html>";
}
