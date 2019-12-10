<?php

namespace App\Repository;

use App\Entity\Cardiovasculaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Cardiovasculaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cardiovasculaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cardiovasculaire[]    findAll()
 * @method Cardiovasculaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CardiovasculaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cardiovasculaire::class);
    }

    // /**
    //  * @return Cardiovasculaire[] Returns an array of Cardiovasculaire objects
    //  */
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
    public function findOneBySomeField($value): ?Cardiovasculaire
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
