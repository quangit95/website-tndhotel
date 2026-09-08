<?php
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

ini_set('memory_limit', '1024M'); // 1 GB minus 1 MB

$linkReferer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
$iswebsite = true;
if( !empty($_SERVER['HTTP_ORIGIN'])) {
    // Enable CORS
    header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, X-Requested-With, Cache-Control, Content-Range, Authorization, Content-Disposition, Content-Type, X-FILE-NAME, X-FILE-SIZE, X-FILE-TYPE');
    header('Access-Control-Allow-Credentials: true');
}


$data = $code = $message = $errors = $file = $information = null;
if (isset($url_data[1])) {
	if ($url_data[1] == 'post') {
		require_once 'api/post.php';
	} elseif ($url_data[1] == 'get') {
		require_once 'api/get.php';
	}
} else {
	die();
}
?>
