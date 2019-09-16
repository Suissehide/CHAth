<?php

namespace App\Repository;

use App\Entity\Gene;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Gene|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gene|null findOneBy(array $criteria, array $orderBy = null)
 * @method Gene[]    findAll()
 * @method Gene[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GeneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gene::class);
    }

    // /**
    //  * @return Gene[] Returns an array of Gene objects
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
    public function findOneBySomeField($value): ?Gene
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
