<?php
namespace App\Mapper\Entity;

use App\Entity\Specialty;
use App\Model\Response\Entity\Specialty\SpecialtyDetail;
use App\Model\Response\Entity\Specialty\SpecialtyForm;
use App\Model\Response\Entity\Specialty\SpecialtyList;
use App\Model\Response\Entity\Specialty\SpecialtyListItem;
use Symfony\Contracts\Translation\TranslatorInterface;

class SpecialtyMapper
{
  public function __construct(
    private TranslatorInterface $translator,
  ) {
  }
  public function mapToDetail(Specialty $specialty, SpecialtyDetail $model): SpecialtyDetail
  {
    return $model
      ->setId($specialty->getId())
      ->setName($specialty->getName());
  }

  public function mapToListItem(Specialty $specialty): SpecialtyListItem
  {
    return new SpecialtyListItem(
      $specialty->getId(),
      $specialty->getName()
    );
  }

  public function mapToEntityList(array $specialties): SpecialtyList
  {
    $items = array_map(
      fn(Specialty $specialty) => $this->mapToEntityListItem($specialty, new SpecialtyListItem),
      $specialties
    );

    return new SpecialtyList(array_values($items));
  }

  public function mapToEntityListItem(Specialty $specialty, SpecialtyListItem $model): SpecialtyListItem
  {
    return $model
      ->setId($specialty->getId())
      ->setName($specialty->getName())
    ;
  }

  public function mapToForm(Specialty $specialty, SpecialtyForm $model): SpecialtyForm
  {
    return $model
      ->setId($specialty->getId())
      ->setName($specialty->getName())
    ;
  }
}