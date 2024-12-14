<?php
namespace App\Dto\Entity;

use OpenApi\Attributes as OA;
class FilmDto
{
  public function __construct(
    #[OA\Property(example: 'Star Wars')]
    public readonly ?string $name,
    #[OA\Property(example: 4)]
    public readonly ?int $genreId,
    #[OA\Property(example: 1987)]
    public readonly ?int $releaseYear,
  ) {
  }
}