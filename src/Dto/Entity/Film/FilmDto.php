<?php
namespace App\Dto\Entity;

use OpenApi\Attributes as OA;
class FilmDto
{
  public function __construct(
    #[OA\Property(example: 'Star Wars')]
    public readonly ?string $name,
    #[OA\Property(example: [1, 2, 3])]
    public readonly ?array $genreIds,
    #[OA\Property(example: 1987)]
    public readonly ?int $releaseYear,
    #[OA\Property(example: [1, 2, 3])]
    public readonly ?array $actorIds,
    #[OA\Property(example: 4)]
    public readonly ?int $directorId,
    
  ) {
  }
}