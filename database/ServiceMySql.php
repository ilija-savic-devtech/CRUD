<?php

namespace database;

use exceptions\EmptyTableException;
use exceptions\InvalidIdException;
use src\Student;

class ServiceMySql implements ServiceInterface
{
	private $conn;

	public function __construct($conn)
	{
		$this->conn = $conn;
	}

	public function getAll()
	{
		$sql = $this->conn->prepare("SELECT * FROM guest.student");
		$sql->execute();
		$var = array();
		foreach ($sql->fetchAll() as $row => $value) {
			$object = new Student();
			$var[] = $object
				->setId($value['id'])
				->setName($value['name'])
				->setSurname($value['surname'])
				->setIndexNo($value['indexno'])
				->setAddress($value['address']);
		}
		$sql = null;

		return $var;
	}

	public function getOne($id)
	{
		$sql = $this->conn->prepare("SELECT * FROM guest.student WHERE id=" . $id . " LIMIT 1");
		$sql->execute();
		$row = $sql->fetch();
		$object = new Student();
		$object
			->setId($row['id'])
			->setName($row['name'])
			->setSurname($row['surname'])
			->setIndexNo($row['indexno'])
			->setAddress($row['address']);

		return $object;
	}

	public function delete($id)
	{

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