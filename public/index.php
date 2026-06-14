<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../app/init.php';
try {
    $app = new App();
} catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
    // require_once '../app/views/errors/500.php';
}
