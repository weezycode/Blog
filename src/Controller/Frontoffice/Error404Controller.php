<?php

declare(strict_types=1);

namespace  App\Controller\Frontoffice;


use App\View\View;
use App\Service\Route;
use App\Service\Http\Response;

final class Error404Controller
{

    private Response  $response;
    public function __construct(private View $view)
    {
        //$this->mailer = $mailer;
    }
    public function displayError()
    {
        $response = new Response();

        return new Response($this->view->render(['template' => 'error/404']));
    }
}
