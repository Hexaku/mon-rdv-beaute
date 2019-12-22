<?php

namespace App\Repository;

use App\Entity\ServicePrices;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ServicePrices|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServicePrices|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServicePrices[]    findAll()
 * @method ServicePrices[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServicePricesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServicePrices::class);
    }

    // /**
    //  * @return ServicePrices[] Returns an array of ServicePrices objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ServicePrices
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
