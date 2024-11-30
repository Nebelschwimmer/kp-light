<?php
namespace App\Model\Response\Entity\Film;
use App\Model\Response\Entity\Film\FilmDetail;

class FilmPaginateList
{
    /**
     * @var FilmDetail[]
     */
    private array $items;
    private int $total;

    /**
     * @param FilmDetail[] $items
     */
    public function __construct(array $items, ?int $total = null)
    {
        $this->items = $items;
        $this->total = $total ?? count($items);
    }

    /**
     * @return FilmDetail[]
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
