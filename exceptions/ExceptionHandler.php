<?php
/**
 * Created by PhpStorm.
 * User: ilija.savic
 * Date: 8/30/2017
 * Time: 12:44 PM
 */
namespace exceptions;

use MongoDB\Driver\Exception\ConnectionTimeoutException;

class ExceptionHandler
{
	public function handle($exception){
		if($exception instanceof \PDOException){
			echo "MySql server not started..." . $exception->getMessage();
		} else if($exception->getPrevious() instanceof InvalidIdException){
			echo "Invalid id";
		} else if($exception->getPrevious() instanceof ConnectionTimeoutException){
			echo "MongoDb server not started";
		} else if($exception->getPrevious() instanceof EmptyTableException){
			echo "Table is empty";
		}

	}
}