<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UtilisateurFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {

        $roles[] = 'ROLE_ADMIN';
        $utilisateur = new Utilisateur();
        $utilisateur->setEmail("admin@qwetle.fr");
        $utilisateur->setNom("Couffinhal");
        $utilisateur->setPrenom("Léo");
        $utilisateur->setPassword($this->passwordEncoder->encodePassword(
            $utilisateur,
            'Admin123'
        ));
        $utilisateur->setRoles($roles);
        $manager->persist($utilisateur);

        $roles[] = 'ROLE_SUPER_ADMIN';
        $utilisateur = new Utilisateur();
        $utilisateur->setEmail("thierry.couffinhal@free.fr");
        $utilisateur->setNom("Couffinhal");
        $utilisateur->setPrenom("Thierry");
        $utilisateur->setPassword($this->passwordEncoder->encodePassword(
            $utilisateur,
            'Admin123'
        ));
        $utilisateur->setRoles($roles);
        $manager->persist($utilisateur);

        $manager->flush();
    }
}
