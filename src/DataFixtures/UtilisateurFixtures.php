<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UtilisateurFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ManagerRegistry $manager)
    {

        $roles = [];
        $roles[] = 'ROLE_ADMIN';
        $utilisateur = new Utilisateur();
        $utilisateur->setEmail("admin@qwetle.fr");
        $utilisateur->setNom("Couffinhal");
        $utilisateur->setPrenom("Léo");
        $utilisateur->setPassword($this->passwordHasher->hashPassword(
            $utilisateur,
            'Admin123'
        ));
        $utilisateur->setRoles($roles);
        $manager->persist($utilisateur);

        $roles[] = 'ROLE_SUPER_ADMIN';
        $utilisateur = new Utilisateur();
        $utilisateur->setEmail("thierry.couffinhal@inserm.fr");
        $utilisateur->setNom("Couffinhal");
        $utilisateur->setPrenom("Thierry");
        $utilisateur->setPassword($this->passwordHasher->hashPassword(
            $utilisateur,
            'Admin123'
        ));
        $utilisateur->setRoles($roles);
        $manager->persist($utilisateur);

        $manager->flush();
    }
}
