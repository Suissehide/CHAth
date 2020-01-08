<?php

namespace App\Repository;

use App\Entity\General;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method General|null find($id, $lockMode = null, $lockVersion = null)
 * @method General|null findOneBy(array $criteria, array $orderBy = null)
 * @method General[]    findAll()
 * @method General[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GeneralRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, General::class);
    }

    // /**
    //  * @return General[] Returns an array of General objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?General
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
