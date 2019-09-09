<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ErreurController extends AbstractController
{
    /**
     * @Route("/erreur", name="erreur")
     */
    public function index()
    {
        return $this->render('erreur/index.html.twig', [
            'controller_name' => 'ErreurController',
        ]);
    }
}
