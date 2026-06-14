<?php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = __DIR__ . $path;

if (is_file($file)) {
    return false; // serve static files (css, js, images) directly
}

// Pass the URL to index.php
$_GET['url'] = ltrim($path, '/');

error_log('URL path: ' . $path);
error_log('GET url: ' . $_GET['url']);

require_once __DIR__ . '/index.php';