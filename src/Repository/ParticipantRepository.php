<?php

namespace App\Repository;

use App\Entity\Participant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Participant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Participant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Participant[]    findAll()
 * @method Participant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticipantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Participant::class);
    }

    public function getCount()
    {
        return $this->createQueryBuilder('p')
            ->select('COUNT(p)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findByFilter($sort, $searchPhrase)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->leftJoin('p.verification', 'v');
        $qb->leftJoin('p.information', 'i');
        $qb->leftJoin('p.donnee', 'd');

        if ($searchPhrase != "") {
            $qb->andWhere('
                    p.code LIKE :search
                    OR v.date LIKE :search
                    OR i.dateSurvenue LIKE :search
                    OR d.dateVisite LIKE :search
                ')
                ->setParameter('search', '%' . $searchPhrase . '%');
        }
        if ($sort) {
            foreach ($sort as $key => $value) {
                if ($key == 'consentement')
                    $qb->orderBy('v.date', $value);
                else if ($key == 'evenement')
                    $qb->orderBy('i.dateSurvenue', $value);
                else if ($key == 'inclusion')
                    $qb->orderBy('d.dateVisite', $value);
                else if ($key == 'code')
                    $qb->orderBy('p.id', $value);
                else
                    $qb->orderBy('p.' . $key, $value);
            }
        } else {
            $qb->orderBy('p.id', 'DESC');
        }
        return $qb;
    }

    // /**
    //  * @return Participant[] Returns an array of Participant objects
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
    public function findOneBySomeField($value): ?Participant
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
