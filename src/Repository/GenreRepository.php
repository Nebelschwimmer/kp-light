<?php

namespace App\Repository;

use App\Entity\Genre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\Traits\ActionTrait;
/**
 * @extends ServiceEntityRepository<Genre>
 */
class GenreRepository extends ServiceEntityRepository
{
	use ActionTrait;
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, Genre::class);
	}

}
