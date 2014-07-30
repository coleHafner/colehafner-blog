<?php

class LoggedInCtrl extends BaseCtrl {

	/**
	 * @param	Base		$f3
	 */
	public function beforeRoute(Base $f3) {
		if (!SessionHelper::create($f3)->isLoggedIn()) {
			$f3->route('GET /');
		}
	}
}