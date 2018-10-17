<?php

namespace App\Repository;

use App\Entity\ClientUsesApplication;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ClientUsesApplication|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClientUsesApplication|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClientUsesApplication[]    findAll()
 * @method ClientUsesApplication[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientUsesApplicationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ClientUsesApplication::class);
    }

//    /**
//     * @return ClientUsesApplication[] Returns an array of ClientUsesApplication objects
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
    public function findOneBySomeField($value): ?ClientUsesApplication
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
