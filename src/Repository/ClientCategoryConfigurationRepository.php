<?php

namespace App\Repository;

use App\Entity\ClientCategoryConfiguration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ClientCategoryConfiguration|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClientCategoryConfiguration|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClientCategoryConfiguration[]    findAll()
 * @method ClientCategoryConfiguration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientCategoryConfigurationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ClientCategoryConfiguration::class);
    }

//    /**
//     * @return ClientCategoryConfiguration[] Returns an array of ClientCategoryConfiguration objects
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
    public function findOneBySomeField($value): ?ClientCategoryConfiguration
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
