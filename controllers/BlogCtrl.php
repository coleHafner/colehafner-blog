<?php

class BlogCtrl extends BaseCtrl {
	public function index() {
		$this->f3->set('title', 'Blog');
		$this->view = 'blog/index';
	}

	public function show() {
		$this->view = 'blog/show';
		$post = $this->db->getQuery('post')->load($this->f3->get('PARAMS.id'));
		$this->f3->set('post', $post);
		$this->f3->set('title', $post->title);
		$this->f3->set('session', $this->session);
	}
}
