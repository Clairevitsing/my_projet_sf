<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PasswordHashSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {
    }

    public function prePersist(PrePersistEventArgs $Args): void
    {
        $entity = $Args->getObject();

        if (!$entity instanceof User) {
            return;
        }

        $entity->setPassword(
            $this->hasher->hashPassword($entity, $entity->getPassword())
        );
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist
        ];
    }
}
