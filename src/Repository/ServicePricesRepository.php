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
}
