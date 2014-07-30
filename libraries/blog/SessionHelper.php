<?php

class SessionHelper extends BaseLib {

	public function __construct(Base $f3 = null) {
		parent::__construct($f3);
		$this->session = $this->f3->get('SESSION');
	}

	/**
	 * @param	string	$key
	 * @param	string	$val
	 * @return	SessionHelper
	 */
	public function set($key, $val) {

		$this->session[$key] = $val;
		$session = $this->f3->set('SESSION', $this->session);
		return $this;
	}

	/**
	 * @param	string	$key
	 * @return	mixed
	 */
	public function get($key) {
		return @$this->session[$key];
	}

	/**
	 * Unsets the key from the session and returns true if exists. False otherwise.
	 * @param	string|array	$key
	 * @return	boolean
	 */
	public function clear($key) {

		$keys = is_array($key) ? $key : array($key);
		$result = true;

		foreach ($keys as $key) {

			$found = false;

			if (array_key_exists($key, $this->session)) {
				unset($this->session[$key]);
				$session = $this->f3->set('SESSION', $this->session);
				$found = true;
			}

			$result != $found;
		}

		return $result;
	}

	/**
	 * Removes the notifications from the SESSION superglobal.
	 * @return	boolean
	 */
	public function clearNotifications() {
		return $this->clear(array('errors', 'messages'));
	}

	/**
	 * Removes the user_id and session_hash keys from the SESSION superglobal.
	 * @return	boolean
	 */
	public function clearSession() {
		return $this->clear(array('session_hash', 'user_id'));
	}

	/**
	 * Sets the notifications into the f3 instance
	 */
	public function setNotifications() {
		$this->f3->set('errors', $this->getErrors());
		$this->f3->set('messages', $this->getMessages());
	}

	/**
	 * Sets the key and user_id keys in the session superglobal.
	 * @param	mixed	$session
	 * @return	SessionHelper
	 */
	public function setSession($session) {
		$this->set('session_hash', $session->hash);
		$this->set('user_id', $session->user_id);
		return $this;
	}

	/**
	 * Sets the errors to display on the view load.
	 * @param	array	$errors
	 * @return	SessionHelper
	 */
	public function setErrors(array $errors) {
		$this->set('errors', $errors);
		return $this;
	}

	/**
	 * Sets the messages to display on the next view load.
	 * @param	array	$messages
	 * @return	SessionHelper
	 */
	public function setMessages(array $messages) {
		$this->set('messsages', $messages);
		return $this;
	}

	/**
	 * @param	Db		$db		for transactions
	 * @return	array|null
	 */
	public function getSession(Db $db = null) {
		$hash = $this->get('session_hash');
		$db = $db ? $db : $this->db;
		$session = $db->getQuery('session')->load(array('hash=?', $hash));
		return !empty($session) ? $session : null;
	}

	/**
	 * Gets the errors to display on the next view load.
	 * @return	array|null
	 */
	public function getErrors() {
		return $this->get('errors');
	}

	/**
	 * Gets the messages to display on the next view load.
	 * @return	array|null
	 */
	public function getMessages() {
		return $this->get('messsages');
	}

	/**
	 * @return array|null
	 */
	public function getUser() {
		$id = $this->get('user_id');
		$user = $this->db->getQuery('user')->load(array('id=?', $id));
		return !empty($user) ? $user : null;
	}

	/**
	 * @return	boolean
	 */
	public function isLoggedIn() {
		$session = $this->getSession();
		return (bool) ($this->getUser() && $session && !$session->archived);
	}

	public static function create(Base $f3) {
		return new SessionHelper($f3);
	}
}