<?php

namespace App\Repository;

use App\Entity\SecretQuestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SecretQuestion|null find($id, $lockMode = null, $lockVersion = null)
 * @method SecretQuestion|null findOneBy(array $criteria, array $orderBy = null)
 * @method SecretQuestion[]    findAll()
 * @method SecretQuestion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SecretQuestionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SecretQuestion::class);
    }

//    /**
//     * @return SecretQuestion[] Returns an array of SecretQuestion objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SecretQuestion
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
