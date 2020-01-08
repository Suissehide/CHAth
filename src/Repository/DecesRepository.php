<?php

namespace App\Repository;

use App\Entity\Deces;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Deces|null find($id, $lockMode = null, $lockVersion = null)
 * @method Deces|null findOneBy(array $criteria, array $orderBy = null)
 * @method Deces[]    findAll()
 * @method Deces[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DecesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Deces::class);
    }

    // /**
    //  * @return Deces[] Returns an array of Deces objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Deces
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
