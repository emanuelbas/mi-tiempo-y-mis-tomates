<?php

namespace App\Repository;

use App\Entity\TaskState;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TaskState|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaskState|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaskState[]    findAll()
 * @method TaskState[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskStateRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TaskState::class);
    }

//    /**
//     * @return TaskState[] Returns an array of TaskState objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TaskState
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
