<?php

namespace App\Repository;

use App\Entity\HomeInformation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method HomeInformation|null find($id, $lockMode = null, $lockVersion = null)
 * @method HomeInformation|null findOneBy(array $criteria, array $orderBy = null)
 * @method HomeInformation[]    findAll()
 * @method HomeInformation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HomeInformationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HomeInformation::class);
    }

    // /**
    //  * @return HomeInformation[] Returns an array of HomeInformation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HomeInformation
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
