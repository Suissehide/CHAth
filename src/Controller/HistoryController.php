<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Repository\ErreurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class HistoryController extends AbstractController
{
    private function formatDate(\DateTime $date) {
        $formatter = new \IntlDateFormatter(
            \Locale::getDefault(),
            \IntlDateFormatter::MEDIUM,
            \IntlDateFormatter::SHORT,
        );
        return $formatter->format($date);
    }

    /**
     * @Route("/participant/{participant}/history/{fieldId}", name="history_list_field")
     */
    public function index(ErreurRepository $erreurRepository, Participant $participant, $fieldId, Request $request): Response
    {  
        if ($request->isXmlHttpRequest()) {
            $current = $request->request->get('current');
            $rowCount = $request->request->get('rowCount');
            $searchPhrase = $request->request->get('searchPhrase');
            $sort = $request->request->get('sort');
            $participantId = $request->request->get('participantId');
            $fieldId = $request->request->get('fieldId');

            $erreurs = $erreurRepository->findByFilter($sort, $searchPhrase, $participantId, $fieldId);
            if ($searchPhrase != "")
                $count = count($erreurs->getQuery()->getResult());
            else
                $count = $erreurRepository->getCount($participantId, $fieldId);
            if ($rowCount != -1) {
                $min = ($current - 1) * $rowCount;
                $max = $rowCount;
                $erreurs->setMaxResults($max)->setFirstResult($min);
            }
            $erreurs = $erreurs->getQuery()->getResult();
            $rows = array();
            foreach ($erreurs as $erreur) {
                $row = array(
                    "id" => $erreur->getId(),
                    "date" => $this->formatDate($erreur->getDate()),
                    "utilisateur" => $erreur->getUtilisateur(),
                    "message" => $erreur->getMessage(),
                    "etat" => $erreur->getEtat(),
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

        return $this->render('history/index.html.twig', [
            'controller_name' => 'ErreurController',
            'code_participant' => $participant->getCode(),
            'id_participant' => $participant->getId(),
            'id_field' => $fieldId,
        ]);
    }
}
