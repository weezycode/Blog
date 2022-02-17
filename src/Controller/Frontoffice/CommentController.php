<?php

declare(strict_types=1);

namespace  App\Controller\Frontoffice;

use App\View\View;
use App\Service\Route;
use App\Service\Token;
use App\Model\Entity\User;
use App\Service\Http\Request;
use App\Service\AccessControl;
use App\Service\Http\Response;
use App\Service\Http\Session\Session;
use App\Model\Repository\UserRepository;
use App\Service\FormValidator\ValidForm;
use App\Model\Repository\ArticleRepository;
use App\Model\Repository\CommentRepository;

final class CommentController
{
    private ?array $infoUser = [];
    private Response $response;

    public function __construct(private Request $request, private UserRepository $userRepository,  private Session $session,  private CommentRepository $commentRepository, private View $view, private ArticleRepository $postRepository, private AccessControl $access)
    {
        $this->infoUser = $this->request->getAllRequest();
    }


    public function addComment()
    {
        $response = new Response();

        if ($this->access->noConnect()) {
            return $response->redirectTo("index.php");
        }

        $user = $this->session->get('user');

        if ($this->infoUser === null) {
            $this->session->addFlashes('warning', "Tous les champs ne sont pas remplis ou corrects.");
            return $response->redirectTo("index.php?action=article");
        }
        $tokenRand = new Token($this->session, $this->request);


        if (!$tokenRand->isToken()) {
            $this->session->addFlashes('error', 'Votre token n\'est plus correct, veuillez réessayer !');
            return $response->redirectTo("index.php");
        }
        $idUser = ValidForm::purifyContent($this->infoUser['id_user']);
        $idPost = ValidForm::purifyContent($this->infoUser['id_article']);
        $content = (ValidForm::purifyAll($this->infoUser['content']));

        if (!isset($content)) {
            $this->session->addFlashes('warning', "Vérifiez votre saisis !");
        }

        $postRepo = $this->postRepository->findOneBy(['id' => $idPost]);

        if (!$postRepo->getId()) {
            $this->session->addFlashes('warning', "Ne mofifiez pas l'id du post !");
        } else if (!$user->getId()) {
            $this->session->addFlashes('warning', "Ne mofifiez pas votre id !");
        } else {

            $idUser = $user->getId();
            $idPost = $postRepo->getId();
            if (!isset($content) || !$postRepo->getId() || !$user->getId()) {
                $this->session->addFlashes('warning', "Votre commentaire est incorrect !");
                $comments = $this->commentRepository->findByPost($idPost);
                $response = new Response($this->view->render(
                    [
                        'template' => 'post',
                        'data' => [
                            'post' => $postRepo,
                            'comments' => $comments,
                        ],
                    ],
                ));


                return $response;
            }

            $this->commentRepository->addComment($idUser, $idPost, $content);
            $this->session->addFlashes('success', "Félicitaion votre commentaire sera publié aprés validation");
            return $response->redirectTo("index.php?action=article");
        }
    }
}
