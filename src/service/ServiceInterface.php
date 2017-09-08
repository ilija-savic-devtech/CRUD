<?php
/**
 * Created by PhpStorm.
 * User: ilija.savic
 * Date: 8/24/2017
 * Time: 9:42 AM
 */

namespace service;

interface ServiceInterface
{
	public function getOne($id);
	public function getAll();
	public function delete($id);
	public function update($id, $putData);
	public function create();
}