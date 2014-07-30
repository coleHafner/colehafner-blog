<?php

class BaseLib {

	/**
	 * f3 class.
	 * @var	Base
	 */
	protected $f3 = null;

	/**
	 * @var	\DB\SQL
	 */
	protected $db = null;

	/**
	 * @param Base	$f3
	 */
	public function __construct(Base $f3 = null) {
		$this->f3 = $f3;
		$this->db = $f3 ? Db::create($f3) : null;
	}

	/**
	 * @param	Base	$f3
	 * @return	BaseLib
	 */
	public function setF3(Base $f3) {
		$this->f3 = $f3;
		return $this;
	}

	/**
	 * @return	Base
	 */
	public function getF3() {
		return $this->f3;
	}

	/**
	 * @param	Base	$f3
	 * @return	BaseLib
	 */
	public function setDb(Base $f3 = null) {
		$f3 = $f3 === null ? $this->f3 : $f3;
		$this->db = Db::create($f3);
		return $this;
	}

	/**
	 * @param	Base	$f3
	 * @return
	 */
	public function getDb() {
		return $this->db;
	}
}
