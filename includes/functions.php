<?php 

// Render template file
function render_template($template_name, $template_folder=TEMPLATE_DIR) {
	global $services;
	include($template_folder . $template_name);
	die;
}

// Reponse AJAX
function render_ajax($data = array()) {
	@header('Content-Type: application/json');
	echo json_encode($data);
	die;
}

// For 4.3.0 <= PHP <= 5.4.0
if (!function_exists('http_response_code'))
{
    function http_response_code($newcode = NULL)
    {
        static $code = 200;
        if($newcode !== NULL)
        {
            header('X-PHP-Response-Code: '.$newcode, true, $newcode);
            if(!headers_sent())
                $code = $newcode;
        }       
        return $code;
    }
}

// Render error messagge via AJAX
function render_ajax_error($message = 'Error') {
	http_response_code(400);
	@header('Content-Type: application/json');

	if (is_string($message)) $data = array('message' => $message);
	else $data = $message;

	echo json_encode($data);
	die;
}

// Get serices URL
function array_map_get_services_url($service)
{
	return $service[2];
}