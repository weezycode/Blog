<?php

declare(strict_types=1);

namespace  App\Service\FormValidator;

use App\Model\Entity\User;
use App\Model\Entity\Comment;
use App\Model\Repository\CommentRepository;
use App\Service\Http\Request;
use App\Service\Http\Session\Session;
use App\Model\Repository\UserRepository;

// TODO => Réfléchir à une Class FormValidator générique. Cette classe n'est pas optimal.

final class CommentValidator
{
    private ?array $infoUser = [];

    public function __construct(private Request $request, private UserRepository $userRepository,  private Session $session, private CommentRepository $commentRepository)
    {
        $this->infoUser = $this->request->getAllRequest();
    }


    public function isCommentValid(): bool
    {
        if ($this->infoUser === null) {

            return false;
        }

        $idUser = ValidForm::purify($this->infoUser['id_user']);
        $idPost = ValidForm::purifyContent($this->infoUser['id_article']);
        $content = (ValidForm::purifyContent($this->infoUser['content']));
        if (!isset($idUser) || !isset($idPost) || !isset($content)) {
            return false;
        }

        $users =  $this->userRepository->findOneBy(['id' => $idUser]);
        if (!$users instanceof (User::class) || $idUser !== $users->getId()) {
            return false;
        }
        $comment = $this->commentRepository->findByPost($idPost);
        $comments = [];
        foreach ($comment as $comments) {
            if ($idPost !== $comments['id_article']) {
                return false;
            }
        }

        return true;
    }
}
