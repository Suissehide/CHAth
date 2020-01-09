<?php

namespace App\Repository;

use App\Entity\Erreur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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

    public function getCountAll($participantId)
    {
        return $this->createQueryBuilder('e')
                    ->leftJoin('e.participant', 'p')
                    ->andWhere('p.id = :participantId')
                    ->setParameters(['participantId' => $participantId])
                    ->select('COUNT(e)')
                    ->getQuery()
                    ->getSingleScalarResult();
    }
    
    public function findHistory($sort, $searchPhrase, $participantId)
    {
        $qb = $this->createQueryBuilder('e')
        ->leftJoin('e.participant', 'p')
        ->andWhere('p.id = :participantId')
        ->setParameters(['participantId' => $participantId]);

        if ($searchPhrase != "") {
            $qb->andWhere('
                    e.utilisateur LIKE :search
                    OR e.message LIKE :search
                    OR e.date LIKE :search
                ')
                ->setParameter('search', '%' . $searchPhrase . '%');
        }
        if ($sort) {
            foreach ($sort as $key => $value) {
                $qb->orderBy('e.' . $key, $value);
            }
        } else {
            $qb->orderBy('e.date', 'DESC');
        }
        return $qb;
    }

    public function getLastErreur($participantId)
    {
        $qb = $this->createQueryBuilder('e')
            ->leftJoin('e.participant', 'p')
            ->andWhere('p.id = :participantId')
            ->setParameters(['participantId' => $participantId])
            ->groupBy('e.id', 'e.fieldId')
            ->orderBy('e.date', 'DESC')
            ->getQuery()
            ->getResult();
        return $qb;
    }

    public function getCount($participantId, $fieldId)
    {
        return $this->createQueryBuilder('e')
                    ->andWhere('e.fieldId = :fieldId')
                    ->leftJoin('e.participant', 'p')
                    ->andWhere('p.id = :participantId')
                    ->setParameters(['participantId' => $participantId, 'fieldId' => $fieldId])
                    ->select('COUNT(e)')
                    ->getQuery()
                    ->getSingleScalarResult();
    }

    public function findByFilter($sort, $searchPhrase, $participantId, $fieldId)
    {
        $qb = $this->createQueryBuilder('e')
        ->andWhere('e.fieldId = :fieldId')
        ->leftJoin('e.participant', 'p')
        ->andWhere('p.id = :participantId')
        ->setParameters(['participantId' => $participantId, 'fieldId' => $fieldId]);

        if ($searchPhrase != "") {
            $qb->andWhere('
                    e.utilisateur LIKE :search
                    OR e.message LIKE :search
                    OR e.date LIKE :search
                ')
                ->setParameter('search', '%' . $searchPhrase . '%');
        }
        if ($sort) {
            foreach ($sort as $key => $value) {
                $qb->orderBy('e.' . $key, $value);
            }
        } else {
            $qb->orderBy('e.date', 'DESC');
        }
        return $qb;
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
