<?php

namespace database;

use src\Student;

class CrudDatabaseMySql implements CrudDatabaseInterface
{
	private $dbConnection;
	private $student;

	public function __construct($dbConnection, $student = array())
	{
		$this->student = $student;
		$this->dbConnection = $dbConnection;
	}

	public function getAll(){
		$sql = $this->dbConnection->prepare("SELECT * FROM guest.student");
		$sql->execute();
		$var = array();
		foreach ($sql->fetchAll() as $row) {
			$this->student = new Student();
			$var[] = $this->student->setId($row['id'])->setName($row['name'])->setSurname($row['surname'])->setIndexNo($row['indexno'])->setAddress($row['address']);
		}
		$this->dbConnection = null;
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

	public function getOne($id){
		echo "Get One<br>";
	}

}