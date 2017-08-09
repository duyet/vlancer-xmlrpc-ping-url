<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

/* Define const */
define('INCLUDE_DIR', 'includes/');
define('TEMPLATE_DIR', 'templates/');

require_once(INCLUDE_DIR . 'functions.php');
require_once(INCLUDE_DIR . 'rpc.php');
require_once(INCLUDE_DIR . 'data/xmlrpc_services.php');

$_p = isset($_GET) && isset($_GET['p']) ? $_GET['p'] : 'index';

// =======================================
// List services =========================
if ($_p == 'list_services') {
	render_template('list_services.html');
}

// =======================================
// AJAX Config ===========================
if ($_p == 'config') {
	$number_of_services = count($services);
	render_ajax(array(
		'number_of_services' => $number_of_services,
		'services' => array_map("array_map_get_services_url", $services)
	));
}

// =======================================
// PING ==================================
if ($_p == 'ping') {
	$url = isset($_GET['url']) ? trim($_GET['url']) : '';
	$service = isset($_GET['service']) ? trim($_GET['service']) : '';
	$service_type = isset($_GET['service_type']) ? trim($_GET['service_type']) : 'weblogUpdates.extendedPing';


	if (!$url or !$service or !$service_type) {
		render_ajax_error('Please submit URL in url param.');
	}

	// TODO: Ping
	$data = rpcXMLCreate($url, $url, $url, '', $service_type);
	$results = getRPC($service, $data);

	$code = $results[0];
	$message = $results[1];

	$success = $code == 0 ? true : false;

	// Response result
	if ($success) 
		return render_ajax(array(
			'url' => $url,
			'status' => 'success',
			'code' => $code,
			'message' => $message,
		));
	else
		return render_ajax_error(array(
			'url' => $url,
			'message' => $message,
			'code' => $code
		));
}

// =======================================
// Render index  =========================
render_template('index.html');