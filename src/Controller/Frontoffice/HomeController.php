<?php

declare(strict_types=1);

namespace  App\Controller\Frontoffice;

use App\View\View;
use App\Service\Http\Request;
use App\Service\Http\Response;
use App\Service\FormValidator\ValidForm;
use App\Service\Http\Session\Session;
use App\Service\SendEmail;

final class HomeController
{
    private $sendEmail;
    private ?array $infoContact = [];

    private Session $session;


    public function __construct(private View $view, private Request $request)
    {
        $this->infoContact = $this->request->getAllRequest();


        //$this->mailer = $mailer;
    }
    public function displayIndex(): Response
    {


        return new Response($this->view->render(['template' => 'home']));
    }

    public function contactForm()
    {

        $this->sendEmail = new SendEmail();
        $name = ValidForm::purify($this->infoContact['nom']);
        $lname = ValidForm::purify($this->infoContact['prenom']);
        $message = ValidForm::purify($this->infoContact['message']);
        $email = ValidForm::purify($this->infoContact['email']);

        if (!isset($name) || !isset($lname) || !isset($email) || !isset($message) || !ValidForm::is_email($email)) {
            $this->session->addFlashes('warning', "Tous les champs ne sont pas remplis ou corrects.");
        } else {

            $this->sendEmail->SendEmail($name, $lname, $email, $message);
            $this->session->addFlashes('error', "Votre formulaire a bien été envoyé.");
        }
        $this->displayIndex();
    }
}
