<?php

namespace App\Repository;

use App\Entity\Professional;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Professional|null find($id, $lockMode = null, $lockVersion = null)
 * @method Professional|null findOneBy(array $criteria, array $orderBy = null)
 * @method Professional[]    findAll()
 * @method Professional[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfessionalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Professional::class);
    }

    public function findAllProfessionals(): ?int
    {
        // returns an array of arrays (i.e. a raw data set)
        return $this
            ->createQueryBuilder("p")
            ->select("count(p)")
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

    public function findAllMatching(string $query, int $limit = 5): ?array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.city LIKE :query')
            ->setParameter('query', '%'.$query.'%')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
            ;
    }
}
