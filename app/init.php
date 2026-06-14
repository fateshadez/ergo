<?php

session_start();
echo 'logged_in: ' . (isset($_SESSION['logged_in']) ? 'true' : 'false') . '<br>';
echo 'url: ' . $_SERVER['REQUEST_URI'] . '<br>';
die();
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/core/Error.php';
require_once __DIR__ . '/core/Model.php';
require_once __DIR__ . '/core/Controller.php';
require_once __DIR__ . '/core/App.php';