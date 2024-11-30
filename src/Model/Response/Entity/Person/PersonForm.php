<?php
namespace App\Model\Response\Entity\Person;

use OpenApi\Attributes as OA;

class PersonForm
{
  #[OA\Property(example: 1)]
  public ?int $id = null;
  #[OA\Property(example: 'John')]
  public ?string $firstname = null;
  #[OA\Property(example: 'Doe')]
  public ?string $lastname = null;
  #[OA\Property(example: 1)]
  public ?int $genderId = 1;
  #[OA\Property(example: '1984-01-01')]
  public ?string $birthday = null;
  #[OA\Property(example: 1)]
  public ?int $typeId = 1;
  #[OA\Property(example: [2, 3])]
  public array $filmIds = [];

  public string $photo = '';


  public function getId(): int
  {
    return $this->id;
  }

  public function setId(int $id): static
  {
    $this->id = $id;

    return $this;
  }
  public function getFirstname(): string
  {
    return $this->firstname;
  }
  public function setFirstname(string $firstname): static
  {
    $this->firstname = $firstname;

    return $this;
  }

  public function getLastname(): string
  {
    return $this->lastname;
  }

  public function setLastname(string $lastname): static
  {
    $this->lastname = $lastname;

    return $this;
  }

  public function getGenderId(): int
  {
    return $this->genderId;
  }
  public function setGenderId(int $genderId): static
  {
    $this->genderId = $genderId;

    return $this;
  }

  public function getBirthday(): string
  {
    return $this->birthday;
  }
  public function setBirthday(string $birthday): static
  {
    $this->birthday = $birthday;

    return $this;
  }

  public function getTypeId(): int
  {
    return $this->typeId;
  }
  public function setTypeId(int $typeId): static
  {
    $this->typeId = $typeId;

    return $this;
  }
  public function getFilmIds(): array
  {
    return $this->filmIds;
  }
  public function setFilmIds(array $filmIds): static
  {
    $this->filmIds = $filmIds;

    return $this;
  }

  public function getPhoto(): string
  {
    return $this->photo;
  }
  public function setPhoto(string $photo): static
  {
    $this->photo = $photo;  

    return $this;
  }

}