<?php

declare(strict_types=1);

namespace App\Service;

use App\Service\Http\Session\Session;
use App\View\View;

final class AccessControl
{
    public function __construct(private Session $session, private View $view)
    {
    }

    public function isUser()
    {
        if ($this->session->get('user') !== null) {
            $return = new Route($this->view);
            return $return->redirecting();
        }
    }

    public function noConnect()
    {
        if ($this->session->get('user') === null) {
            $return = new Route($this->view);
            return $return->redirecting();
        }
    }

    public function isAdmin(): bool
    {
        if ($this->session->get('user') === null) {

            return false;
        }
        return true;
    }
}
