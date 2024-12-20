<?php
namespace App\Mapper\Entity;
use App\Entity\Film;
use App\Model\Response\Entity\Film\FilmDetail;
use App\Model\Response\Entity\Film\FilmForm;
use App\Model\Response\Entity\Film\FilmList;
use App\Model\Response\Entity\Film\FilmListItem;
use Symfony\Contracts\Translation\TranslatorInterface;
class FilmMapper
{
  public function __construct(
    private TranslatorInterface $translator,
  ) {
  }

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
      ->setRating($film->getRating() ?? 0)
      ->setReleaseYear($film->getReleaseYear())
      ->setDirectorName($film->getDirectedBy() ? $film->getDirectedBy()->getFullname() : '')
      ->setDescription($film->getDescription())
    ;
  }
  public function mapToDetail(Film $film, FilmDetail $model): FilmDetail
  {
    return $model
      ->setId($film->getId())
      ->setName($film->getName())
      ->setGenreIds($film->getGenres())
      ->setReleaseYear($film->getReleaseYear())
      ->setActorIds($this->transformActorsToIds($film))
      ->setDirectorId($film->getDirectedBy() ? $film->getDirectedBy()->getId() : null)
      ->setDirectorName($film->getDirectedBy() ? $film->getDirectedBy()->getFullname() : '')
      ->setActorNames($this->transformActorsToNames($film))
      ->setDescription($film->getDescription())
      ->setRating($film->getRating() ?? 0.0)
      ->setAge($film->getAge())
      ->setDuration($film->getDuration())
      ->setProducerName($film->getProducer() ? $film->getProducer()->getFullname() : null)
      ->setProducerId($film->getProducer() ? $film->getProducer()->getId() : null)
      ->setWriterName($film->getWriter() ? $film->getWriter()->getFullname() : null)
      ->setWriterId($film->getWriter() ? $film->getWriter()->getId() : null)
    ;
  }

  public function mapToForm(Film $film, FilmForm $model): FilmForm
  {
    return $model
      ->setId($film->getId())
      ->setName($film->getName())
      ->setGenres($film->getGenres())
      ->setReleaseYear($film->getReleaseYear())
      ->setActorIds($this->transformActorsToIds($film))
      ->setDirectorId($film->getDirectedBy() ? $film->getDirectedBy()->getId() : null)
      ->setWriterId($film->getWriter() ? $film->getWriter()->getId() : null)
      ->setProducerId($film->getProducer() ? $film->getProducer()->getId() : null)
    ;
  }

  public function mapToListItem(Film $film): FilmListItem
  {
    return new FilmListItem(
      $film->getId(),
      $film->getName(),
      $film->getDirectedBy() ? $film->getDirectedBy()->getFullname() : '',
      $film->getPreview(),
      $film->getGenres(),
      $film->getReleaseYear(),
      $film->getRating(),
      $film->getDescription()

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