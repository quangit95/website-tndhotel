<?php
// router.php for PHP built-in web server

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = urldecode($uri);
$filePath = __DIR__ . $uri;

// If the requested resource exists as a file, let the built-in server serve it
if ($uri !== '/' && file_exists($filePath) && !is_dir($filePath)) {
    return false;
}

// Replicate Apache .htaccess RewriteRule ^(.*)$ index.php?q=$1 [L,QSA]
$q = ltrim($uri, '/');
$_GET['q'] = $q;
$_REQUEST['q'] = $q;

// Set default SERVER variables if missing
if (!isset($_SERVER['SERVER_PORT'])) {
    $_SERVER['SERVER_PORT'] = '8000';
}
if (!isset($_SERVER['SERVER_NAME'])) {
    $_SERVER['SERVER_NAME'] = 'localhost';
}
if (!isset($_SERVER['SERVER_ADDR'])) {
    $_SERVER['SERVER_ADDR'] = '127.0.0.1';
}

require_once __DIR__ . '/index.php';
