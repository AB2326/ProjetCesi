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


    public function __construct(EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage)
    {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
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
            $user->setIsConnected(1);
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

}
