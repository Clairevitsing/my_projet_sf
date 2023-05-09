<?php

namespace App\EventSubscriber;

use App\Event\NewsletterSubscribedEvent;
use App\Mail\Newsletter\SubscribedConfirmation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\String\ByteString;

class NewsletterCreatedSubscriber implements EventSubscriberInterface
{

    public  function __construct(
        private EntityManagerInterface $em,
        private SubscribedConfirmation $confirmationEmail
    ) {
    }
    public function onNewsletterSubscribed(NewsletterSubscribedEvent $event): void
    {
        $newsletter = $event->getNewsletter();

        $newsletter->setToken(
            ByteString::fromRandom(32)->toString()
        );

        $this->em->flush();
        $this->confirmationEmail->sendTo($newsletter);
    }

    // public function sendDiscordNotification(NewsletterSubscribedEvent $event): void
    // {
    // }

    public static function getSubscribedEvents(): array
    {
        return [
            'newsletter.subscribed' => 'onNewsletterSubscribed',
        ];
    }
    // public static function getSubscribedEvents(): array
    // {
    //     return [
    //         NewsletterSubscribedEvent::NAME => [

    //         ],
    //     ];
    // }
}
