<?php

declare(strict_types=1);

namespace  App\Controller\backoffice;

use App\View\View;
use App\Service\Http\Request;
use App\Service\AccessControl;
use App\Service\Http\Response;
use App\Service\Http\Session\Session;
use App\Service\FormValidator\ValidForm;
use App\Model\Repository\ArticleRepository;
use App\Model\Repository\CommentRepository;
use App\Service\Route;

final class AdminArticleController
{
    private ?array $infoUser = [];
    public function __construct(private ArticleRepository $postRepository, private View $view, private Session $session, private Request $request)
    {
        $this->infoUser = $this->request->getAllRequest();
    }

    public function Admin(): Response
    {
        $isUser = new AccessControl($this->session, $this->view);
        $redirecting = new Route($this->view);
        if (!$isUser->isAdmin()) {
            $redirecting->redirecting();
        }
        $isAdmin = $this->session->get('user');

        if ($isAdmin->getStatus() === 'admin' || $isAdmin->getStatus() === 'superadmin') {

            $posts = $this->postRepository->findAll();

            return new Response($this->view->renderAdmin([
                'template' => 'listPost',
                'data' => ['posts' => $posts],

            ]));
        } else {

            return $redirecting->displayError();
        }
    }

    public function displayToAddPost(): Response
    {
        $isUser = new AccessControl($this->session, $this->view);
        $redirecting = new Route($this->view);
        if (!$isUser->isAdmin()) {
            $redirecting->redirecting();
        }
        $isAdmin = $this->session->get('user');

        if ($isAdmin->getStatus() === 'admin' || $isAdmin->getStatus() === 'superadmin') {

            return $redirecting->addPost();
        } else {

            return $redirecting->redirecting();
        }
    }

    public function addPost()
    {
        $isUser = new AccessControl($this->session, $this->view);
        $redirecting = new Route($this->view);

        if (!$isUser->isAdmin()) {
            $redirecting->redirecting();
        }

        $isAdmin = $this->session->get('user');

        if ($isAdmin->getStatus() === 'admin' || $isAdmin->getStatus() === 'superadmin') {

            if ($this->infoUser === null) {
                $this->session->addFlashes('warning', "Tous les champs ne sont pas remplis ou corrects.");
                return $this->Admin();
            }
            $title = ValidForm::purifyAll($this->infoUser['title']);
            $shortContent = ValidForm::purifyAll($this->infoUser['short_content']);
            $content = (ValidForm::purifyAll($this->infoUser['content']));

            if (!isset($title)) {
                $this->session->addFlashes('warning', "Veuillez vérifier le champ titre, mettez que tu texte !.");
            } elseif (!isset($shortContent)) {
                $this->session->addFlashes('warning', "Veuillez vérifier le champ châpo, mettez que tu texte.");
            } elseif (!isset($content)) {
                $this->session->addFlashes('warning', "Veuillez vérifier le champ du post, mettez que tu texte.");
            } else {
                if (!$isAdmin->getId()) {
                    $this->session->addFlashes('warning', "Attention n'essayez pas de modifier l'id de l'utilisateur");
                }
                $idUser = $isAdmin->getId();
                $this->postRepository->createPost($idUser, $title, $shortContent, $content);
                $this->session->addFlashes('success', "Félicitaion votre post a été ajouté!");
                return $this->Admin();
            }
            return $this->Admin();
        }
        $redirecting->redirecting();
    }

    public function displayForUpdatePost(int $id): Response
    {
        $isUser = new AccessControl($this->session, $this->view);
        $redirecting = new Route($this->view);

        if (!$isUser->isAdmin()) {
            $redirecting->redirecting();
        }
        $isAdmin = $this->session->get('user');
        if ($isAdmin->getStatus() === 'admin' || $isAdmin->getStatus() === 'superadmin') {
            $article = $this->postRepository->findOneBy(['id' => $id]);
            if ($article) {
                return new Response($this->view->renderAdmin(
                    [
                        'template' => 'displayForUpdatePost',
                        'data' => [
                            'post' => $article,
                        ],
                    ],
                ));
            }
        }

        return $redirecting->redirecting();
    }


