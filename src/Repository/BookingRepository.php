<?php

namespace App\Repository;

use App\Entity\Booking;
use App\Entity\Professional;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Booking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Booking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Booking[]    findAll()
 * @method Booking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    public function findBookingByProfessionalAndDate(?Professional $professional, DateTime $date): array
    {
        return $this
            ->createQueryBuilder('b')
            ->join('b.professional', 'p')
            ->where('p = :p')
            ->andWhere('b.date = :date')
            ->setParameters([
                'p' => $professional,
                'date' => $date
            ])
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllCustomers(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT COUNT(id) FROM booking';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }
}
