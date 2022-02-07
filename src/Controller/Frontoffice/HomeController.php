<?php

declare(strict_types=1);

namespace  App\Controller\Frontoffice;

use App\View\View;
use App\Service\Http\Request;
use App\Service\Http\Response;
use App\Service\FormValidator\ValidForm;
use App\Service\Http\Session\Session;
use App\Service\Route;
use App\Service\SendEmail;

final class HomeController
{

    private Response  $response;

    public function __construct(private View $view)
    {

        //$this->infoContact = $this->request->getAllRequest();
        //$this->session = 

        //$this->mailer = $mailer;
    }
    public function displayIndex(): Response
    {

        return new Response($this->view->render(['template' => 'home']));
    }
}
