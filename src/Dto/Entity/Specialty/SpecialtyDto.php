<?php
namespace App\Dto\Entity;

use OpenApi\Attributes as OA;
class SpecialtyDto
{
  public function __construct(
    #[OA\Property(example: 'editor')]
    public readonly ?string $name = '',
  ) {
  }
}