<?php

namespace App\Repository;

use App\Entity\ReportFrequency;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ReportFrequency|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReportFrequency|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReportFrequency[]    findAll()
 * @method ReportFrequency[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReportFrequencyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ReportFrequency::class);
    }

//    /**
//     * @return ReportFrequency[] Returns an array of ReportFrequency objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ReportFrequency
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
