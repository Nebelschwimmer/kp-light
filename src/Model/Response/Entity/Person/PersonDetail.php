<?php
namespace App\Model\Response\Entity\Person;

use OpenApi\Attributes as OA;

class PersonDetail
{
  #[OA\Property(example: 1)]
  public ?int $id;
  #[OA\Property(example: 'John')]
  public ?string $firstname;
  #[OA\Property(example: 'Doe')]
  public ?string $lastname;
  #[OA\Property(example: '')]
  public ?string $photo;
  #[OA\Property(example: 'male')]
  public ?string $gender;
  #[OA\Property(example: '1984-01-01')]
  public ?string $birthday;
  #[OA\Property(example: 'actor')]
  public ?string $type;
  #[OA\Property(example: [2, 3])]
  public array $films = [];


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

  public function getPhoto(): string
  {
    return $this->photo;
  }
  public function setPhoto(string $photo): static
  {
    $this->photo = $photo;

    return $this;
  }

  public function getGender(): string
  {
    return $this->gender;
  }
  public function setGender(string $gender): static
  {
    $this->gender = $gender;

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

  public function getType(): string
  {
    return $this->type;
  }
  public function setType(string $type): static
  {
    $this->type = $type;

    return $this;
  }
  public function getFilms(): array
  {
    return $this->films;
  }
  public function setFilms(array $films): static
  {
    $this->films = $films;

    return $this;
  }

}