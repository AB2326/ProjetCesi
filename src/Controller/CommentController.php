<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Entity\Resources;
use App\Form\ResourcesType;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use DateTime;

class CommentController extends AbstractController
{
    public CommentRepository $commentRepository;

    /**
     * @param CommentRepository $commentRepository
     */
    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    #[Route('/comment', name: 'app_comment')]
    public function index(): Response
    {
        return $this->render('comment/index.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    }
    #[\Symfony\Component\Routing\Annotation\Route('/createComment', name: 'create_comment')]
    public function createComment(Request $request): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $comment->setCreatedAt(new DateTime());
            $comment->setIsDeleted(false);

            $this->entityManager->persist($comment);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_home');
        }
    }
    #[\Symfony\Component\Routing\Annotation\Route('/deleteComment', name: 'app_delete_comment')]
    public function deletecomment(int $id, EntityManagerInterface $entityManager): Response
    {
        $comment = $this->commentRepository->findByIdRessource($id);

        if ($comment) {

            $comment->setDeletedAt(new DateTime());
            $comment->setIsDeleted(1);

            $this->entityManager->persist($comment);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_home');
        }
    }
}