    public function updatePost()
    {
        $isUser = new AccessControl($this->session, $this->view);
        $redirecting = new Route($this->view);

        if (!$isUser->isAdmin()) {
            $redirecting->redirecting();
        }

        $isAdmin = $this->session->get('user');

        if ($isAdmin->getStatus() === 'admin' || $isAdmin->getStatus() === 'superadmin') {

            if ($this->infoUser === null) {
                $this->session->addFlashes('warning', "Tous les champs ne sont pas remplis ou corrects.");
                return $this->Admin();
            }

            $idPost = $this->infoUser['id_article'];
            $title = ValidForm::purifyAll($this->infoUser['title']);
            $shortContent = ValidForm::purifyAll($this->infoUser['short_content']);
            $content = (ValidForm::purifyAll($this->infoUser['content']));


            if (!isset($idPost)) {
                $this->session->addFlashes('warning', "L'ID de l'article n'existe pas.");
                return $this->Admin();
            } elseif (!isset($title)) {
                $this->session->addFlashes('warning', "Veuillez vérifier le champ titre, mettez que tu texte !.");
                return $this->Admin();
            } elseif (!isset($shortContent)) {
                $this->session->addFlashes('warning', "Veuillez vérifier le champ châpo, mettez que tu texte.");
                return $this->Admin();
            } elseif (!isset($content)) {
                $this->session->addFlashes('warning', "Veuillez vérifier le champ du post, mettez que tu texte.");
                return $this->Admin();
            } else {

                if (!$isAdmin->getId()) {
                    $this->session->addFlashes('warning', "Attention n'essayez pas de modifier l'id de l'utilisateur");
                    return $this->Admin();
                }
                $idUser = $isAdmin->getId();


                $postRepo = $this->postRepository->findOneBy(['id' => $idPost]);

                if (!$postRepo->getId()) {
                    $this->session->addFlashes('warning', "Attention n'essayez pas de modifier l'id du post");
                    return $this->Admin();
                }

                $this->postRepository->updatePost($idPost, $idUser, $title, $shortContent, $content);
                $this->session->addFlashes('success', "Félicitaion votre post a été modifié!");
                return $this->Admin();
            }
            return $this->Admin();
        }
    }


    public function deletePost()
    {
        $isUser = new AccessControl($this->session, $this->view);
        $redirecting = new Route($this->view);

        if (!$isUser->isAdmin()) {
            $redirecting->redirecting();
        }

        $isAdmin = $this->session->get('user');

        if ($isAdmin->getStatus() === 'admin' || $isAdmin->getStatus() === 'superadmin') {

            $idPost = ValidForm::purifyContent($this->infoUser['idPost']);

            $this->postRepository->deletePost($idPost);
            $this->session->addFlashes('success', "Félicitaion le post a été supprimé !");
            return $this->Admin();
        } else {
            $redirecting->redirecting();
        }
    }


    public function displayAllComment(CommentRepository $commentRepository)
    {
        $isUser = new AccessControl($this->session, $this->view);
        $redirecting = new Route($this->view);
        if (!$isUser->isAdmin()) {
            $redirecting->redirecting();
        }
        $isAdmin = $this->session->get('user');

        if ($isAdmin->getStatus() === 'admin' || $isAdmin->getStatus() === 'superadmin') {

            $comments = $commentRepository->findAll();
            $posts = $this->postRepository->findAll();

            return new Response($this->view->renderAdmin([
                'template' => 'listComment',
                'data' => [
                    'comment' => $comments,
                    'posts'  => $posts,
                ],

            ]));
        } else {

            return $redirecting->redirecting();
        }
    }

    public function updateCommentStatus(CommentRepository $commentRepository)
    {
        $isUser = new AccessControl($this->session, $this->view);
        $redirecting = new Route($this->view);
        if (!$isUser->isAdmin()) {
            $redirecting->redirecting();
        }
        $isAdmin = $this->session->get('user');

        if ($isAdmin->getStatus() === 'admin' || $isAdmin->getStatus() === 'superadmin') {
            $id = ValidForm::purifyContent($this->infoUser['idComment']);
            $commentRepository->updateComment($id);
            $this->session->addFlashes('success', "Le commentaire est maintenant en ligne !");
            return $this->Admin();
        } else {

            return $redirecting->redirecting();
        }
    }

    public function deleteComment(CommentRepository $commentRepository)
    {
        $isUser = new AccessControl($this->session, $this->view);
        $redirecting = new Route($this->view);
        if (!$isUser->isAdmin()) {
            $redirecting->redirecting();
        }
        $isAdmin = $this->session->get('user');

        if ($isAdmin->getStatus() === 'admin' || $isAdmin->getStatus() === 'superadmin') {
            $id = ValidForm::purifyContent($this->infoUser['idComment']);
            $commentRepository->deleteComment($id);
            $this->session->addFlashes('success', "Le commentaire a été supprimé !");
            return $this->Admin();
        } else {

            return $redirecting->redirecting();
        }
    }
}
