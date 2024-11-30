<?php

namespace App\Service\Validator\Entity\Person;

use App\Model\Validation\ValidationRule;
use App\Service\Validator\Entity\EntityValidator;

class PersonValidator extends EntityValidator
{
	public function rules(): array
	{
		return [
			new ValidationRule('firstname', $this->translate('person.firstname'), 'required'),
		];
	}
}
