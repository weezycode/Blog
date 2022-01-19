<?php

declare(strict_types=1);

namespace  App\Controller\Frontoffice;


use App\View\View;
use App\Service\Http\Response;

final class Error404Controller
{
    /**
     * @Route("/message", name="message", methods="POST")
     */

    public function __construct(private View $view)
    {
        //$this->mailer = $mailer;
    }
    public function displayError(): Response
    {


        return new Response($this->view->render(['template' => 'error/404']));
    }
}
