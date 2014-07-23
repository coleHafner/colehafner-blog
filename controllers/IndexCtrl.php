<?php

class IndexCtrl extends BaseCtrl {
	public function index($f3) {
		$this->view = 'index/index';
	}

	public function about($f3) {
		$f3->set('param', 'foo');
		$this->view = 'index/about';
	}
}