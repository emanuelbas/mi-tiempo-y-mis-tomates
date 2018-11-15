<?php

namespace App\Repository;

use App\Entity\Clock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Clock|null find($id, $lockMode = null, $lockVersion = null)
 * @method Clock|null findOneBy(array $criteria, array $orderBy = null)
 * @method Clock[]    findAll()
 * @method Clock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClockRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Clock::class);
    }

//    /**
//     * @return Clock[] Returns an array of Clock objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Clock
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
