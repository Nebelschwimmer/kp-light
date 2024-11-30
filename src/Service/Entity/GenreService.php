<?php

namespace App\Service\Entity;

use App\Repository\GenreRepository;
use App\Mapper\Entity\GenreMapper;
use App\Model\Response\Entity\Genre\GenreDetail;
use App\Model\Response\Entity\Genre\GenreForm;
use App\Model\Response\Entity\Genre\GenreList;
use App\Dto\Entity\GenreDto;
use App\Entity\Genre;
use Doctrine\Common\Collections\Order;
use App\Exception\NotFound\GenreNotFoundException;

class GenreService
{
  public function __construct(
    private GenreRepository $repository,
    private GenreMapper $genreMapper,
  ) {
  }
  public function get(int $id): GenreDetail
  {
    return $this->genreMapper
      ->mapToDetail($this->find($id), new GenreDetail());
  }


  public function findForm(int $id): GenreForm
  {
    $person = $this->find($id);
    $form = $this->genreMapper->mapToForm($person, new GenreForm());
    
    return $form;
  }

  public function list(): GenreList
  {
    $genres = $this->repository->findBy([], ['id' => Order::Ascending->value]);

    $items = array_map(
      fn(Genre $genre) => $this->genreMapper->mapToListItem($genre),
      $genres
    );

    return new GenreList($items);
  }

  public function create(GenreDto $dto): GenreForm
  {
    $genre = new Genre();
    $genre->setName($dto->name);

    $this->repository->store($genre);

    return $this->findForm($genre->getId());
  }

  public function update(int $id, GenreDto $dto): GenreForm
  {
    $genre = $this->find($id);
    $genre->setName($dto->name);    
    $this->repository->store($genre);

    return $this->findForm($genre->getId());
  }

  public function delete(int $id): void
  {
    $genre = $this->find($id);
    $this->repository->remove($genre);
  }

  private function find(int $id): Genre
  {
    $genre = $this->repository->find($id);
    if (null === $genre) {
      throw new GenreNotFoundException();
    }

    return $genre;
  }


}