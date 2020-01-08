<?php

namespace App\Repository;

use App\Entity\Pack;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Pack|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pack|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pack[]    findAll()
 * @method Pack[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PackRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pack::class);
    }

    // /**
    //  * @return Pack[] Returns an array of Pack objects
    //  */
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
    public function findOneBySomeField($value): ?Pack
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
