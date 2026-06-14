<?php
require_once '../app/init.php';
try {
    $app = new App();
} catch (Exception $e) {
    http_response_code(500);
    require_once '../app/views/errors/500.php';
}
