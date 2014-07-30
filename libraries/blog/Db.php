<?php

class Db {

	/**
	 * @var	\DB\SQL
	 */
	private $conn = null;

	/**
	 * @param Base $f3
	 */
	public function __construct(Base $f3) {
		$this->conn = $f3->get('CONN');
	}

	/**
	 * Returns a query object for the table passed.
	 * @param	string		$table
	 * @return	\DB\SQL\Mapper
	 */
	public function getQuery($table) {

		if (!$this->conn) {
			throw new RuntimeException('Error: Connection not found. Cannot continue.');
		}

		return new \DB\SQL\Mapper($this->conn, $table);
	}

	/**
	 * @param	Base		$f3
	 * @param	\DB\SQL		$conn		optional connection override for queries
	 * @return	Db
	 */
	public static function create(Base $f3, \DB\SQL $conn = null) {
		$db = new Db($f3);

		if ($conn) {
			$this->conn = $conn;
		}

		return $db;
	}
}