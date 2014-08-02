<?php

class IndexCtrl extends BaseCtrl {

	/**
	 * @param Base $this->f3
	 */
	public function index() {
		$this->view = 'index/index';
		$this->setTitle('Home');
	}

	/**
	 * @param Base $this->f3
	 */
	public function about() {
		$this->view = 'index/about';
		$this->setTitle('About');
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

		$this->setTitle(null);
		$this->set('notifications', null);
		$this->view = 'index/login';
	}

	/**
	 * Portfolio time.
	 * @param	Base			$this->f3
	 * @param	array			$routes
	 */
	public function portfolio() {
		$this->view = 'index/portfolio';
		$this->setTitle('Portfolio');
	}

	public function doLogout(Base $f3, array $routes, Auth $auth = null) {
		$auth = $auth ? $auth : Auth::create($this->f3, array());
		$auth->logout();
		$this->f3->reroute('/');
	}

	/**
	 * Does login
	 * @param	Base			$this->f3
	 * @param	Auth			$auth
	 */
	public function doLogin(Base $f3, array $routes, Auth $auth = null) {

		$auth = $auth ? $auth : Auth::create($this->f3, $this->get('POST'));
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

		if ($errors) {
			$this->session->setErrors($errors);
			$this->f3->reroute('/login?' . http_build_query(array('username' => $this->get('POST.username'))));
		}

		$this->f3->reroute('/posts');
	}
}