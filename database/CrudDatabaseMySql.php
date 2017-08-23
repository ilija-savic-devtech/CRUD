<?php

namespace database;

class CrudDatabaseMySql
{
	private $dbConnection;

	public function __construct(DbConnectionInterface $dbConnection)
	{
		$this->dbConnection = $dbConnection;
	}

	public function getAll(){
		$conn = $this->dbConnection->connect();
		$sql = $conn->prepare("SELECT * FROM guest.student");
		$sql->execute();
		$row = $sql->fetch();
		echo"<pre>";
		print_r($row);
		echo "Get All<br>";
		$conn = null;
	}

	public function getOne(){
		echo "Get One<br>";
	}
}