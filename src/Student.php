<?php
/**
 * Created by PhpStorm.
 * User: ilija.savic
 * Date: 8/24/2017
 * Time: 9:48 AM
 */

namespace src;

class Student
{
	private $id;
	private $name;
	private $surname;
	private $indexNo;
	private $address;

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param mixed $id
	 * @return Student
	 */
	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param mixed $name
	 * @return Student
	 */
	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getSurname()
	{
		return $this->surname;
	}

	/**
	 * @param mixed $surname
	 * @return Student
	 */
	public function setSurname($surname)
	{
		$this->surname = $surname;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getIndexNo()
	{
		return $this->indexNo;
	}

	/**
	 * @param mixed $indexNo
	 * @return Student
	 */
	public function setIndexNo($indexNo)
	{
		$this->indexNo = $indexNo;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getAddress()
	{
		return $this->address;
	}

	/**
	 * @param mixed $address
	 * @return Student
	 */
	public function setAddress($address)
	{
		$this->address = $address;

		return $this;
	}

}