<?php
namespace App\Mapper\Entity;

use App\Entity\Genre;
use App\Model\Response\Entity\Genre\GenreDetail;
use App\Model\Response\Entity\Genre\GenreForm;
use App\Model\Response\Entity\Genre\GenreList;
use App\Model\Response\Entity\Genre\GenreListItem;
use Symfony\Contracts\Translation\TranslatorInterface;

class GenreMapper
{
  public function __construct(
    private TranslatorInterface $translator,
  ) {
  }
  public function mapToDetail(Genre $genre, GenreDetail $model): GenreDetail
  {
    return $model
      ->setId($genre->getId())
      ->setName($genre->getName());
  }

  public function mapToListItem(Genre $genre): GenreListItem
  {
    return new GenreListItem(
      $genre->getId(),
      $genre->getName()
    );
  }

  public function mapToEntityList(array $genres): GenreList
  {
    $items = array_map(
      fn(Genre $genre) => $this->mapToEntityListItem($genre, new GenreListItem),
      $genres
    );

    return new GenreList(array_values($items));
  }

  public function mapToEntityListItem(Genre $genre, GenreListItem $model): GenreListItem
  {
    return $model
      ->setId($genre->getId())
      ->setName($genre->getName())
    ;
  }

  public function mapToForm(Genre $genre, GenreForm $model): GenreForm
  {
    return $model
      ->setId($genre->getId())
      ->setName($genre->getName())
    ;
  }
}