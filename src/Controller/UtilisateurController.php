<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Form\PasswordFormType;
use App\Repository\UtilisateurRepository;

use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route(path: '/')]
class UtilisateurController extends AbstractController
{
    #[Route(path: '/', name: 'default', methods: 'GET')]
    function default (): Response
    {
        return $this->redirectToRoute('login');
    }

    #[Route(path: '/login', name: 'login')]
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

    #[Route(path: '/logout', name: 'logout', methods: 'GET')]
    public function logout(): Response
    {
        return $this->redirectToRoute('login');
    }

    #[Route(path: '/register', name: 'register', methods: 'GET|POST')]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, PersistenceManagerRegistry $doctrine): Response
    {
        $user = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $user);
        $form->handleRequest($request);
        $errors = [];

        if ($form->isSubmitted())
        {
            if ($form->isValid())
            {
                if ($form->get('save')->isClicked())
                {
                    $password = $passwordHasher->hashPassword($user, $user->getPlainPassword());
                    $user->setPassword($password);
                    $user->setRoles(['ROLE_GUEST']);
                    $em = $doctrine->getManager();
                    $em->persist($user);
                    $em->flush();
                    $this->addFlash('notice', 'Félicitations ! Votre compte a été créé avec succès !');
                    return $this->redirectToRoute('login');
                }
            }
            else
            {
                foreach ($form->getErrors(true) as $error)
                {
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

    #[Route(path: '/guest', name: 'guest')]
    public function guest()
    {
        return $this->render('utilisateur/guest.html.twig', [
            'controller_name' => 'GuestController',
        ]);
    }

    #[Route(path: '/utilisateur/ajax', name: 'utilisateur_roles_edit')]
    public function roles_edit(UtilisateurRepository $utilisateurRepository, Request $request, AuthorizationCheckerInterface $authChecker, PersistenceManagerRegistry $doctrine): JsonResponse
    {
        $em = $doctrine->getManager();

        if ($request->isXmlHttpRequest() && true === $authChecker->isGranted('ROLE_ADMIN'))
        {
            $email = $request->get('email');
            $nom = $request->get('nom');
            $prenom = $request->get('prenom');
            $roles = $request->get('roles');

            $utilisateur = $utilisateurRepository->findOneBy(['email' => $email]);
            if ($utilisateur)
            {
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

    #[Route(path: '/utilisateur/list', name: 'utilisateur_list')]
    public function list(UtilisateurRepository $utilisateurRepository, Request $request): Response
    {
        if ($request->isXmlHttpRequest())
        {
            $current = $request->get('current');
            $rowCount = $request->get('rowCount');
            $searchPhrase = $request->get('searchPhrase');
            $sort = $request->get('sort');
            $roles = $request->get('roles');

            $utilisateurs = $utilisateurRepository->findByFilter($sort, $searchPhrase, $roles);
            if ($searchPhrase != "" || !empty($roles))
                $count = is_countable($utilisateurs->getQuery()->getResult()) ? count($utilisateurs->getQuery()->getResult()) : 0;
            else
                $count = $utilisateurRepository->getCount();
            if ($rowCount != -1)
            {
                $min = ($current - 1) * $rowCount;
                $max = $rowCount;
                $utilisateurs->setMaxResults($max)->setFirstResult($min);
            }
            $utilisateurs = $utilisateurs->getQuery()->getResult();
            $rows = [];
            foreach ($utilisateurs as $utilisateur)
            {
                $status = $this->getUser()->getId() == $utilisateur->getId() ? 1 : 0;
                $row = ["id" => $utilisateur->getId(), "nom" => $utilisateur->getNom(), "prenom" => $utilisateur->getPrenom(), "email" => $utilisateur->getEmail(), "roles" => $utilisateur->getRoles(), "status" => $status];
                array_push($rows, $row);
            }

            $data = ["current" => intval($current), "rowCount" => intval($rowCount), "rows" => $rows, "total" => intval($count)];
            return new JsonResponse($data);
        }

        return $this->render('utilisateur/list.html.twig', [
            'controller_name' => 'ListController',
            'id' => $this->getUser()->getId(),
        ]);
    }

    #[Route(path: '/utilisateur/edit', name: 'utilisateur_edit')]
    public function edit(Request $request, UserPasswordHasherInterface $passwordHasher, PersistenceManagerRegistry $doctrine): Response
    {
        $user = $this->getUser();
        $roles = $user->getRoles();
        $em = $doctrine->getManager();
        $errors = [];

        $form = $this->createForm(UtilisateurType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            if ($form->get('save')->isClicked())
            {
                $user = $form->getData();
                $user->setRoles($roles);
                $em->persist($user);
                $em->flush();
            }
            return $this->redirectToRoute('utilisateur_edit');
        }

        $psw = $this->createForm(PasswordFormType::class, $user);
        $psw->handleRequest($request);
        if ($psw->isSubmitted() && $psw->isValid())
        {
            $oldPassword = $request->get('password_form')['oldPassword'];
            if ($psw->get('edit')->isClicked() && $passwordHasher->isPasswordValid($user, $oldPassword))
            {
                $user = $form->getData();
                $password = $passwordHasher->hashPassword($user, $user->getPlainPassword());
                $user->setPassword($password);
                $user->setRoles($roles);

                $em->persist($user);
                $em->flush();

                $this->addFlash('notice', 'Votre mot de passe à bien été changé !');

                return $this->redirectToRoute('utilisateur_edit');
            }
            else
            {
                $errors[] = 'Ancien mot de passe incorrect.';
                foreach ($form->getErrors(true) as $error)
                {
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

    #[Route(path: '/utilisateur/view/{id}', name: 'utilisateur_view')]
    public function view(Utilisateur $utilisateur): Response
    {
        return $this->render('utilisateur/view.html.twig', [
            'controller_name' => 'ViewController',
            'user' => $utilisateur,
        ]);
    }

    #[Route(path: '/utilisateur/getByEmail', name: 'utilisateur_getByEmail')]
    public function getByEmail(Request $request, PersistenceManagerRegistry $doctrine): Response
    {
        if ($request->isXmlHttpRequest())
        {
            $em = $doctrine->getManager();
            $email = $request->get('email');
            $user = $em->getRepository(Utilisateur::class)->findOneBy(['email' => $email]);
            return new JsonResponse($user->getId());
        }
    }

    #[Route(path: '/onAuthenticationSuccess', name: 'onAuthenticationSuccess')]
    public function onAuthenticationSuccess(UrlGeneratorInterface $router, AuthorizationCheckerInterface $authChecker)
    {
        if (true === $authChecker->isGranted('ROLE_GUEST'))
        {
            // c'est un aministrateur : on le rediriger vers l'espace admin
            $redirection = new RedirectResponse($router->generate('guest'));
        }
        else
        {
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