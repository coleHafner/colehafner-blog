<?php

class IndexCtrl extends BaseCtrl {

	/**
	 * @param Base $this->f3
	 */
	public function index() {
		$this->view = 'index/index';
		$this->f3->set('title', 'Home');
	}

	/**
	 * @param Base $this->f3
	 */
	public function about() {
		$this->view = 'index/about';
		$this->f3->set('title', 'About');
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

		$this->f3->set('title', null);
		$this->f3->set('notifications', null);
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

		if ($errors) {
			$this->session->setErrors($errors);
			$this->f3->reroute('/login?' . http_build_query(array('username' => $this->f3->get('POST.username'))));
		}

		$this->f3->reroute('/posts');
	}
}