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
        $response = new Response();

        $article = $this->postRepository->findOneBy(['id' => $id]);

        if ($article !== null) {
            $comments = $commentRepository->findByPost($id);
            return new Response($this->view->render(
                [
                    'template' => 'post',
                    'data' => [
                        'post' => $article,
                        'comments' => $comments,
                    ],
                ],
            ));
        } else {

            return $response->redirectTo("index.php");
        }
    }

    public function displayAllAction(): Response
    {

        $response = new Response();
        $posts = $this->postRepository->findAll();

        if ($posts === null) {
            return $response->redirectTo("index.php");
        } else {


            return new Response($this->view->render([
                'template' => 'posts',
                'data' => ['posts' => $posts],

            ]));
        }
    }
}
