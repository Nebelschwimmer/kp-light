<?php
namespace App\Model\Response\Entity\Genre;

class GenreList
{
  public function __construct(array $items)
  {
    $this->items = $items;
  }
  /**
   * @var GenreListItem[]
   */
  private array $items;

  /**
   * @param PersonListItem[] $items
   */

  /**
   * @return GenreListItem[]
   */
  public function getItems(): array
  {
    return $this->items;
  }

}