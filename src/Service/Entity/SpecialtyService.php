<?php

namespace App\Service\Entity;

use App\Repository\SpecialtyRepository;
use App\Mapper\Entity\SpecialtyMapper;
use App\Model\Response\Entity\Specialty\SpecialtyDetail;
use App\Model\Response\Entity\Specialty\SpecialtyForm;
use App\Model\Response\Entity\Specialty\SpecialtyList;
use App\Dto\Entity\SpecialtyDto;
use App\Entity\Specialty;
use Doctrine\Common\Collections\Order;
use App\Exception\NotFound\SpecialtyNotFoundException;

class SpecialtyService
{
  public function __construct(
    private SpecialtyRepository $repository,
    private SpecialtyMapper $specialtyMapper,
  ) {
  }
  public function get(int $id): SpecialtyDetail
  {
    return $this->specialtyMapper
      ->mapToDetail($this->find($id), new SpecialtyDetail());
  }


  public function findForm(int $id): SpecialtyForm
  {
    $person = $this->find($id);
    $form = $this->specialtyMapper->mapToForm($person, new SpecialtyForm());
    
    return $form;
  }

  public function list(): SpecialtyList
  {
    $specialties = $this->repository->findBy([], ['id' => Order::Ascending->value]);

    $items = array_map(
      fn(Specialty $specialty) => $this->specialtyMapper->mapToListItem($specialty),
      $specialties
    );

    return new SpecialtyList($items);
  }

  public function create(SpecialtyDto $dto): SpecialtyForm
  {
    $specialty = new Specialty();
    $specialty->setName($dto->name);

    $this->repository->store($specialty);

    return $this->findForm($specialty->getId());
  }

  public function update(int $id, SpecialtyDto $dto): SpecialtyForm
  {
    $specialty = $this->find($id);
    $specialty->setName($dto->name);    
    $this->repository->store($specialty);

    return $this->findForm($specialty->getId());
  }

  public function delete(int $id): void
  {
    $specialty = $this->find($id);
    $this->repository->remove($specialty);
  }

  private function find(int $id): Specialty
  {
    $specialty = $this->repository->find($id);
    if (null === $specialty) {
      throw new SpecialtyNotFoundException();
    }

    return $specialty;
  }


}