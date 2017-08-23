<?php


namespace database;

class MongoDbConnection implements DbConnectionInterface
{
	public function connect()
	{
		$conn = new \MongoClient();
		return $conn;
	}
}