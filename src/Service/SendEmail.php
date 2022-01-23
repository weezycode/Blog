<?php

declare(strict_types=1);

namespace  App\Service;

use Exception;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;



final class SendEmail
{

    /**
     * Manage Home Form
     *
     * @param $name
     * @param $forename
     * @param $email
     * @param $message
     */
    public function SendEmail($name, $lname, $email, $message)
    {

        $transport = (new Swift_SmtpTransport('localhost', 1025));
        $mailer = new Swift_Mailer($transport);
        $message = (new Swift_Message('Message du Blog de la part de  ' . $name . ' ' . $lname))
            ->setFrom($email)
            ->setTo($email)
            ->setBody($message);
        $mailer->send($message);
    }
}
