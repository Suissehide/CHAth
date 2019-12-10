<?php

namespace App\Repository;

use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Utilisateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Utilisateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Utilisateur[]    findAll()
 * @method Utilisateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UtilisateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Utilisateur::class);
    }

    public function compte()
    {
        return $this->createQueryBuilder('p')
                    ->select('COUNT(p)')
                    ->getQuery()
                    ->getSingleScalarResult();
    }

    public function findByFilter($sort, $searchPhrase, $roles)
    {
        $qb = $this->createQueryBuilder('p');
        if ($roles) {
            foreach($roles as $index => $role) {
                $qb->orWhere("p.roles LIKE :role$index");
                $qb->setParameter("role$index", '%' .$role. '%');
            }
        }
        if ($searchPhrase != "") {
            $qb->andWhere('
                    p.nom LIKE :search
                    OR p.prenom LIKE :search
                    OR p.email LIKE :search
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
    //  * @return Utilisateur[] Returns an array of Utilisateur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Utilisateur
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
