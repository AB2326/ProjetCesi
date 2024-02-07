<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ResourceStatsController extends AbstractController
{
    #[Route('/resource/stats', name: 'app_resource_stats')]
    public function index(): Response
    {
        return $this->render('resource_stats/index.html.twig', [
            'controller_name' => 'ResourceStatsController',
        ]);
    }
}
