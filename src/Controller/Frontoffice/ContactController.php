<?php

declare(strict_types=1);

namespace  App\Controller\Frontoffice;

use App\View\View;
use App\Service\Route;
use App\Service\Token;
use App\Service\SendEmail;
use App\Service\Http\Request;
use App\Service\Http\Response;
use App\Service\Http\Session\Session;
use App\Service\FormValidator\ValidForm;

final class ContactController
{
    private $sendEmail;
    private ?array $infoContact = [];

    private Response  $response;

    public function __construct(private Request $request, private View $view, private Session $session)
    {
        $this->infoContact = $this->request->getAllRequest();
    }

    public function contactForm(): Response
    {
        $response = new Response();
        if ($this->infoContact === null) {
            $this->session->addFlashes('error', 'Tous les champs doivent être saisis');
            return $response->redirectTo("index.php");
        }

        $tokenRand = new Token($this->session, $this->request);



        if (!$tokenRand->isToken()) {
            $this->session->addFlashes('error', 'Votre token n\'est plus correct, veuillez réessayer !');
            return $response->redirectTo("index.php");
        } else {

            $this->sendEmail = new SendEmail($this->view);
            $name = ValidForm::is_alphAll($this->infoContact['nom']);
            $lname = ValidForm::is_alphAll($this->infoContact['prenom']);
            $message = ValidForm::is_alpha($this->infoContact['message']);
            $email = ValidForm::is_email($this->infoContact['email']);



            if (!isset($name)) {
                $error[] = "Le champ  nom n'est pas correct.";
            }
            if (!isset($lname)) {
                $error[] = "Le champ  prénom n'est pas correct.";
            }
            if (!isset($message)) {
                $error[] = "Le champ  message n'est pas correct ou ne doit pas être vide.";
            }
            if (!isset($email)) {
                $error[] = "Le champ  email n'est pas correct.";
            }

            if (isset($name) and isset($lname) and isset($email) and isset($message)) {

                $name = $this->infoContact['nom'];
                $lname = $this->infoContact['prenom'];
                $message = $this->infoContact['message'];
                $email = $this->infoContact['email'];

                $this->sendEmail->SendEmail($name, $lname, $email, $message);
                $this->session->addFlashes('success', "Votre message a bien été envoyé.");
                return $response->redirectTo("index.php");
            }
        }

        $response = new Response($this->view->render(
            [
                'template' => 'home',
                'data' => [
                    'infoContact' => $this->infoContact,
                    'message' => $error,
                ],
            ],
        ));

        return $response;
    }
}
