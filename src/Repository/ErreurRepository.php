<?php

namespace App\Repository;

use App\Entity\Erreur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Erreur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Erreur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Erreur[]    findAll()
 * @method Erreur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ErreurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Erreur::class);
    }

    // /**
    //  * @return Erreur[] Returns an array of Erreur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Erreur
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
