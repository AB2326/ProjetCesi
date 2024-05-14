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
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class LoginController extends AbstractController
{

    private $entityManager;
    private $tokenStorage;
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage, UserPasswordEncoderInterface  $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->passwordEncoder = $passwordEncoder;
    }

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
    public function login(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(LoginType::class, ['email' => $lastUsername]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $formData['email']]);

            if ($user) {
                // var_dump($user);die();
                if ($this->passwordEncoder->isPasswordValid($user->getPassword(), $formData['firstPassword'], $user->getSalt())) {
                    $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
                    $this->tokenStorage->setToken($token);
                    return $this->redirectToRoute('app_home');
                } else {
                    $this->addFlash('error', 'Mot de passe incorrect.');
                }
            } else {
                $this->addFlash('error', 'Adresse email invalide.');
            }
        }

        return $this->render('login/index.html.twig', [
            'form' => $form->createView(),
            'error' => $error,
        ]);
    }
}
