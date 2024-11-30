<?php
namespace App\Dto\Entity;

use OpenApi\Attributes as OA;
class PersonDto
{
  public function __construct(
    #[OA\Property(example: 'Peter')]
    public readonly ?string $firstname = '',
    #[OA\Property(example: 'Jackson')]
    public readonly ?string $lastname = '',
    #[OA\Property(example: '')]
    public readonly ?string $photo = null,
    #[OA\Property(example: 1)]
    public readonly ?int $genderId = 1,
    #[OA\Property(example: '1986-06-05')]
    public readonly ?\DateTimeImmutable $birthday = null,
    #[OA\Property(example: 1)]
    public readonly ?int $typeId = 1,
  ) {
  }
}