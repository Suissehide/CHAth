<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Form\PasswordFormType;
use App\Repository\UtilisateurRepository;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @Route("/")
 */
class UtilisateurController extends AbstractController
{
    /**
     * @Route("/", name="default", methods="GET")
     */
    function default(): Response {
        return $this->redirectToRoute('login');
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('utilisateur/login.html.twig', [
            'controller_name' => 'LoginController',
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    /**
     * @Route("/logout", name="logout", methods="GET")
     */
    public function logout(): Response
    {
        return $this->redirectToRoute('login');
    }

    /**
     * @Route("/register", name="register", methods="GET|POST")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $user);
        $form->handleRequest($request);
        $errors = [];

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                if ($form->get('save')->isClicked()) {
                    $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                    $user->setPassword($password);
                    $user->setRoles(['ROLE_GUEST']);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($user);
                    $em->flush();
                    $this->addFlash('notice', 'Félicitations ! Votre compte a été créé avec succès !');
                    return $this->redirectToRoute('login');
                }
            } else {
                foreach ($form->getErrors(true) as $error) {
                    $errors[] = $error->getMessage();
                }
                if (strcmp($form->get('plainPassword')->get('first')->getData(), $form->get('plainPassword')->get('second')->getData()))
                    $errors[] = 'Les deux mots de passe ne sont pas identiques.';
                if (($key = array_search('This value is not valid.', $errors)) !== false)
                    unset($errors[$key]);
            }
        }
        return $this->render('utilisateur/register.html.twig', [
            'controller_name' => 'RegisterController',
            'form' => $form->createView(),
            'errors' => $errors,
        ]);
    }

    /** 
     * @Route("/guest", name="guest")
     */
    public function guest()
    {
        return $this->render('utilisateur/guest.html.twig', [
            'controller_name' => 'GuestController',
        ]);
    }

    /**
     * @Route("/utilisateur/ajax", name="utilisateur_roles_edit")
     */
    public function roles_edit(UtilisateurRepository $utilisateurRepository, Request $request, AuthorizationCheckerInterface $authChecker): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();

        if ($request->isXmlHttpRequest() && true === $authChecker->isGranted('ROLE_ADMIN')) {
            $email = $request->request->get('email');
            $nom = $request->request->get('nom');
            $prenom = $request->request->get('prenom');
            $roles = $request->request->get('roles');

            $utilisateur = $utilisateurRepository->findOneBy(['email' => $email]);
            if ($utilisateur) {
                if ($roles == "Invité")
                    $utilisateur->setRoles(["ROLE_GUEST"]);
                else if ($roles == "Utilisateur")
                    $utilisateur->setRoles(["ROLE_USER"]);
                else if ($roles == "Administrateur")
                    $utilisateur->setRoles(["ROLE_ADMIN"]);
                $utilisateur->setNom($nom);
                $utilisateur->setPrenom($prenom);
                $em->flush();
            }
            return new JsonResponse();
        }
    }

    /**
     * @Route("/utilisateur/list", name="utilisateur_list")
     */
    public function list(UtilisateurRepository $utilisateurRepository, Request $request): Response
    {
        if ($request->isXmlHttpRequest()) {
            $current = $request->request->get('current');
            $rowCount = $request->request->get('rowCount');
            $searchPhrase = $request->request->get('searchPhrase');
            $sort = $request->request->get('sort');
            $roles = $request->request->get('roles');

            $utilisateurs = $utilisateurRepository->findByFilter($sort, $searchPhrase, $roles);
            if ($searchPhrase != "" || !empty($roles))
                $count = count($utilisateurs->getQuery()->getResult());
            else
                $count = $utilisateurRepository->compte();
            if ($rowCount != -1) {
                $min = ($current - 1) * $rowCount;
                $max = $rowCount;
                $utilisateurs->setMaxResults($max)->setFirstResult($min);
            }
            $utilisateurs = $utilisateurs->getQuery()->getResult();
            $rows = array();
            foreach ($utilisateurs as $utilisateur) {
                $status = $this->getUser()->getId() == $utilisateur->getId() ? 1 : 0;
                $row = array(
                    "id" => $utilisateur->getId(),
                    "nom" => $utilisateur->getNom(),
                    "prenom" => $utilisateur->getPrenom(),
                    "email" => $utilisateur->getEmail(),
                    "roles" => $utilisateur->getRoles(),
                    "status" => $status,
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

        return $this->render('utilisateur/list.html.twig', [
            'controller_name' => 'ListController',
            'id' => $this->getUser()->getId(),
        ]);
    }

    /**
     * @Route("/utilisateur/edit", name="utilisateur_edit")
     */
    public function edit(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = $this->getUser();
        $roles = $user->getRoles();
        $em = $this->getDoctrine()->getManager();
        $errors = [];

        $form = $this->createForm(UtilisateurType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('save')->isClicked()) {
                $user = $form->getData();
                $user->setRoles($roles);
                $em->persist($user);
                $em->flush();
            }
            return $this->redirectToRoute('utilisateur_edit');
        }

        $psw = $this->createForm(PasswordFormType::class, $user);
        $psw->handleRequest($request);
        if ($psw->isSubmitted() && $psw->isValid()) {
            $oldPassword = $request->request->get('password_form')['oldPassword'];
            if ($psw->get('edit')->isClicked() && $passwordEncoder->isPasswordValid($user, $oldPassword)) {
                $user = $form->getData();
                $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);
                $user->setRoles($roles);

                $em->persist($user);
                $em->flush();

                $this->addFlash('notice', 'Votre mot de passe à bien été changé !');

                return $this->redirectToRoute('utilisateur_edit');
            } else {
                $errors[] = 'Ancien mot de passe incorrect.';
                foreach ($form->getErrors(true) as $error) {
                    $errors[] = $error->getMessage();
                }
            }
        }

        return $this->render('utilisateur/edit.html.twig', [
            'controller_name' => 'EditController',
            'user' => $user,
            'form' => $form->createView(),
            'psw' => $psw->createView(),
            'errors' => $errors,
        ]);
    }

    /**
     * @Route("/onAuthenticationSuccess", name="onAuthenticationSuccess")
     */
    public function onAuthenticationSuccess(UrlGeneratorInterface $router, AuthorizationCheckerInterface $authChecker)
    {
        if (true === $authChecker->isGranted('ROLE_GUEST')) {
            // c'est un aministrateur : on le rediriger vers l'espace admin
            $redirection = new RedirectResponse($router->generate('guest'));
        } else {
            // c'est un utilisaeur lambda : on le rediriger vers l'accueil
            $redirection = new RedirectResponse($router->generate('index_participant'));
        }

        return $redirection;
    }

    /*
    public function accountInfo()
    {
        // allow any authenticated user - we don't care if they just
        // logged in, or are logged in via a remember me cookie
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

    }

    public function resetPassword()
    {
        // require the user to log in during *this* session
        // if they were only logged in via a remember me cookie, they
        // will be redirected to the login page
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

    }
    */
}