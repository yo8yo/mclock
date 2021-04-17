<?php

namespace App\Repository;

use App\Entity\CheckIn;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CheckIn|null find($id, $lockMode = null, $lockVersion = null)
 * @method CheckIn|null findOneBy(array $criteria, array $orderBy = null)
 * @method CheckIn[]    findAll()
 * @method CheckIn[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CheckInRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CheckIn::class);
    }

    public function getTotalUsers($site)
    {
        $q = $this->createQueryBuilder('c');
        return $q->select($q->expr()->countDistinct('c.user'))
            ->where('c.site = :site')
            ->setParameter('site', $site)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getTotalHours($site)
    {
        return $this->createQueryBuilder('c')
            ->select('SUM(c.duration)')
            ->where('c.site = :site')
            ->setParameter('site', $site)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findOneByUserAndDate(User $user, \DateTime $today)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.createdAt >= :today')
            ->andWhere('c.user = :user')
            ->setParameter('today', $today)
            ->setParameter('user', $user)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function countWeeklyHour($user, $mondayThisWeek)
    {
        return $this->createQueryBuilder('c')
            ->select('SUM(c.duration)')
            ->where('c.user = :user')
            ->andWhere('c.createdAt >= :mondayThisWeek')
            ->setParameter('user', $user)
            ->setParameter('mondayThisWeek', $mondayThisWeek)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
