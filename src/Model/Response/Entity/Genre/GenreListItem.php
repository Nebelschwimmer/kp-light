<?php
namespace App\Model\Response\Entity\Genre;

use OpenApi\Attributes as OA;

class GenreListItem
{
  public function __construct(?int $id = null,  ?string $name) {
    $this->id = $id;
    $this->name = $name;
  }

  #[OA\Property(example: 1)]
  public ?int $id;

  #[OA\Property(example: 'drama')]
  public ?string $name;

  public function getId(): ?int
  {
    return $this->id;
  }
  public function setId(int $id): static
  {
    $this->id = $id;
    return $this;
  }

  public function getName(): ?string
  {
    return $this->name;
  }

  public function setName(string $name): static
  {
    $this->name = $name;
    return $this;
  }
}