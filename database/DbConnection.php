<?php
/**
 * Created by PhpStorm.
 * User: ilija.savic
 * Date: 8/24/2017
 * Time: 11:02 AM
 */

namespace database;

use MongoDB\Driver\Manager;
use src\Student;

class DbConnection
{
	private $conn;
	private $crud;
	private static $instance = null;

	public static function getInstance()
	{
		if (self::$instance == null) {
			self::$instance = new DbConnection();
		}

		return self::$instance;
	}

	public function connect($modelObject)
	{
		if ($this->conn == null) {
			if (DATABASE_IN_USE == 'mysql') {
				try {
					$this->conn = new \PDO("mysql:host=" . SERVER_NAME . ";dbname=" . DB_NAME, USERNAME, PASSWORD);
					// set the PDO error mode to exception
					$this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
					$this->crud = new CrudDatabaseMySql($this->conn, $modelObject);

					return $this->crud;
				} catch
				(\PDOException $e) {
					echo "Connection failed: " . $e->getMessage();
				}
			} elseif (DATABASE_IN_USE == 'mongodb') {
				$this->conn = new Manager(MONGODB_URI);
				$this->crud = new CrudDatabaseMongoDb($this->conn, $modelObject);

				return $this->crud;
			} else {
				die("Not valid database is set!!!");
			}
		} else {
			return $this->crud;
		}
	}

	private function __construct()
	{
	}

	private function __clone()
	{
	}
}