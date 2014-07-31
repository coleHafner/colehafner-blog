<?php

class LoggedInCtrl extends BaseCtrl {

	public function beforeRoute() {

		parent::beforeRoute();

		if (!$this->session->isLoggedIn()) {
			$this->f3->reroute('/login');
		}
	}
}