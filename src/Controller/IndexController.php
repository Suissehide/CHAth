<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Repository\ErreurRepository;
use App\Repository\ParticipantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
                $sortie = 0;
                if ($participant->getCode()) {
                    $sortie = 1;
                }

                $row = array(
                    "id" => $participant->getId(),
                    "code" => $participant->getCode(),
                    "consentement" => $participant->getVerification()->getDate() ? $participant->getVerification()->getDate()->format('d/m/Y') : '',
                    "evenement" => $participant->getInformation()->getDateSurvenue() ? $participant->getInformation()->getDateSurvenue()->format('d/m/Y') : '',
                    "inclusion" => $participant->getDonnee()->getDateVisite() ? $participant->getDonnee()->getDateVisite()->format('d/m/Y') : '',
                    "error" => '',
                    "status" => $sortie,
                );
                array_push($rows, $row);
            }

            $data = array(
                "current" => intval($current),
                "rowCount" => intval($rowCount),
                "rows" => $rows,
                "total" => intval($count),
            );
            return new JsonResponse($data);
        }

        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    /**
     * @Route("/advancement", name="advancement", methods="GET|POST")
     */
    public function advancement(Request $request): Response
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $id = $request->request->get('id');
            $participant = $this->getDoctrine()->getRepository(Participant::class)->find($id);

            $RAW_QUERY = 'SELECT f.field_id, f.date_creation
            FROM (
                SELECT field_id, max(date_creation) AS maxdate, etat
                FROM erreur
                GROUP BY field_id, participant_id
            ) AS x
            INNER JOIN erreur AS f ON f.etat = "error" AND f.field_id = x.field_id AND f.date_creation = x.maxdate AND f.participant_id = ' . $participant->getId() . ';';
            $statement = $em->getConnection()->prepare($RAW_QUERY);
            $statement->execute();
            $errors = $statement->fetchAll();

            session_write_close();

            $json = $this->serializeEntity($participant);

            $arr = array();
            $iter = 0;
            foreach ($json as $item) {
                if (($i = $this->isError($iter, $errors)) != 0) {
                    array_push($arr, '{"state": "error", "number": "' . $i . '"}');
                }
                // else if (($i = $this->isCompleted($item, 0)) == 0)
                else if (!$this->array_searchRecursive(null, $item)) {
                    array_push($arr, '{"state": "completed", "number": "&nbsp;"}');
                } else {
                    // array_push($arr, '{"state": "unfinished", "number": "' . $i . '"}');
                    array_push($arr, '{"state": "unfinished", "number": "&nbsp;"}');
                }
                $iter += 1;
            }
            return new JsonResponse($arr);
        }
    }

    private function isError($iter, $errors)
    {
        $err = 0;
        $list = ['verification', 'general', 'cardiovasculaire', 'information', 'donnee', 'deces'];
        foreach ($errors as $error) {
            if (explode('_', $error['field_id'])[0] == $list[$iter]) {
                $err++;
            }

        }
        return $err;
    }

    private function isCompleted($data, $i)
    {
        foreach ($data as $item) {
            if (is_array($item))
                $i = $this->isCompleted($item, $i);
            if ($item === null)
                $i += 1;
        }
        return $i;
    }

    public function array_searchRecursive($needle, $haystack, $strict = false)
    {
        if (!is_array($haystack))
            return false;
        foreach ($haystack as $key => $val) {
            if (is_array($val) && $this->array_searchRecursive($needle, $val, $strict)) {
                return true;
            } elseif ((!$strict && $val == $needle) || ($strict && $val === $needle)) {
                return true;
            }
        }
        return false;
    }

    private function serializeEntity($data)
    {
        $res = $this->get('serializer')->normalize(
            $data,
            'json',
            ['groups' => ['advancement']]
        );
        return $res;
    }
}
