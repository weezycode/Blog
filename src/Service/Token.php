<?php

declare(strict_types=1);

namespace  App\Service;

use App\Service\Http\Request;
use App\Service\Http\Session\Session;

final class Token
{
    private ?array $infoToken = [];
    public function __construct(private Session $session, private Request $request)
    {
        $this->infoToken = $this->request->getAllRequest();
    }

    public function getToken()
    {
        $token = bin2hex(random_bytes(35));
        return $token;
    }

    public function setToken()
    {
        $this->session->set('user', $this->getToken());
    }

    public function isToken(): bool
    {

        if ($this->session->get('token') !== $this->infoToken['token']) {
            return false;
        }
        return true;
    }
}
