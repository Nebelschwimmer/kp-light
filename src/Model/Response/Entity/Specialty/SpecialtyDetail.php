<?php
namespace App\Model\Response\Entity\Specialty;

use OpenApi\Attributes as OA;

class SpecialtyDetail
{
  #[OA\Property(example: 1)]
  public int $id;
  #[OA\Property(example: 'Action')]
  public string $name;

  public function getId(): int
  {
    return $this->id;
  }
  public function setId(int $id): static
  {
    $this->id = $id;

    return $this;
  }
  public function getName(): string
  {
    return $this->name;
  }
  public function setName(string $name): static
  {
    $this->name = $name;

    return $this;  
  }

}