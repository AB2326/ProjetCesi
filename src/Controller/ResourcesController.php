<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Resources;
use App\Form\CommentType;
use App\Form\ResourcesType;
use App\Repository\CommentRepository;
use Doctrine\Common\Util\ClassUtils;

use App\Repository\ResourcesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;
use Symfony\Component\Validator\Constraints\Date;

class ResourcesController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private ResourcesRepository $resourcesRepository;
    private CommentRepository $commentRepository;

    public function __construct(EntityManagerInterface $entityManager,
                                ResourcesRepository $resourcesRepository,
                                CommentRepository $commentRepository)
    {
        $this->entityManager = $entityManager;
        $this->resourcesRepository = $resourcesRepository;
        $this->commentRepository = $commentRepository;
    }

    #[Route('/resources', name: 'app_resources')]
    public function index(): Response
    {
        $resources = $this->resourcesRepository->findAll();

        return $this->render('resources/index.html.twig', [
            'resources' => $resources,
        ]);
    }

    #[Route('/resource/{id}', name: 'resource_page')]
    public function getResourceById(int $id, Request $request): Response
    {
        $resource = $this->resourcesRepository->find($id);
        $comments = $this->commentRepository->findByIdRessource($id);
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData(); 
    
            $comment->setCreatedAt(new \DateTime());
            $comment->setResourceId($id);
    
            // Récupérer l'utilisateur actuellement authentifié
            $user = $this->getUser();
            if ($user !== null) {
                // Si l'utilisateur est authentifié, récupérez son ID et associez-le au commentaire
                $userId = $user->getId(); 
                $comment->setUserId($userId);
            } else {
                // Gérer le cas où aucun utilisateur n'est authentifié
                // Par exemple, rediriger vers une page de connexion ou générer une erreur
            }
    
            $this->entityManager->persist($comment);
            $this->entityManager->flush();
    
            // Rafraîchir les commentaires après l'ajout du nouveau commentaire
            $comments = $this->commentRepository->findByIdRessource($id);
        }
    
        return $this->render('article/article.html.twig', [
            'resource' => $resource,
            'comments' => $comments,
            'form' => $form->createView()
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

            return $this->redirectToRoute('app_home');
        }

        return $this->render('modal/publish.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/deleteResource/{id}', name: 'app_deleteResource', methods: ['GET', 'PATCH'])]
    public function deleteResource(int $id, EntityManagerInterface $entityManager): Response
    {
        $resource = $this->resourcesRepository->find($id);

        if (!$resource) {
            throw $this->createNotFoundException('Resource not found');
        }

        $resource->setDeletedAt(new \DateTime())
            ->setIsDeleted(1);
        $entityManager->persist($resource);
        $entityManager->flush();

        return $this->redirectToRoute('app_home');
    }
}
