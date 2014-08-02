<?php

class BlogCtrl extends BaseCtrl {
	public function index() {
		$this->view = 'blog/index';
		$this->setTitle('Blog');
		$posts = $this->db->getQuery('post');
		$posts->comment_count = 'SELECT COUNT(*) FROM comment WHERE comment.post_id = post.id';
		$this->set('posts', $posts->find());
	}

	public function show() {
		$this->view = 'blog/show';
		$post = $this->db->getQuery('post')->load(array('id=?', $this->get('PARAMS.id')));
		$this->set('post', $post);
		$this->setTitle($post->title);
	}
}
