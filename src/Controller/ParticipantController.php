<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\Verification;
use App\Entity\Qcm;
use App\Entity\Gene;
use App\Entity\Pack;
use App\Entity\Cardiovasculaire;
use App\Entity\Donnee;
use App\Entity\Information;
use App\Entity\Erreur;

use App\Form\ParticipantType;
use App\Form\VerificationType;
use App\Form\GeneralType;
use App\Form\CardiovasculaireType;
use App\Form\DecesType;
use App\Form\InformationType;
use App\Form\DonneeType;


use App\Repository\ErreurRepository;

use DateTime;
use DateTimeZone;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

use Symfony\Component\Security\Core\Security;

class ParticipantController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("/participant/validate", name="participant_validate")
     */
    public function validate(Request $request): Response
    {
        // $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');

        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $validate = $request->request->get('validate');
            $participantId = $request->request->get('participantId');
            $participant = $em->getRepository(Participant::class)->find($participantId);
            $participant->setValidation($validate === 'true' ? true : false);
            if ($validate === 'true')
                $this->addErreur($participant->getId(), $participant->getCode(), 'notice', 'Validation du participant ' . $participant->getCode(), true);
            else
                $this->addErreur($participant->getId(), $participant->getCode(), 'notice', 'Réactivation des modifications', true);
            $em->flush();
            return new JsonResponse('Done.');
        }
    }

    /**
     * @Route("/participant/history", name="history_list")
     */
    public function history(ErreurRepository $erreurRepository, Request $request): Response
    {
        if ($request->isXmlHttpRequest()) {
            $current = $request->request->get('current');
            $rowCount = $request->request->get('rowCount');
            $searchPhrase = $request->request->get('searchPhrase');
            $sort = $request->request->get('sort');
            $participantId = $request->request->get('participantId');

            $erreurs = $erreurRepository->findHistory($sort, $searchPhrase, $participantId);
            if ($searchPhrase != "")
                $count = count($erreurs->getQuery()->getResult());
            else
                $count = $erreurRepository->getCountAll($participantId);
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
                    "fieldId" => $erreur->getFieldId(),
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
    }

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
                $participant->setValidation(false);
                if ($participant->getCode() == '')
                    $participant->setCode('ERROR');
                else {
                    $id = count($em->getRepository(Participant::class)->findAll()) == 0 ? '1' : $em->getRepository(Participant::class)->findOneBy([], ['id' => 'desc'])->getId() + 1;
                    $participant->setCode(strtoupper($participant->getCode()) . $id);
                }

                $this->verification_create($participant, $participant->getVerification()->getDate());
                $this->cardiovasculaire_create($participant);
                $this->information_create($participant);
                $this->donnee_create($participant);

                $em->persist($participant);
                $em->flush();

                $this->addErreur($participant->getId(), $participant->getCode(), 'notice', 'Création du participant ' . $participant->getCode(), true);
            }
            return $this->redirectToRoute('participant_view', ['id' => $participant->getId()]);
        }
        return $this->render('participant/create.html.twig', [
            'title' => 'Ajouter un participant',
            'controller_name' => 'ParticipantController',
            'form' => $form->createView(),
            'verification' => $form->createView(),
        ]);
    }

    private function verification_create(Participant $participant, DateTime $date)
    {
        $em = $this->getDoctrine()->getManager();
        $verification = new Verification();

        $verification->setDate($date);

        $pack = new Pack();

        $qcm = new Qcm();
        $qcm->setQuestion("Patients (homme ou femme) âgés de plus de 80 ans");
        $qcm->setReponse("Oui");
        $pack->addQcm($qcm);
        $qcm = new Qcm();
        $qcm->setQuestion("Patient présentant un premier ECV (Infarctus du myocarde - IDM) d’origine athéromateuse datant de 6 mois (+/- 15 jours)");
        $qcm->setReponse("Oui");
        $pack->addQcm($qcm);
        $qcm = new Qcm();
        $qcm->setQuestion("Absence de preuve pour une hémopathie maligne avérée (connue ou révélée sur les résultats de NFS)");
        $qcm->setReponse("Oui");
        $pack->addQcm($qcm);
        $qcm = new Qcm();
        $qcm->setQuestion("Sujet affilié ou bénéficiaire d’un régime de sécurité sociale");
        $qcm->setReponse("Oui");
        $pack->addQcm($qcm);
        $qcm = new Qcm();
        $qcm->setQuestion("Signature du consentement éclairé");
        $qcm->setReponse("Oui");
        $pack->addQcm($qcm);

        $verification->setInclusion($pack);

        $pack = new Pack();

        $qcm = new Qcm();
        $qcm->setQuestion("Patient ayant présenté un ECV d’origine non-athéromateuse (dissection, embolique, ...)");
        $qcm->setReponse("Non");
        $pack->addQcm($qcm);
        $qcm = new Qcm();
        $qcm->setQuestion("Patient présentant un diabète mal équilibré (HbA1c > 10%)");
        $qcm->setReponse("Non");
        $pack->addQcm($qcm);
        $qcm = new Qcm();
        $qcm->setQuestion("Patient ayant présenté un ou plusieurs ECV avant 80 ans : IDM, coronaropathie, AOMI, sténose carotidienne significative, accident vasculaire cérébral (AVC) d’origine athéromateuse");
        $qcm->setReponse("Non");
        $pack->addQcm($qcm);
        $qcm = new Qcm();
        $qcm->setQuestion("Patient présentant une hémopathie maligne manifeste (connue ou révélée sur les résultats de NFS)");
        $qcm->setReponse("Non");
        $pack->addQcm($qcm);
        $qcm = new Qcm();
        $qcm->setQuestion("Patient présentant une maladie inflammatoire chronique (cancer, vascularite, rhumatismale, hépato-gastro-intestinales)");
        $qcm->setReponse("Non");
        $pack->addQcm($qcm);
        $qcm = new Qcm();
        $qcm->setQuestion("Patient traité par anti-inflammatoire au long cours (Corticoïdes, Anti-inflammatoires non stéroïdiens, Aspirine > 325mg/jour, Inhibiteurs de la cyclo-oxygénase II)");
        $qcm->setReponse("Non");
        $pack->addQcm($qcm);
        $qcm = new Qcm();
        $qcm->setQuestion("Personne placée sous sauvegarde de justice, tutelle ou curatelle");
        $qcm->setReponse("Non");
        $pack->addQcm($qcm);
        $qcm = new Qcm();
        $qcm->setQuestion("Personne étant dans l’incapacité de donner son consentement");
        $qcm->setReponse("Non");
        $pack->addQcm($qcm);
        $qcm = new Qcm();
        $qcm->setQuestion("Sujet non coopérant");
        $qcm->setReponse("Non");
        $pack->addQcm($qcm);

        $verification->setNonInclusion($pack);

        $em->persist($verification);
        $em->flush();
        $participant->setVerification($verification);
    }

    private function cardiovasculaire_create(Participant $participant)
    {
        $em = $this->getDoctrine()->getManager();
        $cardiovasculaire = new Cardiovasculaire();

        $pack = new Pack();

        $qcm = new Qcm();
        $qcm->setQuestion("Diabète");
        $pack->addQcm($qcm);
        $qcm = new Qcm();
        $qcm->setQuestion("Hypertension artérielle");
        $pack->addQcm($qcm);
        $qcm = new Qcm();
        $qcm->setQuestion("Dyslipidémie");
        $pack->addQcm($qcm);

        $cardiovasculaire->setFacteurs($pack);

        $pack = new Pack();

        $qcm = new Qcm();
        $qcm->setQuestion("Hypocholestérolémiant");
        $pack->addQcm($qcm);
        $qcm = new Qcm();
        $qcm->setQuestion("Antihypertenseur");
        $pack->addQcm($qcm);
        $qcm = new Qcm();
        $qcm->setQuestion("Antidiabétique");
        $pack->addQcm($qcm);
        $qcm = new Qcm();
        $qcm->setQuestion("Antiagrégant");
        $pack->addQcm($qcm);

        $cardiovasculaire->setTraitement($pack);

        $em->persist($cardiovasculaire);
        $em->flush();
        $participant->setCardiovasculaire($cardiovasculaire);
    }

    private function information_create(Participant $participant)
    {
        $em = $this->getDoctrine()->getManager();
        $information = new Information();

        $pack = new Pack();

        $qcm = new Qcm();
        $qcm->setQuestion("Sus-décalage du segment ST");
        $pack->addQcm($qcm);

        $qcm = new Qcm();
        $qcm->setQuestion("Antérieur");
        $pack->addQcm($qcm);
        $qcm = new Qcm();
        $qcm->setQuestion("Septo-apical");
        $pack->addQcm($qcm);
        $qcm = new Qcm();
        $qcm->setQuestion("Latéral");
        $pack->addQcm($qcm);
        $qcm = new Qcm();
        $qcm->setQuestion("Inférieur");
        $pack->addQcm($qcm);
        $qcm = new Qcm();
        $qcm->setQuestion("Sans territoire");
        $pack->addQcm($qcm);
    
        $qcm = new Qcm();
        $qcm->setQuestion("IVA");
        $pack->addQcm($qcm);
        $qcm = new Qcm();
        $qcm->setQuestion("CD");
        $pack->addQcm($qcm);
        $qcm = new Qcm();
        $qcm->setQuestion("Cx");
        $pack->addQcm($qcm);
        $qcm = new Qcm();
        $qcm->setQuestion("Marginale");
        $pack->addQcm($qcm);
        $qcm = new Qcm();
        $qcm->setQuestion("Diagonale");
        $pack->addQcm($qcm);
        $qcm = new Qcm();
        $qcm->setQuestion("Pontage");
        $pack->addQcm($qcm);

        $information->setType($pack);

        $pack = new Pack();

        $qcm = new Qcm();
        $qcm->setQuestion("Trouble du rythme ventriculaire");
        $pack->addQcm($qcm);
        $qcm = new Qcm();
        $qcm->setQuestion("Insuffisance cardiaque");
        $pack->addQcm($qcm);
        $qcm = new Qcm();
        $qcm->setQuestion("Péricardite");
        $pack->addQcm($qcm);
        $qcm = new Qcm();
        $qcm->setQuestion("Complication mécanique");
        $pack->addQcm($qcm);

        $information->setComplications($pack);

        $em->persist($information);
        $em->flush();
        $participant->setInformation($information);
    }

    private function donnee_create(Participant $participant)
    {
        $em = $this->getDoctrine()->getManager();
        $donnee = new Donnee();

        $pack = new Pack();

        $qcm = new Qcm();
        $qcm->setQuestion("Diabète");
        $pack->addQcm($qcm);
        $qcm = new Qcm();
        $qcm->setQuestion("Hypertension artérielle");
        $pack->addQcm($qcm);
        $qcm = new Qcm();
        $qcm->setQuestion("Dyslipidémie");
        $pack->addQcm($qcm);

        $donnee->setFacteurs($pack);

        $pack = new Pack();

        $qcm = new Qcm();
        $qcm->setQuestion("Bêta-bloquant");
        $pack->addQcm($qcm);
        $qcm = new Qcm();
        $qcm->setQuestion("Aspirine");
        $pack->addQcm($qcm);
        $qcm = new Qcm();
        $qcm->setQuestion("Inhibiteur du récepteur P2Y12");
        $pack->addQcm($qcm);
        $qcm = new Qcm();
        $qcm->setQuestion("Statine");
        $pack->addQcm($qcm);
        $qcm = new Qcm();
        $qcm->setQuestion("Inhibiteur de l’Enzyme de Conversion");
        $pack->addQcm($qcm);
        $qcm = new Qcm();
        $qcm->setQuestion("Antagoniste du récepteur de l’angiotensine 2");
        $pack->addQcm($qcm);

        $donnee->setTraitement($pack);

        $pack = new Pack();

        $gene = new Gene();
        $gene->setNom("TET2");
        $pack->addGene($gene);
        $gene = new Gene();
        $gene->setNom("ASXL1");
        $pack->addGene($gene);
        $gene = new Gene();
        $gene->setNom("DNMT3A");
        $pack->addGene($gene);
        $gene = new Gene();
        $gene->setNom("SF3B1");
        $pack->addGene($gene);
        $gene = new Gene();
        $gene->setNom("TP53");
        $pack->addGene($gene);
        $gene = new Gene();
        $gene->setNom("CBL");
        $pack->addGene($gene);
        $gene = new Gene();
        $gene->setNom("SRSF2");
        $pack->addGene($gene);
        $gene = new Gene();
        $gene->setNom("PPM1D");
        $pack->addGene($gene);
        $gene = new Gene();
        $gene->setNom("GNB1");
        $pack->addGene($gene);
        $gene = new Gene();
        $gene->setNom("JAK2V617F");
        $pack->addGene($gene);

        $donnee->setGenes($pack);

        $em->persist($donnee);
        $em->flush();
        $participant->setDonnee($donnee);
    }

    /**
     * @Route("/erreur/add", name="erreur_add_info")
     */
    public function erreur_add_info(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $participantId = $request->request->get('participantId');
            $fieldId = $request->request->get('fieldId');
            $message = $request->request->get('message');
            if ($message === '')
                return new JsonResponse('Error: Empty message');
            $this->addErreur(intval($participantId), $this->formatKey($fieldId), 'info', $message, true);
            return new JsonResponse('Done.');
        }
    }

    private function formatKey($key)
    {
        return strtolower(preg_replace('/(?<=[a-z])([A-Z]+)/', '_$1', $key));
    }

    private function serializeEntity($data)
    {
        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        $serialized = $serializer->serialize($data, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return json_decode($serialized, true);
    }

    private function checkEmpty($x)
    {
        if (is_array($x)) {
            $err = '';
            $num = count($x);
            $i = 0;
            foreach($x as $key) {
                $err .= $key;
                if (++$i != $num)
                    $err .= ', ';
            }
            return $num > 0 ? $err : '(vide)';
        }
        return isset($x) ? $x : '(vide)';
    }

    private function searchDiff(Participant $participant, $oldArray, $newArray, $start, $path)
    {
        // dump($newArray);
        foreach ($newArray as $key => $value) {
            if (is_array($value) && array_key_exists('timestamp', $value) && $oldArray[$start][$key]['timestamp'] !== $value['timestamp']) {
                if (!isset($oldArray[$start][$key]['timestamp']))
                    $this->addErreur($participant->getId(), $path . '_' . $this->formatKey($key) , 'notice', 'Modification du champ [' . $path . '_' . $this->formatKey($key) . '] de [(vide)] en [' . date('d/m/Y', $value['timestamp']) . ']', true);
                else
                    $this->addErreur($participant->getId(), $path . '_' . $this->formatKey($key) , 'notice', 'Modification du champ [' . $path . '_' . $this->formatKey($key) . '] de [' . date('d/m/Y', $oldArray[$start][$key]['timestamp']) . '] en [' . date('d/m/Y', $value['timestamp']) . ']', true);
            }
            else if (is_array($oldArray[$start][$key]) && array_key_exists('timestamp', $oldArray[$start][$key]) && !is_array($value)) {
                $this->addErreur($participant->getId(), $path . '_' . $this->formatKey($key) , 'notice', 'Modification du champ [' . $path . '_' . $this->formatKey($key) . '] de [' . date('d/m/Y', $oldArray[$start][$key]['timestamp']) . '] en [(vide)]', true);
            }
            else if (is_array($value) && array_key_exists('reponse', $value) && $oldArray[$start][$key]['reponse'] !== $value['reponse']) {
                $this->addErreur($participant->getId(), $path . '_' . $this->formatKey($key) . '_reponse' , 'notice', 'Modification du champ [' . $path . '_' . $this->formatKey($key) . '] de [' . $this->checkEmpty($oldArray[$start][$key]['reponse']) . '] en [' . $this->checkEmpty($value['reponse']) . ']', true);
            }
            else if (is_array($value) && 'alimentation' === $key && !empty(array_diff($oldArray[$start][$key], $value))) {
                $this->addErreur($participant->getId(), $path . '_' . $this->formatKey($key) , 'notice', 'Modification du champ [' . $path . '_' . $this->formatKey($key) . '] de [' . $this->checkEmpty($oldArray[$start][$key]) . '] en [' . $this->checkEmpty($value) . ']', true);
            }
            else if (is_array($value) && !array_key_exists('timestamp', $value) && !array_key_exists('reponse', $value) && 'alimentation' !== $key) {
                $this->searchDiff($participant, $oldArray[$start], $newArray[$key], $key, $path . '_' . $this->formatKey($key));
            }
            else if ($oldArray[$start][$key] !== $value)
                $this->addErreur($participant->getId(), $path . '_' . $this->formatKey($key) , 'notice', 'Modification du champ [' . $path . '_' . $this->formatKey($key) . '] de [' . $this->checkEmpty($oldArray[$start][$key]) . '] en [' . $this->checkEmpty($value) . ']', true);
        }
    }

    private function generateErreur($participantId, formInterface $form, $array, $start, $path)
    {
        $em = $this->getDoctrine()->getManager();
        $erreurs = $em->getRepository(Erreur::class)->getLastErreur($participantId);

        foreach ($array[$start] as $key => $value) {
            if (is_array($value) && !array_key_exists('timestamp', $value) && !array_key_exists('reponse', $value) && 'alimentation' !== $key) {
                $this->generateErreur($participantId, $form, $array[$start], $key, $path . '_' . $this->formatKey($key));
            }
            if (is_array($value) && array_key_exists('reponse', $value))
                $key = $key . '_reponse';

            foreach($erreurs as $erreur) {
                if ($erreur->getFieldId() === $path . '_' . $this->formatKey($key)) {
                    if ($erreur->getEtat() !== 'error')
                        break;
                    $split = explode('_', $path . '_' . $key);
                    $formGet = $form;
                    foreach(array_slice($split, 1) as $s) {
                        $formGet = $formGet->get($s);
                    }
                    $formGet->addError(new FormError($erreur->getMessage()));
                    break;
                }
            }
        }
    }

    private function addErreur($participantId, $fieldId, $etat, $message, bool $user) {
        $em = $this->getDoctrine()->getManager();
        $participant = $em->getRepository(Participant::class)->find($participantId);
        $createdAt = new DateTime("now", new DateTimeZone('Europe/Paris'));

        $erreur = new Erreur();
        $erreur->setDate($createdAt);
        $erreur->setEtat($etat);
        $erreur->setMessage($message);
        $erreur->setFieldId($fieldId);
        $erreur->setUtilisateur($user ? $this->security->getUser()->getEmail() : 'Système');

        $participant->addErreur($erreur);
        $em->persist($erreur);
        $em->flush();
    }

    /**
     * @Route("/participant/{id}", name="participant_view")
     */
    public function index(Participant $participant, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $oldArray = $this->serializeEntity($participant);

        $verification = $participant->getVerification();
        $formVerification = $this->createForm(VerificationType::class, $verification);
                
        /* GENERATE ERREUR */
        $this->generateErreur($participant->getId(), $formVerification, $oldArray, 'verification', 'verification');

        $formVerification->handleRequest($request);
        if ($formVerification->isSubmitted() && $formVerification->isValid()) {
            if ($formVerification->get('save')->isClicked() && $participant->getValidation() != true) {
                
                /* SERIALISATION */
                $verificationArray = $this->serializeEntity($formVerification->getData());

                /* SPECIAL ERROR */
                
                /* SEARCH DIFF */
                $this->searchDiff($participant, $oldArray, $verificationArray, 'verification', 'verification');

                $participant = $formVerification->getData();
                $em->flush();
            }
            return $this->redirect($request->getUri());
        }

        $general = $participant->getGeneral();
        $formGeneral = $this->createForm(GeneralType::class, $general);
        
        /* GENERATE ERREUR */
        $this->generateErreur($participant->getId(), $formGeneral, $oldArray, 'general', 'general');

        $formGeneral->handleRequest($request);
        if ($formGeneral->isSubmitted() && $formGeneral->isValid()) {
            if ($formGeneral->get('save')->isClicked() && $participant->getValidation() != true) {

                /* SERIALISATION */
                $generalArray = $this->serializeEntity($formGeneral->getData());

                /* SPECIAL ERROR */
                if ($generalArray['dateNaissance']['timestamp'] !== $oldArray['general']['dateNaissance']['timestamp'] && 
                    (floor((time() - $generalArray['dateNaissance']['timestamp']) / 31556926) < 75)) {
                        $this->addErreur($participant->getId(), 'general_date_naissance' , 'error', 'Le participant doit avoir un âge >= 75 ans', false);
                }

                /* SEARCH DIFF */
                $this->searchDiff($participant, $oldArray, $generalArray, 'general', 'general');

                $participant = $formGeneral->getData();
                $em->flush();
            }
            return $this->redirect($request->getUri());
        }

        $cardiovasculaire = $participant->getCardiovasculaire();
        $formCardiovasculaire = $this->createForm(CardiovasculaireType::class, $cardiovasculaire);
                        
        /* GENERATE ERREUR */
        $this->generateErreur($participant->getId(), $formCardiovasculaire, $oldArray, 'cardiovasculaire', 'cardiovasculaire');

        $formCardiovasculaire->handleRequest($request);
        if ($formCardiovasculaire->isSubmitted() && $formCardiovasculaire->isValid()) {
            if ($formCardiovasculaire->get('save')->isClicked() && $participant->getValidation() != true) {
                                
                /* SERIALISATION */
                $cardiovasculaireArray = $this->serializeEntity($formCardiovasculaire->getData());

                /* SPECIAL ERROR */

                /* SEARCH DIFF */
                $this->searchDiff($participant, $oldArray, $cardiovasculaireArray, 'cardiovasculaire', 'cardiovasculaire');

                $participant = $formCardiovasculaire->getData();
                $em->flush();
            }
            return $this->redirect($request->getUri());
        }

        $information = $participant->getInformation();
        $formInformation = $this->createForm(InformationType::class, $information);
                        
        /* GENERATE ERREUR */
        $this->generateErreur($participant->getId(), $formInformation, $oldArray, 'information', 'information');

        $formInformation->handleRequest($request);
        if ($formInformation->isSubmitted() && $formInformation->isValid()) {
            if ($formInformation->get('save')->isClicked() && $participant->getValidation() != true) {
                                                
                /* SERIALISATION */
                $informationArray = $this->serializeEntity($formInformation->getData());

                /* SPECIAL ERROR */

                /* SEARCH DIFF */
                $this->searchDiff($participant, $oldArray, $informationArray, 'information', 'information');

                $participant = $formInformation->getData();
                $em->flush();
            }
            return $this->redirect($request->getUri());
        }

        $donnee = $participant->getDonnee();
        $formDonnee = $this->createForm(DonneeType::class, $donnee);

        /* GENERATE ERREUR */
        $this->generateErreur($participant->getId(), $formDonnee, $oldArray, 'donnee', 'donnee');

        $formDonnee->handleRequest($request);
        if ($formDonnee->isSubmitted() && $formDonnee->isValid()) {
            if ($formDonnee->get('save')->isClicked() && $participant->getValidation() != true) {
                                                                
                /* SERIALISATION */
                $donneeArray = $this->serializeEntity($formDonnee->getData());

                /* SPECIAL ERROR */

                /* SEARCH DIFF */
                $this->searchDiff($participant, $oldArray, $donneeArray, 'donnee', 'donnee');

                $participant = $formDonnee->getData();
                $em->flush();
            }
            return $this->redirect($request->getUri());
        }


        $deces = $participant->getDeces();
        $formDeces = $this->createForm(DecesType::class, $deces);
                        
        /* GENERATE ERREUR */
        $this->generateErreur($participant->getId(), $formDeces, $oldArray, 'deces', 'deces');

        $formDeces->handleRequest($request);
        if ($formDeces->isSubmitted() && $formDeces->isValid()) {
            if ($formDeces->get('save')->isClicked() && $participant->getValidation() != true) {
                                                                                
                /* SERIALISATION */
                $decesArray = $this->serializeEntity($formDeces->getData());

                /* SPECIAL ERROR */

                /* SEARCH DIFF */
                $this->searchDiff($participant, $oldArray, $decesArray, 'deces', 'deces');

                $participant = $formDeces->getData();
                $em->flush();
            }
            return $this->redirect($request->getUri());
        }

        return $this->render('participant/index.html.twig', [
            'controller_name' => 'ParticipantController',
            'participant' => $participant,
            'formVerification' => $formVerification->createView(),
            'formGeneral' => $formGeneral->createView(),
            'formCardiovasculaire' => $formCardiovasculaire->createView(),
            'formInformation' => $formInformation->createView(),
            'formDonnee' => $formDonnee->createView(),
            'formDeces' => $formDeces->createView(),
            'date' => date("d/m/Y"),
        ]);
    }

    private function formatDate(\DateTime $date) {
        $formatter = new \IntlDateFormatter(
            \Locale::getDefault(),
            \IntlDateFormatter::MEDIUM,
            \IntlDateFormatter::SHORT
        );
        return $formatter->format($date);
    }

    /**
     * @Route("/generate", name="participant_code_generate", methods="GET|POST")
     */
    public function participant_code_generate(Request $request): JsonResponse
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
     * @Route("/participant/{id}", name="participant_delete", methods="DELETE")
     */
    public function delete(Request $request, Participant $participant) : Response
    {
        if ($this->isCsrfTokenValid('delete' . $participant->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($participant);
            $em->flush();
        }

        return $this->redirectToRoute('index_participant');
    }
}
