<?php
namespace App\Dto\Entity;

use OpenApi\Attributes as OA;
class DirectorDto
{
  public function __construct(
    #[OA\Property(example: 1)]
    public readonly ?int $directorId = null,
  ) {
  }
}