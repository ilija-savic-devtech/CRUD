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

    private final function putValues($id, $data){
        $putValues = array();
        $idValues = $this->checkId($id);

        (!empty($data['name'])) ? $putValues['name'] = $data['name'] : $putValues['name'] = $idValues['name'];
        (!empty($data['surname'])) ? $putValues['surname'] = $data['surname'] : $putValues['surname'] = $idValues['surname'];
        (!empty($data['indexno'])) ? $putValues['indexno'] = $data['indexno'] : $putValues['indexno'] = $idValues['indexno'];
        (!empty($data['address'])) ? $putValues['address'] = $data['address'] : $putValues['address'] = $idValues['address'];

        return $putValues;

    }

    private final function checkId($id){
        $sql = $this->conn->prepare("SELECT * FROM guest.student WHERE id=" . $id . " LIMIT 1");
        $sql->execute();
        $row = $sql->fetch();
        if ($row == null) {
            throw new InvalidIdException("Invalid id");
        } else {
            return $row;
        }
    }

    public function getAll()
    {
        try {
            $sql = $this->conn->prepare("SELECT * FROM guest.student");
            $sql->execute();
            $rows = $sql->fetchAll();
            if ($rows == null) {
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
        } catch (EmptyTableException $e) {
            echo $e->getMessage();
        }
    }

    public function getOne($id)
    {
        try {
            $row = $this->checkId($id);

            $object = new Student();
            $object
                ->setId($row['id'])
                ->setName($row['name'])
                ->setSurname($row['surname'])
                ->setIndexNo($row['indexno'])
                ->setAddress($row['address']);

            return $object;
        } catch (InvalidIdException $e) {
            echo $e->getMessage();
        }
    }

    public function create()
    {
        try {
            $sql = $this->conn->prepare("INSERT INTO guest.student(name, surname, indexno, address) VALUES (:name, :surname, :indexno, :address)");

            $sql->bindParam(':name', $_POST['name']);
            $sql->bindParam(':surname', $_POST['surname']);
            $sql->bindParam(':indexno', $_POST['indexno']);
            $sql->bindParam(':address', $_POST['address']);

            $sql->execute();
            echo "Resource successfully created";
        } catch (\Exception $e) {
            echo "Error creating resource: " . $e->getMessage();
        }
    }

    public function update($id, $data)
    {
        try {
            $this->checkId($id);

            $putValues = $this->putValues($id, $data);

            $query = "UPDATE guest.student SET name = :name, surname = :surname, indexno = :indexno, address = :address WHERE id = " . $id;
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":name", $putValues["name"]);
            $stmt->bindParam(":surname", $putValues["surname"]);
            $stmt->bindParam(":indexno", $putValues["indexno"]);
            $stmt->bindParam(":address", $putValues["address"]);

            $stmt->execute();
            echo "Resource successfully updated";


        } catch (InvalidIdException $e){
            echo "Error: " . $e->getMessage();
        } catch (\Exception $e) {
            echo "Error updating resource: " . $e->getMessage();
        }
    }

    public function delete($id)
    {

    }
}