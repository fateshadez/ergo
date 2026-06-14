<?php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = __DIR__ . $path;

if (is_file($file)) {
    return false; // serve static files (css, js, images) directly
}

// Pass the URL to index.php
$_GET['url'] = ltrim($path, '/');
require_once __DIR__ . '/index.php';