<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Comment>
 *
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    public function findByIdRessource(int $id): array
    {
        $entityManager = $this->getEntityManager();
    
        $query = $entityManager->createQuery(
            'SELECT c
            FROM App\Entity\Comment c
            WHERE c.resourceId = :id'
        )->setParameter('id', $id);
    
        return $query->getResult();
    }

    public function findUserComment(int $idComment): array
    {
        $entityManager = $this->getEntityManager();
        return $entityManager->createQuery(
            'SELECT u.firstname, u.lastname
        FROM App\Entity\User u
        JOIN App\Entity\Comment c
        WHERE c.id = :id'
        )->setParameter('id', $idComment)
            ->getResult();
    }
}
