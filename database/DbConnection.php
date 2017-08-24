<?php
/**
 * Created by PhpStorm.
 * User: ilija.savic
 * Date: 8/24/2017
 * Time: 11:02 AM
 */

namespace database;

use MongoDB\Client;

class DbConnection
{

	public function connect(){
		if(DATABASE_IN_USE == 'mysql'){
			try
			{
				$conn = new \PDO("mysql:host=". SERVER_NAME .";dbname=". DB_NAME, USERNAME, PASSWORD);
				// set the PDO error mode to exception
				$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
				echo "Connected successfully";

				return new CrudDatabaseMySql($conn);
			}

			catch
			(\PDOException $e)
			{
				echo "Connection failed: " . $e->getMessage();
			}
		} elseif (DATABASE_IN_USE == 'mongodb'){
			$conn = new Client();
			return new CrudDatabaseMongoDb($conn);
		} else {
			die("Not valid database is set!!!");
		}
	}
}