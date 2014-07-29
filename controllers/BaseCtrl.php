<?php

class BaseCtrl {

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

	public function afterRoute($f3) {

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
