<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\Gender;

#[ORM\Entity(repositoryClass: PersonRepository::class)]
class Person
{
  public const DEFAULT_GENDER = Gender::MALE;

  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\Column(length: 255)]
  private ?string $lastname = null;

  #[ORM\Column(length: 255)]
  private ?string $firstname = null;

  #[ORM\Column(type: Types::SMALLINT, enumType: Gender::class)]
  private ?Gender $gender = self::DEFAULT_GENDER;

  #[ORM\Column(type: Types::DATETIME_MUTABLE)]
  private ?\DateTimeInterface $birthday = null;

  #[ORM\Column(length: 255, nullable: true)]
  private ?string $photo = null;


  /**
   * @var Collection<int, Film>
   */
  #[ORM\ManyToMany(targetEntity: Film::class, mappedBy: 'actors', cascade: ['persist'])]
  private Collection $actedInFilms;

  /**
   * @var Collection<int, Specialty>
   */
  #[ORM\ManyToMany(targetEntity: Specialty::class, mappedBy: 'person')]
  private Collection $specialties;


  public function __construct()
  {
    $this->actedInFilms = new ArrayCollection();
    $this->specialties = new ArrayCollection();
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getLastname(): ?string
  {
    return $this->lastname;
  }

  public function setLastname(string $lastname): static
  {
    $this->lastname = $lastname;

    return $this;
  }

  public function getFirstname(): ?string
  {
    return $this->firstname;
  }

  public function setFirstname(string $firstname): static
  {
    $this->firstname = $firstname;

    return $this;
  }

  public function getFullName(): string
  {
    return $this->firstname . ' ' . $this->lastname;
  }
  public function getGender(): ?Gender
  {
    return $this->gender;
  }

  public function setGender(Gender|int $gender): static
  {
    $this->gender = is_int($gender) ? Gender::from($gender) : $gender;

    return $this;
  }

  public function getBirthday(): ?\DateTimeInterface
  {
    return $this->birthday;
  }

  public function setBirthday(\DateTimeInterface $birthday): static
  {
    $this->birthday = $birthday;

    return $this;
  }

  public function getPhoto(): ?string
  {
    return $this->photo;
  }

  public function setPhoto(?string $photo): static
  {
    $this->photo = $photo;

    return $this;
  }

  /**
   * @return Collection<int, Film>
   */
  public function getFilms(): Collection
  {
    return $this->actedInFilms;
  }

  public function addFilm(Film $film): static
  {
    if (!$this->actedInFilms->contains($film)) {
      $this->actedInFilms->add($film);

    }

    return $this;
  }
  public function removeFilm(Film $film): static
  {
    if ($this->actedInFilms->contains($film)) {
      $this->actedInFilms->removeElement($film);
    }

    return $this;
  }

  public function updateFilms(array $actedInFilms): static
  {
    $this->actedInFilms = new ArrayCollection($actedInFilms);

    return $this;
  }

  public function __toString()
  {
    return $this->getFullName();
  }

  /**
   * @return Collection<int, Specialty>
   */
  public function getSpecialties(): Collection
  {
    return $this->specialties;
  }

  public function addSpecialty(Specialty $specialty): static
  {
    if (!$this->specialties->contains($specialty)) {
      $this->specialties->add($specialty);
      $specialty->addPerson($this);
    }

    return $this;
  }

  public function removeSpecialty(Specialty $specialty): static
  {
    if ($this->specialties->removeElement($specialty)) {
      $specialty->removePerson($this);
    }

    return $this;
  }

}
