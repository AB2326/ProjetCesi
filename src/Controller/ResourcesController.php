<?php

namespace App\Controller;

use App\Form\ResourcesType;
use App\Repository\ResourcesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/resources', name: 'app_resources')]
class ResourcesController extends AbstractController
{
    private ResourcesRepository $resourcesRepository;

    public function __construct(ResourcesRepository $resourcesRepository)
    {
        $this->resourcesRepository = $resourcesRepository;
    }

    #[Route('/')]
    public function allResources()
    {
        $resources = $this->resourcesRepository->findAll();
        return $this->render('resources/index.html.twig', [
            'resources' => $resources
        ]);
    }
    #[Route('/createArticle', name: 'createArticle')]
    public function createArticle(Request $request): Response
    {
        $article = new Resources();
        $form = $this->createForm(ResourcesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            return $this->redirectToRoute('app_home');
        }

        return $this->render('modal/publish.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
