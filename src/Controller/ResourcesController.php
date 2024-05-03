<?php

namespace App\Controller;

use App\Entity\Resources;
use App\Form\ArticleType;
use App\Form\ResourcesType;
use App\Repository\ResourcesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResourcesController extends AbstractController
{
    private ResourcesRepository $resourcesRepository;

    public function __construct(ResourcesRepository $resourcesRepository)
    {
        $this->resourcesRepository = $resourcesRepository;
    }

    #[Route('/', name: 'app_resources')]
    public function index(): Response
    {
        $resources = $this->resourcesRepository->findAll();

        return $this->render('resources/index.html.twig', [
            'resources' => $resources
        ]);
    }

    #[Route('/resources/{id}', name: 'resource_page')]
    public function getResourceById(int $id): Response
    {
        $resource = $this->resourcesRepository->findOneBy(['id' => $id]);
        return $this->render('article/article.html.twig', [
            'resource' => $resource
        ]);
    }

    #[Route('/createResource', name: 'create_resource')]
    public function createResource(Request $request): Response
    {
        $resources = new Resources();
        $form = $this->createForm(ResourcesType::class, $resources);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($resources);
            $entityManager->flush();

        }

        return $this->render('modal/publish.html.twig', [
            'form' => $form->createView(),
            'resources' => $resources
        ]);
    }
}

