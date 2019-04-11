<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\Verification;

use App\Form\ParticipantType;
use App\Form\VerificationType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class ParticipantController extends AbstractController
{
    /**
     * @Route("/participant/add", name="participant_add", methods="GET|POST")
     */
    public function add(Request $request): Response
    {
        $participant = new Participant();
        $form = $this->createForm(ParticipantType::class, $participant);

        $em = $this->getDoctrine()->getManager();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('validation')->isClicked()) {
                $participant = $form->getData();

                if ($participant->getCode() == '')
                    $participant->setCode('ERROR');

                $em->persist($participant);
                $em->flush();
            }
            return $this->redirectToRoute('participant_view', ['id' => $participant->getId()]);
        }
        return $this->render('participant/create.html.twig', [
            'title' => 'Ajouter un participant',
            'controller_name' => 'ParticipantController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/participant/{id}", name="participant_view")
     */
    public function index(Participant $participant, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('validation')->isClicked()) {
                $participant = $form->getData();
                $em->flush();
            }
            return $this->redirectToRoute('index');
        }

        $verification = new Verification();
        $formVerification = $this->createForm(VerificationType::class, $verification);

        return $this->render('participant/index.html.twig', [
            'controller_name' => 'ParticipantController',
            'participant' => $participant,
            'form' => $form->createView(),
            'formVerification' => $formVerification->createView(),
        ]);
    }

    /**
     * @Route("/generate", name="participant_code_generate", methods="GET|POST")
     */
    public function rendezVous_date_error(Request $request): JsonResponse
    {
        if ($request->isXmlHttpRequest()) {
            $nom = $this->stripAccents($request->request->get('nom'));
            $prenom = $this->stripAccents($request->request->get('prenom'));
            $ligne = intval($request->request->get('ligne'));
            if ($ligne < 1 || $ligne > 10 || strlen($nom) < 2 || strlen($prenom) < 2)
                return new JsonResponse('');
            $base = array(
                substr($nom, 0, 1),
                substr($nom, 1, 1),
                substr($prenom, 0, 1),
                substr($prenom, 1, 1),
            );
            $array = array(
                array('C', 'J', 'Q', 'Y', 'Z', 'H', 'V', 'S', 'U', 'W', 'M', 'O', 'D', 'T', 'X', 'N', 'F', 'I', 'A', 'E', 'G', 'B', 'K' ,'L', 'R', 'P'),
                array('C', 'J', 'Q', 'Y', 'Z', 'H', 'V', 'S', 'U', 'W', 'M', 'O', 'D', 'T', 'X', 'N', 'F', 'I', 'A', 'E', 'G', 'B', 'K' ,'L', 'R', 'P'),
                array('C', 'J', 'Q', 'Y', 'Z', 'H', 'V', 'S', 'U', 'W', 'M', 'O', 'D', 'T', 'X', 'N', 'F', 'I', 'A', 'E', 'G', 'B', 'K' ,'L', 'R', 'P'),
                array('C', 'J', 'Q', 'Y', 'Z', 'H', 'V', 'S', 'U', 'W', 'M', 'O', 'D', 'T', 'X', 'N', 'F', 'I', 'A', 'E', 'G', 'B', 'K' ,'L', 'R', 'P'),
                array('C', 'J', 'Q', 'Y', 'Z', 'H', 'V', 'S', 'U', 'W', 'M', 'O', 'D', 'T', 'X', 'N', 'F', 'I', 'A', 'E', 'G', 'B', 'K' ,'L', 'R', 'P'),
                array('C', 'J', 'Q', 'Y', 'Z', 'H', 'V', 'S', 'U', 'W', 'M', 'O', 'D', 'T', 'X', 'N', 'F', 'I', 'A', 'E', 'G', 'B', 'K' ,'L', 'R', 'P'),
                array('C', 'J', 'Q', 'Y', 'Z', 'H', 'V', 'S', 'U', 'W', 'M', 'O', 'D', 'T', 'X', 'N', 'F', 'I', 'A', 'E', 'G', 'B', 'K' ,'L', 'R', 'P'),
                array('C', 'J', 'Q', 'Y', 'Z', 'H', 'V', 'S', 'U', 'W', 'M', 'O', 'D', 'T', 'X', 'N', 'F', 'I', 'A', 'E', 'G', 'B', 'K' ,'L', 'R', 'P'),
                array('C', 'J', 'Q', 'Y', 'Z', 'H', 'V', 'S', 'U', 'W', 'M', 'O', 'D', 'T', 'X', 'N', 'F', 'I', 'A', 'E', 'G', 'B', 'K' ,'L', 'R', 'P'),
                array('C', 'J', 'Q', 'Y', 'Z', 'H', 'V', 'S', 'U', 'W', 'M', 'O', 'D', 'T', 'X', 'N', 'F', 'I', 'A', 'E', 'G', 'B', 'K' ,'L', 'R', 'P'),
            );
            $code = $array[$ligne - 1][$this->getAlphaPos($base[0])] . $array[$ligne - 1][$this->getAlphaPos($base[1])]
                . $array[$ligne - 1][$this->getAlphaPos($base[2])] . $array[$ligne - 1][$this->getAlphaPos($base[3])];

            return new JsonResponse($code);
        }
    }

    private function getAlphaPos($letterOfAlphabet)
    {
        return ord(strtoupper($letterOfAlphabet)) - ord('A');
    }

    private function stripAccents($stripAccents)
    {
        return strtr(utf8_decode($stripAccents), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
    }
}
