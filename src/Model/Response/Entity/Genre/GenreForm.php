<?php
namespace App\Model\Response\Entity\Genre;

use OpenApi\Attributes as OA;

class GenreForm
{
  #[OA\Property(type: 'string')]
  public ?int $id = null;

  #[OA\Property(type: 'string', example: 'Action')]
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