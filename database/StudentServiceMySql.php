<?php

namespace database;

use src\Student;

class StudentServiceMySql implements StudentServiceInterface
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

	public function getOne($id)
	{
		echo "Get One<br>";
	}

}