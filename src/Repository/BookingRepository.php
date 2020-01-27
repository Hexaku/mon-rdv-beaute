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
        //to access expr method, we have to put createQueryBuilder in a variable before
        $qb = $this->createQueryBuilder('b');
        return $qb
            ->join('b.professional', 'p')
            ->where($qb->expr()->eq('p', ':p'))
            ->andWhere($qb->expr()->eq('b.date', ':date'))
            ->setParameters([
                'p' => $professional,
                'date' => $date
            ])
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllBookings(): ?int
    {
        // returns an array of arrays (i.e. a raw data set)
        return $this
            ->createQueryBuilder('b')
            ->select("count(b)")
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }
}
