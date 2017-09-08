<?php
/**
 * Created by PhpStorm.
 * User: ilija.savic
 * Date: 8/23/2017
 * Time: 3:33 PM
 */

namespace database;

use exceptions\EmptyTableException;
use exceptions\InvalidIdException;
use Katzgrau\KLogger\Logger;
use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Manager;
use MongoDB\Driver\Query;
use src\Student;

/**
 * Class ServiceMongoDb
 * @package database
 */
class ServiceMongoDb implements ServiceInterface
{
    private $conn;
    private $logger;

    public function __construct(Manager $conn, Logger $logger)
    {
        $this->logger = $logger;
        $this->conn = $conn;
    }


    /**
     * Store PUT resources in array
     * @param $data
     * @return array
     */
    private final function putValues($data)
    {
        $q = array();
        if (trim($data["name"]) !== "") {
            $q['name'] = $data['name'];
        }
        if (trim($data["surname"]) !== "") {
            $q['surname'] = $data['surname'];
        }
        if (trim($data["indexno"]) !== "") {
            $q['indexno'] = $data['indexno'];
        }
        if (trim($data["address"]) !== "") {
            $q['address'] = $data['address'];
        }
        return $q;
    }

    /**
     * Checking if Id exists
     * @param $id
     * @return array
     * @throws InvalidIdException
     */
    private final function checkId($id)
    {
        $filter = ["_id" => intval($id)];
        $options = [];
        $query = new Query($filter, $options);
        $rows = $this->conn->executeQuery("test.user", $query)->toArray();
        if ($rows == null) {
            throw new InvalidIdException("Invalid id");
        } else {
            return $rows;
        }
    }

    /**
     * Autoincrement Id for MongoDB
     * @return int|mixed
     */
    private final function autoIncrement()
    {
        $counter = 0;
        $query = new Query([]);
        $rows = $this->conn->executeQuery("test.user", $query)->toArray();
        if ($rows == null) {
            $counter++;
            return $counter;
        } else {
            $stack = new \SplStack();
            foreach ($rows as $row) {
                $stack->push($row->_id);
            }
            $counter = $stack->pop() + 1;
            return $counter;
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
            $query = new Query([]);
            $rows = $this->conn->executeQuery("test.user", $query)->toArray();
            if ($rows == null) {
                throw new EmptyTableException("Table is empty");
            }
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
            $rows = $this->checkId($id);

            $object = new Student();
            foreach ($rows as $row) {
                $object
                    ->setId($row->_id)
                    ->setName($row->name)
                    ->setSurname($row->surname)
                    ->setIndexNo($row->indexno)
                    ->setAddress($row->address);
            }
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
            $bulk = new BulkWrite();

            $doc = [
                '_id' => $this->autoIncrement(),
                'name' => $_POST['name'],
                'surname' => $_POST['surname'],
                'indexno' => $_POST['indexno'],
                'address' => $_POST['address']
            ];
            $bulk->insert($doc);
            $this->conn->executeBulkWrite('test.user', $bulk);
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

            $putValues = $this->putValues($data);
            if ($putValues > 0) {
                $bulk = new BulkWrite();

                $bulk->update(['_id' => intval($id)], ['$set' => $putValues]);

                $this->conn->executeBulkWrite('test.user', $bulk);
                echo "Resource successfully updated";
                $this->logger->info("Updating resource successful in database table");
            }
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

            $bulk = new BulkWrite();

            $bulk->delete(['_id' => intval($id)]);

            $this->conn->executeBulkWrite('test.user', $bulk);
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