<?php
namespace App\Model\Response\Entity\Film;

use OpenApi\Attributes as OA;

class FilmDetail
{
  public int $id;
  #[OA\Property(example: 'Star Trek')]
  public string $name;

  #[OA\Property(example: 'Star Trek')]
  public ?string $slogan;
  
  #[OA\Property(example: [1, 2])]
  public array $genreIds = [];

  #[OA\Property(example: ['sci-fi', 'action'])]
  public array $genreNames = [];
  
  #[OA\Property(example: 1966)]
  public int $releaseYear;
  
  public array $actorIds = [];
  public ?int $directorId;
  #[OA\Property(example: 'James Cameron')]
  public ?string $directorName;
  #[OA\Property(example: ['Tom Cruise', 'Leonardo DiCaprio'])]
  public array $actorNames = [];
  #[OA\Property(example: 'sci-fi')]

  public ?string $preview;
  #[OA\Property(example: 'A new hope is on the way!')]
  public ?string $description;
  #[OA\Property(example: 'A new hope is on the way!')]
  public ?float $rating;

  #[OA\Property(example: 18)]
  public ?int $age;
  #[OA\Property(example: '2:25:00')]
  public ?string $duration;
  
  #[OA\Property(example: 'Mike Newell')]
  public ?string $producerName;

  #[OA\Property(example: 2)]
  public ?int $producerId = null;
  #[OA\Property(example: 'Thomas Keneally')]
  public ?string $writerName;

  #[OA\Property(example: 4)]
  public ?int $writerId;

  #[OA\Property(example: 6)]
  public ?int $composerId = null;
  
  #[OA\Property(example: 'John Williams')]
  public ?string $composerName;

  public ?array $gallery = [];

  public ?array $actorPhotos = [];

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
  public function getGenreIds(): array
  {
    return $this->genreIds;
  }
  public function setGenreIds(array $genres): static
  {
    $this->genreIds = $genres;

    return $this;
  }


  public function getGenreNames(): array
  {
    return $this->genreNames;
  }
  public function setGenreNames(array $genres): static
  {
    $this->genreNames = $genres;

    return $this;
  }



  public function getReleaseYear(): int
  {
    return $this->releaseYear;
  }
  public function setReleaseYear(?int $releaseYear): static
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
  public function getActorNames(): array
  {
    return $this->actorNames;
  }
  public function setActorNames(array $actorNames): static
  {
    $this->actorNames = $actorNames;

    return $this;
  }
  public function getDirectorId(): ?int
  {
    return $this->directorId;
  }
  public function setDirectorId(?int $directorId): static
  {
    $this->directorId = $directorId;

    return $this;
  }
  public function getDirectorName(): ?string
  {
    return $this->directorName;
  }
  public function setDirectorName(?string $directorName): static
  {
    $this->directorName = $directorName;

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

  public function getDescription(): ?string
  {
    return $this->description;
  }
  public function setDescription(?string $description): static
  {
    $this->description = $description;

    return $this;
  }
  public function getRating(): ?float
  {
    return $this->rating;
  }
  public function setRating(float $rating): static
  {
    $this->rating = $rating;

    return $this;
  }

  public function getAge(): ?int
  {
    return $this->age;
  }
  public function setAge(int $age): static
  {
    $this->age = $age;

    return $this;
  }

  public function getDuration(): ?string
  {
    return $this->duration;
  }
  public function setDuration(?string $duration): static
  {
    $this->duration = $duration;

    return $this;
  }
  public function getProducerName(): ?string
  {
    return $this->producerName;
  }
  public function setProducerName(?string $producerName): static
  {
    $this->producerName = $producerName;

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

  public function getWriterName(): ?string
  {
    return $this->writerName;
  }
  public function setWriterName(?string $writerName): static
  {
    $this->writerName = $writerName;

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

  public function getComposerName(): ?string
  {
    return $this->composerName;
  }
  public function setComposerName(?string $composerName): static
  {
    $this->composerName = $composerName;

    return $this;
  }

  public function getComposerId(): ?int
  {
    return $this->composerId;
  }
  public function setComposerId(?int $composerId): static
  {
    $this->composerId = $composerId;

    return $this;
  }

  public function getActorPhotos(): array
  {
    return $this->actorPhotos;
  }
  public function setActorPhotos(?array $actorPhotos): static
  {
    $this->actorPhotos = $actorPhotos;

    return $this;
  }

}