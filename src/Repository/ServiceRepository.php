<?php

namespace App\Repository;

use App\Entity\Service;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Service|null find($id, $lockMode = null, $lockVersion = null)
 * @method Service|null findOneBy(array $criteria, array $orderBy = null)
 * @method Service[]    findAll()
 * @method Service[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Service::class);
    }

    public function findAllServices(): ?int
    {
        // returns an array of arrays (i.e. a raw data set)
        return $this
            ->createQueryBuilder('s')
            ->select("count(s)")
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

    public function findServicesByQuery(string $serviceName, string $serviceCity): ?array
    {
        $query = $this->createQueryBuilder("s")
            ->innerJoin("s.professional", "p");
        if ($serviceName) {
            $query = $query
            ->andWhere("s.name LIKE :serviceName")
            ->setParameter("serviceName", $serviceName.'%');
        };
        if ($serviceCity) {
            $query = $query
            ->andWhere("p.city LIKE :serviceCity")
            ->setParameter("serviceCity", $serviceCity.'%');
        }
        $query = $query
            ->getQuery()
            ->getResult()
        ;
        return $query;
    }

    public function findAllMatching(string $query, int $limit = 5): ?array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.name LIKE :query')
            ->setParameter('query', '%'.$query.'%')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }
}
