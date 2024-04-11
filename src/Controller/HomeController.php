<?php

namespace App\Controller;

use App\Repository\ResourcesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private ResourcesRepository $resourcesRepository;

    public function __construct(ResourcesRepository $resourcesRepository)
    {
        $this->resourcesRepository = $resourcesRepository;
    }
    #[Route('/')]
    public function index(){
        $resources = $this->resourcesRepository->findAll();
        return $this->render('home/index.html.twig', [
            'resources' => $resources
        ]);
    }

}
