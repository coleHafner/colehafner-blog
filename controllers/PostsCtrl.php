<?php

class PostsCtrl extends LoggedInCtrl {

	protected $home = 'posts';
	protected $table = 'post';
	protected $pk = 'id';


	public function validate() {
		if (empty($this->getRecord()->body) || empty($this->getRecord()->title)) {
			$this->session->setErrors(array('You must provide a title and body.'));
			return false;
		}

		return true;
	}
}