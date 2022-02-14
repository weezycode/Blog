<?php

declare(strict_types=1);

namespace  App\Controller\Frontoffice;


use App\View\View;
use App\Service\Route;
use App\Service\Http\Response;

final class Error404Controller
{

    public function __construct(private View $view)
    {
        //$this->mailer = $mailer;
    }
    public function displayError()
    {

        return new Response($this->view->render(['template' => 'error/404']));
    }
}
