<?php

namespace App\Service\Validator\Entity\Specialty;

use App\Model\Validation\ValidationRule;
use App\Service\Validator\Entity\EntityValidator;

class SpecialtyValidator extends EntityValidator
{
	public function rules(): array
	{
		return [
			new ValidationRule('name', $this->translate('specialty.name'), 'required'),
		];
	}
}
