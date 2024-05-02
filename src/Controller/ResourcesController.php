<?php

namespace App\Controller;

use App\Entity\Resources;
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

    #[Route('/resources', name: 'app_resources')]
    public function allResources(): Response
    {
        $resources = $this->resourcesRepository->findAll();
        return $this->render('resources/index.html.twig', [
            'resources' => $resources,
        ]);
    }

    #[Route('/resources/{id}', name: 'resource_page')]
    public function showResource(int $id): Response
    {
        $resource = $this->resourcesRepository->find($id);
        if (!$resource) {
            throw $this->createNotFoundException("Resource not found.");
        }
        return $this->render('article/article.html.twig', [
            'resource' => $resource,
        ]);
    }

    #[Route('/resources/create', name: 'create_article')]
    public function createArticle(Request $request): Response
    {
        $resource = new Resources();
        $form = $this->createForm(ResourcesType::class, $resource);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->estValide()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($resource);
            $entityManager->flush();

            return $this->redirectToRoute('article_success');
        }

        return $this->render('modal/publish.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/resources/success', name: 'article_success')]
    public function success(): Response
    {
        return new Response("Article créé avec succès!");
    }
}
