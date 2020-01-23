<?php

namespace App\Controller;

use App\Repository\ErreurRepository;
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
    public function index(ParticipantRepository $participantRepository, ErreurRepository $erreurRepository, Request $request): Response
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
                $count = $participantRepository->getCount();
            }
            if ($rowCount != -1) {
                $min = ($current - 1) * $rowCount;
                $max = $rowCount;
                $participants->setMaxResults($max)->setFirstResult($min);
            }
            $participants = $participants->getQuery()->getResult();
            $rows = array();
            foreach ($participants as $participant) {
                // $observ = $participant->getNumero() ? 1 : 0;
                // $error = $erreurRepository->countAllErreur($participant->getId());

                $em = $this->getDoctrine()->getManager();
                $RAW_QUERY = 'SELECT f.field_id
                from (
                   SELECT field_id, max(date) AS maxdate, etat
                   FROM erreur GROUP BY field_id, id
                ) AS x 
                INNER JOIN erreur AS f ON f.etat = "error" AND f.field_id = x.field_id AND f.date = x.maxdate;';
                $statement = $em->getConnection()->prepare($RAW_QUERY);
                $statement->execute();
                $error = $statement->fetchAll();

                $sortie = 0;
                if ($participant->getCode())
                    $sortie = 1;
                $row = array(
                    "id" => $participant->getId(),
                    "code" => $participant->getCode(),
                    "consentement" => $participant->getVerification()->getDate() ? $participant->getVerification()->getDate()->format('d/m/Y') : '',
                    "evenement" => $participant->getInformation()->getDateSurvenue() ? $participant->getInformation()->getDateSurvenue()->format('d/m/Y') : '',
                    "inclusion" => $participant->getDonnee()->getDateVisite() ? $participant->getDonnee()->getDateVisite()->format('d/m/Y') : '',
                    "status" => $sortie,
                    "error" => count($error),
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
