<?php

declare(strict_types=1);

namespace  App\Service\FormValidator;

use App\Service\Http\Request;
use App\Service\Http\Session\Session;
use App\Model\Repository\UserRepository;

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
            if ($user === null) {
                $this->session->addFlashes('error', 'Les identifiants sont incorrecrtes !');
                return false;
            }
        }

        $isPasswordCorrect = password_verify($this->infoUser['password'], $user->getPassword());
        if ($isPasswordCorrect === false) {
            $this->session->addFlashes('error', 'Les identifiants sont incorrecrtes !');
            return false;
        }

        $this->session->set('user', $user);

        return true;
    }
}
