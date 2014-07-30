<?php

class Constants {
	const USER_TYPE_ADMIN = 1;
	const USER_TYPE_NORMAL = 2;

	public $userTypes = array(
		self::USER_TYPE_ADMIN => 'Admin',
		self::USER_TYPE_NORMAL => 'Normal'
	);
}
