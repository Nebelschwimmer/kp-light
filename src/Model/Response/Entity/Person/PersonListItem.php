<?php
namespace App\Model\Response\Entity\Person;

use OpenApi\Attributes as OA;

class PersonListItem
{

  public function __construct(
    ?int $id = null,
    ?string $fullName = null,
  ) {
    $this->id = $id;
    $this->name = $fullName;
  }

  #[OA\Property(example: 1)]
  public ?int $id;
  #[OA\Property(example: 'John Doe')]
  public ?string $name;


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