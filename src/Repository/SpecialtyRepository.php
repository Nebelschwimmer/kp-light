<?php

namespace App\Repository;

use App\Entity\Specialty;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\Traits\ActionTrait;
/**
 * @extends ServiceEntityRepository<Specialty>
 */
class SpecialtyRepository extends ServiceEntityRepository
{
    use ActionTrait;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Specialty::class);
    }

}
