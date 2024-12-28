<?php

namespace App\Service\Validator\Entity\Film;

use App\Model\Validation\ValidationRule;
use App\Service\Validator\Entity\EntityValidator;

class FilmValidator extends EntityValidator
{
	public function rules(): array
	{
		return [
			new ValidationRule('name', $this->translate('film.name'), 'required'),
		];

	}
}
