<?php

namespace App\Controller;

use App\Repository\ResourcesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/resources', name: 'app_resources')]
class ResourcesController extends AbstractController
{
    private ResourcesRepository $resourcesRepository;
    public function __construct(ResourcesRepository $resourcesRepository)
    {
        $this->resourcesRepository = $resourcesRepository;
    }

    public function index(): Response
    {
        return $this->render('resources/index.html.twig', [
            'controller_name' => 'ResourcesController',
        ]);
    }
    #[Route('/')]
    public function allResources(){
        $resources = $this->resourcesRepository->findAll();
        return $this->render('resources/index.html.twig', [
            'resources' => $resources
        ]);
    }
}
