<?php

class PostsCtrl extends LoggedInCtrl {

	public function index() {
		$this->view = 'posts/index';
	}

	public function add() {
		$this->view = 'posts/edit';
	}

	public function edit($f3) {
		$post_id = $f3->get('PARAMS.post_id');
		$this->view = 'posts/edit';
	}
}