<?php
namespace App\Model\Response\Entity\Film;

use OpenApi\Attributes as OA;

class FilmForm
{
  public ?int $id;
  #[OA\Property(example: 'Star Wars')]
  public ?string $name;

  #[OA\Property(example: 'The Empire Strikes Back')]
  public ?string $slogan = null;
  #[OA\Property(example: 4)]
  public ?array $genres = null;
  #[OA\Property(example: 4)]
  public ?int $releaseYear = null;
  #[OA\Property(example: [1, 2, 3])]
  public ?array $actorIds = [];

  #[OA\Property(example: 2)]
  public ?int $directorId = null;

  #[OA\Property(example: 4)]
  public ?int $producerId = null;

  #[OA\Property(example: 5)]
  public ?int $writerId = null;
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
  public function getGenres(): array
  {
    return $this->genres;
  }
  public function setGenres(array $genres): static
  {
    $this->genres = $genres;

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
  public function getProducerId(): ?int
  {
    return $this->producerId;
  }
  public function setProducerId(?int $producerId): static
  {
    $this->producerId = $producerId;

    return $this;
  }

  public function getWriterId(): ?int
  {
    return $this->writerId;
  }

  public function setWriterId(?int $writerId): static
  {
    $this->writerId = $writerId;

    return $this;
  }

  public function getSlogan(): ?string
  {
    return $this->slogan;
  }

  public function setSlogan(?string $slogan): static
  {
    $this->slogan = $slogan;

    return $this;
  }



}