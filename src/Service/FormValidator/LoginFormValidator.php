<?php

declare(strict_types=1);

namespace  App\Service\FormValidator;

use App\Model\Entity\User;
use App\Service\Http\Request;
use App\Service\Http\Session\Session;
use App\Model\Repository\UserRepository;

// TODO => Réfléchir à une Class FormValidator générique. Cette classe n'est pas optimal.

final class LoginFormValidator
{
    private ?array $infoUser = [];

    public function __construct(private Request $request, private UserRepository $userRepository, private Session $session)
    {
        $this->infoUser = $this->request->getAllRequest();
    }

    public function isValid(): bool
    {
        if ($this->infoUser === null) {

            return false;
        } else {

            $user =  $this->userRepository->findOneBy(['email' => $this->infoUser['email']]);
        }
        $isPasswordCorrect = password_verify($this->infoUser['password'], $user->getPassword());

        if (!$user instanceof (User::class) || $isPasswordCorrect === false) {
            return false;
        }


        $this->session->set('user', $user);

        return true;
    }
}
