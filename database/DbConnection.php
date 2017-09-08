<?php
/**
 * Created by PhpStorm.
 * User: ilija.savic
 * Date: 8/24/2017
 * Time: 11:02 AM
 */

namespace database;

use Katzgrau\KLogger\Logger;
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


	/**
	 * Connection for MySQL
	 * @param Logger $logger
	 * @return \PDO
     */
	public function connectMySql(Logger $logger)
	{
		try {

			$logger->info("Trying to connect to MySQL database");
			$this->conn = new \PDO("mysql:host=" . SERVER_NAME . ";dbname=" . DB_NAME, USERNAME, PASSWORD);
			// set the PDO error mode to exception
			$this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			$logger->info("Connected successfully");
			return $this->conn;
		} catch (\PDOException $e){
			$logger->warning("Connection to MySQL failed");
			echo "Connection failed: " . $e->getMessage();
		}
	}

	/**
	 * Connection for MongoDB
	 * @param Logger $logger
	 * @return Manager
     */
	public function connectMongoDb(Logger $logger)
	{
		try {
			$logger->info("Trying to connect to MongoDB database");
			$this->conn = new Manager(MONGODB_URI);
			$logger->info("Connected successfully");
			return $this->conn;
		} catch(\MongoConnectionException $e){
			$logger->warning("Connection to MongoDB failed");
			echo "Connection failed: " . $e->getMessage();
		}
	}

	private function __construct()
	{
	}

	private function __clone()
	{
	}
}