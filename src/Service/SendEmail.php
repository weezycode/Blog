<?php

declare(strict_types=1);

namespace  App\Service;

use Exception;
use Swift_Mailer;
use App\View\View;
use Swift_Message;
use Swift_SmtpTransport;



final class SendEmail
{


    public function __construct(private View $view)
    {
    }

    /**
     * Manage Home Form
     *
     * @param $name
     * @param $lname
     * @param $email
     * @param $message
     */




    public function SendEmail($name, $lname, $email, $message)
    {

        $transport = (new Swift_SmtpTransport('localhost', 1025));
        $mailer = new Swift_Mailer($transport);
        $cid = (\Swift_Image::fromPath('images\MOUDOU.png'));

        $message = (new Swift_Message())
            ->attach($cid)
            ->setFrom($email)
            ->setTo('moudou.openclassrooms@gmail.com')
            ->setBody(
                $this->view->render(
                    [
                        'template' => 'email/contactEmail',
                        'data'   => [
                            'name' => $name,
                            'prenom' => $lname,
                            'message' => $message,
                            'email'  => $email,
                            'image'  => $cid,
                        ],
                    ],
                ),
                'text/html'
            );
        $mailer->send($message);
    }
    public function SendEmailRegister($pseudo, $email)
    {

        $transport = (new Swift_SmtpTransport('localhost', 1025));
        $mailer = new Swift_Mailer($transport);
        $cid = (\Swift_Image::fromPath('images\MOUDOU.png'));

        $message = (new Swift_Message())
            ->attach($cid)
            ->setFrom($email)
            ->setTo('moudou.openclassrooms@gmail.com')
            ->setBody(
                $this->view->render(
                    [
                        'template' => 'email/register',
                        'data'   => [
                            'name' => $pseudo,
                            'email'  => $email,
                            'image'  => $cid,
                        ],
                    ],
                ),
                'text/html'
            );
        $mailer->send($message);
    }
}
