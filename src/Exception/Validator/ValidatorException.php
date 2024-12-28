<?php

namespace App\Exception;

class ValidatorException extends \Exception
{
	public function __construct()
	{
		parent::__construct('Validation error');
	}
}
