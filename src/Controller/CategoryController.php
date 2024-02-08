<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/category', name: 'app_category')]
class CategoryController extends AbstractController
{
    private CategoryRepository $categoryRepository;
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    #[Route('/')]
    public function index(): JsonResponse
    {
        $category = [
            'id' => '1',
            'name' => 'film'
        ];
        return $this->json($category);
    }
    #[Route('/{id}')]
    public function findCategoryById(int $id): JsonResponse
    {
        $category = $this->categoryRepository->findOneBy(['id' => $id]);
        return $this->json($category);
    }
}
