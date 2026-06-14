<?php

define('DB_HOST', getenv('MYSQLHOST') ?: 'localhost');
define('DB_PORT', getenv('MYSQLPORT') ?: '3306');
define('DB_USER', getenv('MYSQLUSER') ?: 'root');
define('DB_PASS', getenv('MYSQLPASSWORD') ?: '');
define('DB_NAME', getenv('MYSQLDATABASE') ?: 'task-app');

define('BASE_URL', '');
