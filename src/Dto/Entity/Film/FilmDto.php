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
    #[OA\Property(example: 2)]
    public readonly ?int $producerId,
    #[OA\Property(example: 2)]
    public readonly ?int $writerId,
    #[OA\Property(example: 18)]
    public readonly ?int $age,
    #[OA\Property(example: '2:30:00')]
    public readonly ?\DateTimeImmutable $duration,
    
  ) {
  }
}