<?php

namespace App\Repository;

use App\Entity\ContactDay;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ContactDay|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactDay|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactDay[]    findAll()
 * @method ContactDay[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactDayRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactDay::class);
    }

    // /**
    //  * @return ContactSpeDay[] Returns an array of ContactSpeDay objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ContactSpeDay
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
