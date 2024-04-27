<?php

namespace App\Controller;

use App\Entity\Resources;
use App\Form\ResourcesType;
use App\Repository\ResourcesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/resources', name: 'app_resources')]
class ResourcesController extends AbstractController
{
    private ResourcesRepository $resourcesRepository;

    public function __construct(ResourcesRepository $resourcesRepository)
    {
        $this->resourcesRepository = $resourcesRepository;
    }

    #[Route('/')]
    public function allResources(): Response
    {
        $resources = $this->resourcesRepository->findAll();
        return $this->render('resources/index.html.twig', [
            'resources' => $resources
        ]);
    }

    #[Route('/{id}', name: 'resource_page')]
    public function showResource(int $id): Response
    {
        $resource = $this->resourcesRepository->findOneBy(['id' => $id]);
        return $this->render('article/article.html.twig', [
            'resource' => $resource
        ]);
    }

    #[Route('/createArticle', name: 'create_article')]
    public function createArticle(Request $request): Response
    {
        $article = new Resources();
        $form = $this->createForm(ResourcesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('app_resources');
        }

        return $this->render('modal/publish.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

