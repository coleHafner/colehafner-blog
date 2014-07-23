<?php

class LoggedInCtrl extends BaseCtrl {
	public function beforeRoute() {
		die('user is not logged in. Cannot continue...');
	}
}