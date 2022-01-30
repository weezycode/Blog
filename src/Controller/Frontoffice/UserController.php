<?php

declare(strict_types=1);

namespace  App\Controller\Frontoffice;

use App\View\View;
use App\Service\SendEmail;
use App\Service\Http\Request;
use App\Service\Http\Response;
use App\Service\Http\Session\Session;
use App\Model\Repository\UserRepository;
use App\Service\AccessControl;
use App\Service\FormValidator\ValidForm;
use App\Service\FormValidator\LoginFormValidator;
use App\Service\FormValidator\SignupFormValidator;
use App\Service\Route;

final class UserController
{

    private $sendEmail;
    public function __construct(private Request $request, private UserRepository $userRepository, private View $view, private Session $session)
    {
        $this->infoUser = $this->request->getAllRequest();
    }

    public function signAction(): Response
    {
        if ($this->session->get('user')) {
            header('Location: index.php');
        }
        $redirecting = new Route($this->view);
        return $redirecting->signAction();
    }




    public function loginAction(Request $request): Response
    {
        $redirecting = new Route($this->view);
        $userConnect = new AccessControl($this->session, $this->view);

        if ($userConnect->isUser()) {
            return $redirecting->redirecting();
        }

        $loginFormValidator = new LoginFormValidator($request, $this->userRepository, $this->session);

        if ($request->getMethod() === 'POST') {
            if ($loginFormValidator->isValid()) {
                return $redirecting->redirecting();
            }
        }
        return $redirecting->loginAction();
    }



    public function signUpAction(Request $request): Response
    {
        $redirecting = new Response();
        $userConnect = new AccessControl($this->session, $this->view);

        if ($userConnect->isUser()) {
            return $redirecting->redirecting();
        }

        $this->sendEmail = new SendEmail($this->view);
        $signupFormValid = new SignupFormValidator($request, $this->userRepository, $this->session);
        if ($request->getMethod() === 'POST') {

            if ($signupFormValid->isValidSignup()) {

                $pseudo = $request->getRequest('pseudo');
                $email = $request->getRequest('email');
                $password = $request->getRequest('password');
                $passwd = password_hash($password, PASSWORD_DEFAULT);

                $newUser = $this->userRepository->createUser($pseudo, $email, $passwd);
                $this->sendEmail->SendEmailRegister($pseudo, $email);
                $this->session->set('user', $newUser);
                $this->session->addFlashes('success', 'Félicitation vous êtes maintenant un membre et vous allez recevoir un email de confirmation!');

                return $redirecting->redirecting();
            }
        }
        $redirectingToSign = new Route($this->view);
        return $redirectingToSign->signAction();
    }

    public function logoutAction()
    {
        $this->session->remove('user');
        header('Location: index.php');
    }

    public function deleteUser(Request $request)
    {
        $redirecting = new Response();
        $userConnect = new AccessControl($this->session, $this->view);
        $route = new Route($this->view);

        if ($userConnect->noConnect()) {
            return $redirecting->redirecting();
        }

        if ($request->getMethod() === 'POST') {

            $idUser = $request->getRequest('id_user');
            $user = $this->session->get('user');
            if ($user->getId() !== null) {
                $this->userRepository->delete($idUser);
                $this->session->addFlashes('success', 'Vous n\'êtes plus un membre du blog');
                $this->logoutAction();
                return $redirecting->redirecting();
            }
        }
        return $route->deleteUser();
    }
}
