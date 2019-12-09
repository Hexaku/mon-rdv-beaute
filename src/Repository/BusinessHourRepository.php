<?php

namespace App\Repository;

use App\Entity\BusinessHour;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method BusinessHour|null find($id, $lockMode = null, $lockVersion = null)
 * @method BusinessHour|null findOneBy(array $criteria, array $orderBy = null)
 * @method BusinessHour[]    findAll()
 * @method BusinessHour[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BusinessHourRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BusinessHour::class);
    }

    // /**
    //  * @return BusinessHour[] Returns an array of BusinessHour objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BusinessHour
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
