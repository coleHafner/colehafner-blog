<?php

class BaseCtrl {

	/**
	 * @var	string
	 */
	const DEFAULT_LAYOUT = 'layouts/main.php';

	/**
	 * Path the view file.
	 * @var	string
	 */
	protected $view = null;

	/**
	 * Path to layout file.
	 * @var	string
	 */
	protected $layout = null;

	/**
	 *
	 * @var	\DB\SQL
	 */
	protected $db = null;

	/**
	 * @var	Base
	 */
	protected $f3 = null;

	/**
	 * @var	SessionHelper
	 */
	protected $session = null;

	/**
	 * @param	Base			$this->f3
	 * @param	SessionHelper	$session
	 * @param	Db				$db
	 */
	public function __construct(Base $f3, SessionHelper $session = null, Db $db = null) {

		//for controllers
		$this->f3 = $f3;
		$this->db = $db ? $db : Db::create($this->f3);
		$this->session = $session ? $session : SessionHelper::create($this->f3);

		//for views
		$this->set('db', $this->db);
		$this->set('session', $this->session);
		$this->set('f3', $this->f3);
	}

	public function beforeRoute() {

		if ($this->session->isLoggedIn()) {

			//grab session
			$session = $this->session->getSession();

			//if they have been away for an hour, log them out
			if (Auth::sessionHasExpired($session)) {
				$this->session->setErrors(array('You have been logged out due to inactivity.'));
				$auth = Auth::create($this->f3, array());
				$auth->logout();
				$this->f3->reroute('/');
			}

			//update last page view
			$session->updated = strtotime('now');
			$session->save();
		}
	}

	public function afterRoute() {

		$this->session->setNotifications();
		$this->set('sh', $this->session);
		$this->session->clearNotifications();
		$viewer = View::instance();
		$view = strpos($this->view, '.php') !== false ? $this->view : $this->view . '.php';
		$layout = $this->layout !== null ? $this->layout : self::DEFAULT_LAYOUT;
		$this->set('content_view', $view);
		echo $viewer->render($layout);
	}

	public function set($key, $val) {
		$this->f3->set($key, $val);
	}

	public function get($key) {
		return $this->f3->get($key);
	}

	public function setTitle($title) {
		$this->set('title', $title);
	}

	public function getTitle() {
		return $this->get('title');
	}

	public function setRecord(array $request = null) {
		$request = !$request ? $this->get('PARAMS') : $request;
		$record = $this->db->getQuery($this->table);
		$new = empty($request[$this->pk]);

		if (!$new) {
			$record = $record->load(array($this->pk . '=?', $request[$this->pk]));
		}

		$this->set('record', $record);

		if (!$new && !$this->getRecord()) {
			$this->session->setErrors(array('Post #' . $request[$this->pk] . ' does not exist.'));
			$this->goHome();
		}
	}

	/**
	 * @return	Object
	 */
	public function getRecord() {
		return $this->get('record');
	}

	public function setRecords($filters = array()) {
		$records = $this->db->getQuery($this->table)
			->find($filters, array('order' => 'id DESC'));

		$this->set('records', $records);
	}

	/**
	 * @return	array
	 */
	public function getRecords() {
		return $this->get('records');
	}

	public function routeTo($action = null, $params = array()) {
		$action = $action ? '/' . $action : '';
		$params = !empty($params) ? '?' . http_build_query($params) : '';
		$this->f3->reroute('/' .$this->home . $action . $params);
	}

	public function goHome() {
		$this->routeTo();
	}

	//------------------------------------------------------
	public function index() {
		$this->setTitle( ucfirst($this->home));
		$this->view = $this->home . '/index';
		$this->setRecords();
	}

	public function add() {
		$this->setTitle('Add ' . ucfirst($this->table));
		$this->view = $this->home . '/edit';
		$this->setRecord();
		$this->getRecord()->copyFrom('GET');
	}

	public function edit() {
		$this->setTitle('Edit ' . ucfirst($this->table));
		$this->view = $this->home . '/edit';
		$this->setRecord();
		$this->getRecord()->copyFrom('GET');

	}

	public function delete() {

		try {
			$this->setRecord();
			$record = $this->getRecord();
			$record->erase();
			$this->session->setMessages(array('Post deleted!'));

		}catch(Exception $e) {
			$this->session->setErrors(array($e->getMessage()));
		}

		$this->goHome();
	}

	public function save() {

		$this->setRecord($this->get('POST'));
		$this->getRecord()->copyfrom('POST');
		$action = !$this->getRecord()->id ? 'add' : 'edit';

		try {
			if ($this->validate()) {
				$now = strtotime('now');
				$this->getRecord()->updated = $now;

				if (!$this->getRecord()->id) {
					$this->getRecord()->created = $now;
				}

				$this->getRecord()->save();
				$this->session->setMessages(array('Saved successfully!'));
				$this->goHome();
			}
		}catch(Exception $e) {
			$sh->setErrors(array($e->getMessage()));
		}

		$this->routeTo($action, $this->get('POST'));
	}
}