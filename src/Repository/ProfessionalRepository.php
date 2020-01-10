<?php

namespace App\Repository;

use App\Entity\Professional;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Professional|null find($id, $lockMode = null, $lockVersion = null)
 * @method Professional|null findOneBy(array $criteria, array $orderBy = null)
 * @method Professional[]    findAll()
 * @method Professional[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfessionalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Professional::class);
    }

    public function findAllProfessionals()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT COUNT(id) FROM professional';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }
}
