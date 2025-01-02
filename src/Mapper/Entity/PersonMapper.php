<?php
namespace App\Mapper\Entity;
use App\Entity\Person;
use App\Model\Response\Entity\Person\PersonDetail;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Model\Response\Entity\Person\PersonForm;
use App\Model\Response\Entity\Person\PersonList;
use App\Model\Response\Entity\Person\PersonListItem;
use App\Entity\Film;
use App\Enum\Specialty;
class PersonMapper
{
  public function __construct(
    private TranslatorInterface $translator,
  ) {
  }

  public function mapToEntityList(array $persons): PersonList
  {
    $items = array_map(
      fn(Person $person) => $this->mapToEntityListItem($person, new PersonListItem),
      $persons
    );

    return new PersonList(array_values($items));
  }

  public function mapToEntityListItem(Person $person, PersonListItem $model): PersonListItem
  {
    return $model
      ->setId($person->getId())
      ->setName($person->getFullname())
    ;
  }
  public function mapToListItem(Person $person): PersonListItem
  {
    return new PersonListItem(
      $person->getId(),
      $person->getFullname(),
    );
  }
  public function mapToDetail(Person $person, PersonDetail $model, ?string $locale = null): PersonDetail
  {
    return $model
      ->setId($person->getId())
      ->setFirstname($person->getFirstname())
      ->setLastname($person->getLastname())
      ->setGender($person->getGender()->trans($this->translator))
      ->setBirthday($person->getBirthday()->format('Y-m-d'))
      ->setActedInFilms($this->mapToFilmNameWithId($person))
      ->setPhoto($person->getPhoto() ?: '')
      ->setSpecialtyIds($person->getSpecialties())
      ->setSpecialtyNames(array_map(fn(Specialty $specialty) => $specialty->trans($this->translator, $locale), $person->getSpecialties()))
    ;
  }

  public function mapToForm(Person $person, PersonForm $model): PersonForm
  {
    return $model
      ->setId($person->getId())
      ->setFirstname($person->getFirstname())
      ->setLastname($person->getLastname())
      ->setGenderId($person->getGender()->value)
      ->setBirthday($person->getBirthday()->format('Y-m-d'))
      ->setActedInFilmIds($this->mapFilmsToIds($person))
      ->setPhoto($person->getPhoto() ?: '')
      ->setSpecialtyIds($person->getSpecialties())
    ;
  }
  private function mapFilmsToIds(Person $person): array
  {
    $films = $person->getFilms()->toArray();

    $filmIds = array_map(fn(Film $film) => $film->getId(), $films);

    return $filmIds;
  }

  private function mapToFilmNameWithId(Person $person): array
  {
    $films = $person->getFilms()->toArray();

    $filmNames = array_map(fn(Film $film) => [
      'id' => $film->getId(),
      'name' => $film->getName(),
    ], $films);

    return $filmNames;
  }


  private function matchSpecialtyIdsToTranslations(array $specialties)
  {
    foreach ($specialties as $specialty) {
      $specialtyId = $specialty->value;
      Specialty::tryFrom($specialtyId);

    }

  }

}