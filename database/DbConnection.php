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

	public function connect()
	{
		if (DATABASE_IN_USE == 'mysql') {
			try {
				$conn = new \PDO("mysql:host=" . SERVER_NAME . ";dbname=" . DB_NAME, USERNAME, PASSWORD);
				// set the PDO error mode to exception
				$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
				echo "Connected successfully";

				return new CrudDatabaseMySql($conn, new Student());
			} catch
			(\PDOException $e) {
				echo "Connection failed: " . $e->getMessage();
			}
		} elseif (DATABASE_IN_USE == 'mongodb') {
			$conn = new Manager(MONGODB_URI);

			return new CrudDatabaseMongoDb($conn, new Student());
		} else {
			die("Not valid database is set!!!");
		}
	}
}