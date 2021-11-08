<?php

namespace App\EventListener;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserUpdateEventSubscriber implements EventSubscriberInterface
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher, EntityManagerInterface $em)
    {
        $this->hasher = $hasher;
        $this->em = $em;
    }

    /**
     * @var BeforeEntityPersistedEvent|BeforeEntityUpdatedEvent
     */
    public function onBeforePersist($event)
    {
        $user = $event->getEntityInstance();

        if (!$user instanceof User || empty($user->getPlainPassword())) {
            return;
        }

        $newPwd = $this->hasher->hashPassword($user, $user->getPlainPassword());

        $user->setPassword($newPwd);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => 'onBeforePersist',
            BeforeEntityUpdatedEvent::class => 'onBeforePersist',
        ];
    }
}
