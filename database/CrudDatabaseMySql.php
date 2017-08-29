<?php

namespace database;

use src\Student;

class CrudDatabaseMySql implements CrudDatabaseInterface
{
	private $conn;
	private $object;

	public function __construct($conn, $object)
	{
		$this->object = $object;
		$this->conn = $conn;
	}

	public function getAll()
	{
		$sql = $this->conn->prepare("SELECT * FROM guest.student");
		$sql->execute();
		$var = array();
		foreach ($sql->fetchAll() as $row => $value) {
			$this->object = new Student();
			$var[] = $this->object->setId($value['id'])->setName($value['name'])->setSurname($value['surname'])->setIndexNo($value['indexno'])->setAddress($value['address']);
		}
		$this->conn = null;

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