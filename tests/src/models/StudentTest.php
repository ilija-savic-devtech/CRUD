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
}