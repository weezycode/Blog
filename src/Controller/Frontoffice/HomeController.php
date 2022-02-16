<?php

declare(strict_types=1);

namespace  App\Controller\Frontoffice;

use App\Service\Http\Request;
use App\View\View;
use App\Service\Token;
use App\Service\Http\Response;
use App\Service\Http\Session\Session;

final class HomeController
{


    public function __construct(private View $view, private Session $session, private Request $request)
    {
    }
    public function displayIndex(): Response
    {
        $tokenRand = new Token($this->session, $this->request);
        $tokenRand->genToken();
        return new Response($this->view->render([
            'template' => 'home', 'data' => [
                'token' => $tokenRand->getToken(),
            ]
        ]));
    }
}
