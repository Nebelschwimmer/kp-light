<?php
namespace App\Model\Response\Entity\Film;

use OpenApi\Attributes as OA;

class FilmListItem
{
  public function __construct(?int $id = null, ?string $name, ?string $directorName, ?string $preview, array $genres, int $releaseYear, float $rating) 
  {
    $this->id = $id;
    $this->name = $name;
    $this->directorName = $directorName;
    $this->preview = $preview;
    $this->genres = $genres;
    $this->releaseYear = $releaseYear;
    $this->rating = $rating;
  }
  #[OA\Property(example: 1)]
  public ?int $id;
  #[OA\Property(example: 'Star Wars')]
  public ?string $name;
  
  #[OA\Property(example: 'James Cameron')]
  public ?string $directorName;

  public ?string $preview;

  public array $genres = [];

  public int $releaseYear;

  public float $rating;

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
  public function getPreview(): string
  {
    return $this->preview;
  }
  public function setPreview(string $preview): static
  {
    $this->preview = $preview;

    return $this;
  }

  public function getDirectorName(): string
  {
    return $this->directorName;
  }

  public function setDirectorName(string $directorName): static
  {
    $this->directorName = $directorName;

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

  public function getRating(): float
  {
    return $this->rating;
  }

  public function setRating(float $rating): static
  {
    $this->rating = $rating;

    return $this;
  }
}