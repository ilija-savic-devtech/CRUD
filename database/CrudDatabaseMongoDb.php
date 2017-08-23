<?php
/**
 * Created by PhpStorm.
 * User: ilija.savic
 * Date: 8/23/2017
 * Time: 3:33 PM
 */

namespace database;

class CrudDatabaseMongoDb
{
	private $dbConnection;

	public function __construct(DbConnectionInterface $dbConnection)
	{
		$this->dbConnection = $dbConnection;
	}

	public function getAll(){
		$conn = $this->dbConnection->connect();
		$db = $conn->test->user;
		foreach($db as $key => $item){
			$doc[$key] = $key;
			$doc[$item] = $item;
		}
		$doc = $db->find();
		echo "<pre>";
		print_r($doc);
	}

}