<?php

class BlogCtrl extends BaseCtrl {
	public function index() {
		echo 'this is a blog index...';
	}

	public function show($f3) {
		$post_id = $f3->get('PARAMS.post_id');
		echo 'this is a post id: ' . $post_id;
	}
}
