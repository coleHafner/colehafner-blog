<?php

/**
 * Description of Auth
 *
 * @author colehafner
 */
class Auth extends BaseLib {

	const SALT = '81872698053d866133d7c25.46029213';

	/**
	 * @var	string
	 */
	public $username = null;

	/**
	 * @var	string
	 */
	public $password = null;

	/**
	 * Array of user data
	 * @var	array
	 */
	protected $user = null;

	/**
	 * @var	array
	 */
	private $_validationErrors = array();

	/**
	 * Ensures username and password is populated
	 * @return	boolean
	 */
	public function validate() {
		if (empty($this->username)) {
			$this->_validationErrors[] = 'You must provide a username';
		}

		if (empty($this->password)) {
			$this->_validationErrors[] = 'You must provide a password';
		}

		return count($this->_validationErrors) == 0;
	}

	/**
	 * If password and username passed, true is returned, false otherwise.
	 * If false, see _validationErrors for clues.
	 * @return	boolean
	 */
	public function setUser() {

		if (!$this->validate()) {
			return false;
		}

		$q = $this->db->getQuery('user');
		$hashed = self::doHash($this->password);
		$user = $q->load(array('username=? AND password=?', $this->username, $hashed));

		if (empty($user)) {
			$this->_validationErrors[] = 'Invalid username or password.';
			return false;
		}

		if ($user->archived !== null) {
			$this->_validationErrors[] = 'The account for "' . $this->username . '" has been deactivated.';
			return false;
		}

		$this->user = $user;
		return true;
	}

	/**
	 * Logs the user in and creates a session record.
	 * @return	boolean
	 * @throws	RuntimeException
	 */
	public function login() {
		$this->db->begin();

		try {
			if (empty($this->user)) {
				throw new RuntimeException('Error: Cannot login without user.');
			}

			//create and cache session
			$now = strtotime('now');
			$session = $this->db->getQuery('session');
			$session->user_id = $this->user->id;
			$session->user_agent = $this->f3->get('AGENT');
			$session->ip_address = $this->f3->get('IP');
			$session->hash = $this->getUniqueSessionHash();
			$session->created = $now;
			$session->updated = $now;
			$session->save();

			SessionHelper::create($this->f3)->setSession($session);
			$this->db->commit();
			return true;

		}catch(Exception $e) {
			$this->db->rollback();
			error_log($e->getMessage());
			return false;
		}
	}

	/**
	 * Expires the current session and clears session vars from superglobal.
	 * @param	SessionHelper	$sh
	 * @return	boolean
	 */
	public function logout(SessionHelper $sh = null) {

		$sh = $sh ? $sh : SessionHelper::create($this->f3);
		$this->db->begin();

		try {
			$session = $sh->getSession($this->db);
			$session->archived = strtotime('now');
			$session->save();
			$sh->clearSession();

			$this->db->commit();
			return true;

		}catch(Exception $e) {
			$this->db->rollback();
			error_log($e->getmessage());
			return false;
		}
	}

	/**
	 * Generates a unique session hash. Checked against the database.
	 * @return	string
	 */
	public function getUniqueSessionHash() {

		$q = $this->db->getQuery('session');
		$unique = false;

		while (!$unique) {
			$hash = $this->generateSessionHash();
			$session = $q->load(array('hash=?', $hash));

			if (empty($session)) {
				$unique = true;
			}
		}

		return $hash;
	}

	/**
	 * @return	string
	 */
	public function generateSessionHash() {
		return sha1(uniqid($this->user->id));
	}

	/**
	 * @return	array
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * Returns an array of validation errors.
	 * @return	array
	 */
	public function getValidationErrors() {
		return $this->_validationErrors;
	}

	/**
	 * @param	array	$params
	 * @return	Auth
	 */
	public static function create(Base $f3, $params = array()) {

		$auth = new Auth($f3);

		if (!empty($params['username'])) {
			$auth->username = $params['username'];
		}

		if (!empty($params['password'])) {
			$auth->password = $params['password'];
		}

		return $auth;
	}

	/**
	 * @param	string	$password
	 * @return	string
	 */
	public static function doSalt($password) {
		return self::SALT . $password;
	}

	/**
	 * @param	string	$password
	 * @return	string
	 */
	public static function doHash($password) {
		$salted = self::doSalt($password);
		return md5($salted);
	}
}