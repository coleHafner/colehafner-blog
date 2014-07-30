<?php

class LoggedInCtrl extends BaseCtrl {

	/**
	 * @param	Base		$f3
	 */
	public function beforeRoute(Base $f3, array $routes, SessionHelper $sh = null) {
		if (!SessionHelper::create($f3)->isLoggedIn()) {
			$f3->reroute('/');
		}
	}
}