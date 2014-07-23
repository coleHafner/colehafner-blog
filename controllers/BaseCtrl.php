<?php

class BaseCtrl {

	protected $view = null;

	public function afterRoute($f3) {
		$view = strpos($this->view, '.php') !== false ? $this->view : $this->view . '.php';
		echo View::instance()->render($view);
	}
}
