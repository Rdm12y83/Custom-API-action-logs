<?php
/*
Plugin Name: Logs
Plugin URI: http://yourls.org
Description: Define custom API action 'logs' and custom logs page
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
	
		//table head
	echo" <table><tr><th>Shorturl</th><th>Click time</th><th>Click \n id</th><th>IP</th><th>Country \n code</th><th>User Agent</th>";
	foreach ($results as $result) {
		
		$shorturl = $result->shorturl;
		$clicktime = $result->click_time;
		$clickid = $result->click_id;
		$ip = $result->ip_address;
		$countrycode = $result -> country_code;
		#$referrer = $result -> referrer;
		$useragent = $result->user_agent;
		
		echo '<tr>';
		echo '<td>'; echo($shorturl); echo '</td>'; 
		echo '<td>'; print_r($clicktime); echo '</td>';
		echo '<td>'; echo "  "; print_r($clickid); echo '</td>';
		echo '<td>'; print_r($ip); echo '</td>';
		echo '<td>'; echo "   ";print_r($countrycode); echo '</td>';
		echo '<td>'; print_r(substr($useragent, 0, 82));echo'...'; echo '</td>'; 
		echo '</tr>';
	    }
        echo '</table>';

}
