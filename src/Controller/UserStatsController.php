<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserStatsController extends AbstractController
{
    #[Route('/user/stats', name: 'app_user_stats')]
    public function index(): Response
    {
        return $this->render('user_stats/index.html.twig', [
            'controller_name' => 'UserStatsController',
        ]);
    }
}
