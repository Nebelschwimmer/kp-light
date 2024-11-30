<?php
namespace App\Mapper\Entity;
use App\Entity\Film;
use App\Model\Response\Entity\Film\FilmDetail;
use App\Model\Response\Entity\Film\FilmForm;
use App\Model\Response\Entity\Film\FilmList;
use App\Model\Response\Entity\Film\FilmListItem;
use App\Enum\PersonType;
class FilmMapper
{

  public function mapToEntityList(array $films): FilmList
  {
    $items = array_map(
      fn(Film $film) => $this->mapToEntityListItem($film, new FilmListItem),
      $films
    );

    return new FilmList(array_values($items));
  }

  public function mapToEntityListItem(Film $film, FilmListItem $model): FilmListItem
  {
    return $model
      ->setId($film->getId())
      ->setName($film->getName())
    ;
  }
  public function mapToDetail(Film $film, FilmDetail $model): FilmDetail
  {
    return $model
      ->setId($film->getId())
      ->setName($film->getName())
      ->setGenreId($film->getGenre()->getId())
      ->setReleaseYear($film->getReleaseYear())
      ->setActorIds($this->transformActorsToIds($film))
      ->setDirectorId($film->getDirector() ? $film->getDirector()->getId() : null)
      ->setDirectorName($film->getDirector() ? $film->getDirector()->getFullname() : null)
      ->setGenreName($film->getGenre()->getName())
      ->setActorNames($this->transformActorsToNames($film))
      ->setDescription($film->getDescription())
      ->setRating($film->getRating())
    ;
  }

  public function mapToForm(Film $film, FilmForm $model): FilmForm
  {
    return $model
      ->setId($film->getId())
      ->setName($film->getName())
      ->setGenreId($film->getGenre()->getId())
      ->setReleaseYear($film->getReleaseYear())
      ->setActorIds($this->transformActorsToIds($film))
      ->setDirectorId($film->getDirector() ? $film->getDirector()->getId() : null)
    ;
  }

  public function mapToListItem(Film $film): FilmListItem
  {
    return new FilmListItem(
      $film->getId(),
      $film->getName(),
    );
  }
  private function transformActorsToNames(Film $film): array
  {
    $actorsIds = $this->transformActorsToIds($film);

    $namesArr = [];
    for ($i = 0; $i < count($actorsIds); $i++) {
      $namesArr[] = $film->getActors()[$i]->getFullname();
    }

    return $namesArr;
  }
  private function transformActorsToIds(Film $film): array
  {
    $idsArr = [];
    foreach ($film->getActors() as $actor) {
      $idsArr[] = $actor->getId();
    }

    return $idsArr;
  }

}