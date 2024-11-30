<?php
namespace App\Dto\Entity;

use OpenApi\Attributes as OA;
class GenreDto
{
  public function __construct(
    #[OA\Property(example: 'sci-fi')]
    public readonly ?string $name = '',
  ) {
  }
}