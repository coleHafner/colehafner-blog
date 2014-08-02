<?php

if (function_exists('prompt')) {
	return;
}

function prompt($message) {
	fwrite(STDOUT, "$message: ");
	return trim(fgets(STDIN));
}

/**
 * Creates a link from the post title
 * @param	Object
 * @return	string
 */
function get_slug($post) {
	return strtolower(str_replace(' ', '-', $post->title)) . '/' . $post->id;
}