<?php

namespace App\Service\Validator\Entity;

use App\Entity\BaseEntity;
use App\Model\Response\Validation\ValidationError;
use App\Model\Response\Validation\ValidationErrorList;
use App\Model\Validation\ValidationRule;
use Rakit\Validation\Validator;
use App\Exception\ValidatorException;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class EntityValidator
{
	protected array $errors = [];
	protected array $customValidators = [];
	protected array $messages = [
		'required' => 'This field is required',
		'email' => ':attribute is not a valid email',
		'url' => 'Format :attribute is not valid',
		'ip' => ':attribute is not a valid ip',
		'between' => 'The value must be between :min and :max',
		'digits' => 'The value must be :length цифр',
	];

	public function __construct(
		protected Validator $validator,
		protected TranslatorInterface $translator
	) {
		$this->validator->setMessages($this->messages);

		$this->setCustomValidators();
	}

	public function getErrors(): ValidationErrorList
	{
		$errors = [];

		foreach ($this->errors as $name => $message) {
			$errors[] = new ValidationError($name, [$message]);
		}

		return new ValidationErrorList($errors);
	}

	public function validate(array|object $data, array $excludeProperties = [], ?BaseEntity $entity = null)
	{
		$data = is_object($data) ? (array) $data : $data;
		$messages = $this->getMessages();
		$validatorRules = $this->getRules($entity);

		$rules = $this->createValidatorRules($validatorRules, $excludeProperties);
		$aliases = $this->createValidatorAliases($validatorRules);

		$validation = $this->validator->make($data, $rules, $messages);
		$validation->setAliases($aliases);

		$validation->validate();

		if ($validation->fails()) {
			$errors = $validation->errors();

			$this->errors = $errors->firstOfAll();

			throw new ValidatorException();
		}
	}


	protected function setCustomValidators(): void
	{
		foreach ($this->customValidators as $name => $className) {
			$this->validator->addValidator($name, new $className());
		}
	}

	protected function getMessages(): array
	{
		return [];
	}

	protected function translate(string $key, ?string $domain = null)
	{
		return $this->translator->trans($key, domain: $domain);
	}
	protected function internalRules(?BaseEntity $entity = null): array
	{
		return [];
	}

	private function getRules(?BaseEntity $entity = null): array
	{
		$rules = [
			...$this->rules(),
			...$this->internalRules($entity),
		];

		$validatorRules = [];

		/** @var ValidationRule $rule */
		foreach ($rules as $rule) {
			if (!isset($validatorRules[$rule->getProperty()])) {
				$validatorRules[$rule->getProperty()] = $rule;
			} else {
				$validatorRules[$rule->getProperty()]->addRule($rule->getRule());
			}
		}

		return $validatorRules;
	}

	private function createValidatorRules(array $validatorRules, array $excludeProperties = [])
	{
		$rules = array_reduce($validatorRules, function ($acc, ValidationRule $cur) {
			$acc[$cur->property] = $cur->rule;

			return $acc;
		}, []);

		return array_filter($rules, function ($key) use ($excludeProperties) {
			if (in_array($key, $excludeProperties)) {
				return false;
			}

			return true;
		}, ARRAY_FILTER_USE_KEY);
	}

	private function createValidatorAliases(array $validatorRules)
	{
		return array_reduce($validatorRules, function ($acc, $cur) {
			$acc[$cur->property] = $cur->propertyName;

			return $acc;
		}, []);
	}

	abstract public function rules(): array;
}
