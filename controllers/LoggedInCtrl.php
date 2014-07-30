<?php

class LoggedInCtrl extends BaseCtrl {

	/**
	 * @param	Base		$f3
	 */
	public function beforeRoute(Base $f3, array $routes, SessionHelper $sh = null) {

		$sh = $sh ? $sh : SessionHelper::create($f3);

		if (!$sh->isLoggedIn()) {
			$f3->reroute('/login');
		}
	}
}