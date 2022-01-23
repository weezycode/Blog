<?php

declare(strict_types=1);

namespace  App\Controller\Frontoffice;

use App\View\View;
use App\Service\Http\Request;
use App\Service\FormValidator\ValidForm;
use App\Service\Http\Session\Session;
use App\Service\SendEmail;

final class ContactController
{
    private $sendEmail;
    private ?array $infoContact = [];


    public function __construct(private Request $request, private View $view, private Session $session)
    {
        $this->infoContact = $this->request->getAllRequest();
    }

    public function contactForm()
    {
        $this->sendEmail = new SendEmail($this->session);
        $name = ValidForm::purify($this->infoContact['nom']);
        $lname = ValidForm::purify($this->infoContact['prenom']);
        $message = ValidForm::purify($this->infoContact['message']);
        $email = ValidForm::purifyContent($this->infoContact['email']);

        if (!isset($name) || !isset($lname) || !isset($email) || !isset($message) || !ValidForm::is_email($email)) {
            $this->session->addFlashes('warning', "Tous les champs ne sont pas remplis ou corrects.");
        } else {

            $this->sendEmail->SendEmail($name, $lname, $email, $message);
            $this->session->addFlashes('success', "Votre message a bien été envoyé.");
        }
        header('Location: index.php');
    }
}
