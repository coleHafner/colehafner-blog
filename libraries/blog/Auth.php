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

		$q = $this->getQuery('user', $this->f3);
		$hashed = self::doHash($this->password);

		$users = $q->find(array(
			'username' => $this->username,
			'password' => $hashed
		));

		if (empty($users)) {
			$this->_validationErrors[] = 'Invalid username or password.';
			return false;
		}

		$user = array_shift($users);

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

		$this->db->conn->begin();

		try {
			if (empty($this->user)) {
				throw new RuntimeException('Error: Cannot login without user.');
			}

			//create and cache session
			$session = $this->db->getQuery('session');
			$session->user_id = $this->user->id;
			$session->user_agent = $this->f3->get('AGENT');
			$session->ip_address = $this->f3->get('IP');
			$session->key = $this->generateSessionKey();
			$session->save();

			SessionHelper::create($this->f3)->setSession($session);
			$this->conn->commit();
			return true;

		}catch(Exception $e) {
			$this->conn->rollback();
			error_log($e->getMessage());
			return false;
		}
	}

	/**
	 * Generates a unique session key. Checked against the database.
	 * @return	string
	 */
	public function generateSessionKey() {

		$unique = false;
		$q = $this->db->getQuery('session');

		while (!$unique) {
			$key = sha1(mt_rand(uniqid($this->user->id)));
			$sessions = $q->find(array('key' => $key));

			if (empty($sessions)) {
				$unique = true;
			}
		}

		return $key;
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
	public static function create($params = array(), Base $f3) {

		$auth = new Auth;
		$auth->setF3($f3);

		if (!empty($params['username'])) {
			$auth->username = $params['username'];
		}

		if (!empty($params['password'])) {
			$auth->username = $params['password'];
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