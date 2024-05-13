<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Entity\Resources;
use App\Form\ResourcesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use DateTime;

class CommentController extends AbstractController
{
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

        return $this->render('article/article.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
