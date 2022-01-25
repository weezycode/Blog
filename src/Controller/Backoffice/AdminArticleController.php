<?php

declare(strict_types=1);

namespace  App\Controller\backoffice;

use App\View\View;
use App\Service\Http\Response;
use App\Service\Http\Session\Session;
use App\Model\Repository\ArticleRepository;
use App\Model\Repository\CommentRepository;
use App\Controller\Frontoffice\Error404Controller;

final class AdminArticleController
{
    public function __construct(private ArticleRepository $postRepository, private View $view, private Session $session)
    {
    }

    public function Admin(): Response
    {
        $isAdmin = $this->session->get('user');

        if ($isAdmin->getStatus() === 'admin' || $isAdmin->getStatus() === 'superadmin') {

            $posts = $this->postRepository->findAll();

            return new Response($this->view->renderAdmin([
                'template' => 'listPost',
                'data' => ['posts' => $posts],

            ]));
        } else {

            return  new Error404Controller($this->view);
        }
    }

    public function displayForUpdatePost(int $id): Response
    {
        $response = new Error404Controller($this->view);

        $article = $this->postRepository->findOneBy(['id' => $id]);

        if ($article !== null) {
            $response = new Response($this->view->renderAdmin(
                [
                    'template' => 'displayForUpdatePost',
                    'data' => [
                        'post' => $article,
                    ],
                ],
            ));
        }

        return $response;
    }


    public function updatePost()
    {
    }
}
