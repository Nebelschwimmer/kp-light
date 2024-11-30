<?php

namespace App\Model\Response\Validation;

class ValidationErrorList
{
	/**
	 * @var ValidationError[]
	 */
	private array $validationErrors;

	/**
	 * @param string[] $validationErrors
	 */
	public function __construct(array $validationErrors)
	{
		$this->validationErrors = $validationErrors;
	}

	/**
	 * @return ValidationError[]
	 */
	public function getValidationErrors(): array
	{
		return $this->validationErrors;
	}
}
