<?php

namespace App\Repository;

use App\Entity\UserStats;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserStats>
 *
 * @method UserStats|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserStats|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserStats[]    findAll()
 * @method UserStats[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserStatsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserStats::class);
    }

}
