<?php
namespace App\Dto\Entity;

use OpenApi\Attributes as OA;
class ActorDto
{
  public function __construct(
    #[OA\Property(example: 1)]
    public readonly ?int $actorId = null,
  ) {
  }
}