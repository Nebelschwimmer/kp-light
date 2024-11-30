<?php

namespace App\Model\Validation;

class ValidationRule
{
	public function __construct(
		public string $property,
		public string $propertyName,
		public string $rule,
	) {
	}

	public function getProperty()
	{
		return $this->property;
	}

	public function setProperty($property): static
	{
		$this->property = $property;

		return $this;
	}

	public function getPropertyName()
	{
		return $this->propertyName;
	}

	public function setPropertyName($propertyName): static
	{
		$this->propertyName = $propertyName;

		return $this;
	}

	public function getRule()
	{
		return $this->rule;
	}

	public function setRule($rule): static
	{
		$this->rule = $rule;

		return $this;
	}

	public function addRule(string $rule): static
	{
		$this->rule .= '|' . $rule;

		return $this;
	}

	public function toArray(): array
	{
		return [
			'property' => $this->property,
			'propertyName' => $this->propertyName,
			'rule' => $this->rule,
		];
	}
}
