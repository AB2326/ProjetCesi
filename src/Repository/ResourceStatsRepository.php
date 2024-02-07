<?php

namespace App\Repository;

use App\Entity\ResourceStats;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ResourceStats>
 *
 * @method ResourceStats|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResourceStats|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResourceStats[]    findAll()
 * @method ResourceStats[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResourceStatsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResourceStats::class);
    }

//    /**
//     * @return ResourceStats[] Returns an array of ResourceStats objects
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

//    public function findOneBySomeField($value): ?ResourceStats
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
