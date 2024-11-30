<?php

namespace App\Service\Validator\Entity\Genre;

use App\Model\Validation\ValidationRule;
use App\Service\Validator\Entity\EntityValidator;

class GenreValidator extends EntityValidator
{
	public function rules(): array
	{
		return [
			new ValidationRule('name', $this->translate('genre.name'), 'required'),
		];
	}
}
