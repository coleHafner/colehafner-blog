<?php

class PostsCtrl extends LoggedInCtrl {

	public function index() {
		echo 'listing all posts';
	}

	public function add() {
		echo 'adding new post...';
	}

	public function edit($f3) {
		$post_id = $f3->get('PARAMS.post_id');
		echo 'editing #' . $post_id;
	}
}