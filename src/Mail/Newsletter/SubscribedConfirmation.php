<?php

namespace App\Mail\Newsletter;

use App\Entity\Newsletter;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SubscribedConfirmation
{

    public function __construct(
        private MailerInterface $mailer,
        private UrlGeneratorInterface $urlGenerator
    ) {
    }
    public function sendTo(Newsletter $newsletter)    #pas insert independance
    {
        $email = (new Email())
            ->from('admin@hb-corp.com')
            ->to($newsletter->getEmail())
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Inscription à la newsletter!')
            ->text($this->urlGenerator->generate(
                'newsletter_confirm',
                ['token' => $newsletter->getToken()],
                UrlGeneratorInterface::ABSOLUTE_URL
            ));

        $this->mailer->send($email);
    }
}
