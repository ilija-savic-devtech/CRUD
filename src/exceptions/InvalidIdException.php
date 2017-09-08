<?php
/**
 * Created by PhpStorm.
 * User: ilija.savic
 * Date: 8/30/2017
 * Time: 1:44 PM
 */

namespace exceptions;

use Throwable;

class InvalidIdException extends \Exception
{
	public function __construct($message)
	{
		parent::__construct($message);
	}
}