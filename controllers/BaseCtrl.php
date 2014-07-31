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
		$this->f3 = $f3;
		$this->db = $db ? $db : Db::create($this->f3);
		$this->session = $session ? $session : SessionHelper::create($this->f3);
	}

	public function beforeRoute() {
		$this->session->setNotifications();
		$this->session->clearNotifications();
	}

	public function afterRoute() {

		$this->f3 = $this->session->setNotifications();
		$this->f3->set('sh', $this->session);
		$this->session->clearNotifications();

		if (!$this->f3->get('title')) {
			$view_split = explode('/', $this->view);
			$view_name = str_replace('.php', '', array_pop($view_split));
			$this->f3->set('title', ucwords(strtolower($view_name)));
		}

		$viewer = View::instance();
		$view = strpos($this->view, '.php') !== false ? $this->view : $this->view . '.php';
		$layout = $this->layout !== null ? $this->layout : self::DEFAULT_LAYOUT;
		$this->f3->set('content_view', $view);
		echo $viewer->render($layout);
	}

	public function setRecord(array $request = null) {
		
		$request = !$request ? $this->f3->get('PARAMS') : $request;
		$record = $this->db->getQuery($this->table);

		if (!empty($request[$this->pk])) {
			$record = $record->load(array($this->pk . '=?', $request[$this->pk]));
		}

		$this->f3->set('record', $record);

		if (!$this->f3->get('record')) {
			$this->session->setErrors(array('Post #' . $request[$this->pk] . ' does not exist.'));
			$this->goHome();
		}
	}

	public function setRecords() {
		$records = $this->db->getQuery($this->table)
			->find(null, array('order' => 'id DESC'));

		$this->f3->set('records', $records);
	}

	public function routeTo($action = null, $params = array()) {
		$action = $action ? '/' . $action : '';
		$params = !empty($params) ? '?' . http_build_query($params) : '';
		$this->f3->reroute('/' .$this->home . $action . $params);
	}

	public function goHome() {
		$this->routeTo();
	}
}