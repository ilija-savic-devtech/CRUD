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
	private $conn;
	private $object;

	public function __construct($conn, $object)
	{
		$this->object = $object;
		$this->conn = $conn;
	}

	public function getAll(){
		$query = new Query([]);
		$rows = $this->conn->executeQuery("test.user", $query);
		$var = array();
		foreach ($rows as $row) {
			$this->object = new Student();
			$var[] = $this->object->setId($row->_id)->setName($row->name)->setSurname($row->surname)->setIndexNo($row->indexno)->setAddress($row->address);

		}
		$this->conn = null;
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