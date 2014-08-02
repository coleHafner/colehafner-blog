<?php

class CommentsCtrl extends LoggedInCtrl {

	protected $table = 'comment';
	protected $home = 'comments';
	protected $pk = 'id';

	public function index() {
		$post_id = $this->get('PARAMS.post_id');
		parent::index();

		if (!empty($post_id)) {
			$post = $this->db->getQuery('post')->load(array('id=?', $post_id));
			$this->setTitle('Comments for ' . $post->title);
		}
	}

	public function edit() {
		$this->setPosts();
		parent::edit();
	}

	public function add() {
		$this->setPosts();
		parent::add();
	}

	public function validate() {

		if (empty($this->getRecord()->author) || empty($this->getRecord()->body)) {
			$this->session->setErrors(array('You must provide a title and body.'));
			return false;
		}

		return true;
	}

	public function setRecords($filters = array()) {

		$post_id = $this->get('PARAMS.post_id');

		if (!empty($post_id)) {
			$filters = array('post_id=?', $post_id);
		}

		parent::setRecords($filters);
	}

	private function setPosts() {
		$this->set('posts', $this->db->getQuery('post')->find());
	}
}
