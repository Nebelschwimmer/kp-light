<?php
namespace App\Model\Response\Entity\Specialty;

class SpecialtyList
{
  public function __construct(array $items)
  {
    $this->items = $items;
  }
  /**
   * @var SpecialtyListItem[]
   */
  private array $items;

  /**
   * @param PersonListItem[] $items
   */

  /**
   * @return SpecialtyListItem[]
   */
  public function getItems(): array
  {
    return $this->items;
  }

}