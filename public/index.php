<?php
require('../config.php');
$f3 = require(LIB_DIR . 'f3/base.php');
$f3->set('AUTOLOAD', ROOT . 'controllers/');
$f3->set('UI', ROOT . 'views/');
$f3->config(ROOT . 'globals.ini');
$f3->config(ROOT . 'routes.ini');
$f3->config(ROOT . 'maps.ini');
$f3->run();