<?php

class BaseCtrl {

	/**
	 * @var	string
	 */
	const DEFAULT_LAYOUT = 'layouts/main.php';

	/**
	 * Path the view file.
	 * @var	string
	 */
	protected $view = null;

	/**
	 * Path to layout file.
	 * @var	string
	 */
	protected $layout = null;

	/**
	 * Set notifications
	 * @param	Base	$f3
	 */
	public function beforeRoute(Base $f3, array $routes, SessionHelper $sh = null) {
		$sh = $sh ? $sh : SessionHelper::create($f3);
		$sh->setNotifications();
		$sh->clearNotifications();
	}

	/**
	 * @param Base	$f3
	 */
	public function afterRoute(Base $f3, array $routes, SessionHelper $sh = null) {

		$sh = $sh ? $sh : SessionHelper::create($f3);
		$f3->set('sh', $sh);

		if (!$f3->get('title')) {
			$view_split = explode('/', $this->view);
			$view_name = str_replace('.php', '', array_pop($view_split));
			$f3->set('title', ucwords(strtolower($view_name)));
		}

		$viewer = View::instance();
		$view = strpos($this->view, '.php') !== false ? $this->view : $this->view . '.php';
		$layout = $this->layout !== null ? $this->layout : self::DEFAULT_LAYOUT;
		$f3->set('content_view', $view);
		echo $viewer->render($layout);
	}
}