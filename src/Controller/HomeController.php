<?php

namespace App\Controller;

use App\Form\ResourcesType;
use App\Repository\ResourcesRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private ResourcesRepository $resourcesRepository;
    private Security $security;

    public function __construct(ResourcesRepository $resourcesRepository, Security $security)
    {
        $this->resourcesRepository = $resourcesRepository;
        $this->security = $security;
    }

    #[Route('/', name: 'app_home')]
    public function index()
    {
        $resources = $this->resourcesRepository->findAll();
        $user = $this->security->getUser();
        var_dump($user);
        return $this->render('home/index.html.twig', [
            'resources' => $resources,
            'user' => $user,
        ]);
    }
}
