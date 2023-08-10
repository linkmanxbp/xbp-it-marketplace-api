<?php

namespace App\EventSubscriber;

use ApiPlatform\Symfony\EventListener\EventPriorities;
use App\Entity\Ad;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;

class AddOwnerSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private Security $security,
        private UserRepository $repository
    ) {
    }

    public function onKernelView($event): void
    {
        $class = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$class instanceof Ad || Request::METHOD_POST !== $method) {

            // Only handle Article entities (Event is called on any Api entity)
            return;
        }

        // // maybe these extra null checks are not even needed
        // $token = $this->tokenStorage->getToken();
        // if (!$token) {
        //     return;
        // }

        $owner = $this->security->getUser();
        if (!$owner instanceof User) {
            return;
        }

        // Attach the user to the not yet persisted Article
        $class->setUser($owner);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.view' => ['onKernelView', EventPriorities::PRE_WRITE],
        ];
    }
}