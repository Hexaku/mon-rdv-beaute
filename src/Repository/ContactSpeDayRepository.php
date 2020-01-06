<?php

namespace App\Repository;

use App\Entity\ContactSpeDay;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ContactSpeDay|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactSpeDay|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactSpeDay[]    findAll()
 * @method ContactSpeDay[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactSpeDayRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactSpeDay::class);
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
