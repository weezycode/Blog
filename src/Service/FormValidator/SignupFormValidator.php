<?php

declare(strict_types=1);

namespace  App\Service\FormValidator;

use App\Model\Entity\User;
use App\Service\Http\Request;
use App\Service\Http\Session\Session;
use App\Model\Repository\UserRepository;
use App\Service\FormValidator\ValidForm;
use Whoops\Run;

final class SignupFormValidator
{
    private ?array $infoUser = [];

    public function __construct(private Request $request, private UserRepository $userRepository, private Session $session)
    {
        $this->infoUser = $this->request->getAllRequest();
    }

    public function isValidSignup(): bool
    {

        if ($this->infoUser === null) {

            return false;
        } else {

            $pseudo = ValidForm::purifyAll($this->infoUser['pseudo']);
            $email = ValidForm::is_email($this->infoUser['email']);
            $password = (ValidForm::purify($this->infoUser['password']));
            $passwordConfirmed = (ValidForm::purify($this->infoUser['password_confimed']));

            // Veridcations des mots de passe avec algo.

            if (!$password) {
                $this->session->addFlashes('error', 'Veuillez saisir au moins 6 caratères sans espaces pour votre mot de passe!');
                return false;
            }
            if (!$passwordConfirmed) {
                $this->session->addFlashes('error', 'euillez saisir au moins 6 caratères sans espaces pour le deuxième champ du mot de passe !');
                return false;
            }

            if (!preg_match('/[A-Z]/', $password)) {
                $this->session->addFlashes('error', 'Veuillez saisir au moins une lettre Majuscule  pour votre mot de passe');
                return false;
            }

            if (!preg_match('/[a-z]/', $password)) {
                $this->session->addFlashes('error', 'Veuillez saisir au moins une lettre minuscule  pour votre mot de passe');
                return false;
            }
            if (!preg_match('/[0-9]/', $password)) {
                $this->session->addFlashes('error', 'Veuillez saisir au moins un chiffre pour votre mot de passe');
                return false;
            }
            if (!preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $password)) {
                $this->session->addFlashes('error', 'Veuillez saisir au moins un caractère spécial pour votre mot de passe');
                return false;
            }
            if ($password !== $passwordConfirmed) {
                $this->session->addFlashes('error', 'Veuillez saisir le même mot de passe !');
                return false;
            } else {
                $password = $passwordConfirmed;
            }
            //fin du check mot de passe 

            // check entrée pseudo
            if (!$pseudo) {
                $this->session->addFlashes('error', 'Veuillez saisir un pseudo !');
                return false;
            }
            // check entrée email 
            if (!$email) {
                $this->session->addFlashes('error', 'Veuillez saisir un email correct !');
                return false;
            };
            $emailExist =  $this->userRepository->findUser(['email' => $this->infoUser['email']]);

            foreach ($emailExist as $emailExists) {

                if ($emailExists->getEmail() === $this->infoUser['email']) {
                    $this->session->addFlashes('error', 'Cette adresse email existe déjà !');
                    return false;
                }

                if ($emailExists->getPseudo() === $pseudo) {
                    $this->session->addFlashes('error', 'Ce pseudo existe déjà !');
                    return false;
                }
            }
        }

        return true;
    }
}
