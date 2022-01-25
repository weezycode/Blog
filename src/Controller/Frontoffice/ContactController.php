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
        if ($this->infoContact === null) {
            header('Location: index.php');
            $this->session->addFlashes('error', 'Tous les champs doivent être saisis');
        }
        $this->sendEmail = new SendEmail($this->session);
        $name = ValidForm::purifyAll($this->infoContact['nom']);
        $lname = ValidForm::purifyAll($this->infoContact['prenom']);
        $message = ValidForm::purifyAll($this->infoContact['message']);
        $email = ValidForm::purifyContent($this->infoContact['email']);


        if (!isset($name)) {
            header('Location: index.php');
            $this->session->addFlashes('warning', "Le champ  nom n'est pas correct.");
        }
        if (!isset($lname)) {
            $this->session->addFlashes('warning', "Le champ  prénom n'est pas correct.");
        }
        if (!isset($message)) {
            $this->session->addFlashes('warning', "Le champ  message n'est pas correct ou ne doit pas être vide.");
        }
        if (!ValidForm::is_email($email)) {
            $this->session->addFlashes('warning', "Le champ  email n'est pas correct.");
        }
        if (isset($name) and isset($lname) and isset($email) and isset($message)) {


            $this->sendEmail->SendEmail($name, $lname, $email, $message);
            $this->session->addFlashes('success', "Votre message a bien été envoyé.");
        }

        header('Location: index.php');
    }
}
