<?php

declare(strict_types=1);

namespace  App\Controller\backoffice;

use App\View\View;
use App\Service\Http\Response;
use App\Service\Http\Session\Session;
use App\Model\Repository\ArticleRepository;
use App\Model\Repository\CommentRepository;
use App\Controller\Frontoffice\Error404Controller;
use App\Service\FormValidator\ValidForm;

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

    public function addPost()
    {
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
        if ($this->infoUser === null) {
            $this->session->addFlashes('warning', "Tous les champs ne sont pas remplis ou corrects.");
            return $this->Admin();
        }

        $idPost = ValidForm::purify($this->infoUser['id_article']);
        $idUser = ValidForm::purifyContent($this->infoUser['id_author']);
        $title = ValidForm::purifyContent($this->infoUser['title']);
        $shortContent = ValidForm::purifyContent($this->infoUser['short_content']);
        $content = (ValidForm::purifyContent($this->infoUser['content']));

        if (!isset($idPost) || !isset($idUser) || !isset($title) || !isset($shortContent) || !isset($content)) {
            $this->session->addFlashes('warning', "Tous les champs ne sont pas remplis ou corrects.");
            return $this->Admin();
        }
        $postRepo = $this->postRepository->findOneBy(['id' => $idPost]);
        $userRepo = $this->userRepository->findUser();
        foreach ($userRepo as $user) {

            if ($user->getId() !== $idUser and $postRepo->getId() !== $idPost) {
                $this->session->addFlashes('warning', "Attention n'essayez pas de modifier les id");
                return $this->Admin();
            }
        }
        $this->postRepository->updatePost($idPost, $idUser, $title, $shortContent, $content);
        $this->session->addFlashes('success', "Félicitaion votre post est publié !");
        return $this->Admin();
    }


    public function deletePost()
    {
    }
}
