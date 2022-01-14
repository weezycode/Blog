<?php

declare(strict_types=1);

namespace  App\Controller\Frontoffice;

use App\View\View;
use App\Service\Http\Request;
use App\Service\Http\Response;
use App\Service\Http\Session\Session;
use App\Model\Repository\UserRepository;
use App\Service\FormValidator\LoginFormValidator;

final class UserController
{
    public function __construct(private UserRepository $userRepository, private View $view, private Session $session)
    {
    }

    public function loginAction(Request $request): Response
    {
        $loginFormValidator = new LoginFormValidator($request, $this->userRepository, $this->session);

        if ($request->getMethod() === 'POST') {
            if ($loginFormValidator->isValid()) {
                return new Response('<h1>Utilisateur connecté</h1><h2>faire une redirection vers la page d\'accueil</h2><a href="index.php?action=posts">Liste des posts</a><br>', 200);
            }
            $this->session->addFlashes('error', 'Mauvais identifiants');
        }
        return new Response($this->view->render(['template' => 'login', 'data' => []]));
    }

    public function signAction(Request $request): Response
    {
        $loginFormValidator = new LoginFormValidator($request, $this->userRepository, $this->session);

        if ($request->getMethod() === 'POST') {
            if ($loginFormValidator->isValid()) {
                return new Response('<h1>Utilisateur connecté</h1><h2>faire une redirection vers la page d\'accueil</h2><a href="index.php?action=posts">Liste des posts</a><br>', 200);
            }
            $this->session->addFlashes('error', 'Mauvais identifiants');
        }
        return new Response($this->view->render(['template' => 'sign', 'data' => []]));
    }
    public function logoutAction(): Response
    {
        $this->session->remove('user');
        return new Response('<h1>Utilisateur déconnecté</h1><h2>faire une redirection vers la page d\'accueil</h2><a href="index.php?action=posts">Liste des posts</a><br>', 200);
    }
}
