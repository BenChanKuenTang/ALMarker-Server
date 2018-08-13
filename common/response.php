<?php
	/*
	//reference of http response code
	$response_code_ok = 200;
    $response_code_created = 201;
    $response_code_accepted = 202;
    $response_code_no_content = 204;
    $response_code_bad_request = 400;
    $response_code_unauthorized = 401;
    $response_code_forbidden = 403;
    $response_code_not_found = 404;
    $response_code_method_not_allowed = 405;
    $response_code_request_timeout = 408;
    $response_code_unsupported_media_type = 415;
    $response_code_internal_server_error = 500;
    $response_code_bad_gateway = 502;
    $response_code_service_unavailable = 503;
    */

	function successResponse($data) {
		http_response_code(200);
		echo json_encode(
			array(
				'data' => $data
			)
		);
	}

	function errorResponse($error) {
		http_response_code($RESPONSE_CODE_NOT_FOUND);
		echo json_encode(
			array(
				'error' => $error
			)
		);
	}
?>