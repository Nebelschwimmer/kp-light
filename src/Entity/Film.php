<?php

namespace App\Entity;

use App\Enum\PersonType;
use App\Repository\FilmRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FilmRepository::class)]
class Film
{

  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\Column(length: 255)]
  private ?string $name = null;

  #[ORM\ManyToOne(inversedBy: 'films')]
  private ?Genre $genre = null;

  #[ORM\Column]
  private ?int $releaseYear = null;

  #[ORM\Column(type: Types::TEXT)]
  private ?string $description = null;

  #[ORM\Column(length: 255)]
  private ?int $rating = null;

  private string $preview = '';

  private array $gallery = [];

  /**
   * @var Collection<int, Person>
   */
  #[ORM\ManyToMany(targetEntity: Person::class, inversedBy: 'films', cascade: ['persist'])]
  #[ORM\JoinTable(name: 'film_person')]
  private Collection $actors;

  #[ORM\ManyToOne(cascade: ['persist'])]
  private ?Person $director = null;

  public function __construct()
  {
    $this->actors = new ArrayCollection();
  }

  public function getId(): ?int
  {
    return $this->id;
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

  public function getGenre(): ?Genre
  {
    return $this->genre;
  }

  public function setGenre(?Genre $genre): static
  {
    $this->genre = $genre;

    return $this;
  }

  public function getReleaseYear(): ?int
  {
    return $this->releaseYear;
  }

  public function setReleaseYear(int $releaseYear): static
  {
    $this->releaseYear = $releaseYear;

    return $this;
  }

  /**
   * @return Collection<int, Person>
   */
  public function getActors(): Collection
  {
    $actors = $this->actors->filter(fn(Person $actor) => $actor->getType() === PersonType::ACTOR);
    return $actors;
  }

  public function addActor(Person $actor): static
  {
    if (!$this->actors->contains($actor)) {
      $this->actors->add($actor);
    }

    return $this;
  }

  public function removeActor(Person $actor): static
  {
    $this->actors->removeElement($actor);

    return $this;
  }

  public function updateActors(array $actors): static
  {
    $this->actors = new ArrayCollection($actors);

    return $this;
  }


  public function getDirector(): ?Person
  {
    if ($this->director && $this->director->getType() !== PersonType::DIRECTOR) {
      $this->director =  null;
    }

    return $this->director;
  }

  public function setDirector(?Person $director): static
  {
    if (
      $director &&
      $director->getType() === PersonType::DIRECTOR
    ) {
      $this->director = $director;
    }

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

  public function setDescription(string $description): static
  {
    $this->description = $description;

    return $this;
  } 

  public function getRating(): ?int
  {
    return $this->rating;
  }

  public function setRating(int $rating): static
  {
    $this->rating = $rating;

    return $this;
  }

  public function __toString()
  {
    return $this->name;
  }
}
