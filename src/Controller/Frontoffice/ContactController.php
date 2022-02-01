<?php

declare(strict_types=1);

namespace  App\Controller\Frontoffice;

use App\View\View;
use App\Service\Http\Request;
use App\Service\FormValidator\ValidForm;
use App\Service\Http\Session\Session;
use App\Service\Route;
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
        $response = new Route($this->view);
        if ($this->infoContact === null) {
            $this->session->addFlashes('error', 'Tous les champs doivent être saisis');
            return $response->displayIndex();
        }
        $this->sendEmail = new SendEmail($this->view);
        $name = ValidForm::purifyAll($this->infoContact['nom']);
        $lname = ValidForm::purifyAll($this->infoContact['prenom']);
        $message = ValidForm::purifyAll($this->infoContact['message']);
        $email = ValidForm::purifyContent($this->infoContact['email']);


        if (!ctype_alnum($name)) {

            $this->session->addFlashes('warning', "Le champ  nom n'est pas correct.");
            return $response->displayIndex();
        }
        if (!ctype_alnum($lname)) {
            $this->session->addFlashes('warning', "Le champ  prénom n'est pas correct.");
            return $response->displayIndex();
        }
        if (!ctype_alpha($message)) {
            $this->session->addFlashes('warning', "Le champ  message n'est pas correct ou ne doit pas être vide.");
            return $response->displayIndex();
        }
        if (!ValidForm::is_email($email)) {
            $this->session->addFlashes('warning', "Le champ  email n'est pas correct.");
            return $response->displayIndex();
        }
        if (isset($name) and isset($lname) and isset($email) and isset($message)) {


            $this->sendEmail->SendEmail($name, $lname, $email, $message);
            $this->session->addFlashes('success', "Votre message a bien été envoyé.");
        }


        return $response->redirecting();
    }
}
