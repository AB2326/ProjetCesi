<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\RegisterType;
use  App\Entity\User;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(Request $request,EntityManagerInterface $em)
    {
        $form = $this->createForm(RegisterType::class);
        $form->handleRequest($request);

        $user = New User;

        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($user);
            $em->flush();
   
        }
        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
            'form' => $form->createView(),
        ]);
    }
}
