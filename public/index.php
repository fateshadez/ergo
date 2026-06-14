<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

chdir(dirname(__DIR__));

require_once 'app/init.php';

try {
    $app = new App();
} catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
    echo $e->getFile() . ' on line ' . $e->getLine();
}
