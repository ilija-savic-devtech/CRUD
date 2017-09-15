<?php

/**
 * Created by PhpStorm.
 * User: ilija.savic
 * Date: 9/13/2017
 * Time: 12:55 PM
 */
namespace testservice;

use database\DbConnection;
use Katzgrau\KLogger\Logger;
use PHPUnit\Framework\TestCase;
use service\ServiceMySql;
use models\Student;

class ServiceMySqlTest extends TestCase
{
    public function testGetAll(){

        $mockDatabase= \Mockery::mock('database\DbConnection');
        $mockPdo = \Mockery::mock('PDO');
        $logger = new Logger('logs');
        $stmtMock = \Mockery::mock('PDOStatement');

        //Data for comparing return value from getAll method
        $student = new Student();
        $student->setId(1)->setName("Petar")->setSurname("Petrovic")->setIndexNo("123456")->setAddress("Njegoseva 14");
        $student2 = new Student();
        $student2->setId(2)->setName("Sava")->setSurname("Savanovic")->setIndexNo("789456")->setAddress("Savina 19");
        $array[0] = $student;
        $array[1] = $student2;
        //Data for returning from fetchAll method from PDOStatement object
        $rowset[0] = ['id'=>1, 'name'=>'Petar', 'surname'=>'Petrovic', 'indexno'=>123456, 'address'=>'Njegoseva 14'];
        $rowset[1] = ['id'=>2, 'name'=>'Sava', 'surname'=>'Savanovic', 'indexno'=>789456, 'address'=>'Savina 19'];

        $stmtMock->shouldReceive('execute')->andReturn(true);
        $stmtMock->shouldReceive('fetchAll')->andReturn($rowset);

        $mockDatabase->shouldReceive('connectMySql')->andReturn($mockPdo);
        $mockDatabase->shouldReceive('prepare')->andReturn($stmtMock);

        $service = new ServiceMySql($mockDatabase, $logger);

        $this->assertEquals($array,  $service->getAll());
    }

    public function testGetOne(){
        //Mock Objects
        $mockDatabase= \Mockery::mock('database\DbConnection');
        $mockPdo = \Mockery::mock('PDO');
        $logger = new Logger('logs');
        $stmtMock = \Mockery::mock('PDOStatement');

        //Data for comparing return value from getOne method
        $student = new Student();
        $student->setId(1)->setName("Petar")->setSurname("Petrovic")->setIndexNo("123456")->setAddress("Njegoseva 14");
        $student2 = new Student();
        $student2->setId(2)->setName("Sava")->setSurname("Savanovic")->setIndexNo("789456")->setAddress("Savina 19");
        $array[0] = $student;
        $array[1] = $student2;
        //Data for returning from fetchAll method from PDOStatement object
        $rowset[0] = ['id'=>1, 'name'=>'Petar', 'surname'=>'Petrovic', 'indexno'=>123456, 'address'=>'Njegoseva 14'];
        $rowset[1] = ['id'=>2, 'name'=>'Sava', 'surname'=>'Savanovic', 'indexno'=>789456, 'address'=>'Savina 19'];

        $stmtMock->shouldReceive('execute')->andReturn(true);
        $stmtMock->shouldReceive('bindParam')->andReturn(true);
        $stmtMock->shouldReceive('fetch')->andReturn($rowset[0]);

        $mockDatabase->shouldReceive('connectMySql')->andReturn($mockPdo);
        $mockDatabase->shouldReceive('prepare')->andReturn($stmtMock);

        $service = new ServiceMySql($mockDatabase, $logger);

        $this->assertEquals($student, $service->getOne(1));
    }
}