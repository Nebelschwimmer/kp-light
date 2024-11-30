<?php
namespace App\Dto\Entity\Query;
use OpenApi\Attributes as OA;

class PersonQueryDto
{
  public function __construct(
    #[OA\Property(example: 5)]
    public readonly ?int $limit = 5,
    #[OA\Property(example: 0)]
    public readonly ?int $offset = 0,
    #[OA\Property(example: 'John')]
    public ?string $search = null,
  ) {
  }

}