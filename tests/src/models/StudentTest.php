<?php

class StudentTest extends \PHPUnit\Framework\TestCase
{
    protected $student;

    public function setUp(){
        $this->student = new \models\Student();
    }

    public function testThatWeCanGetName(){
        $this->student->setName('Petar');
        $this->assertEquals($this->student->getName(),'Petar');
    }

    public function testThatWeCanGetSurname(){
        $this->student->setSurname('Petrovic');
        $this->assertEquals($this->student->getSurname(),'Petrovic');
    }

    public function testThatWeCanGetIndexNo(){
        $this->student->setIndexno(123456);
        $this->assertEquals($this->student->getIndexno(), 123456);
    }

    public function testThatWeCanGetAddress(){
        $this->student->setAddress('Petra Petrovica 17');
        $this->assertEquals($this->student->getAddress(),'Petra Petrovica 17');
    }


}