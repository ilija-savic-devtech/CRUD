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
	private static $conn;

	private function __construct()
	{
	}

	public static function connect()
	{
		if (self::$conn === null) {
			if (DATABASE_IN_USE == 'mysql') {
				try {
					self::$conn = new \PDO("mysql:host=" . SERVER_NAME . ";dbname=" . DB_NAME, USERNAME, PASSWORD);
					// set the PDO error mode to exception
					self::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

					return new CrudDatabaseMySql(self::$conn, new Student());
				} catch
				(\PDOException $e) {
					echo "Connection failed: " . $e->getMessage();
				}
			} elseif (DATABASE_IN_USE == 'mongodb') {
				self::$conn = new Manager(MONGODB_URI);

				return new CrudDatabaseMongoDb(self::$conn, new Student());
			} else {
				die("Not valid database is set!!!");
			}
		} else {
			return self::$conn;
		}
	}
}