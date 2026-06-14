<?php
error_log('=== ROUTER START ===');
error_log('REQUEST_URI: ' . $_SERVER['REQUEST_URI']);

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = __DIR__ . $path;

if (is_file($file)) {
    return false;
}

$url = ltrim($path, '/');

$_GET['url'] = empty($url) ? 'auth' : $url;

error_log('GET url: ' . $_GET['url']);

require_once __DIR__ . '/index.php';