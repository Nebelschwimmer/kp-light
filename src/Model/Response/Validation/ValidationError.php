<?php

namespace App\Model\Response\Validation;

use OpenApi\Attributes as OA;

class ValidationError
{

  #[OA\Property(example: 'title')]
  private string $property;

  #[OA\Property(example: ['Property \'title\' must be required'])]
  private array $errors = [];

  public function __construct(string $property, array $errors = [])
  {
    $this->property = $property;
    $this->errors = $errors;
  }

  public function getProperty(): string
  {
    return $this->property;
  }

  public function setProperty(string $property): static
  {
    $this->property = $property;

    return $this;
  }

  public function getErrors(): array
  {
    return $this->errors;
  }

  public function setErrors(array $errors): static
  {
    $this->errors = $errors;

    return $this;
  }
}
