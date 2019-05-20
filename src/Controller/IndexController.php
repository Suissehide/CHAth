<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Repository\ParticipantRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class IndexController extends AbstractController
{
    /**
     * @Route("/index", name="index_participant")
     */
    public function index(ParticipantRepository $participantRepository, Request $request): Response
    {
        if ($request->isXmlHttpRequest()) {
            $current = $request->request->get('current');
            $rowCount = $request->request->get('rowCount');
            $searchPhrase = $request->request->get('searchPhrase');
            $sort = $request->request->get('sort');

            $participants = $participantRepository->findByFilter($sort, $searchPhrase);
            if ($searchPhrase != "") {
                $count = count($participants->getQuery()->getResult());
            } else {
                $count = $participantRepository->compte();
            }
            if ($rowCount != -1) {
                $min = ($current - 1) * $rowCount;
                $max = $rowCount;
                $participants->setMaxResults($max)->setFirstResult($min);
            }
            $participants = $participants->getQuery()->getResult();
            $rows = array();
            foreach ($participants as $participant) {
                $observ = $participant->getNumero() ? 1 : 0;
                $sortie = 0;
                if ($participant->getCode())
                    $sortie = 1;
                $row = array(
                    "id" => $participant->getId(),
                    "nom" => $participant->getNom(),
                    "prenom" => $participant->getPrenom(),
                    "code" => $participant->getCode(),
                    "numero" => $participant->getNumero(),
                    "status" => $sortie,
                    "observ" => $observ,
                );
                array_push($rows, $row);
            }

            $data = array(
                "current" => intval($current),
                "rowCount" => intval($rowCount),
                "rows" => $rows,
                "total" => intval($count)
            );
            return new JsonResponse($data);
        }

        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }
}
