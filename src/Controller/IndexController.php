<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();

        return $this->render('index/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    // #[Route('/article/{id}', name: 'article_item')]
    // public function item(
    //     Article $article,
    //     int $id
    // ): Response {
    //     return $this->render('/articleItem.html.twig', [
    //         'Article' => $article,
    //     ]);
    // }
}
