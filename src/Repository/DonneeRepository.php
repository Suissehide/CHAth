<?php

namespace App\Repository;

use App\Entity\Donnee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Donnee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Donnee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Donnee[]    findAll()
 * @method Donnee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DonneeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Donnee::class);
    }

    // /**
    //  * @return Donnee[] Returns an array of Donnee objects
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
    public function findOneBySomeField($value): ?Donnee
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
