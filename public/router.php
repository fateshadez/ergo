<?php
error_log('ROUTER START');
error_log('REQUEST_URI: ' . $_SERVER['REQUEST_URI']);

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = __DIR__ . $path;

if (is_file($file)) {
    return false; // serve static files (css, js, images) directly
}

// Pass the URL to index.php
$_GET['url'] = ltrim($path, '/');
error_log('GET url set to: ' . $_GET['url']);

require_once __DIR__ . '/index.php';