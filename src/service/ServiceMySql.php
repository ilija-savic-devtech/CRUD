<?php

namespace service;

use exceptions\EmptyTableException;
use exceptions\InvalidIdException;
use Katzgrau\KLogger\Logger;
use models\Student;

/**
 * Class ServiceMySql
 * @package database
 */
class ServiceMySql implements ServiceInterface
{
    private $conn;
    private $logger;

    public function __construct(\PDO $conn, Logger $logger)
    {
        $this->logger = $logger;
        $this->conn = $conn;
    }

    /**
     * Store PUT resources in array
     * @param $id
     * @param $data
     * @return array
     * @throws InvalidIdException
     */
    private final function putValues($id, $data)
    {

        $putValues = array();
        $idValues = $this->checkId($id);

        (!empty($data['name'])) ? $putValues['name'] = $data['name'] : $putValues['name'] = $idValues['name'];
        (!empty($data['surname'])) ? $putValues['surname'] = $data['surname'] : $putValues['surname'] = $idValues['surname'];
        (!empty($data['indexno'])) ? $putValues['indexno'] = $data['indexno'] : $putValues['indexno'] = $idValues['indexno'];
        (!empty($data['address'])) ? $putValues['address'] = $data['address'] : $putValues['address'] = $idValues['address'];

        return $putValues;

    }

    /**
     * Checking if Id exists
     * @param $id
     * @return mixed
     * @throws InvalidIdException
     */
    private final function checkId($id)
    {
        $sql = $this->conn->prepare("SELECT * FROM guest.student WHERE id = :id LIMIT 1");
        $sql->bindParam(":id", $id);
        $sql->execute();
        $row = $sql->fetch();
        if ($row == null) {
            throw new InvalidIdException("Invalid id");
        } else {
            return $row;
        }
    }

    /**
     * Get all resources
     * @return array
     */
    public function getAll()
    {
        try {
            $this->logger->info("Trying to get all resources from database table");
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
            $this->logger->info("Getting all resources successful");
            return $var;
        } catch (EmptyTableException $e) {
            $this->logger->warning("Empty table error");
            echo $e->getMessage();
        }
    }

    /**
     * Get one resource
     * @param $id
     * @return Student
     */
    public function getOne($id)
    {
        try {
            $this->logger->info("Trying to get one resource from database table");
            $row = $this->checkId($id);

            $object = new Student();
            $object
                ->setId($row['id'])
                ->setName($row['name'])
                ->setSurname($row['surname'])
                ->setIndexNo($row['indexno'])
                ->setAddress($row['address']);
            $this->logger->info("Getting one resource successful");
            return $object;
        } catch (InvalidIdException $e) {
            $this->logger->warning("ID doesn't exist in database table");
            echo $e->getMessage();
        }
    }

    /**
     * Creation of a resource
     */
    public function create()
    {
        try {
            $this->logger->info("Trying to create resource in database table");
            $sql = $this->conn->prepare("INSERT INTO guest.student(name, surname, indexno, address) VALUES (:name, :surname, :indexno, :address)");

            $sql->bindParam(':name', $_POST['name']);
            $sql->bindParam(':surname', $_POST['surname']);
            $sql->bindParam(':indexno', $_POST['indexno']);
            $sql->bindParam(':address', $_POST['address']);

            $sql->execute();
            echo "Resource successfully created";
            $this->logger->info("Creating resource successful");
        } catch (\Exception $e) {
            $this->logger->warning("Error creating resource in database table");
            echo "Error creating resource: " . $e->getMessage();
        }
    }

    /**
     * Update of a resource
     * @param $id
     * @param $data
     */
    public function update($id, $data)
    {
        try {
            $this->logger->info("Trying to update resource in database table");
            $this->checkId($id);

            $putValues = $this->putValues($id, $data);

            $query = "UPDATE guest.student SET name = :name, surname = :surname, indexno = :indexno, address = :address WHERE id = :id";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":name", $putValues["name"]);
            $stmt->bindParam(":surname", $putValues["surname"]);
            $stmt->bindParam(":indexno", $putValues["indexno"]);
            $stmt->bindParam(":address", $putValues["address"]);

            $stmt->execute();
            echo "Resource successfully updated";
            $this->logger->info("Updating resource successful in database table");

        } catch (InvalidIdException $e) {
            $this->logger->warning("ID doesn't exist in database table");
            echo "Error: " . $e->getMessage();
        } catch (\Exception $e) {
            $this->logger->warning("Error updating resource in database table");
            echo "Error updating resource: " . $e->getMessage();
        }
    }

    /**
     * Deletion of a resource
     * @param $id
     */
    public function delete($id)
    {
        try {
            $this->logger->info("Trying to delete resource from database table");
            $this->checkId($id);

            $query = "DELETE FROM guest.student WHERE id = :id";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":id", $id);

            $stmt->execute();
            echo "Resource successfully deleted";
            $this->logger->info("Deleting resource successful from database table");
        } catch (InvalidIdException $e) {
            $this->logger->warning("ID doesn't exist in database table");
            echo "Error: " . $e->getMessage();
        } catch (\Exception $e) {
            $this->logger->warning("Error deleting resource from database table");
            echo "Error: " . $e->getMessage();
        }
    }
}