<?php

declare(strict_types=1);

namespace App\Service\FormValidator;

use Whoops\Run;
use App\View\View;
use App\Service\Token;
use App\Model\Entity\User;
use App\Service\Http\Request;
use App\Service\Http\Response;
use App\Service\Http\Session\Session;
use App\Model\Repository\UserRepository;
use App\Service\FormValidator\ValidForm;

final class SignupFormValidator
{
    private ?array $infoUser = [];
    private View $view;

    public function __construct(private Request $request, private UserRepository $userRepository, private Session $session)
    {
        $this->infoUser = $this->request->getAllRequest();
        $this->view = new View($this->session);
    }

    public function isValidSignup(): bool
    {

        if ($this->infoUser === null) {

            return false;
        }

        $pseudo = ValidForm::purifyAll($this->infoUser['pseudo']);
        $email = ValidForm::is_email($this->infoUser['email']);
        $password = ValidForm::purify($this->infoUser['password']);
        $passwordConfirmed = (ValidForm::purify($this->infoUser['password_confimed']));

        if (!$password || !$passwordConfirmed) {
            return false;
        }
        // if (!$passwordConfirmed) {
        //     return false;
        // }

        if ($password !== $passwordConfirmed) {
            return false;
        } else {
            $password = $passwordConfirmed;
        }

        if (!preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $password)) {
            return false;
        }
        // if (!preg_match('/[a-z]/', $password)) {
        //     return false;
        // }
        // if (!preg_match('/[0-9]/', $password)) {
        //     return false;
        // }
        //if (!preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $password)) {
        //   return false;
        // }

        //fin du check mot de passe 

        // check entrée pseudo
        if (!$pseudo) {
            return false;
        }
        // check entrée email 
        if (!$email) {
            return false;
        };
        $emailExist =  $this->userRepository->findUser(['email' => $this->infoUser['email']]);

        foreach ($emailExist as $emailExists) {


            if ($emailExists->getEmail() === $this->infoUser['email']) {
                return false;
            }

            if ($emailExists->getPseudo() === $pseudo) {
                return false;
            }
        }
        return true;
    }
}
