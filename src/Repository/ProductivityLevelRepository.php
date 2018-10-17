<?php

namespace App\Repository;

use App\Entity\ProductivityLevel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProductivityLevel|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductivityLevel|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductivityLevel[]    findAll()
 * @method ProductivityLevel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductivityLevelRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProductivityLevel::class);
    }

//    /**
//     * @return ProductivityLevel[] Returns an array of ProductivityLevel objects
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
    public function findOneBySomeField($value): ?ProductivityLevel
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
