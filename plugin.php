<?php
/*
Plugin Name: Custom API action (logs)
Plugin URI: http://yourls.org
Description: Define custom API action 'logs'
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

//table

function array2Html($array, $table = true)
{
    $out = '';
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            if (!isset($tableHeader)) {
                $tableHeader =
                    '<th>' .
                    implode('</th><th>', array_keys($value)) .
                    '</th>';
            }
            array_keys($value);
            $out .= '<tr>';
            $out .= array2Html($value, false);
            $out .= '</tr>';
        } else {
            $out .= "<td>$value</td>";
        }
    }

    if ($table) {
        return '<table>' . $tableHeader . $out . '</table>';
    } else {
        return $out;
    }
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
		/*
		echo '<h5>Shorturl</h5>'; print_r($shorturl); 
		echo '<h5>Click id</h5>'; print_r($clickid); 
		echo '<h5>Click time</h5>'; print_r($clicktime); 
		echo '<h5>IP</h5>'; print_r($ip);
		echo '<h5>User agent</h5>'; print_r($useragent); 
		echo '<h5>Country code</h5>'; print_r($countrycode); 
		echo '<h5>Referrer</h5>'; print_r($referrer); 
		echo '<pre>_______________________________________';
		*/
		
	    }
	    
	    
        echo '</table>';

}
