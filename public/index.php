<?php
require('../config.php');

if (empty($f3)) {
	throw new RuntimeException('Error: F3 not found. Cannot continue.');
}

$f3->run();
