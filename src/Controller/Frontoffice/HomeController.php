<?php

declare(strict_types=1);

namespace  App\Controller\Frontoffice;



use App\Service\SendEmail;
use App\View\View;
use App\Service\Http\Response;

final class HomeController
{
    /**
     * @Route("/message", name="message", methods="POST")
     */

    public function __construct(private View $view)
    {
        //$this->mailer = $mailer;
    }
    public function displayIndex(): Response
    {


        return new Response($this->view->render(['template' => 'home']));
    }


    static function send(array $params)
    {
        $sendEmailManager = new SendEmail();
        $sendEmailManager->sendEmail($params['post']['email'], $params['post']['name'], $params['post']['prenom'], $params['post']['content']);
    }
}
