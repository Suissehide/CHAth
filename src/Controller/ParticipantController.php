<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\Verification;
use App\Entity\Qcm;
use App\Entity\Pack;

use App\Form\ParticipantType;
use App\Form\VerificationType;
use App\Form\QcmType;

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

                $verification = new Verification();

                $pack = new Pack();

                $qcm = new Qcm();
                $qcm->setQuestion("Patients (homme ou femme) âgés de plus de 80 ans");
                $pack->addQcm($qcm);
                $qcm = new Qcm();
                $qcm->setQuestion("Patient présentant un premier ECV (Infarctus du myocarde - IDM) d’origine athéromateuse datant de 6 mois (+/- 15 jours)");
                $pack->addQcm($qcm);
                $qcm = new Qcm();
                $qcm->setQuestion("Absence de preuve pour une hémopathie maligne avérée (connue ou révélée sur les résultats de NFS)");
                $pack->addQcm($qcm);
                $qcm = new Qcm();
                $qcm->setQuestion("Sujet affilié ou bénéficiaire d’un régime de sécurité sociale");
                $pack->addQcm($qcm);

                $verification->setInclusion($pack);

                $pack = new Pack();

                $qcm = new Qcm();
                $qcm->setQuestion("Patient ayant présenté un ECV d’origine non-athéromateuse (dissection, embolique, ...)");
                $pack->addQcm($qcm);
                $qcm = new Qcm();
                $qcm->setQuestion("Patient présentant un diabète mal équilibré (HbA1c > 10%)");
                $pack->addQcm($qcm);
                $qcm = new Qcm();
                $qcm->setQuestion("Patient ayant présenté un ou plusieurs ECV avant 80 ans : IDM, coronaropathie, AOMI, sténose carotidienne significative, accident vasculaire cérébral (AVC) d’origine athéromateuse");
                $pack->addQcm($qcm);
                $qcm = new Qcm();
                $qcm->setQuestion("Patient présentant une hémopathie maligne manifeste (connue ou révélée sur les résultats de NFS)");
                $pack->addQcm($qcm);
                $qcm = new Qcm();
                $qcm->setQuestion("Patient présentant une maladie inflammatoire chronique (cancer, vascularite, rhumatismale, hépato-gastro-intestinales)");
                $pack->addQcm($qcm);
                $qcm = new Qcm();
                $qcm->setQuestion("Patient traité par anti-inflammatoire au long cours (Corticoïdes, Anti-inflammatoires non stéroïdiens, Aspirine > 325mg/jour, Inhibiteurs de la cyclo-oxygénase II)");
                $pack->addQcm($qcm);
                $qcm = new Qcm();
                $qcm->setQuestion("Personne placée sous sauvegarde de justice, tutelle ou curatelle");
                $pack->addQcm($qcm);
                $qcm = new Qcm();
                $qcm->setQuestion("Personne étant dans l’incapacité de donner son consentement");
                $pack->addQcm($qcm);
                $qcm = new Qcm();
                $qcm->setQuestion("Personne étant dans l’incapacité de donner son consentement");
                $pack->addQcm($qcm);

                $verification->setNonInclusion($pack);

                $em->persist($verification);
                $em->flush();
                $participant->setVerification($verification);

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
                array('Q', 'N', 'B', 'G', 'V', 'K', 'P', 'U', 'X', 'H', 'W', 'R', 'Z', 'M', 'E', 'I', 'C', 'L', 'Y', 'S', 'O', 'D', 'J', 'A', 'T', 'F'),
                array('V', 'G', 'S', 'M', 'L', 'C', 'Z', 'D', 'B', 'Q', 'R', 'U', 'H', 'A', 'X', 'P', 'E', 'K', 'W', 'I', 'T', 'Y', 'F', 'O', 'N', 'J'),
                array('K', 'H', 'L', 'R', 'I', 'Y', 'W', 'Q', 'S', 'J', 'U', 'F', 'A', 'Z', 'G', 'O', 'C', 'B', 'D', 'P', 'M', 'V', 'N', 'E', 'X', 'T'),
                array('E', 'D', 'C', 'Z', 'K', 'B', 'U', 'M', 'W', 'R', 'Q', 'L', 'V', 'A', 'T', 'J', 'G', 'F', 'H', 'X', 'P', 'O', 'S', 'I', 'N', 'Y'),
                array('C', 'L', 'M', 'A', 'D', 'T', 'G', 'I', 'Y', 'O', 'V', 'X', 'K', 'B', 'S', 'Z', 'J', 'E', 'W', 'N', 'Q', 'F', 'P', 'U', 'H', 'R'),
                array('A', 'K', 'J', 'F', 'S', 'Z', 'T', 'C', 'E', 'D', 'U', 'Y', 'O', 'P', 'G', 'R', 'M', 'L', 'I', 'V', 'X', 'B', 'H', 'N', 'W', 'Q'),
                array('D', 'M', 'P', 'I', 'Z', 'L', 'B', 'V', 'K', 'S', 'Q', 'O', 'T', 'U', 'J', 'H', 'R', 'W', 'G', 'E', 'C', 'A', 'Y', 'F', 'N', 'X'),
                array('W', 'B', 'T', 'A', 'S', 'D', 'Y', 'U', 'F', 'E', 'R', 'Q', 'I', 'Z', 'H', 'V', 'J', 'N', 'K', 'G', 'X', 'P', 'O', 'L', 'C', 'M'),
                array('A', 'P', 'Z', 'N', 'W', 'C', 'S', 'G', 'O', 'B', 'I', 'Y', 'D', 'L', 'M', 'Q', 'U', 'R', 'T', 'J', 'F', 'K', 'V', 'X', 'H', 'E'),
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

    /**
     * @Route("/{id}", name="participant_delete", methods="DELETE")
     */
    public function delete(Request $request, Participant $participant) : Response
    {
        dump($this->isCsrfTokenValid('delete' . $participant->getId(), $request->request->get('_token')));
        
        if ($this->isCsrfTokenValid('delete' . $participant->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($participant);
            $em->flush();
        }

        return $this->redirectToRoute('index');
    }
}
