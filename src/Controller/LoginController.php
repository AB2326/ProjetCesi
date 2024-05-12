<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\RegisterType;
use App\Entity\User;
use App\Form\LoginType;
use DateTime;
use Symfony\Component\Form\FormError;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Guard\GuardAuthenticatorInterface;

class LoginController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(RegisterType::class);
        $form->handleRequest($request);

        $date = new DateTime;

        if ($form->isSubmitted() && $form->isValid()) {
            $userData = $form->getData();

            $user = new User();
            $user->setFirstname($userData['firstname']);
            $user->setLastname($userData['lastname']);
            $user->setEmail($userData['email']);
            $user->setPhone($userData['phone']);
            $user->setCreatedAt($date);

            $hashedPassword = password_hash($userData['firstPassword'], PASSWORD_DEFAULT);
            $user->setPassword($hashedPassword);

            if ($userData['firstPassword'] !== $userData['secondPassword']) {
                $form->get('secondPassword')->addError(new FormError("Les mots de passe ne correspondent pas"));
            } else {
                $em->persist($user);
                $em->flush();

                return $this->redirectToRoute('app_login');
            }
        }

        return $this->render('register/index.html.twig', [
            'controller_name' => 'LoginController',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/login', name: 'app_login')]
    public function login(Request $request, AuthenticationUtils $authenticationUtils, EntityManagerInterface $entityManager, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator): Response
    {
        $form = $this->createForm(LoginType::class);
    
        $form->handleRequest($request);
    
        $error = $authenticationUtils->getLastAuthenticationError();
    
        $lastUsername = $authenticationUtils->getLastUsername();
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer l'e-mail et le mot de passe soumis dans le formulaire
            $formData = $form->getData();
    
            // Chercher l'utilisateur par son e-mail dans la base de données
            $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $formData['email']]);
    
            // Vérifier si l'utilisateur existe et si le mot de passe est correct
            if ($user && password_verify($formData['password'], $user->getPassword())) {
                // Authentifier l'utilisateur
                $guardHandler->authenticateUser($user, $authenticator, $request);
    
                // Rediriger l'utilisateur vers la page souhaitée après la connexion
                return $this->redirectToRoute('app_home');
            } else {
                // Afficher une erreur de connexion invalide
                $this->addFlash('error', 'Identifiants invalides');
            }
        }
    
        return $this->render('login/index.html.twig', [
            'form' => $form->createView(),
            'last_username' => $lastUsername,
        ]);
    }
    
}
