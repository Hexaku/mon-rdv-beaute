<?php

namespace App\Repository;

use App\Entity\UserVerify;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UserVerify|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserVerify|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserVerify[]    findAll()
 * @method UserVerify[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserVerify::class);
    }
}
