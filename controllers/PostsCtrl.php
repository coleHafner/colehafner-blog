<?php

class PostsCtrl extends LoggedInCtrl {

	protected $home = 'posts';
	protected $table = 'post';
	protected $pk = 'id';

	public function index() {
		$this->setRecords();
		$this->f3->set('title', 'Posts');
		$this->view = 'posts/index';
	}

	public function add() {
		$this->view = 'posts/edit';
		$this->setRecord();
		$this->f3->get('record')->copyfrom('GET');
		$this->f3->set('title', 'Add Post');
	}

	public function edit() {
		$this->view = 'posts/edit';
		$this->setRecord();
		$this->f3->get('record')->copyfrom('GET');
		$this->f3->set('title', 'Edit Post');
	}

	public function delete() {

		try {
			$this->setRecord();
			$record = $this->f3->get('record');
			$record->erase();
			$this->session->setMessages(array('Post deleted!'));

		}catch(Exception $e) {
			$this->session->setErrors(array($e->getMessage()));
		}

		$this->goHome();
	}

	public function save() {

		$new = true;
		$post = $this->db->getQuery('post');
		$action = 'add';

		if ($id = $this->f3->get('POST.id')) {
			$new = false;
			$action = $this->f3->get('POST.id');
			$post = $post->load(array('id=?', $id));
		}

		$post->copyfrom('POST');

		try {
			if (empty($post->body) || empty($post->title)) {
				$this->session->setErrors(array('You must provide a title and body.'));
			}else {
				$now = strtotime('now');
				$post->updated = $now;

				if ($new) {
					$post->created = $now;
				}

				$post->save();
				$this->session->setMessages(array('Post saved!'));
				$this->goHome();
			}
		}catch(Exception $e) {
			throw $e;
			$sh->setErrors(array($e->getMessage()));
		}

		$this->routeTo($action, $this->f3->get('POST'));
	}
}