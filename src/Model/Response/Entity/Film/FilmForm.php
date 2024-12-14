<?php
namespace App\Model\Response\Entity\Film;

use OpenApi\Attributes as OA;

class FilmForm
{
  public ?int $id;
  #[OA\Property(example: 'Star Wars')]
  public ?string $name;
  #[OA\Property(example: 4)]
  public ?int $genreId = null;
  #[OA\Property(example: 4)]
  public ?int $releaseYear = null;
  #[OA\Property(example: [1, 2, 3])]
  public ?array $actorIds = [];
  
  #[OA\Property(example: 2)]
  public ?int $directorId = null;
  public ?string $preview = null;

  public array $gallery = [];

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
  public function getGenreId(): int
  {
    return $this->genreId;
  }
  public function setGenreId(int $genreId): static
  {
    $this->genreId = $genreId;

    return $this;
  }
  public function getReleaseYear(): int
  {
    return $this->releaseYear;
  }
  public function setReleaseYear(int $releaseYear): static
  {
    $this->releaseYear = $releaseYear;

    return $this;
  }
  public function getActorIds(): array
  {
    return $this->actorIds;
  }
  public function setActorIds(array $actorIds): static
  {
    $this->actorIds = $actorIds;

    return $this;
  }
  public function getDirectorId(): int
  {
    return $this->directorId;
  }
  public function setDirectorId(?int $directorId): static
  {
    $this->directorId = $directorId;

    return $this;
  }
  public function getPreview(): ?string
  {
    return $this->preview;
  }
  public function setPreview(?string $preview): static
  {
    $this->preview = $preview;

    return $this;
  }
  public function getGallery(): array
  {
    return $this->gallery;
  }
  public function setGallery(array $gallery): static
  {
    $this->gallery = $gallery;

    return $this;
  }

}