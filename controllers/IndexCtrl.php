<?php

class IndexCtrl extends BaseCtrl {

	/**
	 * @param Base $f3
	 */
	public function index(Base $f3) {
		$this->view = 'index/index';
	}

	/**
	 * @param Base $f3
	 */
	public function about(Base $f3) {
		$f3->set('param', 'foo');
		$this->view = 'index/about';
	}

	/**
	 * @param Base $f3
	 */
	public function login(Base $f3) {
		$this->view = 'index/login';
	}

	/**
	 * Does login
	 * @param	Base			$f3
	 * @param	Auth			$auth
	 * @param	SessionHelper	$session_helper
	 */
	public function doLogin(Base $f3, array $routes, Auth $auth = null, SessionHelper $sh = null) {

		$auth = $auth ? $auth : Auth::create($f3->get('POST'), $f3);
		$user = $auth->setUser();
		$errors = array();

		if ($user === false) {
			$errors = $auth->getValidationErrors();
		}

		if (!$errors) {
			$logged_in = $auth->login();

			if (!$logged_in) {
				$errors = $auth->getValidationErrors();
			}
		}

		$sh = $sh ? $sh : SessionHelper::create($f3);
		$sh->setErrors($errors);
		$f3->route('GET /posts', array());
	}
}