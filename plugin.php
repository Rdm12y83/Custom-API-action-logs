<?php
/*
Plugin Name: Custom API action (logs)
Plugin URI: http://yourls.org
Description: Define custom API action 'logs' and Logs Page
Version: 0.1
Author: rdm12y83
Author URI: github.com/rdm12y83
*/


// API FUNCTION
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

// Create link for page on Admin page
yourls_add_action ('plugins_loaded', 'logs');
function logs() {
	yourls_register_plugin_page('logs', 'Logs page', 'logs_display_page');
}

//draw the plugin page LOGS
function logs_display_page(){
	echo "<pre><h2>Logs page</h2><pre>";
	$table = YOURLS_DB_TABLE_LOG;
	$where = array('sql' => '', 'binds' => array());
	$results = yourls_get_db()->fetchObjects( 
	    "SELECT * FROM `$table` WHERE 1=1 ${where['sql']};", $where['binds'] );
		
	foreach ($results as $result) {
		
		$shorturl = $result->shorturl;
		$clickid = $result->click_id;
		$clicktime = $result->click_time;
		$ip = $result->ip_address;
		$useragent = $result->user_agent;
		$countrycode = $result -> country_code;
		$referrer = $result -> referrer;
		
		echo '<h5>Shorturl</h5>'; print_r($shorturl); 
		echo '<h5>Click id</h5>'; print_r($clickid); 
		echo '<h5>Click time</h5>'; print_r($clicktime); 
		echo '<h5>IP</h5>'; print_r($ip);
		echo '<h5>User agent</h5>'; print_r($useragent); 
		echo '<h5>Country code</h5>'; print_r($countrycode); 
		echo '<h5>Referrer</h5>'; print_r($referrer); 
		echo '<pre>_______________________________________';
		
	    }

}
