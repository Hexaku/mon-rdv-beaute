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
}
