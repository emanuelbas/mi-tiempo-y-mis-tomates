<?php

namespace App\Repository;

use App\Entity\ClientApplicationsConfiguration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ClientApplicationsConfiguration|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClientApplicationsConfiguration|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClientApplicationsConfiguration[]    findAll()
 * @method ClientApplicationsConfiguration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientApplicationsConfigurationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ClientApplicationsConfiguration::class);
    }

//    /**
//     * @return ClientApplicationsConfiguration[] Returns an array of ClientApplicationsConfiguration objects
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
    public function findOneBySomeField($value): ?ClientApplicationsConfiguration
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
