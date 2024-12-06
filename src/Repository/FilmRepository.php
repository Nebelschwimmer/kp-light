<?php

namespace App\Repository;

use App\Dto\Entity\Query\FilmQueryDto;
use App\Entity\Film;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\Traits\ActionTrait;

/**
 * @extends ServiceEntityRepository<Film>
 */
class FilmRepository extends ServiceEntityRepository
{
	use ActionTrait;
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, Film::class);
	}


	public function filterByQueryParams(FilmQueryDto $filmQueryDto): array
	{

		$search = $filmQueryDto->search;
		$offset = $filmQueryDto->offset;
		$limit = $filmQueryDto->limit;

		$queryBuilder = $this->createQueryBuilder('p')->where('1 = 1');
		;

		if (!empty($search)) {
			$search = trim(strtolower($search));
			$queryBuilder
				->where($queryBuilder->expr()->like('LOWER(p.name)', ':search'))
				->orWhere($queryBuilder->expr()->like('p.releaseYear', ':search'))
				->setParameter('search', "%{$search}%");
		}
		$queryBuilder
			->orderBy('p.id', 'ASC')
			->setFirstResult($offset)
			->setMaxResults($limit);
		return $queryBuilder->getQuery()->getResult();
	}

	public function total(): int
	{
		return $this->createQueryBuilder('p')
			->select('COUNT(p.id)')
			->getQuery()
			->getSingleScalarResult()
		;
	}

}
