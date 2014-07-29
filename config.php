<?php
if (defined('CONFIG_LOADED')
	&& CONFIG_LOADED === true) {
	return;
}

define('ROOT', dirname(__FILE__) . '/');
define('LIB_DIR', ROOT . 'libraries/');
define('LOGS_DIR', ROOT . 'logs/');
define('CONFIG_DIR', ROOT . 'config/');
define('DOC_ROOT', ROOT . 'public/');
define('CONFIG_LOADED', true);

//ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . ROOT . 'controllers');