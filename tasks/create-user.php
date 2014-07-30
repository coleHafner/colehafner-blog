<?php

require_once('../config.php');

$username = !empty($argv[1]) ? $argv[1] : null;
$password = !empty($argv[2]) ? $argv[2] : null;
$type = !empty($argv[3]) ? $argv[3] : null;

if (!$username) {
	$username = prompt('Username');
}

if (!$password) {
	$password = prompt('Password');
}

if (!$type) {
	$type = prompt('User Type (1 = admin, 2 = normal)');
}

if (empty($username) || empty($password) || empty($type) || $username == 'help') {
	echo PHP_EOL . PHP_EOL . 'Usage: ' . PHP_EOL;
	echo 'argv[1] = username' . PHP_EOL;
	echo 'argv[2] = password' . PHP_EOL . PHP_EOL;
	echo 'argv[3] = password (1 = admin, 2 = normal)' . PHP_EOL . PHP_EOL;
	die;
}

$user = Db::create($f3)->getQuery('user');
$dup_user = $user->load(array('username=?', $username));

if (!empty($dup_user)) {
	die('User with username "' . $username . '" already exists (ID #' . $user->id . '). Choose a different one.' . PHP_EOL);
}

$now = strtotime('now');
$user->username = $username;
$user->password = Auth::doHash($password);
$user->type = $type;
$user->created = $now;
$user->updated = $now;
$user->save();