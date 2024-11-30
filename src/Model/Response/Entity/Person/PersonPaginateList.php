<?php
namespace App\Model\Response\Entity\Person;
use App\Model\Response\Entity\Person\PersonDetail;

class PersonPaginateList
{
	/**
	 * @var PersonDetail[]
	 */
	private array $items;
	private int $total;

	/**
	 * @param PersonDetail[] $items
	 */
	public function __construct(array $items, ?int $total = null)
	{
		$this->items = $items;
		$this->total = $total ?? count($items);
	}

	/**
	 * @return PersonDetail[]
	 */
	public function getItems(): array
	{
		return $this->items;
	}

	public function getTotal(): ?int
	{
		return $this->total;
	}
}
