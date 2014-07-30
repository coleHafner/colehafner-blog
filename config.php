<?php
if (defined('CONFIG_LOADED')
	&& CONFIG_LOADED === true) {
	return;
}

//paths
define('ROOT', dirname(__FILE__) . '/');
define('LIB_DIR', ROOT . 'libraries/');
define('LOGS_DIR', ROOT . 'logs/');
define('CONFIG_DIR', ROOT . 'config/');
define('DOC_ROOT', ROOT . 'public/');

//f3 config
$f3 = require(LIB_DIR . 'f3/base.php');
$f3->config(CONFIG_DIR . 'globals.ini');
$f3->config(CONFIG_DIR . 'routes.ini');
$f3->config(CONFIG_DIR . 'maps.ini');

//database connections
$connections = CONFIG_DIR . 'connections.ini';
$db_ini = parse_ini_file($connections, true);
$db = $db_ini['connection'];
$dsn = $db['type'] . ':host=' . $db['host'] . ';port=' . $db['port'] . ';dbname=' . $db['dbname'];
$conn = new \DB\SQL($dsn, $db['user'], $db['pass']);

//super globals
$f3->set('AUTOLOAD', ROOT . 'controllers/; ' . ROOT . 'libraries/blog/;');
$f3->set('UI', ROOT . 'views/');
$f3->set('CONN', $conn);

require_once(ROOT . 'libraries/helper_funcs.php');
define('CONFIG_LOADED', true);