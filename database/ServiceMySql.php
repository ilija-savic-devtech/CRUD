<?php

namespace database;

use exceptions\EmptyTableException;
use exceptions\InvalidIdException;
use src\Student;

class ServiceMySql implements ServiceInterface
{
	private $conn;

	public function __construct(\PDO $conn)
	{
		$this->conn = $conn;
	}

	public function getAll()
	{
		try {
			$sql = $this->conn->prepare("SELECT * FROM guest.student");
			$sql->execute();
			$rows = $sql->fetchAll();
			if($rows == null){
				throw new EmptyTableException("Table is empty");
			}
			$var = array();
			foreach ($rows as $row => $value) {
				$object = new Student();
				$var[] = $object
					->setId($value['id'])
					->setName($value['name'])
					->setSurname($value['surname'])
					->setIndexNo($value['indexno'])
					->setAddress($value['address']);
			}

			return $var;
		} catch (EmptyTableException $e){
			echo $e->getMessage();
		}
	}

	public function getOne($id)
	{
		try {
			$sql = $this->conn->prepare("SELECT * FROM guest.student WHERE id=" . $id . " LIMIT 1");
			$sql->execute();
			$row = $sql->fetch();
			if($row == null){
				throw new InvalidIdException("Invalid id");
			}
			$object = new Student();
			$object
				->setId($row['id'])
				->setName($row['name'])
				->setSurname($row['surname'])
				->setIndexNo($row['indexno'])
				->setAddress($row['address']);

			return $object;
		} catch (InvalidIdException $e){
			echo $e->getMessage();
		}
	}

	public function create($name, $surname, $indexno, $address)
	{
		$sql = $this->conn->prepare("INSERT INTO guest.student(name, surname, indexno, address) VALUES (:name, :surname, :indexno, :address)");

		$sql->bindParam(':name', $name);
		$sql->bindParam(':surname', $surname);
		$sql->bindParam(':indexno', $indexno);
		$sql->bindParam(':address', $address);

		$sql->execute();
	}

	public function delete($id)
	{

	}

	public function update($id)
	{
		// TODO: Implement update() method.
	}

}