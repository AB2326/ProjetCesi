<?php

namespace App\Repository;

use App\Entity\StatsUsers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StatsUsers>
 *
 * @method StatsUsers|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatsUsers|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatsUsers[]    findAll()
 * @method StatsUsers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatsUsersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StatsUsers::class);
    }

//    /**
//     * @return StatsUsers[] Returns an array of StatsUsers objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?StatsUsers
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
