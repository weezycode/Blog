<?php

declare(strict_types=1);

namespace  App\Controller\Frontoffice;

use App\View\View;
use App\Service\Route;
use App\Model\Entity\User;
use App\Service\Http\Request;
use App\Service\AccessControl;
use App\Service\Http\Response;
use App\Service\Http\Session\Session;
use App\Model\Repository\UserRepository;
use App\Service\FormValidator\ValidForm;
use App\Model\Repository\ArticleRepository;
use App\Model\Repository\CommentRepository;

// TODO => Réfléchir à une Class FormValidator générique. Cette classe n'est pas optimal.

final class CommentController
{
    private ?array $infoUser = [];

    public function __construct(private Request $request, private UserRepository $userRepository,  private Session $session,  private CommentRepository $commentRepository, private View $view, private ArticleRepository $postRepository)
    {
        $this->infoUser = $this->request->getAllRequest();
    }


    public function addComment()
    {
        $redirecting = new Route($this->view);
        $userConnect = new AccessControl($this->session, $this->view);

        if ($userConnect->noConnect()) {
            return $redirecting->redirecting();
        }
        $user = $this->session->get('user');

        if ($this->infoUser === null) {
            $this->session->addFlashes('warning', "Tous les champs ne sont pas remplis ou corrects.");
            return $redirecting->redirectingPostcomment();
        }

        $idUser = ValidForm::purifyContent($this->infoUser['id_user']);
        $idPost = ValidForm::purifyContent($this->infoUser['id_article']);
        $content = (ValidForm::purifyAll($this->infoUser['content']));

        if (!isset($idUser) || !isset($idPost) || !isset($content)) {
            $this->session->addFlashes('warning', "Vérifiez votre saisis !");
            return $redirecting->redirectingPostcomment();
        }

        $postRepo = $this->postRepository->findOneBy(['id' => $idPost]);

        if (!$postRepo->getId()) {
            $this->session->addFlashes('warning', "Ne mofifiez pas l'id du post !");
            return $redirecting->redirectingPostcomment();
        }

        if (!$user->getId()) {
            $this->session->addFlashes('warning', "Ne mofifiez pas votre id !");
            return $redirecting->redirectingPostcomment();
        }

        $this->commentRepository->addComment($idUser, $idPost, $content);
        $this->session->addFlashes('success', "Félicitaion votre commentaire sera publié aprés validation");

        return $redirecting->redirectingPostcomment();
    }
}
