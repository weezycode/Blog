<?php

declare(strict_types=1);

namespace  App\Controller\Frontoffice;

use App\View\View;
use App\Service\Http\Response;
use App\Model\Repository\ArticleRepository;
use App\Model\Repository\CommentRepository;
use App\Controller\Frontoffice\Error404Controller;

final class ArticleController
{
    public function __construct(private ArticleRepository $postRepository, private View $view)
    {
    }

    public function displayOneAction(int $id, CommentRepository $commentRepository): Response
    {
        $response = new Error404Controller($this->view);

        $article = $this->postRepository->findOneBy(['id' => $id]);

        if ($article !== null) {
            $comments = $commentRepository->findByPost($id);
            $response = new Response($this->view->render(
                [
                    'template' => 'post',
                    'data' => [
                        'post' => $article,
                        'comments' => $comments,
                    ],
                ],
            ));
        }

        return $response;
    }

    public function displayAllAction(): Response
    {


        $posts = $this->postRepository->findAll();


        return new Response($this->view->render([
            'template' => 'posts',
            'data' => ['posts' => $posts],

        ]));
    }
}
