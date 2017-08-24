<?php
/**
 * Created by PhpStorm.
 * User: ilija.savic
 * Date: 8/23/2017
 * Time: 3:33 PM
 */

namespace database;

class CrudDatabaseMongoDb implements CrudDatabaseInterface
{
	private $dbConnection;

	public function __construct($dbConnection)
	{
		$this->dbConnection = $dbConnection;
	}

	public function getAll(){
		$db = $this->dbConnection->test->user;
		$doc = $db->find();
		$this->dbConnection = null;
		return $doc;
	}

	public function getOne($id)
	{
		// TODO: Implement getOne() method.
	}

	public function delete($id)
	{
		// TODO: Implement delete() method.
	}

	public function update($id)
	{
		// TODO: Implement update() method.
	}

	public function create()
	{
		// TODO: Implement create() method.
	}

}