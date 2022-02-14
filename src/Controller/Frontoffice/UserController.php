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
use App\Service\Token;
use App\Service\FormValidator\ValidForm;
use App\Service\FormValidator\LoginFormValidator;
use App\Service\FormValidator\SignupFormValidator;
use App\Service\Route;

final class UserController
{

    private $sendEmail;
    private $tok;
    private ?array $infoUser = [];
    public function __construct(private Request $request, private UserRepository $userRepository, private View $view, private Session $session, private AccessControl $access)
    {
        $this->infoUser = $this->request->getAllRequest();
    }


    public function loginAction(Request $request): Response
    {

        $response = new Response();
        if ($this->access->isUser()) {
            return $response->redirectTo("index.php");
        }

        $tokenRand = new Token($this->session, $request);
        $token = $tokenRand->getToken();


        $loginFormValidator = new LoginFormValidator($request, $this->userRepository, $this->session);

        if ($request->getMethod() === 'POST') {

            if (!$tokenRand->isToken()) {
                $this->session->addFlashes('error', 'Votre token n\'est plus correct, veuillez réessayer !');
                return $response->redirectTo("index.php");
            }
            if ($loginFormValidator->isValid()) {
                return $response->redirectTo("index.php");
            }
        }



        $response = new Response($this->view->render(
            [
                'template' => 'login',
                'data' => [
                    'email' => $request->getRequest('email'),
                    'token' => $token,

                ],
            ],
        ));

        return $response;
    }


    public function signUpAction(): Response
    {

        $error = [];
        $response = new Response();

        if ($this->access->isUser()) {
            return $response->redirectTo("index.php");
        }

        $tokenRand = new Token($this->session, $this->request);
        $token = $tokenRand->getToken();
        $this->sendEmail = new SendEmail($this->view);
        $signupFormValid = new SignupFormValidator($this->request, $this->userRepository, $this->session);

        if ($this->infoUser === null) {
            $this->session->addFlashes('error', 'Tous les champs doivent être saisis');
            return $response->redirectTo("index.php");
        }
        if ($this->request->getMethod() === 'POST') {
            if ($tokenRand->isToken() === false) {
                $this->session->addFlashes('error', 'Votre token n\'est plus correct, veuillez réessayer !');
                return $response->redirectTo("index.php");
            }

            $verify = new ValidForm();

            $pseudo = $this->infoUser['pseudo'];
            $email = $this->infoUser['email'];
            $password = $this->infoUser['password'];
            $passwordConfirmed = $this->infoUser['password_confimed'];

            if ($password !== $passwordConfirmed) {
                $error[] = 'Veuillez saisir le même mot de passe !';
            } else {
                $password = $passwordConfirmed;
            }

            if (!ValidForm::purifyMe($password) || !ValidForm::purifyMe($passwordConfirmed) || !$verify->is_carak($password) || !$verify->is_uppercase($password) || !$verify->is_lowercase($password) || !$verify->is_number($password)) {
                $error[] =  'Veuillez saisir au moins au moins 6 caratères sans espaces, une lettre Majuscule, minuscule,un chiffre et un caractère espécial pour votre mot de passe';
            }

            // check entrée pseudo
            if (!ValidForm::purifyContent($pseudo)) {
                $error[] = 'Vérifiez votre pseudo !';
            }
            if (!ValidForm::is_email($email)) {
                $error[] = 'Vérifiez votre email!';
            }

            if (!isset($pseudo) && !isset($email) && !isset($password) && !isset($passwordConfirmed)) {
                $error[] =   'Vérifiez vos saisis';
            } else {
                $mailExist =  $this->userRepository->findOneBy(['email' => $this->infoUser['email']]);

                if ($mailExist !== null) {
                    $error[] =   'Cette adresse email existe déjà !';

                    if ($mailExist->getPseudo() === $pseudo) {
                        $error[] =   'Ce pseudo existe déjà !';
                    }
                } else {

                    if ($signupFormValid->isValidSignup()) {
                        $passwd = password_hash($password, PASSWORD_DEFAULT);

                        $newUser = $this->userRepository->createUser($pseudo, $email, $passwd);
                        $this->sendEmail->SendEmailRegister($pseudo, $email);
                        $this->session->set('user', $newUser);
                        $this->session->addFlashes('success', 'Félicitation vous êtes maintenant un membre et vous allez recevoir un email de confirmation!');

                        return $response->redirectTo("index.php");
                    }
                }
            }
        }


        $response = new Response($this->view->render(
            [
                'template' => 'sign',
                'data' => [
                    'infoUser' => $this->infoUser,
                    'token' => $token,
                    'message' => $error,

                ],
            ],
        ));

        return $response;
    }



    public function logoutAction()
    {
        $response = new Response();
        if ($this->access->noConnect()) {
            return $response->redirectTo("index.php");
        }
        $this->session->remove('user');
        return $response->redirectTo("index.php");
    }

    public function deleteUser(Request $request)
    {
        $response = new Response();
        if ($this->access->noConnect()) {
            return $response->redirectTo("index.php");
        }

        if ($request->getMethod() === 'POST') {

            $idUser = $request->getRequest('id_user');
            $user = $this->session->get('user');
            if ($user->getId() !== null) {
                $this->userRepository->delete($idUser);
                $this->session->addFlashes('success', 'Vous n\'êtes plus un membre du blog');
                $this->logoutAction();
                return $response->redirectTo("index.php");
            }
        }
        return new Response($this->view->render(['template' => 'deleteUser', 'data' => []]));
    }
}
