<?php

namespace App\Controller;

use App\Entity\Newsletter;
use App\Event\NewsletterSubscribedEvent;
use App\Form\NewsletterType;
use App\Mail\Newsletter\SubscribedConfirmation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\ByteString;

class NewsletterController extends AbstractController
{
    #[Route('/newsletter/subscribe', name: 'newsletter_subscribe')]
    public function subscribe(
        Request $request,
        EntityManagerInterface $em,
        EventDispatcherInterface $dispatcher,
        SubscribedConfirmation $confirmationEmail
    ): Response {
        $newsletter = new Newsletter();
        $form = $this->createForm(NewsletterType::class, $newsletter);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $newsletter->setToken(
            //     ByteString::fromRandom(32)->toString()
            // );
            //persist mon email address
            $em->persist($newsletter);
            $em->flush();

            $event = new NewsletterSubscribedEvent($newsletter);
            $dispatcher->dispatch($event, NewsletterSubscribedEvent::NAME);

            // $confirmationEmail->sendTo($newsletter);

            $this->addFlash('success', 'Votre inscription a été prise en compte, un email de confirmation vous a étét envoyé');

            return $this->redirectToRoute('app_index');
        }

        return $this->renderForm('newsletter/subscribe.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/newsletter/confirm/{token}', name: 'newsletter_confirm')]
    public function confirm(
        Newsletter $newsletter,
        EntityManagerInterface $em
    ): Response {
        $newsletter
            ->setActive(true)
            ->setToken(null);

        $em->flush();

        return $this->redirectToRoute('app_index');
    }
}
