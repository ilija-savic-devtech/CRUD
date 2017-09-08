<?php
/**
 * Created by PhpStorm.
 * User: ilija.savic
 * Date: 8/30/2017
 * Time: 3:30 PM
 */

namespace exceptions;


use Throwable;

class EmptyTableException extends \Exception
{
	public function __construct($message)
	{
		parent::__construct($message);
	}
}