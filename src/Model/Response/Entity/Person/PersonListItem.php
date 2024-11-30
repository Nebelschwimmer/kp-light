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
    $this->fullname = $fullName;
  }

  #[OA\Property(example: 1)]
  public ?int $id;
  #[OA\Property(example: 'John Doe')]
  public ?string $fullname;


  public function getId(): int
  {
    return $this->id;
  }

  public function setId(int $id): static
  {
    $this->id = $id;

    return $this;
  }
  public function getFullname(): string
  {
    return $this->fullname;
  }

  public function setFullname(string $fullName): static
  {
    $this->fullname = $fullName;

    return $this;
  }

}