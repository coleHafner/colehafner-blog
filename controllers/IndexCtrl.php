<?php

class IndexCtrl extends BaseCtrl {
	public function index($f3) {
		$this->view = 'index/index';
	}

	public function about($f3) {
		$f3->set('param', 'foo');
		$this->view = 'index/about';
	}

	public function login($f3) {
		$this->view = 'index/login';
	}

	public function doLogin($f3) {
		$conn = $f3->get('CONN');
		$posts = new \DB\SQL\Mapper($conn, 'post');
		echo 'posts:';
		print_r($posts->find());die;

		//$auth = new \Auth($user, array('id'=>'user_id', 'pw'=>'password'));
		//print_r($f3->get('POST'));die;
	}
}