<?php
/**
 * Created by PhpStorm.
 * User: ilija.savic
 * Date: 8/23/2017
 * Time: 2:49 PM
 */

namespace database;

class MySqlConnection implements DbConnectionInterface
{
		private $servername = 'localhost:3306';
		private $username = 'root';
		private $password = 'NoIdea(*(989';
		private $dbName = 'guest';

		public function connect()
		{
			try
			{
				$conn = new \PDO("mysql:host=$this->servername;dbname=$this->dbName", $this->username, $this->password);
				// set the PDO error mode to exception
				$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
				echo "Connected successfully";
				return $conn;
			}

			catch
			(\PDOException $e)
			{
				echo "Connection failed: " . $e->getMessage();
			}

		}


}