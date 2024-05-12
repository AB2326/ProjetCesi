<?php

namespace App\Controller;

use App\Entity\Resources;
use App\Form\ResourcesType;
use Doctrine\Common\Util\ClassUtils;

use App\Repository\ResourcesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;


class ResourcesController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private ResourcesRepository $resourcesRepository;

    public function __construct(EntityManagerInterface $entityManager, ResourcesRepository $resourcesRepository)
    {
        $this->entityManager = $entityManager;
        $this->resourcesRepository = $resourcesRepository;
    }

    #[Route('/resources', name: 'app_resources')]
    public function index(): Response
    {
        $resources = $this->resourcesRepository->findAll();

        return $this->render('resources/index.html.twig', [
            'resources' => $resources,
        ]);
    }

    #[Route('/resources/{id}', name: 'resource_page')]
    public function getResourceById(int $id): Response
    {
        $resource = $this->resourcesRepository->find($id);
        return $this->render('article/article.html.twig', [
            'resource' => $resource,
        ]);
    }

    #[Route('/createResource', name: 'create_resource')]
    public function createResource(Request $request): Response
    {
        $resource = new Resources();

        $form = $this->createForm(ResourcesType::class, $resource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $resource->setCreatedAt(new DateTime());
            $resource->setIsCompleted(false);
            $resource->setIsRestricted(false);

            $this->entityManager->persist($resource);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_resources');
        }

        return $this->render('modal/publish.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
