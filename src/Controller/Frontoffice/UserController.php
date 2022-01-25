<?php

declare(strict_types=1);

namespace  App\Controller\Frontoffice;

use App\View\View;
use App\Service\Http\Request;
use App\Service\Http\Response;
use App\Service\Http\Session\Session;
use App\Model\Repository\UserRepository;
use App\Service\FormValidator\ValidForm;
use App\Service\FormValidator\LoginFormValidator;

final class UserController
{

    private ?array $infoUser = [];
    public function __construct(private Request $request, private UserRepository $userRepository, private View $view, private Session $session)
    {
        $this->infoUser = $this->request->getAllRequest();
    }

    public function signAction(): Response
    {

        return new Response($this->view->render(['template' => 'sign', 'data' => []]));
    }




    public function loginAction(Request $request): Response
    {

        $loginFormValidator = new LoginFormValidator($request, $this->userRepository, $this->session);

        if ($request->getMethod() === 'POST') {
            if ($loginFormValidator->isValid()) {
                return new Response(($this->view->render(['template' => 'home'])));
            }
            $this->session->addFlashes('error', 'Mauvais identifiants');
        }



        return new Response($this->view->render(['template' => 'login', 'data' => []]));
    }



    public function signUpAction()
    {

        if ($this->infoUser === null) {
            $this->session->addFlashes('error', 'Tous les champs doivent être saisis');
            return new Response($this->view->render(['template' => 'sign', 'data' => []]));
        }
        $pseudo = ValidForm::purify($this->infoUser['pseudo']);
        $email = ValidForm::purifyContent($this->infoUser['email']);
        $password = (ValidForm::purify($this->infoUser['password']));
        if (!isset($pseudo) || !isset($password) || !isset($email) || !ValidForm::is_email($email)) {
            $this->session->addFlashes('error', 'Tous les champs doivent être saisis');
            return new Response($this->view->render(['template' => 'sign', 'data' => []]));
        }

        $passwd = password_hash($password, PASSWORD_DEFAULT);
        $setUser = $this->userRepository->findUser();

        foreach ($setUser as $currentUser) {

            if ($pseudo === $currentUser->getPseudo() || $email === $currentUser->getEmail()) {
                $this->session->addFlashes('error', 'Cet utilisateur existe déjà !');
                return new Response($this->view->render(['template' => 'sign', 'data' => []]));
            }
        }
        $newUser = $this->userRepository->createUser($pseudo, $email, $passwd);

        $this->session->set('user', $newUser);
        $this->session->addFlashes('success', 'Félicitation vous maintenant un membre !');
        return new Response(($this->view->render(['template' => 'home'])));
    }



    public function logoutAction(): Response
    {
        $this->session->remove('user');
        return new Response(($this->view->render(['template' => 'home'])));
    }
}
