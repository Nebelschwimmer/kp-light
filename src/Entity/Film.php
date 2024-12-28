<?php

namespace App\Entity;

use App\Enum\Genres;
use App\Repository\FilmRepository;
use Cake\Database\Type\EnumType;
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

  #[ORM\Column(type: Types::JSON, enumType: Genres::class)]
  private array $genres = [];

  #[ORM\Column]
  private ?int $releaseYear = null;

  #[ORM\Column(type: Types::TEXT)]
  private ?string $description = null;

  #[ORM\Column(type: Types::FLOAT)]
  private ?float $rating = null;

  private string $preview = '';

  private array $gallery = [];

  /**
   * @var Collection<int, Person>
   */
  #[ORM\ManyToMany(targetEntity: Person::class, inversedBy: 'films', cascade: ['persist'])]
  #[ORM\JoinTable(name: 'film_person')]
  private Collection $actors;

  #[ORM\ManyToOne(inversedBy: 'directedFilms')]
  private ?Person $directedBy = null;

  #[ORM\Column(type: Types::TIME_IMMUTABLE)]
  private ?\DateTimeImmutable $duration = null;

  #[ORM\Column]
  private ?int $age = null;

  #[ORM\Column(length: 255, nullable: true)]
  private ?string $slogan = null;

  #[ORM\ManyToOne(inversedBy: 'producedFilms')]
  private ?Person $producer = null;

  #[ORM\ManyToOne(inversedBy: 'writtenFilms')]
  private ?Person $writer = null;

  #[ORM\ManyToOne]
  private ?Person $composer = null;


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

  public function getGenres(): array
  {
    return $this->genres;
  }

  public function setGenres(array $genres): static
  {
    $this->genres = $genres;

    return $this;
  }

  public function addGenre(Genres $genre): static
  {
    if (!in_array($genre->value, $this->genres, true)) {
      $this->genres[] = $genre->value;
    }

    return $this;
  }

  public function removeGenre(Genres $genre): static
  {
    $index = array_search($genre->value, $this->genres, true);
    if ($index !== false) {
      unset($this->genres[$index]);
    }

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
    return $this->actors;
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

  public function getRating(): ?float
  {
    return $this->rating;
  }

  public function setRating(float $rating): static
  {
    $this->rating = $rating;

    return $this;
  }

  public function __toString()
  {
    return $this->name;
  }

  public function getDirectedBy(): ?Person
  {
      return $this->directedBy;
  }

  public function setDirectedBy(?Person $directedBy): static
  {
      $this->directedBy = $directedBy;

      return $this;
  }

  public function getDuration(): ?\DateTimeImmutable
  {
      return $this->duration;
  }

  public function setDuration(\DateTimeImmutable $duration): static
  {
      $this->duration = $duration;

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

  public function getSlogan(): ?string
  {
      return $this->slogan;
  }

  public function setSlogan(?string $slogan): static
  {
      $this->slogan = $slogan;

      return $this;
  }

  public function getProducer(): ?Person
  {
      return $this->producer;
  }

  public function setProducer(?Person $producer): static
  {
      $this->producer = $producer;

      return $this;
  }

  public function getWriter(): ?Person
  {
      return $this->writer;
  }

  public function setWriter(?Person $writer): static
  {
      $this->writer = $writer;

      return $this;
  }

  public function getComposer(): ?Person
  {
      return $this->composer;
  }

  public function setComposer(?Person $composer): static
  {
      $this->composer = $composer;

      return $this;
  }


}
