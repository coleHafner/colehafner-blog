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
	 * Allows the user to login if they're not already.
	 * @param Base			$f3
	 * @paramarray			$routes
	 * @param SessionHelper $sh
	 */
	public function login(Base $f3, array $routes, SessionHelper $sh = null) {

		$sh = $sh ? $sh : SessionHelper::create($f3);

		if ($sh->isLoggedIn()) {
			$f3->reroute('/posts');
		}

		$this->view = 'index/login';
	}

	public function doLogout(Base $f3, array $routes, Auth $auth = null) {
		$auth = $auth ? $auth : Auth::create($f3, array());
		$auth->logout();
		$f3->reroute('/');
	}

	/**
	 * Does login
	 * @param	Base			$f3
	 * @param	Auth			$auth
	 * @param	SessionHelper	$session_helper
	 */
	public function doLogin(Base $f3, array $routes, Auth $auth = null, SessionHelper $sh = null) {

		$auth = $auth ? $auth : Auth::create($f3, $f3->get('POST'));
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
		$f3->reroute('/posts');
	}
}