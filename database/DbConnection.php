<?php
/**
 * Created by PhpStorm.
 * User: ilija.savic
 * Date: 8/24/2017
 * Time: 11:02 AM
 */

namespace database;

use MongoDB\Driver\Manager;

class DbConnection
{
	private $conn;
	private static $instance = null;

	public static function getInstance()
	{
		if (self::$instance == null) {
			self::$instance = new DbConnection();
		}

		return self::$instance;
	}

	public function connectMySql()
	{
		try {
			$this->conn = new \PDO("mysql:host=" . SERVER_NAME . ";dbname=" . DB_NAME, USERNAME, PASSWORD);
			// set the PDO error mode to exception
			$this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

			return $this->conn;
		} catch
		(\PDOException $e) {
			echo "Connection failed: " . $e->getMessage();
		}
	}

	public function connectMongoDb()
	{
		$this->conn = new Manager(MONGODB_URI);

		return $this->conn;
	}

	private function __construct()
	{
	}

	private function __clone()
	{
	}
}