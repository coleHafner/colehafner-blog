<?php

class IndexCtrl extends BaseCtrl {

	/**
	 * @param Base $this->f3
	 */
	public function index() {
		$this->view = 'index/index';
	}

	/**
	 * @param Base $this->f3
	 */
	public function about() {
		$this->view = 'index/about';
	}

	/**
	 * Allows the user to login if they're not already.
	 * @param	Base			$this->f3
	 * @param	array			$routes
	 */
	public function login() {

		if ($this->session->isLoggedIn()) {
			$this->f3->reroute('/posts');
		}

		$this->view = 'index/login';
	}

	/**
	 * Portfolio time.
	 * @param	Base			$this->f3
	 * @param	array			$routes
	 */
	public function portfolio() {
		$this->view = 'index/portfolio';
		$this->f3->set('title', 'Portfolio');
	}

	public function doLogout(Auth $auth = null) {
		$auth = $auth ? $auth : Auth::create($this->f3, array());
		$auth->logout();
		$this->f3->reroute('/');
	}

	/**
	 * Does login
	 * @param	Base			$this->f3
	 * @param	Auth			$auth
	 */
	public function doLogin(Auth $auth = null) {

		$auth = $auth ? $auth : Auth::create($this->f3, $this->f3->get('POST'));
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

		$this->session->setErrors($errors);
		$this->f3->reroute('/posts');
	}
}