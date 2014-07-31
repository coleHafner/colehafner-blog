<?php

class BlogCtrl extends BaseCtrl {
	public function index() {
		$this->view = 'blog/index';
	}

	public function show() {
		$this->view = 'blog/show';
		$f3->set('post_id', $this->f3->get('PARAMS.post_id'));
	}
}
