<?php

namespace App\Repository;

use App\Entity\ServiceType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ServiceType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServiceType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServiceType[]    findAll()
 * @method ServiceType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServiceType::class);
    }
}
