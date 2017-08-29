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

class ServiceMongoDb implements ServiceInterface
{
	private $conn;

	public function __construct($conn)
	{
		$this->conn = $conn;
	}

	public function getAll()
	{
		$query = new Query([]);
		$rows = $this->conn->executeQuery("test.user", $query);
		echo "<pre>";
		print_r($rows);
		$var = array();
		foreach ($rows as $row) {
			$object = new Student();
			$var[] = $object
				->setId($row->_id)
				->setName($row->name)
				->setSurname($row->surname)
				->setIndexNo($row->indexno)
				->setAddress($row->address);
		}
		$this->conn = null;

		return $var;
	}

	public function getOne($id)
	{
		$filter = ["_id" => intval($id)];
		$options = [];
		$query = new Query($filter, $options);
		$rows = $this->conn->executeQuery("test.user", $query);
		$var[] = array();
		$object = new Student();
		foreach ($rows as $row) {
			$object
				->setId($row->_id)
				->setName($row->name)
				->setSurname($row->surname)
				->setIndexNo($row->indexno)
				->setAddress($row->address);
			var_dump($object);
		}
		$this->conn = null;

		return $object;
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