<?php
require('../config.php');
$f3 = require(LIB_DIR . 'f3/base.php');
$f3->config(CONFIG_DIR . 'globals.ini');
$f3->config(CONFIG_DIR . 'routes.ini');
$f3->config(CONFIG_DIR . 'maps.ini');

//db connection
$connections = CONFIG_DIR . 'connections.ini';
$db_ini = parse_ini_file($connections, true);
$db = $db_ini['connection'];
$dsn = $db['type'] . ':host=' . $db['host'] . ';port=' . $db['port'] . ';dbname=' . $db['dbname'];
$conn = new \DB\SQL($dsn, $db['user'], $db['pass']);

$f3->set('AUTOLOAD', ROOT . 'controllers/');
$f3->set('UI', ROOT . 'views/');
$f3->set('CONN', $conn);

$f3->run();