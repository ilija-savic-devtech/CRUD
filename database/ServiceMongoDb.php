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
use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Manager;
use MongoDB\Driver\Query;
use src\Student;

class ServiceMongoDb implements ServiceInterface
{
    private $conn;

    public function __construct(Manager $conn)
    {
        $this->conn = $conn;
    }

    private final function autoIncrement(){
        $counter = 0;
        $query = new Query([]);
        $rows = $this->conn->executeQuery("test.user", $query)->toArray();
        if($rows == null) {
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


    public function getAll()
    {
        try {
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

            return $var;
        } catch (EmptyTableException $e) {
            echo $e->getMessage();

        }
    }

    public function getOne($id)
    {
        try {
            $filter = ["_id" => intval($id)];
            $options = [];
            $query = new Query($filter, $options);
            $rows = $this->conn->executeQuery("test.user", $query)->toArray();
            if ($rows == null) {
                throw new InvalidIdException("Invalid id");
            }
            $object = new Student();
            foreach ($rows as $row) {
                $object
                    ->setId($row->_id)
                    ->setName($row->name)
                    ->setSurname($row->surname)
                    ->setIndexNo($row->indexno)
                    ->setAddress($row->address);
            }

            return $object;
        } catch (InvalidIdException $e) {
            echo $e->getMessage();
        }
    }

    public function create()
    {
        $bulk = new BulkWrite();

        $doc = ['_id' => $this->autoIncrement(),'name' => $_POST['name'], 'surname' => $_POST['surname'], 'indexno' => $_POST['indexno'], 'address' => $_POST['address']];
        echo "<pre>";
        var_dump($doc);
        $bulk->insert($doc);
        $this->conn->executeBulkWrite('test.user', $bulk);

    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    public function update($id)
    {
        // TODO: Implement update() method.
    }

}