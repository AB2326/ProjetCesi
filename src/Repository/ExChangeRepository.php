<?php

namespace App\Repository;

use App\Entity\ExChange;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExChange>
 *
 * @method ExChange|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExChange|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExChange[]    findAll()
 * @method ExChange[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExChangeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExChange::class);
    }

//    /**
//     * @return ExChange[] Returns an array of ExChange objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ExChange
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
