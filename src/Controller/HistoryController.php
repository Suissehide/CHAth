<?php

namespace App\Controller;

use App\Entity\Liste;
use App\Entity\Participant;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HistoryController extends AbstractController
{
    /**
     * @Route("/participant/{id}/history/{pos}", name="erreur")
     */
    public function index(Participant $participant, int $pos, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        // $list = $em->getRepository(Liste::class)->findAllErrorField();

        return $this->render('erreur/index.html.twig', [
            'controller_name' => 'ErreurController',
            // 'error_list' => $list
        ]);
    }
}
