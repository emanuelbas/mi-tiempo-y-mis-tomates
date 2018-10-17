<?php

namespace App\Repository;

use App\Entity\PomodorosConfiguration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PomodorosConfiguration|null find($id, $lockMode = null, $lockVersion = null)
 * @method PomodorosConfiguration|null findOneBy(array $criteria, array $orderBy = null)
 * @method PomodorosConfiguration[]    findAll()
 * @method PomodorosConfiguration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PomodorosConfigurationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PomodorosConfiguration::class);
    }

//    /**
//     * @return PomodorosConfiguration[] Returns an array of PomodorosConfiguration objects
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
    public function findOneBySomeField($value): ?PomodorosConfiguration
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
