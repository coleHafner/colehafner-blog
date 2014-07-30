<?php

if (function_exists('prompt')) {
	return;
}

function prompt($message) {
	fwrite(STDOUT, "$message: ");
	return trim(fgets(STDIN));
}