<?php

namespace App\Controller;

use App\Repository\ErreurRepository;
use App\Repository\ParticipantRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

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


                $RAW_QUERY = 'SELECT f.field_id, f.participant_id
                from (
                   SELECT field_id, max(date) AS maxdate, etat
                   FROM erreur GROUP BY field_id, id
                ) AS x 
                INNER JOIN erreur AS f ON f.etat = "error" AND f.field_id = x.field_id AND f.date = x.maxdate AND f.participant_id = ' . $participant->getId() . ';';
                $statement = $em->getConnection()->prepare($RAW_QUERY);
                $statement->execute();
                // dump($statement->fetchAll());
                $error = $statement->fetchAll();

                // $RAW = 'SELECT CONCAT(
                //     \'SELECT * FROM `db_chath`.`participant` WHERE CONCAT(\',
                //     (SELECT GROUP_CONCAT(COLUMN_NAME)
                //         FROM `information_schema`.`COLUMNS`
                //         WHERE `TABLE_SCHEMA` = \'db_chath\' AND
                //         `TABLE_NAME` = \'participant\'
                //         AND `IS_NULLABLE` = \'YES\'),
                //     \') IS NOT NULL\');';
                // $st = $em->getConnection()->prepare($RAW);
                // $st->execute();
                // dump($st->fetchAll());

                // dump($participantRepository->test());

                $sortie = 0;
                if ($participant->getCode())
                    $sortie = 1;
                $row = array(
                    "id" => $participant->getId(),
                    "code" => $participant->getCode(),
                    "consentement" => $participant->getVerification()->getDate() ? $participant->getVerification()->getDate()->format('d/m/Y') : '',
                    "evenement" => $participant->getInformation()->getDateSurvenue() ? $participant->getInformation()->getDateSurvenue()->format('d/m/Y') : '',
                    "inclusion" => $participant->getDonnee()->getDateVisite() ? $participant->getDonnee()->getDateVisite()->format('d/m/Y') : '',
                    "error" => count($error) / 2,
                    "status" => $sortie,
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

    /**
     * @Route("/", name="export_csv", methods="GET")
     */
    public function generateCsvAction(ParticipantRepository $participantRepository)
    {
        $serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);

        $res = $this->get('serializer')->normalize(
            $participantRepository->findAll(),
            'json',
            ['groups' => ['export']]
        );
        $data = $serializer->encode($res, 'csv');

        $data = str_replace(",", ";", $data);
        $fileName = "export_participant_" . date("d_m_Y") . ".csv";
        $response = new Response($data);
        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8; application/excel');
        $response->headers->set('Content-Disposition', 'attachment; filename=' . $fileName);
        echo "\xEF\xBB\xBF"; // UTF-8 with BOM
        return $response;
    }
}
