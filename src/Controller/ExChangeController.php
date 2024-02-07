<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ExChangeController extends AbstractController
{
    #[Route('/ex/change', name: 'app_ex_change')]
    public function index(): Response
    {
        return $this->render('ex_change/index.html.twig', [
            'controller_name' => 'ExChangeController',
        ]);
    }
}
