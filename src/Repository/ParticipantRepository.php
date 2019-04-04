<?php

namespace App\Repository;

use App\Entity\Participant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Participant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Participant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Participant[]    findAll()
 * @method Participant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticipantRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Participant::class);
    }

    public function compte()
    {
        return $this->createQueryBuilder('p')
                    ->select('COUNT(p)')
                    ->getQuery()
                    ->getSingleScalarResult();
    }

    public function findByFilter($sort, $searchPhrase)
    {
        $qb = $this->createQueryBuilder('p');

        if ($searchPhrase != "") {
            $qb->andWhere('
                    p.nom LIKE :search
                    OR p.prenom LIKE :search
                ')
                ->setParameter('search', '%' . $searchPhrase . '%');
        }
        if ($sort) {
            foreach ($sort as $key => $value) {
                $qb->orderBy('p.' . $key, $value);
            }
        } else {
            $qb->orderBy('p.nom', 'ASC');
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
