<?php

namespace App\Repository;

use App\Entity\Dashboard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Dashboard|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dashboard|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dashboard[]    findAll()
 * @method Dashboard[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DashboardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dashboard::class);
    }
}
