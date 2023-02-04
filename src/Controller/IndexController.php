<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Repository\ParticipantRepository;

use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class IndexController extends AbstractController
{
    public function __construct(private \Doctrine\Persistence\ManagerRegistry $managerRegistry, private \Symfony\Component\Serializer\SerializerInterface $serializer)
    {
    }

    #[Route(path: '/index', name: 'index_participant')]
    public function index(ParticipantRepository $participantRepository, Request $request): Response
    {
        if ($request->isXmlHttpRequest()) {
            $current = $request->get('current');
            $rowCount = $request->get('rowCount');
            $searchPhrase = $request->get('searchPhrase');
            $sort = $request->get('sort');

            $participants = $participantRepository->findByFilter($sort, $searchPhrase);
            if ($searchPhrase != "") {
                $count = is_countable($participants->getQuery()->getResult()) ? count($participants->getQuery()->getResult()) : 0;
            } else {
                $count = $participantRepository->getCount();
            }
            if ($rowCount != -1) {
                $min = ($current - 1) * $rowCount;
                $max = $rowCount;
                $participants->setMaxResults($max)->setFirstResult($min);
            }
            $participants = $participants->getQuery()->getResult();
            $rows = [];
            foreach ($participants as $participant) {
                $validation = 0;
                if ($participant->getValidation()) {
                    $validation = 1;
                }

                $row = [
                    "id" => $participant->getId(),
                    "code" => $participant->getCode(),
                    "consentement" => $participant->getVerification()->getDate() ? $participant->getVerification()->getDate()->format('d/m/Y') : '',
                    "evenement" => $participant->getInformation()->getDateSurvenue() ? $participant->getInformation()->getDateSurvenue()->format('d/m/Y') : '',
                    "inclusion" => $participant->getDonnee()->getDateVisite() ? $participant->getDonnee()->getDateVisite()->format('d/m/Y') : '',
                    "error" => '', "status" => $validation
                ];
                array_push($rows, $row);
            }

            $data = [
                "current" => intval($current),
                "rowCount" => intval($rowCount),
                "rows" => $rows,
                "total" => intval($count)
            ];

            return new JsonResponse($data);
        }

        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    #[Route(path: '/advancement', name: 'advancement', methods: 'GET|POST')]
    public function advancement(Request $request, PersistenceManagerRegistry $doctrine): Response
    {
        $conn = $this->managerRegistry->getConnection();

        if ($request->isXmlHttpRequest()) {
            $id = $request->get('id');
            $participant = $doctrine->getRepository(Participant::class)->find($id);

            $RAW_QUERY = 'SELECT f.field_id
            FROM (
                SELECT field_id, max(date_creation) AS maxdate
                FROM erreur
                GROUP BY field_id, participant_id
            ) AS x
            INNER JOIN erreur AS f ON f.etat = "error" AND f.field_id = x.field_id AND f.date_creation = x.maxdate AND f.participant_id = ' . $participant->getId() . ';';
            $statement = $conn->prepare($RAW_QUERY);
            $resultSet = $statement->executeQuery();
            $errors = $resultSet->fetchAllAssociative();

            session_write_close();

            $json = $this->serializeEntity($participant);

            $arr = [];
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
        $res = $this->serializer->normalize(
            $data,
            'json',
            ['groups' => ['advancement']]
        );
        return $res;
    }

    #[Route(path: '/export/csv', name: 'export_csv', methods: 'GET')]
    public function generateCsvAction(ParticipantRepository $participantRepository)
    {
        $serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);

        $res = $this->serializer->normalize(
            $participantRepository->findAll(),
            'json',
            ['groups' => ['export']]
        );
        $data = $serializer->encode($res, 'csv');

        $data = str_replace(",", ";", $data);
        $fileName = "export_participant_" . date("d_m_Y") . ".csv";
        $response = new Response($data);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8; application/excel');
        $response->headers->set('Content-Disposition', 'attachment; filename=' . $fileName);
        echo "\xEF\xBB\xBF"; // UTF-8 with BOM
        return $response;
    }
}
