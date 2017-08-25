<?php
/**
 * Created by PhpStorm.
 * User: ilija.savic
 * Date: 8/23/2017
 * Time: 3:33 PM
 */

namespace database;

use MongoDB\Driver\Query;
use src\Student;

class CrudDatabaseMongoDb implements CrudDatabaseInterface
{
	private $dbConnection;
	private $student;

	public function __construct($dbConnection, $student = array())
	{
		$this->student = $student;
		$this->dbConnection = $dbConnection;
	}

	public function getAll(){
		$query = new Query([]);
		$rows = $this->dbConnection->executeQuery("test.user", $query);
		$var = array();
		foreach ($rows as $row) {
			$this->student = new Student();
			$var[] = $this->student->setId($row->_id)->setName($row->name)->setSurname($row->surname)->setIndexNo($row->indexno)->setAddress($row->address);

		}
		$this->dbConnection = null;
		return $var;
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