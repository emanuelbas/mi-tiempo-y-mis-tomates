<?php

namespace App\Repository;

use App\Entity\Pomodoro;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Pomodoro|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pomodoro|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pomodoro[]    findAll()
 * @method Pomodoro[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PomodoroRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Pomodoro::class);
    }

//    /**
//     * @return Pomodoro[] Returns an array of Pomodoro objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Pomodoro
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
