<?php


namespace database;

use MongoDB\Client;

class MongoDbConnection implements DbConnectionInterface
{
	public function connect()
	{
		$conn = new Client();
		return $conn;
	}
}