<?php

declare(strict_types=1);

namespace  App\Controller\Frontoffice;

use App\View\View;
use App\Model\Entity\User;
use App\Service\Http\Request;
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
        if ($this->infoUser === null) {
            $this->session->addFlashes('warning', "Tous les champs ne sont pas remplis ou corrects.");
            header('Location: index.php?action=article');
        }

        $idUser = ValidForm::purify($this->infoUser['id_user']);
        $idPost = ValidForm::purifyContent($this->infoUser['id_article']);
        $content = (ValidForm::purifyContent($this->infoUser['content']));

        if (!isset($idUser) || !isset($idPost) || !isset($content)) {
            $this->session->addFlashes('warning', "Tous les champs ne sont pas remplis ou corrects.");
            header('Location: index.php?action=article');
        }
        $postRepo = $this->postRepository->findOneBy(['id' => $idPost]);
        $userRepo = $this->userRepository->findUser();
        foreach ($userRepo as $user) {

            if ($user->getId() !== $idUser and $postRepo->getId() !== $idPost) {
                $this->session->addFlashes('warning', "Tous les champs ne sont pas remplis ou corrects.");
                header('Location: index.php?action=article');
            }
        }
        $this->commentRepository->addComment($idUser, $idPost, $content);
        $this->session->addFlashes('success', "Félicitaion votre commentaire sera publié aprés validation");

        header('Location: index.php?action=article');
    }
}
